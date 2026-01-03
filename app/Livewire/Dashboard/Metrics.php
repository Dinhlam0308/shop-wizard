<?php

namespace App\Livewire\Dashboard;

use App\Models\Booking;
use App\Models\Contact;
use App\Models\MetricsTarget;
use App\Models\News;
use Livewire\Component;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class Metrics extends Component
{
    public int $totalProducts = 0;
    public int $totalOrders = 0;
    public float $totalRevenue = 0.0;
    public int $totalNews = 0;
    public int $totalUsers = 0;
    public int $totalBookings = 0;
    public int $totalContacts = 0;

    public array $deltas = [
        'news'   => 0,
        'products' => 0,
        'orders'   => 0,
        'revenue'  => 0,
        'users'    => 0,
        'bookings' => 0,
        'contacts' => 0,
    ];
    public array $targets = [
        'news'   => 0,
        'products' => 0,
        'orders'   => 0,
        'revenue'  => 0,
        'users'    => 0,
        'bookings' => 0,
        'contacts' => 0,
    ];

    public function mount()
    {
        $this->refresh();
    }

    private function TodayVsPast($model, $field = 'id', $mode = 'count'): array
    {
        if ($mode === 'count') {
            $todayCount = $model::whereDate('created_at', now()->toDateString())->count();
            $yesterdayCount = $model::whereDate('created_at', now()->subDay()->toDateString())->count();
        } elseif ($mode === 'sum') {
            $todayCount = $model::whereDate('created_at', now()->toDateString())->sum($field);
            $yesterdayCount = $model::whereDate('created_at', now()->subDay()->toDateString())->sum($field);
        } else {
            throw new \InvalidArgumentException("Invalid mode: $mode");
        }

        if ($yesterdayCount === 0) {
            return [$todayCount, $todayCount > 0 ? 100.0 : 0.0];
        }

        $delta = (($todayCount - $yesterdayCount) / $yesterdayCount) * 100;

        return [$todayCount, round($delta, 2)];
    }

    private function TargetProgress($model, $metric_name, $field = 'id', $mode = 'count'): float
    {
        $goal = MetricsTarget::where('metric_name', $metric_name)->value('monthly_goal') ?? 0;

        if ($goal <= 0) return 0;

        $monthStart = now()->startOfMonth();
        $monthEnd   = now()->endOfMonth();

        $monthValue = $mode === 'sum'
            ? (float) $model::whereBetween('created_at', [$monthStart, $monthEnd])->sum($field)
            : (float) $model::whereBetween('created_at', [$monthStart, $monthEnd])->count();

        return round(min(100, ($monthValue / $goal) * 100), 1);
    }

    public function refresh(): void
    {
        $this->totalNews = News::query()->count();

        $this->totalUsers = User::query()->count();

        $this->totalProducts = Product::query()->count();

        $this->totalOrders = Order::query()->count();

        $this->totalRevenue = Order::query()->sum('total');

        $this->totalBookings = Booking::query()->count();

        $this->totalContacts = Contact::query()->count();

        $this->deltas = [
            'news'   => $this->TodayVsPast(News::class)[1],
            'products' => $this->TodayVsPast(Product::class)[1],
            'orders'   => $this->TodayVsPast(Order::class)[1],
            'revenue'  => $this->TodayVsPast(Order::class, 'total')[1],
            'users'    => $this->TodayVsPast(User::class)[1],
            'bookings' => $this->TodayVsPast(Booking::class)[1],
            'contacts' => $this->TodayVsPast(Contact::class)[1],
        ];

        $this->targets = [
            'news'   => $this->TargetProgress(News::class, 'news'),
            'products' => $this->TargetProgress(Product::class, 'products'),
            'orders'   => $this->TargetProgress(Order::class, 'orders'),
            'revenue'  => $this->TargetProgress(Order::class, 'revenue', 'total', 'sum'),
            'users'    => $this->TargetProgress(User::class, 'users'),
            'bookings' => $this->TargetProgress(Booking::class, 'bookings'),
            'contacts' => $this->TargetProgress(Contact::class, 'contacts'),
        ];
    }

    public function render()
    {
        return view('livewire.dashboard.metrics');
    }
}
