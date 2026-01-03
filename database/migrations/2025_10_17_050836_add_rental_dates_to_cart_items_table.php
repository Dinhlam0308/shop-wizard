<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Chọn 1 trong 2 kiểu: date hoặc datetime. Nếu chỉ cần ngày -> dùng date.
            $table->date('rental_start_at')->nullable()->after('price');
            $table->date('rental_end_at')->nullable()->after('rental_start_at');
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn(['rental_start_at', 'rental_end_at']);
        });
    }
};

