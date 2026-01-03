<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class InteractiveCharts extends Component
{
    public $chartData = [];

    public function mount()
    {
        $this->refresh();
    }

    public function refresh()
    {
        $this->chartData = [
            'revenue' => Order::query()
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
                ->groupBy('date')
                ->pluck('total', 'date')
                ->toArray(),

            'users' => User::query()
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                ->groupBy('date')
                ->pluck('count', 'date')
                ->toArray(),

            'products' => Product::query()
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
                ->groupBy('date')
                ->pluck('count', 'date')
                ->toArray(),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.interactive-charts');
    }
}
