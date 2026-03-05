<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('baixas_patrimoniais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tombamento_id')->constrained();
            $table->date('data_baixa');
            $table->string('motivo');
            $table->text('descricao')->nullable();
            $table->foreignId('usuario_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('baixas_patrimoniais');
    }
};
