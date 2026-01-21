<?php

namespace App\Livewire\Shop;

use App\Models\Product;
use Livewire\Component;

class RentalAccessories extends Component
{
    public $rentals = [];
    public $accessories = [];

    public function mount()
    {
        $this->rentals = Product::query()->where('is_rental', true)->latest()->take(3)->get();

        $this->accessories = Product::query()->where('is_rental', false)->latest()->take(4)->get();
    }

    public function addToCart($productId)
    {
        try {
            $product = Product::findOrFail($productId);

            // Giỏ hàng lưu trong session (nếu chưa có thì tạo mảng trống)
            $cart = session()->get('cart', []);

            // Nếu sản phẩm đã có thì tăng số lượng
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity']++;
            } else {
                $cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image ?? null,
                    'quantity' => 1,
                ];
            }

            session()->put('cart', $cart);

            // Gửi thông báo UI đẹp (toast magic glass)
            $this->dispatch('toast', [
                'type' => 'success',
                'message' => "✨ {$product->name} đã được thêm vào giỏ hàng!"
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error',
                'message' => 'Lỗi khi thêm sản phẩm vào giỏ hàng.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.shop.rental-accessories');
    }
}
