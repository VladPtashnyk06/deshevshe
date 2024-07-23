<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained();
            $table->string('delivery_name');
            $table->string('delivery_method');
            $table->string('region');
            $table->string('regionRef');
            $table->string('settlementType');
            $table->string('settlement')->nullable();
            $table->string('settlementRef')->nullable();
            $table->string('branch')->nullable();
            $table->string('branchRef')->nullable();
            $table->string('district')->nullable();
            $table->string('districtRef')->nullable();
            $table->string('street')->nullable();
            $table->string('streetRef')->nullable();
            $table->string('house')->nullable();
            $table->string('flat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
