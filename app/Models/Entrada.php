<?php

namespace App\Models;

use App\Enums\EntradaStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entrada extends Model
{
    use HasFactory;

    protected $fillable = [
        'fornecedor_id',
        'numero_nota',
        'data_entrada',
        'observacao',
        'usuario_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'data_entrada' => 'date',
            'status' => EntradaStatus::class,
        ];
    }

    public function fornecedor(): BelongsTo
    {
        return $this->belongsTo(Fornecedor::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function itens(): HasMany
    {
        return $this->hasMany(EntradaItem::class);
    }

    public function isRascunho(): bool
    {
        return $this->status === EntradaStatus::Rascunho;
    }

    public function isConfirmada(): bool
    {
        return $this->status === EntradaStatus::Confirmada;
    }
}
