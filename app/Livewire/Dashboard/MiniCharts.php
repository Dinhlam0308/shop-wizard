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
        $this->sales = Order::query()->sum('total');
        $this->salesChange = ($this->sales - Order::query()->where('created_at', '<=', now()->subWeek())->sum('total')) / Order::all()->sum('total') * 100;

        $this->orders = Order::query()->count();
        $this->orderChange = ($this->orders - Order::query()->where('created_at', '<=', now()->subDay())->count()) / Order::all()->count() * 100;

        $this->bars = [
            'yesterday' => Order::query()->whereDate('created_at', now()->subDay())->count(),
            'now' => Order::query()->whereDate('created_at', now())->count(),
        ];
        $max = max($this->bars) ?: 1;
        foreach ($this->bars as $key => $value) {
            $this->bars[$key] = max(1, ($value / $max) * 100);
        }

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
