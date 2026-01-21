<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;

class FeaturedMenu extends Component
{
    public $featured = [];
    public $slide = 0;

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->featured = Menu::query()
            ->where('is_featured', true)
            ->where('available', true)
            ->orderBy('created_at', 'desc')
            ->skip(3)
            ->take(4)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.featured-menu');
    }
}
