<?php

namespace App\Models;

use App\Enums\MovimentacaoTipo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Movimentacao extends Model
{
    use HasFactory;

    protected $table = 'movimentacoes';

    protected $fillable = [
        'item_id',
        'tipo',
        'quantidade',
        'saldo_anterior',
        'saldo_atual',
        'referencia_tipo',
        'referencia_id',
        'data',
        'usuario_id',
    ];

    protected function casts(): array
    {
        return [
            'tipo' => MovimentacaoTipo::class,
            'data' => 'date',
        ];
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function referencia(): MorphTo
    {
        return $this->morphTo(name: 'referencia');
    }
}
