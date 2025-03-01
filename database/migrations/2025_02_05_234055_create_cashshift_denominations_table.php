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
        Schema::create('cashshift_denominations', function (Blueprint $table) {
            $table->id();
            $table->string('cashshift_uuid', 36);
            $table->string('denomination_uuid', 36);
            $table->enum('type', ['1', '4']);
            $table->foreign('cashshift_uuid')->references('cashshift_uuid')->on('cashshifts')->onDelete('cascade');
            $table->foreign('denomination_uuid')->references('denomination_uuid')->on('denominations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashshift_denominations');
    }
};
