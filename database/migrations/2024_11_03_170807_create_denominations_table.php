<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('denominations', function (Blueprint $table) {
      $table->string('denomination_uuid',36)->unique();
      $table->enum('type', [1, 2, 3, 4, 5, 6, 7,8,9,10,11,12,13,14,15,16])->default(1);
      $table->integer("bill_200")->default(0);
      $table->integer("bill_100")->default(0);
      $table->integer("bill_50")->default(0);
      $table->integer("bill_20")->default(0);
      $table->integer("bill_10")->default(0);
      $table->integer("coin_5")->default(0);
      $table->integer("coin_2")->default(0);
      $table->integer("coin_1")->default(0);
      $table->integer("coin_0_5")->default(0);
      $table->integer("coin_0_2")->default(0);
      $table->integer("coin_0_1")->default(0);
      $table->decimal('total', 20, 2);
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('denominations');
  }
};
