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
        Schema::create('companies', function (Blueprint $table) {
            $table->string('company_uuid', 36)->unique();
            $table->string('name', 100)->unique();
            $table->bigInteger('nit');
            $table->string('description', 150)->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('activity_uuid', 36);
            $table->foreign('activity_uuid')->references('activity_uuid')->on('activities');
            $table->string('businesstype_uuid', 36);
            $table->foreign('businesstype_uuid')->references('businesstype_uuid')->on('businesstypes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
