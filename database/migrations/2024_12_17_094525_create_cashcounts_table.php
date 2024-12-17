<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cashcounts', function (Blueprint $table) {
            $table->string('cashcount_uuid', 36)->unique();
            $table->decimal('physical_balance', 20, 2);
            $table->decimal('system_balance', 20, 2)->nullable();
            $table->decimal('difference', 20, 2)->nullable();
            $table->string('observation', 50)->nullable();
            $table->enum('status', ['Completado', 'Pendiente','Cerrado'])->default('Pendiente');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('cashshift_uuid', 36);
            $table->foreign('cashshift_uuid')->references('cashshift_uuid')->on('cashshifts');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cashcounts');
    }
};
