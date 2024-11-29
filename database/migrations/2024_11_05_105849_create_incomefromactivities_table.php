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
    //actividades de servicio
    Schema::create('incomefromactivities', function (Blueprint $table) {
      $table->string('incomefromactivities_uuid', 36)->unique();
      $table->decimal('amount', 20, 2);
      $table->decimal('commission', 10, 2)->nullable();
      $table->string('observation', 100)->nullable();
      $table->enum('status', ['1', '0'])->default('1');
      //$table->string('service_uuid', 36);
      //$table->foreign('service_uuid')->references('service_uuid')->on('services');
      $table->string('customer_uuid', 36);
      $table->foreign('customer_uuid')->references('customer_uuid')->on('customers');
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
    Schema::dropIfExists('incomefromactivities');
  }
};
