<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ukr_poshta_settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('ukr_poshta_regions');
            $table->foreignId('district_id')->nullable()->constrained('ukr_poshta_districts');
            $table->string('description');
            $table->string('settlement_type');
            $table->string('settlement_id')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ukr_poshta_settlements');
    }
};
