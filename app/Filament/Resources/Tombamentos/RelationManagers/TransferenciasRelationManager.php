<?php

namespace App\Filament\Resources\Tombamentos\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransferenciasRelationManager extends RelationManager
{
    protected static string $relationship = 'transferencias';

    protected static ?string $title = 'Transferências';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('data_transferencia')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('secretariaOrigem.nome')
                    ->label('Origem'),
                TextColumn::make('secretariaDestino.nome')
                    ->label('Destino'),
                TextColumn::make('motivo')
                    ->limit(40),
                TextColumn::make('usuario.name')
                    ->label('Usuário'),
            ])
            ->defaultSort('data_transferencia', 'desc');
    }
}
