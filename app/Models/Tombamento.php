<?php

namespace App\Models;

use App\Enums\TombamentoStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tombamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_id',
        'entrada_item_id',
        'numero_tombamento',
        'secretaria_id',
        'departamento_id',
        'valor',
        'data_tombamento',
        'status',
        'observacao',
        'usuario_id',
    ];

    protected function casts(): array
    {
        return [
            'valor' => 'decimal:2',
            'data_tombamento' => 'date',
            'status' => TombamentoStatus::class,
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function entradaItem(): BelongsTo
    {
        return $this->belongsTo(EntradaItem::class);
    }

    public function secretaria(): BelongsTo
    {
        return $this->belongsTo(Secretaria::class);
    }

    public function departamento(): BelongsTo
    {
        return $this->belongsTo(Departamento::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function transferencias(): HasMany
    {
        return $this->hasMany(TransferenciaPatrimonial::class);
    }

    public function baixa(): HasOne
    {
        return $this->hasOne(BaixaPatrimonial::class);
    }

    public function isPendente(): bool
    {
        return $this->status === TombamentoStatus::Pendente;
    }

    public function isAtivo(): bool
    {
        return $this->status === TombamentoStatus::Ativo;
    }
}
