<?php

namespace App\Actions;

use App\Enums\MovimentacaoTipo;
use App\Enums\RequisicaoStatus;
use App\Models\Movimentacao;
use App\Models\Requisicao;
use Illuminate\Support\Facades\DB;

class ConfirmarRequisicao
{
    public function execute(Requisicao $requisicao): void
    {
        if ($requisicao->isConfirmada()) {
            throw new \RuntimeException('Esta requisição já foi confirmada.');
        }

        $requisicao->load(['itens.item', 'requisicaoTombamentos.tombamento']);

        $hasItens = $requisicao->itens->isNotEmpty();
        $hasTombamentos = $requisicao->requisicaoTombamentos->isNotEmpty();

        if (! $hasItens && ! $hasTombamentos) {
            throw new \RuntimeException('A requisição precisa ter ao menos um item ou tombamento.');
        }

        DB::transaction(function () use ($requisicao) {
            foreach ($requisicao->itens as $requisicaoItem) {
                $item = $requisicaoItem->item;
                $quantidade = $requisicaoItem->quantidade_atendida ?: $requisicaoItem->quantidade_solicitada;
                $saldoAnterior = $item->estoque_atual;
                $novoSaldo = $saldoAnterior - $quantidade;

                if ($novoSaldo < 0) {
                    throw new \RuntimeException("Estoque insuficiente para o item: {$item->nome}. Disponível: {$saldoAnterior}, Solicitado: {$quantidade}");
                }

                $item->update(['estoque_atual' => $novoSaldo]);

                $requisicaoItem->update(['quantidade_atendida' => $quantidade]);

                Movimentacao::create([
                    'item_id' => $item->id,
                    'tipo' => MovimentacaoTipo::Saida,
                    'quantidade' => $quantidade,
                    'saldo_anterior' => $saldoAnterior,
                    'saldo_atual' => $novoSaldo,
                    'referencia_tipo' => 'requisicao',
                    'referencia_id' => $requisicao->id,
                    'data' => $requisicao->data_requisicao,
                    'usuario_id' => auth()->id(),
                ]);
            }

            foreach ($requisicao->requisicaoTombamentos as $requisicaoTombamento) {
                $tombamento = $requisicaoTombamento->tombamento;

                $tombamento->update([
                    'secretaria_id' => $requisicao->secretaria_id,
                    'departamento_id' => $requisicao->departamento_id,
                ]);
            }

            $requisicao->update(['status' => RequisicaoStatus::Confirmada]);
        });
    }
}
