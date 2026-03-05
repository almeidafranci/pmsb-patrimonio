<?php

namespace App\Filament\Widgets;

use App\Models\Entrada;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class EntradasChart extends ChartWidget
{
    protected ?string $heading = 'Entradas nos Últimos 6 Meses';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $data = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = Carbon::now()->subMonths($monthsAgo);

            return [
                'label' => $date->translatedFormat('M/y'),
                'count' => Entrada::whereMonth('data_entrada', $date->month)
                    ->whereYear('data_entrada', $date->year)
                    ->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => 'Entradas',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.2)',
                    'borderColor' => 'rgb(59, 130, 246)',
                ],
            ],
            'labels' => $data->pluck('label')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
