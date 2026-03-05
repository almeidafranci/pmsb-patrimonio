<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entrada_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrada_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained('itens');
            $table->integer('quantidade');
            $table->decimal('valor_unitario', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrada_itens');
    }
};
