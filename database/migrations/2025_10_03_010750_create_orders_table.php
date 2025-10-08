<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_number');
            $table->integer('seats')->default(4);
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->enum('location',['indoor', 'outdoor', 'vip']);
            $table->timestamps();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_id')->constrained('tables', 'id');
            $table->foreignId('customer_id')->constrained('customers');
            $table->enum('status', ['new', 'process','ready','completed']);
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('order_id')->constrained('orders', 'id')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products', 'id');
            $table->integer('quantity');
            $table->timestamps();
        });
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->decimal('total', 10, 2);
            $table->enum('payment_status', ['paid', 'pending'])->default('pending');
            $table->enum('payment_method', ['cash', 'credit_card', 'debit_card', 'mobile'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('tables');
    }
};
