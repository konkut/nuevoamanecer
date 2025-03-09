<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accountsubgroups', function (Blueprint $table) {
            $table->string('accountsubgroup_uuid', 36)->unique();
            $table->integer('code');
            $table->string('name', 70);
            $table->string('description', 100)->nullable();
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('accountgroup_uuid', 36);
            $table->foreign('accountgroup_uuid')->references('accountgroup_uuid')->on('accountgroups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountsubgroups');
    }
};
