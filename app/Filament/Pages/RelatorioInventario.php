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

class RelatorioInventario extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $title = 'Inventário por Secretaria';

    protected static ?string $navigationLabel = 'Inventário por Secretaria';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Relatorios;

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.relatorio-table';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Tombamento::query()
                    ->with(['item', 'secretaria', 'departamento'])
                    ->where('status', TombamentoStatus::Ativo)
                    ->whereNotNull('secretaria_id')
            )
            ->columns([
                TextColumn::make('secretaria.sigla')
                    ->label('Secretaria')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('departamento.nome')
                    ->label('Departamento')
                    ->sortable()
                    ->searchable()
                    ->placeholder('—'),
                TextColumn::make('numero_tombamento')
                    ->label('Nº Tombamento')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('item.nome')
                    ->label('Item')
                    ->searchable(),
                TextColumn::make('valor')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),
                TextColumn::make('data_tombamento')
                    ->label('Data Tombamento')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('secretaria_id')
                    ->relationship('secretaria', 'nome')
                    ->label('Secretaria')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('departamento_id')
                    ->relationship('departamento', 'nome')
                    ->label('Departamento')
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('secretaria.sigla');
    }
}
