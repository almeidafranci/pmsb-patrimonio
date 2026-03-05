<?php

namespace App\Actions;

use App\Enums\BaixaMotivo;
use App\Enums\TombamentoStatus;
use App\Models\BaixaPatrimonial;
use App\Models\Tombamento;
use Illuminate\Support\Facades\DB;

class RegistrarBaixa
{
    /**
     * @param  array{data_baixa: string, motivo: BaixaMotivo, descricao: ?string}  $data
     */
    public function execute(Tombamento $tombamento, array $data): BaixaPatrimonial
    {
        if (! $tombamento->isAtivo()) {
            throw new \RuntimeException('Apenas tombamentos com status "Ativo" podem receber baixa.');
        }

        return DB::transaction(function () use ($tombamento, $data) {
            $baixa = BaixaPatrimonial::create([
                'tombamento_id' => $tombamento->id,
                'data_baixa' => $data['data_baixa'],
                'motivo' => $data['motivo'],
                'descricao' => $data['descricao'] ?? null,
                'usuario_id' => auth()->id(),
            ]);

            $tombamento->update(['status' => TombamentoStatus::Baixado]);

            return $baixa;
        });
    }
}
