<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;

class Homepage extends Component
{
    public $slide = 0;
    public $featured = [];
    public $special = null;

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
            ->take(3)
            ->get()
            ->toArray();
           
        $this->special = Menu::query()
            ->where('is_special', true)
            ->where('available', true)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function render()
    {
        return view('livewire.homepage');
    }
}
