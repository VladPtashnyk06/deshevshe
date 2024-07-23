<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nova_poshta_settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->index()->constrained('nova_poshta_regions')->cascadeOnDelete();
            $table->foreignId('district_id')->nullable()->index()->constrained('nova_poshta_districts')->cascadeOnDelete();
            $table->string('description');
            $table->string('settlement_type_description');
            $table->string('ref')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nova_poshta_cities');
    }
};
