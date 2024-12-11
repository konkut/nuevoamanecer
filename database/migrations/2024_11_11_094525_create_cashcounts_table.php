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
      $table->enum('status', ['1', '0'])->default('1');
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
