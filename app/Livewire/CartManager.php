<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartItem;
use Carbon\Carbon;

class CartManager extends Component
{
    /** @var array<int,array> */
    public array $items = []; // state chuẩn production
    public bool $showConfirm = false;

    public function mount()
    {
        $this->loadItems();
    }

    private function loadItems(): void
    {
        $cart = Cart::with('items.product')
            ->firstOrCreate(['user_id' => Auth::id()]);

        $this->items = $cart->items->map(function ($it) {
            return [
                'cart_item_id' => $it->id,
                'product_id' => $it->product_id,
                'name' => optional($it->product)->name,
                'quantity' => (int) $it->quantity,
                'base_price' => (float) $it->price,
                'is_rental' => (bool) optional($it->product)->is_rental,
                'rental_start_at' => $it->rental_start_at ? Carbon::parse($it->rental_start_at)->toDateString() : null,
                'rental_end_at' => $it->rental_end_at ? Carbon::parse($it->rental_end_at)->toDateString() : null,
            ];
        })->values()->toArray();
    }

    // ===== Business rules =====
    public function unitPrice(array $it): float
    {
        $base = (float) ($it['base_price'] ?? 0);
        return round(($it['is_rental'] ? $base * 2 : $base), 2);
    }

    public function rentalDays(array $it): int
    {
        if (empty($it['is_rental']) || empty($it['rental_start_at']) || empty($it['rental_end_at'])) {
            return 0;
        }

        try {
            $s = Carbon::parse($it['rental_start_at'])->startOfDay();
            $e = Carbon::parse($it['rental_end_at'])->startOfDay();
            return max(1, $e->diffInDays($s) + 1);
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public function lineTotal(array $it): float
    {
        $qty  = (int) ($it['quantity'] ?? 0);
        $unit = $this->unitPrice($it);

        if (empty($it['is_rental'])) {
            return round($qty * $unit, 2);
        }

        $days = $this->rentalDays($it) ?: 1;
        $sum = $qty * $unit * $days;

        if ($days >= 3) $sum *= 0.7;

        return round($sum, 2);
    }

    public function getTotalProperty(): float
    {
        return round(array_reduce($this->items, fn($s,$it) => $s + $this->lineTotal($it), 0), 2);
    }

    public function getAnyRentalProperty(): bool
    {
        return collect($this->items)->contains(fn($it) => !empty($it['is_rental']));
    }

    // ===== Actions =====
    public function increase(int $cartItemId): void
    {
        $cartId = Auth::user()?->cart?->id;
        $item = CartItem::where('cart_id', $cartId)->where('id', $cartItemId)->first();
        if (!$item) return;

        $item->increment('quantity');
        $item->update(['subtotal' => $item->quantity * $item->price]);

        $this->loadItems(); // ✅ không dispatch, chỉ reload state
    }

    public function decrease(int $cartItemId): void
    {
        $cartId = Auth::user()?->cart?->id;
        $item = CartItem::where('cart_id', $cartId)->where('id', $cartItemId)->first();
        if (!$item) return;

        if ($item->quantity > 1) {
            $item->decrement('quantity');
            $item->update(['subtotal' => $item->quantity * $item->price]);
        } else {
            $item->delete();
        }

        $this->loadItems();
    }

    public function remove(int $cartItemId): void
    {
        $cartId = Auth::user()?->cart?->id;
        CartItem::where('cart_id', $cartId)->where('id', $cartItemId)->delete();

        $this->loadItems();
    }

    public function clear(): void
    {
        $cartId = Auth::user()?->cart?->id;
        CartItem::where('cart_id', $cartId)->delete();

        $this->loadItems();
    }

    // update rental dates directly to DB (production)
    public function updateRentalDates(int $index): void
    {
        $it = $this->items[$index] ?? null;
        if (!$it) return;

        if (!empty($it['rental_end_at']) && !empty($it['rental_start_at']) && $it['rental_end_at'] < $it['rental_start_at']) {
            $this->items[$index]['rental_end_at'] = $it['rental_start_at'];
            $it = $this->items[$index];
        }

        CartItem::where('id', $it['cart_item_id'])->update([
            'rental_start_at' => $it['rental_start_at'],
            'rental_end_at' => $it['rental_end_at'],
        ]);

        // không cần reload vẫn ok, nhưng reload để chắc chắn
        $this->loadItems();
    }

    public function render()
    {
        return view('livewire.cart-manager');
    }
}
