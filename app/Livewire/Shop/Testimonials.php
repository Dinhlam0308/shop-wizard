<?php

namespace App\Livewire\Shop;

use App\Models\Feedback;
use Livewire\Component;

class Testimonials extends Component
{
    public $testimonials = [];

    public function mount()
    {
        $this->loadTestimonials();
    }

    public function loadTestimonials()
    {
        $this->testimonials = Feedback::query()
            ->where('rating', 5)
            ->orderByRaw('LENGTH(message) DESC')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.shop.testimonials');
    }
}
