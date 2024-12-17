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
        Schema::create('denominationables', function (Blueprint $table) {
            $table->string('denominationable_uuid',36);
            $table->string('denominationable_type',36);
            $table->string('denomination_uuid',36);
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
        Schema::dropIfExists('denominationables');
    }
};
