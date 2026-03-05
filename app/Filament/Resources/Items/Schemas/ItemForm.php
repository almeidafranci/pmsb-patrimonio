<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('nome')
                            ->required()
                            ->maxLength(255),
                        Select::make('categoria_id')
                            ->relationship('categoria', 'nome')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Select::make('unidade_medida_id')
                            ->relationship('unidadeMedida', 'nome')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Toggle::make('requer_tombamento')
                            ->label('Requer Tombamento')
                            ->helperText('Ativar para itens patrimoniais que necessitam de etiqueta'),
                        Textarea::make('descricao')
                            ->label('Descrição')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Estoque')
                    ->schema([
                        TextInput::make('estoque_minimo')
                            ->label('Estoque Mínimo')
                            ->numeric()
                            ->default(0)
                            ->required(),
                        TextInput::make('estoque_atual')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false)
                            ->visibleOn('edit'),
                    ])
                    ->columns(2),
            ]);
    }
}
