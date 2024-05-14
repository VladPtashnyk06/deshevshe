<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('producer_id')->constrained('producers');
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('size_id')->constrained('sizes');
            $table->foreignId('color_id')->constrained('colors');
            $table->foreignId('package_id')->constrained('packages');
            $table->foreignId('material_id')->constrained('materials');
            $table->foreignId('characteristic_id')->constrained('characteristics');
            $table->string('title');
            $table->text('description');
            $table->integer('quantity');
            $table->integer('code');
            $table->string('model')->nullable();
            $table->boolean('product_promotion')->default(false);
            $table->boolean('top_product')->default(false);
            $table->boolean('rec_product')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
