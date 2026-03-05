<?php

namespace App\Filament\Resources\Requisicaos\RelationManagers;

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

class RequisicaoItensRelationManager extends RelationManager
{
    protected static string $relationship = 'itens';

    protected static ?string $title = 'Itens de Consumo';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('item_id')
                    ->relationship('item', 'nome', fn ($query) => $query->where('requer_tombamento', false))
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('quantidade_solicitada')
                    ->label('Qtd. Solicitada')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                TextInput::make('quantidade_atendida')
                    ->label('Qtd. Atendida')
                    ->numeric()
                    ->minValue(0)
                    ->default(0),
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
                TextColumn::make('quantidade_solicitada')
                    ->label('Qtd. Solicitada')
                    ->numeric()
                    ->summarize(Sum::make()->label('Total')),
                TextColumn::make('quantidade_atendida')
                    ->label('Qtd. Atendida')
                    ->numeric(),
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
