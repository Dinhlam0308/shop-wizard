<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('receiver_name')->after('user_id');
            $table->string('receiver_phone', 20)->after('receiver_name');
            $table->string('shipping_address')->after('receiver_phone');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'receiver_name',
                'receiver_phone',
                'shipping_address',
            ]);
        });
    }
};
