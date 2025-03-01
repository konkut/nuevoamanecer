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
        Schema::create('income_cashregisters', function (Blueprint $table) {
            $table->id();
            $table->string('income_uuid', 36);
            $table->string('cashregister_uuid', 36);
            $table->decimal('total', 20, 2);
            $table->enum('type', ['2', '3']);
            $table->integer('index')->nullable();
            $table->foreign('income_uuid')->references('income_uuid')->on('incomes')->onDelete('cascade');
            $table->foreign('cashregister_uuid')->references('cashregister_uuid')->on('cashregisters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_cashregisters');
    }
};
