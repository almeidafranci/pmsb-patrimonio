<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisicaoItem extends Model
{
    use HasFactory;

    protected $table = 'requisicao_itens';

    protected $fillable = [
        'requisicao_id',
        'item_id',
        'quantidade_solicitada',
        'quantidade_atendida',
    ];

    public function requisicao(): BelongsTo
    {
        return $this->belongsTo(Requisicao::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
