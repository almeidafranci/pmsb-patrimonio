<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained();
            $table->foreignId('unidade_medida_id')->constrained('unidades_medida');
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->boolean('requer_tombamento')->default(false);
            $table->integer('estoque_minimo')->default(0);
            $table->integer('estoque_atual')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itens');
    }
};
