<?php

namespace App\Filament\Resources\TransferenciaPatrimonials\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransferenciaPatrimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tombamento.numero_tombamento')
                    ->label('Nº Tombamento')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('secretariaOrigem.nome')
                    ->label('Origem'),
                TextColumn::make('secretariaDestino.nome')
                    ->label('Destino'),
                TextColumn::make('data_transferencia')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('usuario.name')
                    ->label('Usuário')
                    ->toggleable(),
            ])
            ->defaultSort('data_transferencia', 'desc')
            ->recordActions([
                EditAction::make(),
            ]);
    }
}
