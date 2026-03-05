<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transferencias_patrimoniais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tombamento_id')->constrained();
            $table->foreignId('secretaria_origem_id')->constrained('secretarias');
            $table->foreignId('departamento_origem_id')->nullable()->constrained('departamentos');
            $table->foreignId('secretaria_destino_id')->constrained('secretarias');
            $table->foreignId('departamento_destino_id')->nullable()->constrained('departamentos');
            $table->date('data_transferencia');
            $table->text('motivo')->nullable();
            $table->text('observacao')->nullable();
            $table->foreignId('usuario_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transferencias_patrimoniais');
    }
};
