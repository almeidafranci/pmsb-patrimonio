<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisicaoTombamento extends Model
{
    use HasFactory;

    protected $table = 'requisicao_tombamentos';

    protected $fillable = [
        'requisicao_id',
        'tombamento_id',
    ];

    public function requisicao(): BelongsTo
    {
        return $this->belongsTo(Requisicao::class);
    }

    public function tombamento(): BelongsTo
    {
        return $this->belongsTo(Tombamento::class);
    }
}
