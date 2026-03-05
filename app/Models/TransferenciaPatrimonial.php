<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransferenciaPatrimonial extends Model
{
    use HasFactory;

    protected $table = 'transferencias_patrimoniais';

    protected $fillable = [
        'tombamento_id',
        'secretaria_origem_id',
        'departamento_origem_id',
        'secretaria_destino_id',
        'departamento_destino_id',
        'data_transferencia',
        'motivo',
        'observacao',
        'usuario_id',
    ];

    protected function casts(): array
    {
        return [
            'data_transferencia' => 'date',
        ];
    }

    public function tombamento(): BelongsTo
    {
        return $this->belongsTo(Tombamento::class);
    }

    public function secretariaOrigem(): BelongsTo
    {
        return $this->belongsTo(Secretaria::class, 'secretaria_origem_id');
    }

    public function departamentoOrigem(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_origem_id');
    }

    public function secretariaDestino(): BelongsTo
    {
        return $this->belongsTo(Secretaria::class, 'secretaria_destino_id');
    }

    public function departamentoDestino(): BelongsTo
    {
        return $this->belongsTo(Departamento::class, 'departamento_destino_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
