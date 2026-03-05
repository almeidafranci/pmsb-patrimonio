<?php

namespace App\Filament\Resources\Fornecedors\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FornecedorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados Principais')
                    ->schema([
                        TextInput::make('nome')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('cnpj')
                            ->label('CNPJ')
                            ->mask('99.999.999/9999-99')
                            ->maxLength(18),
                        TextInput::make('telefone')
                            ->tel()
                            ->maxLength(20),
                        TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Toggle::make('ativo')
                            ->default(true),
                    ])
                    ->columns(2),
                Section::make('Endereço')
                    ->schema([
                        TextInput::make('endereco')
                            ->label('Endereço')
                            ->maxLength(255),
                        TextInput::make('cidade')
                            ->maxLength(255),
                        TextInput::make('estado')
                            ->maxLength(2),
                        TextInput::make('cep')
                            ->label('CEP')
                            ->mask('99999-999')
                            ->maxLength(10),
                    ])
                    ->columns(2),
            ]);
    }
}
