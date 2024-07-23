<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ukr_poshta_districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('ukr_poshta_regions');
            $table->string('description');
            $table->string('district_id')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ukr_poshta_districts');
    }
};
