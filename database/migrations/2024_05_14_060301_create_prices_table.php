<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unique()->constrained('products');
            $table->integer('pair');
            $table->integer('rec_pair');
            $table->integer('package')->nullable();
            $table->integer('rec_package')->nullable();
            $table->integer('retail');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
