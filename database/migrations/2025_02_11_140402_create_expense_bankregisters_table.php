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
        Schema::create('expense_bankregisters', function (Blueprint $table) {
            $table->id();
            $table->string('expense_uuid', 36);
            $table->string('bankregister_uuid', 36);
            $table->decimal('total', 20, 2);
            $table->foreign('expense_uuid')->references('expense_uuid')->on('expenses')->onDelete('cascade');
            $table->foreign('bankregister_uuid')->references('bankregister_uuid')->on('bankregisters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_bankregisters');
    }
};
