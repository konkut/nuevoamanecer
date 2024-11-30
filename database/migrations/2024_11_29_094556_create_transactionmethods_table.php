<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transactionmethods', function (Blueprint $table) {
            $table->string('transactionmethod_uuid', 36)->unique();
            $table->string('name', 30)->unique();
            $table->string('description', 100)->nullable();
            $table->enum('status', ['1', '0'])->default('1');
            $table->timestamps();
            $table->softDeletes();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('transactionmethods');
    }
};
