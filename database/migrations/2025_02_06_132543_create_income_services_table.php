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
        Schema::create('income_services', function (Blueprint $table) {
            $table->id();
            $table->string('income_uuid', 36);
            $table->string('service_uuid', 36);
            $table->integer('code')->nullable();
            $table->integer('quantity');
            $table->decimal('amount', 20, 2);
            $table->decimal('commission', 20, 2)->nullable();
            $table->integer('index')->nullable();
            $table->foreign('income_uuid')->references('income_uuid')->on('incomes')->onDelete('cascade');
            $table->foreign('service_uuid')->references('service_uuid')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_services');
    }
};
