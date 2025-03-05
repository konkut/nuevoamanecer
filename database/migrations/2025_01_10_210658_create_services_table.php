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
        Schema::create('services', function (Blueprint $table) {
            $table->string('service_uuid', 36)->unique();
            $table->string('name', 70)->unique();
            $table->string('description', 110)->nullable();
            $table->decimal('amount', 20, 2)->nullable();
            $table->decimal('commission', 10, 2)->nullable();
            $table->enum('status', [1, 0])->default(1);
            $table->string('category_uuid', 36);
            $table->foreign('category_uuid')->references('category_uuid')->on('categories');
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
        Schema::dropIfExists('services');
    }
};
