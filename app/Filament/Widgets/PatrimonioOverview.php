<?php

namespace App\Filament\Widgets;

use App\Enums\TombamentoStatus;
use App\Models\Entrada;
use App\Models\Item;
use App\Models\Requisicao;
use App\Models\Tombamento;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatrimonioOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $bensAtivos = Tombamento::where('status', TombamentoStatus::Ativo)->count();
        $itensCriticos = Item::whereColumn('estoque_atual', '<=', 'estoque_minimo')->count();
        $entradasMes = Entrada::whereMonth('data_entrada', now()->month)
            ->whereYear('data_entrada', now()->year)
            ->count();
        $requisicoesMes = Requisicao::whereMonth('data_requisicao', now()->month)
            ->whereYear('data_requisicao', now()->year)
            ->count();
        $bensEmAlmoxarifado = Tombamento::where('status', TombamentoStatus::Ativo)
            ->whereNull('secretaria_id')
            ->count();
        $totalItens = Item::withoutTrashed()->count();

        return [
            Stat::make('Bens Tombados Ativos', $bensAtivos)
                ->description("{$bensEmAlmoxarifado} em almoxarifado")
                ->color('primary'),
            Stat::make('Itens em Estoque Crítico', $itensCriticos)
                ->description("de {$totalItens} itens cadastrados")
                ->color($itensCriticos > 0 ? 'danger' : 'success'),
            Stat::make('Entradas no Mês', $entradasMes)
                ->description(now()->translatedFormat('F/Y'))
                ->color('info'),
            Stat::make('Requisições no Mês', $requisicoesMes)
                ->description(now()->translatedFormat('F/Y'))
                ->color('warning'),
        ];
    }
}
