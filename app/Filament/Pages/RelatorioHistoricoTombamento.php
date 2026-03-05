<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Models\TransferenciaPatrimonial;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class RelatorioHistoricoTombamento extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $title = 'Histórico de Tombamento';

    protected static ?string $navigationLabel = 'Histórico de Tombamento';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Relatorios;

    protected static ?int $navigationSort = 5;

    protected string $view = 'filament.pages.relatorio-table';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TransferenciaPatrimonial::query()
                    ->with([
                        'tombamento.item',
                        'secretariaOrigem',
                        'departamentoOrigem',
                        'secretariaDestino',
                        'departamentoDestino',
                        'usuario',
                    ])
            )
            ->columns([
                TextColumn::make('tombamento.numero_tombamento')
                    ->label('Nº Tombamento')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tombamento.item.nome')
                    ->label('Item'),
                TextColumn::make('data_transferencia')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('origem')
                    ->label('Origem')
                    ->state(fn ($record): string => ($record->secretariaOrigem?->sigla ?? '—')
                        .($record->departamentoOrigem ? " / {$record->departamentoOrigem->nome}" : '')),
                TextColumn::make('destino')
                    ->label('Destino')
                    ->state(fn ($record): string => ($record->secretariaDestino?->sigla ?? '—')
                        .($record->departamentoDestino ? " / {$record->departamentoDestino->nome}" : '')),
                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->limit(30)
                    ->toggleable(),
                TextColumn::make('usuario.name')
                    ->label('Usuário')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('tombamento')
                    ->label('Tombamento')
                    ->relationship('tombamento', 'numero_tombamento')
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('data_transferencia', 'desc');
    }
}
