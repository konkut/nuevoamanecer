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
        Schema::create('paymentwithprices', function (Blueprint $table) {
            $table->string('paymentwithprice_uuid', 36)->unique();
            $table->string('name', 30);
            $table->decimal('amount', 20, 2);
            $table->decimal('commission', 10, 2)->nullable();
            $table->string('observation', 100)->nullable();
            $table->string('servicewithoutprice_uuid', 36);
            $table->foreign('servicewithoutprice_uuid')->references('servicewithoutprice_uuid')->on('servicewithoutprices');
            $table->string('transactionmethod_uuid', 36);
            $table->foreign('transactionmethod_uuid')->references('transactionmethod_uuid')->on('transactionmethods');
            $table->string('denomination_uuid', 36);
            $table->foreign('denomination_uuid')->references('denomination_uuid')->on('denominations');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentwithprices');
    }
};
