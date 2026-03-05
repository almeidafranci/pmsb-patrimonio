<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Models\Item;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class RelatorioEstoqueCritico extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $title = 'Estoque Abaixo do Mínimo';

    protected static ?string $navigationLabel = 'Estoque Crítico';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationTriangle;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Relatorios;

    protected static ?int $navigationSort = 4;

    protected string $view = 'filament.pages.relatorio-table';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Item::query()
                    ->with(['categoria', 'unidadeMedida'])
                    ->whereColumn('estoque_atual', '<=', 'estoque_minimo')
            )
            ->columns([
                TextColumn::make('nome')
                    ->label('Item')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('categoria.nome')
                    ->label('Categoria')
                    ->sortable(),
                TextColumn::make('unidadeMedida.sigla')
                    ->label('Unidade'),
                IconColumn::make('requer_tombamento')
                    ->label('Tombável')
                    ->boolean(),
                TextColumn::make('estoque_minimo')
                    ->label('Mínimo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estoque_atual')
                    ->label('Atual')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('danger'),
                TextColumn::make('deficit')
                    ->label('Déficit')
                    ->state(fn (Item $record): int => $record->estoque_minimo - $record->estoque_atual)
                    ->numeric()
                    ->sortable(query: fn ($query, $direction) => $query
                        ->orderByRaw("(estoque_minimo - estoque_atual) {$direction}")),
            ])
            ->filters([
                SelectFilter::make('categoria_id')
                    ->relationship('categoria', 'nome')
                    ->label('Categoria')
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('estoque_atual');
    }
}
