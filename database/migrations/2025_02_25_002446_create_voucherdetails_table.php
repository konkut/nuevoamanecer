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
        Schema::create('voucherdetails', function (Blueprint $table) {
            $table->string('voucherdetail_uuid', 36)->unique();
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->integer('index')->nullable();
            $table->string('voucher_uuid', 36);
            $table->foreign('voucher_uuid')->references('voucher_uuid')->on('vouchers');
            $table->string('account_uuid');
            $table->foreign('account_uuid')->references('account_uuid')->on('accounts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucherdetails');
    }
};
