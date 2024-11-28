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
    Schema::create('currencies', function (Blueprint $table) {
      $table->string('currency_uuid',36)->unique();
      $table->string('name', 30)->unique();
      $table->string('symbol', 10)->nullable();
      $table->decimal('exchange_rate', 10, 2)->nullable();
      $table->enum('status', ['1', '0'])->default('1');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('currencies');
  }
};
