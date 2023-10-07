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
        Schema::create('products_in_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->on('orders')->references('id')->cascadeOnDelete();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->on('products')->references('id')->nullOnDelete();
            $table->string('product_name', 255);
            $table->unsignedFloat('product_price');
            $table->unsignedInteger('product_quantity');
            $table->date('pick_up_date')->nullable();
            $table->date('return_date')->nullable();
            $table->date('expected_pick_up_date');
            $table->date('expected_return_date');
            $table->decimal('deposit', 20, 2);
            $table->decimal('deposit_return', 20, 2);
            $table->string('status');
            $table->unsignedInteger('returned_bad_quantity')->default(0);
            $table->unsignedInteger('returned_good_quantity')->default(0);
            $table->tinyInteger('lated')->default(0)->comment('0:false; 1:true');
            $table->unsignedInteger('rent_time')->default(7);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_in_orders');
    }
};
