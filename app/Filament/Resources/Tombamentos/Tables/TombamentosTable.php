<?php

namespace App\Filament\Resources\Tombamentos\Tables;

use App\Enums\TombamentoStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class TombamentosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero_tombamento')
                    ->label('Nº Tombamento')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Pendente'),
                TextColumn::make('item.nome')
                    ->label('Item')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('secretaria.nome')
                    ->label('Secretaria')
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('departamento.nome')
                    ->label('Departamento')
                    ->toggleable()
                    ->placeholder('—'),
                TextColumn::make('valor')
                    ->money('BRL')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('data_tombamento')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(TombamentoStatus::class),
                SelectFilter::make('secretaria_id')
                    ->relationship('secretaria', 'nome')
                    ->label('Secretaria')
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
                ]),
            ]);
    }
}
