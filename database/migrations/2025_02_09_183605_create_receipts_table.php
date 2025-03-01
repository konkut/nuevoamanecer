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
        Schema::create('receipts', function (Blueprint $table) {
            $table->string('receipt_uuid', 36)->unique();
            $table->string('code', 6)->unique();
            $table->decimal('amount', 20, 2);
            $table->string('income_uuid', 36);
            $table->foreign('income_uuid')->references('income_uuid')->on('incomes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
