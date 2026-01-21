<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("
            ALTER TABLE bookings
            MODIFY type ENUM('table','tarot','potion_class','event_table')
            NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE bookings
            MODIFY type ENUM('table','tarot','potion_class')
            NOT NULL
        ");
    }
};

