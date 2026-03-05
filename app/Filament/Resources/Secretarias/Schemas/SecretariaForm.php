<?php

namespace App\Filament\Resources\Secretarias\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SecretariaForm
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
                            ->maxLength(20),
                        Toggle::make('ativo')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }
}
