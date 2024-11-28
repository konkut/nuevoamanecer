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
    //actividades de transferencias
    Schema::create('incomefromtransfers', function (Blueprint $table) {
      $table->string('incomefromtransfer_uuid', 36)->unique();
      $table->string('code', 30);
      $table->json('amounts'); // Aquí se almacenará un array de montos (JSON)
      $table->json('commissions'); // Aquí se almacenará un array de comisiones (JSON)
      $table->json('service_uuids'); // Aquí se almacenarán los UUIDs de servicios relacionados (JSON)
      $table->string('observation', 100)->nullable();
      $table->enum('status', ['1', '0'])->default('1');
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
    Schema::dropIfExists('incomefromtransfers');
  }
};
