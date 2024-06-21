<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->string('delivery_name');
            $table->string('delivery_method');
            $table->string('region');
            $table->string('regionRef');
            $table->string('city')->nullable();
            $table->string('cityRef')->nullable();
            $table->string('branch')->nullable();
            $table->string('branchNumber')->nullable();
            $table->string('branchRef')->nullable();
            $table->string('district')->nullable();
            $table->string('districtRef')->nullable();
            $table->string('village')->nullable();
            $table->string('villageRef')->nullable();
            $table->string('street')->nullable();
            $table->string('streetRef')->nullable();
            $table->string('house')->nullable();
            $table->string('flat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_addresses');
    }
};
