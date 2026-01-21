<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Auth;
use DB;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $carts = Cart::query()->get();
            return view('admin.cart.index', compact('carts'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with(['error' => 'Failed to load cart: ' . $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addToCart(Request $request, $product_id)
    {
        try {
            DB::beginTransaction();

            $cart = Cart::query()->firstOrCreate(['user_id' => Auth::id()]);
            if ($cart->items()->count() >= 100) {
                throw new \Exception('You cannot add more than 100 items to the cart.');
            }

            $product = Product::with('variants')->find($product_id);
            if (!$product) throw new \Exception('Product not found.');

            $qty = (int) $request->input('qty', 1);
            if ($qty < 1) $qty = 1;

            $variantId = $request->input('variant_id');
            $variant = null;

            if ($variantId) {
                $variant = $product->variants()->where('id', $variantId)->first();
                if (!$variant) throw new \Exception('Invalid variant selection.');
            } else {
                if ($product->variants()->exists()) {
                    throw new \Exception('Please select a variant (color/size).');
                }
            }

            $availableStock = $variant ? (int)$variant->stock : (int)$product->stock;
            if ($qty > $availableStock) {
                throw new \Exception("Only {$availableStock} item(s) left in stock.");
            }

            $unitPrice = $variant
                ? (($variant->price === null || $variant->price === '') ? (float)$product->price : (float)$variant->price)
                : (float)$product->price;

            $itemQuery = $cart->items()->where('product_id', $product_id);
            $variant ? $itemQuery->where('variant_id', $variant->id) : $itemQuery->whereNull('variant_id');
            $item = $itemQuery->first();

            if ($item) {
                $nextQty = (int)$item->quantity + $qty;

                if ($nextQty > $availableStock) {
                    throw new \Exception(
                        "Not enough stock. You already have {$item->quantity} in cart, only {$availableStock} available."
                    );
                }

                $item->quantity = $nextQty;
                $item->price = $unitPrice;
                $item->subtotal = $item->price * $item->quantity;
                $item->save();
            } else {
                $cart->items()->create([
                    'product_id' => $product_id,
                    'variant_id' => $variant ? $variant->id : null,
                    'quantity' => $qty,
                    'price' => $unitPrice,
                    'subtotal' => $unitPrice * $qty,
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Product added to cart successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['error' => 'Failed to add to cart: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            return view('user.cart.show', []);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with(['error' => 'Failed to load cart details: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    private function getCart(): Cart
    {
        return Cart::firstOrCreate(['user_id' => Auth::id()])
            ->load(['items.product', 'items.variant']);
    }

    private function payload(Cart $cart): array
    {
        $items = $cart->items->map(function ($it) {
            return [
                'cart_item_id' => $it->id,
                'product_id' => $it->product_id,
                'name' => optional($it->product)->name,
                'quantity' => (int) $it->quantity,
                'base_price' => (float) $it->price,
                'is_rental' => (bool) optional($it->product)->is_rental,
                'rental_start_at' => $it->rental_start_at ? $it->rental_start_at->toDateString() : null,
                'rental_end_at' => $it->rental_end_at ? $it->rental_end_at->toDateString() : null,
                // ✅ variant info
                'variant_id' => $it->variant_id,
                'variant_color' => optional($it->variant)->color,
                'variant_size' => optional($it->variant)->size,
            ];
        })->values()->all();

        return ['items' => $items];
    }

    public function state()
    {
        $cart = $this->getCart();
        return response()->json($this->payload($cart));
    }

    public function updateItem(Request $request, CartItem $cartItem)
    {
        $cart = $this->getCart();

        abort_if($cartItem->cart_id !== $cart->id, 403);

        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
            'rental_start_at' => ['nullable', 'date'],
            'rental_end_at' => ['nullable', 'date'],
        ]);

        DB::transaction(function () use ($cartItem, $data) {
            if (array_key_exists('quantity', $data) && $data['quantity'] !== null) {
                $cartItem->quantity = (int) $data['quantity'];
            }

            $isRental = (bool) optional($cartItem->product)->is_rental;
            if ($isRental) {
                if (array_key_exists('rental_start_at', $data)) $cartItem->rental_start_at = $data['rental_start_at'];
                if (array_key_exists('rental_end_at', $data)) $cartItem->rental_end_at = $data['rental_end_at'];
            }

            $cartItem->subtotal = (float) $cartItem->price * (int) $cartItem->quantity;
            $cartItem->save();
        });

        $cart->refresh()->load(['items.product', 'items.variant']);
        return response()->json($this->payload($cart));
    }

    public function removeItem(CartItem $cartItem)
    {
        $cart = $this->getCart();
        abort_if($cartItem->cart_id !== $cart->id, 403);

        $cartItem->delete();

        $cart->refresh()->load(['items.product', 'items.variant']);
        return response()->json($this->payload($cart));
    }

    public function clear()
    {
        $cart = $this->getCart();

        $cart->items()->delete();

        $cart->refresh()->load(['items.product', 'items.variant']);
        return response()->json($this->payload($cart));
    }
}
