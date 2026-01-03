<?php

namespace App\Http\Controllers;

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
            $search = $request->input('search');
            $orders = \App\Models\Order::when($search, function ($query, $search) {
                return $query->where('id', $search);
            })->paginate(10);
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

            $validator_order = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',

                // snapshot shipping
                'receiver_name' => 'required|string|max:100',
                'receiver_phone' => 'required|string|max:20',
                'shipping_address' => 'required|string|max:255',

                'total' => 'required|numeric|min:0',
                'is_rental' => 'boolean',
                'payment_method' => ['required', Rule::in(['cod', 'vnpay', 'momo', 'banking'])],
            ]);
            $validated_order = $validator_order->validate();

            $validator_order_item = Validator::make($request->all(), [
                'items' => 'required|array|min:1',
                'items.*.product_id' => 'required|exists:products,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'items.*.rental_start_at' => 'nullable|date',
                'items.*.rental_end_at' => 'nullable|date|after:items.*.rental_start_at',
            ]);
            $validated_item = $validator_order_item->validate();

            $order = \App\Models\Order::create($validated_order);

            foreach ($validated_item['items'] as $item) {
                \App\Models\OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'rental_start_at' => $item['rental_start_at'] ?? null,
                    'rental_end_at' => $item['rental_end_at'] ?? null,
                ]);
            }

            // send mail to correct customer (NOT admin)
            $user = \App\Models\User::findOrFail($validated_order['user_id']);
            \Mail::to($user->email)->send(new \App\Mail\OrderCreated($validated_order, $validated_item));

            // (optional) clear customer's cart - only if this order comes from cart
            $cart = \App\Models\Cart::where('user_id', $validated_order['user_id'])->first();
            if ($cart) {
                \App\Models\CartItem::where('cart_id', $cart->id)->delete();
            }

            // decrease stock
            foreach ($validated_item['items'] as $item) {
                $product = \App\Models\Product::find($item['product_id']);
                if ($product) {
                    $product->decrement('stock', $item['quantity']);
                }
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
            $order = \App\Models\Order::with('items.product', 'user')->findOrFail($id);
            return view("admin.order.show", compact("order"));
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to load order details: ' . $e->getMessage()]);
        }
    }

    public function edit(string $id)
    {
        try {
            $order = \App\Models\Order::findOrFail($id);
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
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:orders,id',
                'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
            ]);
            $validated = $validator->validate();
            $order = \App\Models\Order::findOrFail($id);
            $order->update($validated);
            $user = $order->user;
            if ($request->has('status') && $request->input('status') === 'completed') {
                \Mail::to($user->email)->send(new \App\Mail\OrderCompleted($order));
            }
            DB::commit();
            return redirect()->route('admin.order.index')
                ->with('success', 'Order updated successfully.');
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
            $order = \App\Models\Order::findOrFail($id);
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
            $order = \App\Models\Order::findOrFail($id);
            if (Auth::user()->id !== $order->user_id) {
                return redirect()->back()
                    ->withErrors(['error' => 'You are not authorized to cancel this order.']);
            }
            $order->status = 'cancelled';
            $order->save();
            return redirect()->back()
                ->with('success', 'Order cancelled successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Failed to cancel order: ' . $e->getMessage()]);
        }
    }
}
