<?php

namespace App\Filament\Resources\Tombamentos\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BaixaRelationManager extends RelationManager
{
    protected static string $relationship = 'baixa';

    protected static ?string $title = 'Baixa';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('data_baixa')
                    ->label('Data da Baixa')
                    ->date('d/m/Y'),
                TextColumn::make('motivo')
                    ->badge(),
                TextColumn::make('descricao')
                    ->label('Descrição')
                    ->limit(50),
                TextColumn::make('usuario.name')
                    ->label('Usuário'),
            ]);
    }
}
