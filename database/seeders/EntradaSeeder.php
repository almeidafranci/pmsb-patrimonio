<?php

namespace Database\Seeders;

use App\Enums\EntradaStatus;
use App\Enums\MovimentacaoTipo;
use App\Enums\TombamentoStatus;
use App\Models\Entrada;
use App\Models\EntradaItem;
use App\Models\Fornecedor;
use App\Models\Item;
use App\Models\Movimentacao;
use App\Models\Secretaria;
use App\Models\Tombamento;
use App\Models\User;
use Illuminate\Database\Seeder;

class EntradaSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@patrimonio.test')->first();
        $fornecedores = Fornecedor::all();
        $secretarias = Secretaria::with('departamentos')->get();

        $tombamentoItems = Item::where('requer_tombamento', true)->get();
        $consumoItems = Item::where('requer_tombamento', false)->take(4)->get();

        $this->criarEntradaPatrimonio($admin, $fornecedores, $tombamentoItems, $secretarias);
        $this->criarEntradaConsumo($admin, $fornecedores, $consumoItems);
    }

    private function criarEntradaPatrimonio(User $admin, $fornecedores, $tombamentoItems, $secretarias): void
    {
        $entrada = Entrada::create([
            'fornecedor_id' => $fornecedores->where('nome', 'InfoTech Soluções em TI')->first()?->id ?? $fornecedores->first()->id,
            'numero_nota' => 'NF-2026/001',
            'data_entrada' => '2026-02-15',
            'observacao' => 'Entrada inicial de equipamentos de informática e mobiliário',
            'usuario_id' => $admin->id,
            'status' => EntradaStatus::Confirmada,
        ]);

        $tombamentoNum = 1;

        foreach ($tombamentoItems as $item) {
            $quantidade = match (true) {
                str_contains($item->nome, 'Computador') => 5,
                str_contains($item->nome, 'Monitor') => 5,
                str_contains($item->nome, 'Impressora') => 3,
                str_contains($item->nome, 'Notebook') => 2,
                str_contains($item->nome, 'Mesa') => 4,
                str_contains($item->nome, 'Cadeira') => 6,
                str_contains($item->nome, 'Armário') => 3,
                str_contains($item->nome, 'Estante') => 2,
                str_contains($item->nome, 'Esfigmomanômetro') => 4,
                str_contains($item->nome, 'Balança') => 2,
                default => 2,
            };

            $valorUnitario = match (true) {
                str_contains($item->nome, 'Computador') => 3500.00,
                str_contains($item->nome, 'Monitor') => 890.00,
                str_contains($item->nome, 'Impressora') => 1250.00,
                str_contains($item->nome, 'Notebook') => 4200.00,
                str_contains($item->nome, 'Mesa') => 650.00,
                str_contains($item->nome, 'Cadeira') => 480.00,
                str_contains($item->nome, 'Armário') => 780.00,
                str_contains($item->nome, 'Estante') => 420.00,
                str_contains($item->nome, 'Esfigmomanômetro') => 320.00,
                str_contains($item->nome, 'Balança') => 1100.00,
                default => 500.00,
            };

            $entradaItem = EntradaItem::create([
                'entrada_id' => $entrada->id,
                'item_id' => $item->id,
                'quantidade' => $quantidade,
                'valor_unitario' => $valorUnitario,
            ]);

            Movimentacao::create([
                'item_id' => $item->id,
                'tipo' => MovimentacaoTipo::Entrada,
                'quantidade' => $quantidade,
                'saldo_anterior' => $item->estoque_atual,
                'saldo_atual' => $item->estoque_atual + $quantidade,
                'referencia_tipo' => 'entrada',
                'referencia_id' => $entrada->id,
                'data' => $entrada->data_entrada,
                'usuario_id' => $admin->id,
            ]);

            $item->increment('estoque_atual', $quantidade);

            $distribuidos = (int) ceil($quantidade / 2);
            $secretariaPool = $secretarias->shuffle();

            for ($i = 0; $i < $quantidade; $i++) {
                $emAlmoxarifado = $i >= $distribuidos;

                $sec = $emAlmoxarifado ? null : $secretariaPool[$i % $secretariaPool->count()];
                $dep = $emAlmoxarifado ? null : $sec->departamentos->random();

                Tombamento::create([
                    'item_id' => $item->id,
                    'entrada_item_id' => $entradaItem->id,
                    'numero_tombamento' => sprintf('PMB-%05d', $tombamentoNum++),
                    'secretaria_id' => $sec?->id,
                    'departamento_id' => $dep?->id,
                    'valor' => $valorUnitario,
                    'data_tombamento' => '2026-02-16',
                    'status' => TombamentoStatus::Ativo,
                    'observacao' => null,
                    'usuario_id' => $admin->id,
                ]);
            }
        }
    }

    private function criarEntradaConsumo(User $admin, $fornecedores, $consumoItems): void
    {
        $entrada = Entrada::create([
            'fornecedor_id' => $fornecedores->where('nome', 'Papelaria Central Ltda')->first()?->id ?? $fornecedores->first()->id,
            'numero_nota' => 'NF-2026/002',
            'data_entrada' => '2026-02-20',
            'observacao' => 'Reposição de material de escritório e limpeza',
            'usuario_id' => $admin->id,
            'status' => EntradaStatus::Confirmada,
        ]);

        foreach ($consumoItems as $item) {
            $quantidade = fake()->numberBetween(20, 50);
            $valorUnitario = fake()->randomFloat(2, 5, 80);

            EntradaItem::create([
                'entrada_id' => $entrada->id,
                'item_id' => $item->id,
                'quantidade' => $quantidade,
                'valor_unitario' => $valorUnitario,
            ]);

            Movimentacao::create([
                'item_id' => $item->id,
                'tipo' => MovimentacaoTipo::Entrada,
                'quantidade' => $quantidade,
                'saldo_anterior' => $item->estoque_atual,
                'saldo_atual' => $item->estoque_atual + $quantidade,
                'referencia_tipo' => 'entrada',
                'referencia_id' => $entrada->id,
                'data' => $entrada->data_entrada,
                'usuario_id' => $admin->id,
            ]);

            $item->increment('estoque_atual', $quantidade);
        }
    }
}
