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
        Schema::create('income_denominations', function (Blueprint $table) {
            $table->id();
            $table->string('income_uuid', 36);
            $table->string('denomination_uuid', 36);
            $table->enum('type', ['2', '3']);
            $table->foreign('income_uuid')->references('income_uuid')->on('incomes')->onDelete('cascade');
            $table->foreign('denomination_uuid')->references('denomination_uuid')->on('denominations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_denominations');
    }
};
