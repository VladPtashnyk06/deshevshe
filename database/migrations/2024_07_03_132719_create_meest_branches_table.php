<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meest_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained('meest_cities')->cascadeOnDelete();
            $table->string('branch_id')->unique();
            $table->string('branch_type');
            $table->string('description');
            $table->string('address');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meest_branches');
    }
};
