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
        Schema::create('sales', function (Blueprint $table) {
            $table->string('sale_uuid', 36)->unique();
            $table->string('observation', 100)->nullable();
            $table->string('denomination_uuid', 36)->nullable();
            $table->foreign('denomination_uuid')->references('denomination_uuid')->on('denominations')->onDelete('cascade');
            $table->string('cashshift_uuid', 36);
            $table->foreign('cashshift_uuid')->references('cashshift_uuid')->on('cashshifts');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
