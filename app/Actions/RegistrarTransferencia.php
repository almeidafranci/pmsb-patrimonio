<?php

namespace App\Actions;

use App\Models\Tombamento;
use App\Models\TransferenciaPatrimonial;
use Illuminate\Support\Facades\DB;

class RegistrarTransferencia
{
    /**
     * @param  array{secretaria_destino_id: int, departamento_destino_id: ?int, data_transferencia: string, motivo: ?string, observacao: ?string}  $data
     */
    public function execute(Tombamento $tombamento, array $data): TransferenciaPatrimonial
    {
        if (! $tombamento->isAtivo()) {
            throw new \RuntimeException('Apenas tombamentos com status "Ativo" podem ser transferidos.');
        }

        return DB::transaction(function () use ($tombamento, $data) {
            $transferencia = TransferenciaPatrimonial::create([
                'tombamento_id' => $tombamento->id,
                'secretaria_origem_id' => $tombamento->secretaria_id,
                'departamento_origem_id' => $tombamento->departamento_id,
                'secretaria_destino_id' => $data['secretaria_destino_id'],
                'departamento_destino_id' => $data['departamento_destino_id'] ?? null,
                'data_transferencia' => $data['data_transferencia'],
                'motivo' => $data['motivo'] ?? null,
                'observacao' => $data['observacao'] ?? null,
                'usuario_id' => auth()->id(),
            ]);

            $tombamento->update([
                'secretaria_id' => $data['secretaria_destino_id'],
                'departamento_id' => $data['departamento_destino_id'] ?? null,
            ]);

            return $transferencia;
        });
    }
}
