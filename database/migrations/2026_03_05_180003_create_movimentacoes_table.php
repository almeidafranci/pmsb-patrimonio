<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('itens');
            $table->string('tipo');
            $table->integer('quantidade');
            $table->integer('saldo_anterior');
            $table->integer('saldo_atual');
            $table->string('referencia_tipo');
            $table->unsignedBigInteger('referencia_id');
            $table->date('data');
            $table->foreignId('usuario_id')->constrained('users');
            $table->timestamps();

            $table->index(['referencia_tipo', 'referencia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentacoes');
    }
};
