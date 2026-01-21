<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = trim($request->input('search', ''));
            $orders = Order::query()
                ->when($search !== '', function ($q) use ($search) {
                    $id = preg_replace('/\D/', '', $search);
                    if ($id !== '') $q->where('id', (int)$id);
                })
                ->latest('id')
                ->paginate(10);

            return view("admin.order.index", compact("orders"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load orders: ' . $e->getMessage()]);
        }
    }

    public function create()
    {
        try {
            return view("admin.order.create");
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load order form: ' . $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // detect rental
            $isRental = false;
            foreach ($request->input('items', []) as $item) {
                if (!empty($item['rental_start_at']) || !empty($item['rental_end_at'])) {
                    $isRental = true;
                    break;
                }
            }
            $request->merge(['is_rental' => $isRental]);

            $validated_order = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'receiver_name' => 'required|string|max:100',
                'receiver_phone' => 'required|string|max:20',
                'shipping_address' => 'required|string|max:255',
                'total' => 'required|numeric|min:0',
                'is_rental' => 'boolean',
                'payment_method' => ['required', Rule::in(['cod', 'vnpay', 'momo', 'banking'])],
            ])->validate();

            $validator_order_item = Validator::make($request->all(), [
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.rental_start_at' => 'nullable|date',
                'items.*.rental_end_at' => 'nullable|date',
                'items.*.variant_id' => 'nullable|integer|exists:product_variants,id',
            ]);

            $validator_order_item->after(function ($v) use ($request) {
                foreach ($request->input('items', []) as $idx => $it) {
                    $s = $it['rental_start_at'] ?? null;
                    $e = $it['rental_end_at'] ?? null;

                    if (($s && !$e) || (!$s && $e)) {
                        $v->errors()->add("items.$idx.rental_end_at", "Rental needs both start and end date.");
                        continue;
                    }
                    if ($s && $e && strtotime($e) < strtotime($s)) {
                        $v->errors()->add("items.$idx.rental_end_at", "End date must be after start date.");
                    }

                    $pid = $it['product_id'] ?? null;
                    $vid = $it['variant_id'] ?? null;
                    if ($vid) {
                        $ok = \App\Models\ProductVariant::where('id', $vid)
                            ->where('product_id', $pid)
                            ->exists();
                        if (!$ok) $v->errors()->add("items.$idx.variant_id", "Invalid variant for this product.");
                    }
                }
            });

            $validated_item = $validator_order_item->validate();
            $itemsForMail = collect($validated_item['items'])->map(function ($it) {
                $product = Product::select('id', 'name')->find($it['product_id']);

                $variant = null;
                if (!empty($it['variant_id'])) {
                    $variant = \App\Models\ProductVariant::select('id', 'color', 'size')
                        ->find($it['variant_id']);
                }

                return [
                    'product_id'   => $it['product_id'],
                    'product_name' => $product?->name,
                    'variant_id'   => $it['variant_id'] ?? null,
                    'variant'      => $variant ? [
                        'color' => $variant->color,
                        'size'  => $variant->size,
                    ] : null,
                    'quantity'     => (int)$it['quantity'],
                    'price'        => (float)$it['price'],
                    'rental_start_at' => $it['rental_start_at'] ?? null,
                    'rental_end_at'   => $it['rental_end_at'] ?? null,
                ];
            })->values()->all();


            // ✅ create order + giữ lại object
            $order = Order::create($validated_order);

            // ✅ tạo OrderItem trước (lưu variant_id luôn)
            foreach ($validated_item['items'] as $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'quantity' => (int)$item['quantity'],
                    'price' => $item['price'],
                    'rental_start_at' => $item['rental_start_at'] ?? null,
                    'rental_end_at' => $item['rental_end_at'] ?? null,
                ]);
            }

            // ✅ trừ stock (variant ưu tiên)
            foreach ($validated_item['items'] as $item) {
                $qty = (int)$item['quantity'];

                if (!empty($item['variant_id'])) {
                    $variant = \App\Models\ProductVariant::where('id', $item['variant_id'])
                        ->lockForUpdate()
                        ->first();

                    if (!$variant) throw new \Exception("Variant not found");
                    if ($variant->stock < $qty) throw new \Exception("Out of stock (variant)");

                    $variant->decrement('stock', $qty);

                    // optional sync product stock = sum variants
                    Product::where('id', $item['product_id'])->update([
                        'stock' => \App\Models\ProductVariant::where('product_id', $item['product_id'])->sum('stock')
                    ]);
                } else {
                    $product = Product::where('id', $item['product_id'])
                        ->lockForUpdate()
                        ->first();

                    if (!$product) throw new \Exception("Product not found");
                    if ($product->stock < $qty) throw new \Exception("Out of stock");

                    $product->decrement('stock', $qty);
                }
            }

            $user = \App\Models\User::findOrFail($validated_order['user_id']);
            \Mail::to($user->email)->cc(config('mail.from.address'))->send(new \App\Mail\OrderCreated($validated_order, ['items' => $itemsForMail]));

            $cart = \App\Models\Cart::where('user_id', $validated_order['user_id'])->first();
            if ($cart) {
                \App\Models\CartItem::where('cart_id', $cart->id)->delete();
            }

            DB::commit();
            return redirect()->back()->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to create order: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function show(string $id)
    {
        try {
            $order = Order::with(['items.product', 'items.variant', 'user'])->findOrFail($id);
            return view("admin.order.show", compact("order"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load order details: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $order = Order::with([
                'user',
                'items.product',
                'items.variant',
            ])->findOrFail($id);
            return view("admin.order.edit", compact("order"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load order edit form: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $validated = Validator::make($request->all(), [
                'id' => 'required|exists:orders,id',
                'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
            ])->validate();

            $order = Order::with(['items', 'user'])->findOrFail($id);

            $oldStatus = $order->status;
            $newStatus = $validated['status'];

            if ($oldStatus === 'completed' && $newStatus !== 'completed') {
                throw new \Exception("Completed order cannot be changed.");
            }

            // trả stock nếu chuyển sang cancelled (từ trạng thái khác)
            if ($oldStatus !== 'cancelled' && $newStatus === 'cancelled') {
                foreach ($order->items as $it) {
                    if ($it->variant_id) {
                        $variant = \App\Models\ProductVariant::where('id', $it->variant_id)->lockForUpdate()->first();
                        if ($variant) $variant->increment('stock', $it->quantity);

                        Product::where('id', $it->product_id)->update([
                            'stock' => \App\Models\ProductVariant::where('product_id', $it->product_id)->sum('stock')
                        ]);
                    } else {
                        $product = Product::where('id', $it->product_id)->lockForUpdate()->first();
                        if ($product) $product->increment('stock', $it->quantity);
                    }
                }
            }

            $order->update(['status' => $newStatus]);

            // gửi mail chỉ khi chuyển sang completed
            if ($oldStatus !== 'completed' && $newStatus === 'completed') {
                \Mail::to($order->user->email)->send(new \App\Mail\OrderCompleted($order));
            }

            DB::commit();

            return redirect()->route('admin.order.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to update order: ' . $e->getMessage()])
                ->withInput();
        }
    }


    public function destroy(string $id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return redirect()->route('admin.order.index')
                ->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to delete order: ' . $e->getMessage()]);
        }
    }

    public function cancel(string $id)
    {
        try {
            DB::beginTransaction();

            $order = Order::with('items')->findOrFail($id);

            if (Auth::id() !== $order->user_id) {
                DB::rollBack();
                return redirect()->back()->withErrors(['error' => 'You are not authorized to cancel this order.']);
            }

            if ($order->status === 'completed') {
                throw new \Exception("Completed order cannot be changed.");
            }

            if ($order->status !== 'cancelled') {
                foreach ($order->items as $it) {
                    if ($it->variant_id) {
                        $variant = \App\Models\ProductVariant::where('id', $it->variant_id)->lockForUpdate()->first();
                        if ($variant) $variant->increment('stock', $it->quantity);

                        Product::where('id', $it->product_id)->update([
                            'stock' => \App\Models\ProductVariant::where('product_id', $it->product_id)->sum('stock')
                        ]);
                    } else {
                        $product = Product::where('id', $it->product_id)->lockForUpdate()->first();
                        if ($product) $product->increment('stock', $it->quantity);
                    }
                }
            }

            $order->status = 'cancelled';
            $order->save();

            DB::commit();
            return redirect()->back()->with('success', 'Order cancelled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to cancel order: ' . $e->getMessage()]);
        }
    }
}
