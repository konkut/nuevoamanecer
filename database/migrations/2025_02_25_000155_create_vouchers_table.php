<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->string('voucher_uuid', 36)->unique();
            $table->string('number', 20)->unique();
            $table->enum('type', ['1', '2', '3']);
            $table->date('date');
            $table->string('narration', 255)->nullable();
            $table->string('cheque_number', 50)->nullable();
            $table->decimal('ufv', 10, 4)->nullable();
            $table->decimal('usd', 10, 2)->nullable();
            $table->string('company_uuid', 36);
            $table->foreign('company_uuid')->references('company_uuid')->on('companies');
            $table->string('project_uuid', 36)->nullable();
            $table->foreign('project_uuid')->references('project_uuid')->on('projects');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
