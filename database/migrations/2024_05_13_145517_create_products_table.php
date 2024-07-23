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
            $table->foreignId('material_id')->nullable()->constrained('materials');
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->foreignId('gender_id')->nullable()->constrained('genders');
            $table->foreignId('fabric_composition_id')->nullable()->constrained('fabric_compositions');
            $table->foreignId('style_id')->nullable()->constrained('styles');
            $table->foreignId('season_id')->nullable()->constrained('seasons');
            $table->foreignId('fashion_id')->nullable()->constrained('fashions');
            $table->foreignId('characteristic_id')->nullable()->constrained('characteristics');
            $table->string('img_path')->nullable();
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->text('advantages')->nullable();
            $table->text('outfit')->nullable();
            $table->text('measurements')->nullable();
            $table->integer('code')->unique();
            $table->boolean('product_promotion')->default(false);
            $table->integer('rating')->default(5);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
