<?php

namespace App\Models;

use App\Enums\RequisicaoStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requisicao extends Model
{
    use HasFactory;

    protected $table = 'requisicoes';

    protected $fillable = [
        'secretaria_id',
        'departamento_id',
        'data_requisicao',
        'responsavel',
        'observacao',
        'usuario_id',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'data_requisicao' => 'date',
            'status' => RequisicaoStatus::class,
        ];
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

    public function itens(): HasMany
    {
        return $this->hasMany(RequisicaoItem::class);
    }

    public function requisicaoTombamentos(): HasMany
    {
        return $this->hasMany(RequisicaoTombamento::class);
    }

    public function tombamentos(): BelongsToMany
    {
        return $this->belongsToMany(Tombamento::class, 'requisicao_tombamentos');
    }

    public function isRascunho(): bool
    {
        return $this->status === RequisicaoStatus::Rascunho;
    }

    public function isConfirmada(): bool
    {
        return $this->status === RequisicaoStatus::Confirmada;
    }
}
