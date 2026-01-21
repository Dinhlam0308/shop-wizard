<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Thêm cờ is_rental vào orders
        Schema::table('orders', function (Blueprint $table) {
            // đặt sau user_id cho dễ đọc (tuỳ bạn)
            if (!Schema::hasColumn('orders', 'is_rental')) {
                $table->boolean('is_rental')->default(false)->index()->after('user_id');
            }
        });

        // Thêm mốc thời gian thuê vào order_items
        Schema::table('order_items', function (Blueprint $table) {
            if (!Schema::hasColumn('order_items', 'rental_start_at')) {
                $table->timestamp('rental_start_at')->nullable()->after('quantity');
            }
            if (!Schema::hasColumn('order_items', 'rental_end_at')) {
                $table->timestamp('rental_end_at')->nullable()->after('rental_start_at');
            }

            // Index phục vụ kiểm tra overlap (product x khoảng thời gian)
            $table->index(
                ['product_id', 'rental_start_at', 'rental_end_at'],
                'oi_product_rental_range_idx'
            );
        });
    }

    public function down(): void
    {
        // Gỡ cột ở order_items trước (để tránh lỗi khi drop index)
        Schema::table('order_items', function (Blueprint $table) {
            // drop index nếu tồn tại
            try {
                $table->dropIndex('oi_product_rental_range_idx');
            } catch (\Throwable $e) {
                // ignore nếu index không tồn tại
            }

            if (Schema::hasColumn('order_items', 'rental_end_at')) {
                $table->dropColumn('rental_end_at');
            }
            if (Schema::hasColumn('order_items', 'rental_start_at')) {
                $table->dropColumn('rental_start_at');
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'is_rental')) {
                $table->dropColumn('is_rental');
            }
        });
    }
};
