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
      $table->string('email',50)->unique();
      $table->string('phone', 20);
      $table->text('address',100);
      $table->boolean('status')->default(true);
      $table->unsignedBigInteger('user_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('customers');
  }
};
