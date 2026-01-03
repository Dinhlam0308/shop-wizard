<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;

class FooterSummary extends Component
{
    public $ordersProcessed;
    public $revenueGenerated;
    public $activeUsers;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->ordersProcessed = Order::query()->count();
        $this->revenueGenerated = number_format(Order::query()->sum('total'), 0, ',', '.');
        $this->activeUsers = User::query()->count();
    }

    public function render()
    {
        return view('livewire.dashboard.footer-summary');
    }
}
