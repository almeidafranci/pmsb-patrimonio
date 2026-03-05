<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requisicao_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisicao_id')->constrained('requisicoes')->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('itens');
            $table->integer('quantidade_solicitada');
            $table->integer('quantidade_atendida')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requisicao_itens');
    }
};
