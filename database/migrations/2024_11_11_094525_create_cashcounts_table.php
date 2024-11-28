<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('cashcounts', function (Blueprint $table) {
      $table->string('cashcount_uuid', 36)->unique();
      $table->date('date')->unique();  
      $table->decimal('opening', 20, 2);
      $table->decimal('closing', 20, 2)->nullable(); 
      $table->string('opening_denomination_uuid', 36);
      $table->foreign('opening_denomination_uuid')->references('denomination_uuid')->on('denominations');
      $table->string('closing_denomination_uuid', 36)->nullable(); 
      $table->foreign('closing_denomination_uuid')->references('denomination_uuid')->on('denominations');
      $table->unsignedBigInteger('user_id'); 
      $table->foreign('user_id')->references('id')->on('users');
      $table->timestamps();
      $table->softDeletes();
    });
  } 
  public function down(): void
  {
    Schema::dropIfExists('cashcounts');
  }
};
