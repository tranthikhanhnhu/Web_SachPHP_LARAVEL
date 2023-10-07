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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->text('short_description')->nullable();
            $table->tinyInteger('status');
            $table->float('price');
            $table->unsignedBigInteger('publisher_id')->nullable();
            $table->foreign('publisher_id')->references('id')->on('publishers')->nullOnDelete();
            $table->unsignedBigInteger('origin_id')->nullable();
            $table->foreign('origin_id')->references('id')->on('origins')->nullOnDelete();
            $table->integer('publish_year')->nullable();
            $table->tinyInteger('book_layout')->comment('0:paperback; 1:hardcover')->nullable(); // 0:paperback; 1:hardcover
            $table->integer('height')->nullable();
            $table->integer('width')->nullable();
            $table->integer('thickness')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('number_of_pages')->nullable();
            $table->string('author')->nullable();
            $table->unsignedInteger('quantity')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
