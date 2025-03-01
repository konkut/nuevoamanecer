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
        Schema::create('cashregisters', function (Blueprint $table) {
            $table->string('cashregister_uuid', 36)->unique();
            $table->string('name', 30)->unique();
            $table->decimal('total', 20, 2)->default(0);
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('denomination_uuid', 36);
            $table->foreign('denomination_uuid')->references('denomination_uuid')->on('denominations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashregisters');
    }
};
