<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use DB;

class MiniCharts extends Component
{
    public $sales = 0;
    public $salesChange = 0;
    public $orders = 0;
    public $orderChange = 0;
    public $bars = [];
    public $sales7Days = [];

    public function refresh()
    {
        // ===== SALES =====
        $this->sales = Order::sum('total');

        $lastWeekSales = Order::where('created_at', '<=', now()->subWeek())->sum('total');
        $totalSales = Order::sum('total');

        $this->salesChange = $totalSales > 0
            ? (($this->sales - $lastWeekSales) / $totalSales) * 100
            : 0;

        // ===== ORDERS =====
        $this->orders = Order::count();

        $yesterdayOrders = Order::where('created_at', '<=', now()->subDay())->count();
        $totalOrders = Order::count();

        $this->orderChange = $totalOrders > 0
            ? (($this->orders - $yesterdayOrders) / $totalOrders) * 100
            : 0;

        // ===== BAR CHART =====
        $this->bars = [
            'yesterday' => Order::whereDate('created_at', now()->subDay())->count(),
            'now' => Order::whereDate('created_at', now())->count(),
        ];

        $max = max($this->bars) ?: 1;

        foreach ($this->bars as $key => $value) {
            $this->bars[$key] = max(1, ($value / $max) * 100);
        }

        // ===== SALES 7 DAYS =====
        $this->sales7Days = Order::query()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as total'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();
    }

    public function mount()
    {
        $this->refresh();
    }

    public function render()
    {
        return view('livewire.dashboard.mini-charts');
    }
}
