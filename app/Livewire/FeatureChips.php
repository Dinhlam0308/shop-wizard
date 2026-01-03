<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;

class FeatureChips extends Component
{
    public $chips = [];
    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->chips = Menu::query()
            ->where('is_featured', true)
            ->orderBy('updated_at', 'desc')
            ->take(4)
            ->pluck('name')
            ->toArray();
    }
    public function render()
    {
        return view('livewire.feature-chips');
    }
}
