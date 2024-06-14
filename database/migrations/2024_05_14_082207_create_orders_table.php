<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('order_status_id')->constrained('order_statuses');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->foreignId('operator_id')->nullable()->constrained('users');
            $table->foreignId('promo_code_id')->nullable()->constrained('promo_codes');
            $table->string('user_name')->nullable();
            $table->string('user_last_name')->nullable();
            $table->string('user_middle_name')->nullable();
            $table->string('user_phone', 15)->nullable();
            $table->string('user_email')->nullable();
            $table->string('cost_delivery');
            $table->integer('total_price');
            $table->string('currency');
            $table->string('int_doc_number')->nullable();
            $table->string('ref')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
