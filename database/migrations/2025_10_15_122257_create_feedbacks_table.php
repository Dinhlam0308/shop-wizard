<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Họ và tên người gửi
            $table->text('message');         // Nội dung phản hồi
            $table->unsignedTinyInteger('rating')->default(0); // Số sao (1–5)
            $table->timestamps();            // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
