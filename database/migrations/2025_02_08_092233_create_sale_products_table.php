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
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->string('sale_uuid', 36);
            $table->string('product_uuid', 36);
            $table->integer('quantity');
            $table->decimal('amount', 20, 2);
            $table->integer('index')->nullable();
            $table->foreign('sale_uuid')->references('sale_uuid')->on('sales')->onDelete('cascade');
            $table->foreign('product_uuid')->references('product_uuid')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_products');
    }
};
