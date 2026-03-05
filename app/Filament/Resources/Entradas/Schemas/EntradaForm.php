<?php

namespace App\Filament\Resources\Entradas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EntradaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('fornecedor_id')
                            ->relationship('fornecedor', 'nome')
                            ->required()
                            ->searchable()
                            ->preload(),
                        TextInput::make('numero_nota')
                            ->label('Número da Nota')
                            ->maxLength(255),
                        DatePicker::make('data_entrada')
                            ->required()
                            ->default(now()),
                        Textarea::make('observacao')
                            ->label('Observação')
                            ->columnSpanFull(),
                        Hidden::make('usuario_id')
                            ->default(fn () => auth()->id()),
                    ])
                    ->columns(2),
            ]);
    }
}
