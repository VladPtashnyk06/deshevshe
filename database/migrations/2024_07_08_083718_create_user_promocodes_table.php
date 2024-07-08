<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_promocodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('promo_code_id');
            $table->enum('status', ['Використанний', 'Не використанний'])->default('Не використанний');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_promocodes');
    }
};
