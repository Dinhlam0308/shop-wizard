<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // thêm cột variant_id (nullable) sau product_id cho gọn
            $table->unsignedBigInteger('variant_id')->nullable()->after('product_id');

            // index để query nhanh (order -> items -> variant)
            $table->index('variant_id');

            // foreign key (nullable nên khi variant bị xóa -> set null)
            $table->foreign('variant_id')
                ->references('id')
                ->on('product_variants')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // rollback phải drop FK trước
            $table->dropForeign(['variant_id']);
            $table->dropIndex(['variant_id']);
            $table->dropColumn('variant_id');
        });
    }
};
