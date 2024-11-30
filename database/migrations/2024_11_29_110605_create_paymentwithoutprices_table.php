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
        Schema::create('paymentwithoutprices', function (Blueprint $table) {
            $table->string('paymentwithoutprice_uuid', 36)->unique();
            $table->string('observation', 100)->nullable();
            $table->string('servicewithprice_uuid', 36);
            $table->foreign('servicewithprice_uuid')->references('servicewithprice_uuid')->on('servicewithprices');
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

    public function down(): void
    {
        Schema::dropIfExists('paymentwithoutprices');
    }
};
