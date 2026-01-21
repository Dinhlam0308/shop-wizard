<?php

namespace Database\Seeders;

use App\Models\MetricsTarget;
use Illuminate\Database\Seeder;

class MetricsTargetSeeder extends Seeder
{
    public function run(): void
    {
        MetricsTarget::insert([
            ['metric_name' => 'news', 'monthly_goal' => 100],
            ['metric_name' => 'products', 'monthly_goal' => 200],
            ['metric_name' => 'orders', 'monthly_goal' => 500],
            ['metric_name' => 'revenue', 'monthly_goal' => 100000],
            ['metric_name' => 'users', 'monthly_goal' => 300],
            ['metric_name' => 'bookings', 'monthly_goal' => 150],
            ['metric_name' => 'contacts', 'monthly_goal' => 120],
            ['metric_name' => 'workshops', 'monthly_goal' => 50],
            ['metric_name' => 'categories', 'monthly_goal' => 20],
            ['metric_name' => 'menus', 'monthly_goal' => 30],
        ]);
    }
}
