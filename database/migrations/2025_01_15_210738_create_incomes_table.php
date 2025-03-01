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
        Schema::create('incomes', function (Blueprint $table) {
            $table->string('income_uuid', 36)->primary();
            $table->string('observation', 100)->nullable();
            $table->string('cashshift_uuid', 36);
            $table->foreign('cashshift_uuid')->references('cashshift_uuid')->on('cashshifts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
