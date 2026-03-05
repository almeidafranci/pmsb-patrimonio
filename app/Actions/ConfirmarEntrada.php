<?php

namespace App\Actions;

use App\Enums\EntradaStatus;
use App\Enums\MovimentacaoTipo;
use App\Enums\TombamentoStatus;
use App\Models\Entrada;
use App\Models\Movimentacao;
use App\Models\Tombamento;
use Illuminate\Support\Facades\DB;

class ConfirmarEntrada
{
    public function execute(Entrada $entrada): void
    {
        if ($entrada->isConfirmada()) {
            throw new \RuntimeException('Esta entrada já foi confirmada.');
        }

        if ($entrada->itens->isEmpty()) {
            throw new \RuntimeException('A entrada precisa ter ao menos um item.');
        }

        DB::transaction(function () use ($entrada) {
            $entrada->load('itens.item');

            foreach ($entrada->itens as $entradaItem) {
                $item = $entradaItem->item;
                $saldoAnterior = $item->estoque_atual;
                $novoSaldo = $saldoAnterior + $entradaItem->quantidade;

                $item->update(['estoque_atual' => $novoSaldo]);

                Movimentacao::create([
                    'item_id' => $item->id,
                    'tipo' => MovimentacaoTipo::Entrada,
                    'quantidade' => $entradaItem->quantidade,
                    'saldo_anterior' => $saldoAnterior,
                    'saldo_atual' => $novoSaldo,
                    'referencia_tipo' => 'entrada',
                    'referencia_id' => $entrada->id,
                    'data' => $entrada->data_entrada,
                    'usuario_id' => auth()->id(),
                ]);

                if ($item->requer_tombamento) {
                    for ($i = 0; $i < $entradaItem->quantidade; $i++) {
                        Tombamento::create([
                            'item_id' => $item->id,
                            'entrada_item_id' => $entradaItem->id,
                            'valor' => $entradaItem->valor_unitario,
                            'status' => TombamentoStatus::Pendente,
                            'usuario_id' => auth()->id(),
                        ]);
                    }
                }
            }

            $entrada->update(['status' => EntradaStatus::Confirmada]);
        });
    }
}
