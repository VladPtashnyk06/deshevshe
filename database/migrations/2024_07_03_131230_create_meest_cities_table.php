<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meest_cities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('meest_regions')->cascadeOnDelete();
            $table->string('city_id')->unique();
            $table->string('city_type');
            $table->string('description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meest_cities');
    }
};
