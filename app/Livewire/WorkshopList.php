<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Workshop;

class WorkshopList extends Component
{
    public $workshops = [];

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->workshops = Workshop::query()
            ->whereDate('date', '>=', now())
            ->orderBy('date', 'asc')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.workshop-list');
    }
}
