<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nova_poshta_warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('settlement_id')->constrained('nova_poshta_settlements')->cascadeOnDelete();
            $table->string('description');
            $table->string('short_address');
            $table->string('type_of_warehouse');
            $table->string('ref')->unique();
            $table->string('number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nova_poshta_warehouses');
    }
};
