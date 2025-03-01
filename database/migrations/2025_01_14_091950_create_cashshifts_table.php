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
        Schema::create('cashshifts', function (Blueprint $table) {
            $table->string('cashshift_uuid', 36)->unique();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->string('observation', 50)->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('cashregister_uuid', 36);
            $table->foreign('cashregister_uuid')->references('cashregister_uuid')->on('cashregisters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashshifts');
    }
};
