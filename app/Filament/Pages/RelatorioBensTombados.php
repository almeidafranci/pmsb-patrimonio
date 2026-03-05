<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Enums\TombamentoStatus;
use App\Models\Tombamento;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class RelatorioBensTombados extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $title = 'Bens Tombados';

    protected static ?string $navigationLabel = 'Bens Tombados';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Relatorios;

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.relatorio-table';

    public function table(Table $table): Table
    {
        return $table
            ->query(Tombamento::query()->with(['item', 'secretaria', 'departamento']))
            ->columns([
                TextColumn::make('numero_tombamento')
                    ->label('Nº Tombamento')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Pendente'),
                TextColumn::make('item.nome')
                    ->label('Item')
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('secretaria.sigla')
                    ->label('Secretaria')
                    ->sortable()
                    ->placeholder('Almoxarifado'),
                TextColumn::make('departamento.nome')
                    ->label('Departamento')
                    ->placeholder('—'),
                TextColumn::make('valor')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),
                TextColumn::make('data_tombamento')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(TombamentoStatus::class),
                SelectFilter::make('secretaria_id')
                    ->relationship('secretaria', 'nome')
                    ->label('Secretaria')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('item_id')
                    ->relationship('item', 'nome')
                    ->label('Item')
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('numero_tombamento');
    }
}
