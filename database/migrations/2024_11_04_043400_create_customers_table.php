<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

  public function up(): void
  {
    Schema::create('customers', function (Blueprint $table) {
      $table->string('customer_uuid',36)->unique();
      $table->string('name', 100);
      $table->string('last_name', 100);
      $table->string('email',50)->unique();
      $table->string('phone', 20)->nullable();
      $table->string('address',100)->nullable();
      $table->enum('status', ['1', '0'])->default('1');
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('customers');
  }
};
