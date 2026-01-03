<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metrics_targets', function (Blueprint $table) {
            $table->id();
            $table->enum('metric_name', [
                'news',
                'products',
                'orders',
                'revenue',
                'users',
                'bookings',
                'contacts',
                'workshops',
                'categories',
                'menus'
            ])->unique();
            $table->integer('monthly_goal')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('metrics_targets');
    }
};
