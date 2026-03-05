<?php

namespace App\Filament\Resources\Requisicaos\Schemas;

use App\Models\Departamento;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class RequisicaoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados da Requisição')
                    ->schema([
                        Select::make('secretaria_id')
                            ->relationship('secretaria', 'nome')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live(),
                        Select::make('departamento_id')
                            ->label('Departamento')
                            ->options(fn (Get $get) => Departamento::query()
                                ->where('secretaria_id', $get('secretaria_id'))
                                ->where('ativo', true)
                                ->pluck('nome', 'id'))
                            ->searchable()
                            ->preload()
                            ->visible(fn (Get $get): bool => filled($get('secretaria_id'))),
                        DatePicker::make('data_requisicao')
                            ->label('Data da Requisição')
                            ->required()
                            ->default(now()),
                        TextInput::make('responsavel')
                            ->label('Responsável')
                            ->required()
                            ->maxLength(255),
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
