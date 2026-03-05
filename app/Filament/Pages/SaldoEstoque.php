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
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class SaldoEstoque extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $title = 'Saldo de Estoque';

    protected static ?string $navigationLabel = 'Saldo de Estoque';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBarSquare;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Almoxarifado;

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.saldo-estoque';

    public function table(Table $table): Table
    {
        return $table
            ->query(Item::query()->with(['categoria', 'unidadeMedida']))
            ->columns([
                TextColumn::make('nome')
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
                    ->color(fn (Item $record): string => $record->isEstoqueCritico() ? 'danger' : 'success'),
            ])
            ->filters([
                SelectFilter::make('categoria_id')
                    ->relationship('categoria', 'nome')
                    ->label('Categoria')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('estoque_critico')
                    ->label('Situação')
                    ->options([
                        'critico' => 'Estoque Crítico',
                        'normal' => 'Estoque Normal',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if ($data['value'] === 'critico') {
                            $query->whereColumn('estoque_atual', '<=', 'estoque_minimo');
                        } elseif ($data['value'] === 'normal') {
                            $query->whereColumn('estoque_atual', '>', 'estoque_minimo');
                        }
                    }),
            ])
            ->defaultSort('nome');
    }
}
