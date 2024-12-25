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
            $table->json('names');
            $table->json('amounts');
            $table->json('commissions')->nullable();
            $table->string('observation', 100)->nullable();
            $table->json('servicewithoutprice_uuids');
            $table->json('transactionmethod_uuids');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('cashshift_uuid', 36);
            $table->foreign('cashshift_uuid')->references('cashshift_uuid')->on('cashshifts');
            $table->string('denomination_uuid', 36);
            $table->foreign('denomination_uuid')->references('denomination_uuid')->on('denominations');
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
