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
        Schema::create('accountgroups', function (Blueprint $table) {
            $table->string('accountgroup_uuid', 36)->unique();
            $table->integer('code');
            $table->string('name', 70);
            $table->string('description', 100)->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('accountclass_uuid', 36);
            $table->foreign('accountclass_uuid')->references('accountclass_uuid')->on('accountclasses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountgroups');
    }
};
