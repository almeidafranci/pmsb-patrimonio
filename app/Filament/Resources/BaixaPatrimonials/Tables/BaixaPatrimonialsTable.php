<?php

namespace App\Filament\Resources\BaixaPatrimonials\Tables;

use App\Enums\BaixaMotivo;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BaixaPatrimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tombamento.numero_tombamento')
                    ->label('Nº Tombamento')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tombamento.item.nome')
                    ->label('Item'),
                TextColumn::make('data_baixa')
                    ->label('Data da Baixa')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('motivo')
                    ->badge(),
                TextColumn::make('usuario.name')
                    ->label('Usuário')
                    ->toggleable(),
            ])
            ->defaultSort('data_baixa', 'desc')
            ->filters([
                SelectFilter::make('motivo')
                    ->options(BaixaMotivo::class),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
