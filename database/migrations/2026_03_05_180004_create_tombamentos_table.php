<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tombamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('itens');
            $table->foreignId('entrada_item_id')->constrained('entrada_itens');
            $table->string('numero_tombamento')->unique()->nullable();
            $table->foreignId('secretaria_id')->nullable()->constrained();
            $table->foreignId('departamento_id')->nullable()->constrained();
            $table->decimal('valor', 10, 2)->nullable();
            $table->date('data_tombamento')->nullable();
            $table->string('status')->default('pendente');
            $table->text('observacao')->nullable();
            $table->foreignId('usuario_id')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tombamentos');
    }
};
