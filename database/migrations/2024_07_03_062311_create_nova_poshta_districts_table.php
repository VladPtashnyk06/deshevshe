<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nova_poshta_districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained('nova_poshta_regions')->cascadeOnDelete();
            $table->string('description');
            $table->string('ref')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nova_poshta_districts');
    }
};
