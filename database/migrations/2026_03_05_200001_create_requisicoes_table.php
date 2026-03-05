<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requisicoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secretaria_id')->constrained();
            $table->foreignId('departamento_id')->nullable()->constrained();
            $table->date('data_requisicao');
            $table->string('responsavel');
            $table->text('observacao')->nullable();
            $table->foreignId('usuario_id')->constrained('users');
            $table->string('status')->default('rascunho');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisicoes');
    }
};
