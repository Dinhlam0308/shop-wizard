<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
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
                ->withErrors(['error' => 'Failed to load cart: ' . $e->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function addToCart( $product_id)
    {
        try {
            DB::beginTransaction();
            $cart = Cart::query()->firstOrCreate(['user_id' => Auth::id()]);
            if ($cart->items()->count() >= 100) {
                return redirect()->back()->withErrors(['error' => 'You cannot add more than 100 items to the cart.']);
            }
            $item = $cart->items()->where('product_id', $product_id)->first();
            if ($item) {
                $item->quantity += 1;
                $item->subtotal = $item->price * $item->quantity;
                $item->save();
            } else {
                $product = \App\Models\Product::where('id', $product_id)->first();
                if (!$product) {
                    return redirect()->back()->withErrors(['error' => 'Product not found.']);
                }
                $cart->items()->create([
                    'product_id' => $product_id,
                    'quantity' => 1,
                    'price' => $product->price,
                    'subtotal' => $product->price,
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Product added to cart successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withErrors(['error' => 'Failed to add to cart: ' . $e->getMessage()]);
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
                ->withErrors(['error' => 'Failed to load cart details: ' . $e->getMessage()]);
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
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        return $cart->load('items.product');
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
            ];
        })->values()->all();

        return ['items' => $items];
    }

    // GET /user/cart/state
    public function state()
    {
        $cart = $this->getCart();
        return response()->json($this->payload($cart));
    }

    // PATCH /user/cart/items/{cartItem}
    public function updateItem(Request $request, CartItem $cartItem)
    {
        $cart = $this->getCart();

        // bảo vệ: item phải thuộc cart của user
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

            // chỉ update ngày thuê nếu product là rental
            $isRental = (bool) optional($cartItem->product)->is_rental;
            if ($isRental) {
                if (array_key_exists('rental_start_at', $data)) $cartItem->rental_start_at = $data['rental_start_at'];
                if (array_key_exists('rental_end_at', $data)) $cartItem->rental_end_at = $data['rental_end_at'];
            }

            // nếu bạn đang lưu subtotal
            $cartItem->subtotal = (float) $cartItem->price * (int) $cartItem->quantity;
            $cartItem->save();
        });

        $cart->refresh()->load('items.product');
        return response()->json($this->payload($cart));
    }

    // DELETE /user/cart/items/{cartItem}
    public function removeItem(CartItem $cartItem)
    {
        $cart = $this->getCart();
        abort_if($cartItem->cart_id !== $cart->id, 403);

        $cartItem->delete();

        $cart->refresh()->load('items.product');
        return response()->json($this->payload($cart));
    }

    // DELETE /user/cart/clear
    public function clear()
    {
        $cart = $this->getCart();

        $cart->items()->delete();

        $cart->refresh()->load('items.product');
        return response()->json($this->payload($cart));
    }
}
