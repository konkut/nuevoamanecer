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
        Schema::create('sale_platforms', function (Blueprint $table) {
            $table->id();
            $table->string('sale_uuid', 36);
            $table->string('platform_uuid', 36);
            $table->decimal('total', 20, 2);
            $table->integer('index')->nullable();
            $table->foreign('sale_uuid')->references('sale_uuid')->on('sales')->onDelete('cascade');
            $table->foreign('platform_uuid')->references('platform_uuid')->on('platforms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_platforms');
    }
};
