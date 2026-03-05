<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EntradaItem extends Model
{
    use HasFactory;

    protected $table = 'entrada_itens';

    protected $fillable = [
        'entrada_id',
        'item_id',
        'quantidade',
        'valor_unitario',
    ];

    protected function casts(): array
    {
        return [
            'valor_unitario' => 'decimal:2',
        ];
    }

    public function entrada(): BelongsTo
    {
        return $this->belongsTo(Entrada::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function tombamentos(): HasMany
    {
        return $this->hasMany(Tombamento::class);
    }

    public function valorTotal(): float
    {
        return $this->quantidade * $this->valor_unitario;
    }
}
