<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // nullable vì product không có variants vẫn add bình thường
            $table->unsignedBigInteger('variant_id')->nullable()->after('product_id');

            // index để query nhanh
            $table->index(['cart_id', 'product_id', 'variant_id'], 'cart_items_cart_product_variant_idx');

            // FK: đổi tên bảng đúng với bảng variants của bạn
            // Nếu variants table là `product_variants` (thường là vậy)
            $table->foreign('variant_id')
                ->references('id')
                ->on('product_variants')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['variant_id']);
            $table->dropIndex('cart_items_cart_product_variant_idx');
            $table->dropColumn('variant_id');
        });
    }
};
