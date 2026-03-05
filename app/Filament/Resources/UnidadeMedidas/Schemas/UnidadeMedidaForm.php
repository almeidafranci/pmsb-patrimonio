<?php

namespace App\Filament\Resources\UnidadeMedidas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UnidadeMedidaForm
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
                        TextInput::make('sigla')
                            ->required()
                            ->maxLength(10),
                    ])
                    ->columns(2),
            ]);
    }
}
