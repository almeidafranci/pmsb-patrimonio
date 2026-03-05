<?php

namespace App\Filament\Resources\Items\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
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
                    ->label('Tombamento')
                    ->boolean(),
                TextColumn::make('estoque_minimo')
                    ->label('Mín.')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('estoque_atual')
                    ->label('Atual')
                    ->numeric()
                    ->sortable()
                    ->color(fn ($record): string => $record->isEstoqueCritico() ? 'danger' : 'success')
                    ->weight(fn ($record): string => $record->isEstoqueCritico() ? 'bold' : 'normal'),
            ])
            ->filters([
                SelectFilter::make('categoria_id')
                    ->relationship('categoria', 'nome')
                    ->label('Categoria')
                    ->searchable()
                    ->preload(),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
