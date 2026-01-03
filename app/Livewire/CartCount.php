<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class CartCount extends Component
{
    public $count = 0;

    protected $listeners = ['cartUpdated' => 'updateCount'];

    public function mount()
    {
        $this->refreshCartCount();
    }

    public function refreshCartCount()
    {
        if (Auth::check()) {
            $cart_id = Auth::user()->cart?->id;
            if ($cart_id) {
                $this->count = CartItem::query()->where('cart_id', $cart_id)->count();
            } else {
                Cart::firstOrCreate(['user_id' => Auth::id()]);
                $this->count = 0;
            }
        } else {
            $this->count = 0;
        }
    }

    public function render()
    {
        return view('livewire.cart-count');
    }
}
