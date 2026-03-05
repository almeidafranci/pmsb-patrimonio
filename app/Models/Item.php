<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'itens';

    protected $fillable = [
        'categoria_id',
        'unidade_medida_id',
        'nome',
        'descricao',
        'requer_tombamento',
        'estoque_minimo',
        'estoque_atual',
    ];

    protected function casts(): array
    {
        return [
            'requer_tombamento' => 'boolean',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    public function unidadeMedida(): BelongsTo
    {
        return $this->belongsTo(UnidadeMedida::class);
    }

    public function movimentacoes(): HasMany
    {
        return $this->hasMany(Movimentacao::class);
    }

    public function tombamentos(): HasMany
    {
        return $this->hasMany(Tombamento::class);
    }

    public function isEstoqueCritico(): bool
    {
        return $this->estoque_atual <= $this->estoque_minimo;
    }
}
