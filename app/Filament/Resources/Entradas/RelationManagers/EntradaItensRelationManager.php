<?php

namespace App\Filament\Resources\Entradas\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EntradaItensRelationManager extends RelationManager
{
    protected static string $relationship = 'itens';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('item_id')
                    ->relationship('item', 'nome')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('quantidade')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                TextInput::make('valor_unitario')
                    ->label('Valor Unitário (R$)')
                    ->required()
                    ->numeric()
                    ->prefix('R$')
                    ->minValue(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item.nome')
            ->columns([
                TextColumn::make('item.nome')
                    ->label('Item')
                    ->searchable(),
                TextColumn::make('quantidade')
                    ->numeric()
                    ->summarize(Sum::make()->label('Total')),
                TextColumn::make('valor_unitario')
                    ->label('Valor Unit.')
                    ->money('BRL'),
                TextColumn::make('valor_total')
                    ->label('Valor Total')
                    ->state(fn ($record): string => number_format($record->quantidade * $record->valor_unitario, 2, ',', '.'))
                    ->prefix('R$ '),
            ])
            ->headerActions([
                CreateAction::make()
                    ->visible(fn () => $this->getOwnerRecord()->isRascunho()),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn () => $this->getOwnerRecord()->isRascunho()),
                DeleteAction::make()
                    ->visible(fn () => $this->getOwnerRecord()->isRascunho()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => $this->getOwnerRecord()->isRascunho()),
                ]),
            ]);
    }
}
