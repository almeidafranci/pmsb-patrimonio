<?php

namespace App\Models;

use App\Enums\BaixaMotivo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaixaPatrimonial extends Model
{
    use HasFactory;

    protected $table = 'baixas_patrimoniais';

    protected $fillable = [
        'tombamento_id',
        'data_baixa',
        'motivo',
        'descricao',
        'usuario_id',
    ];

    protected function casts(): array
    {
        return [
            'data_baixa' => 'date',
            'motivo' => BaixaMotivo::class,
        ];
    }

    public function tombamento(): BelongsTo
    {
        return $this->belongsTo(Tombamento::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
