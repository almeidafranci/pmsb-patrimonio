<?php

namespace App\Filament\Resources\TransferenciaPatrimonials\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TransferenciaPatrimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('tombamento_id')
                            ->relationship('tombamento', 'numero_tombamento')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled(),
                        DatePicker::make('data_transferencia')
                            ->label('Data da Transferência')
                            ->required()
                            ->disabled(),
                    ])
                    ->columns(2),
                Section::make('Origem')
                    ->schema([
                        Select::make('secretaria_origem_id')
                            ->relationship('secretariaOrigem', 'nome')
                            ->label('Secretaria de Origem')
                            ->disabled(),
                        Select::make('departamento_origem_id')
                            ->relationship('departamentoOrigem', 'nome')
                            ->label('Departamento de Origem')
                            ->disabled(),
                    ])
                    ->columns(2),
                Section::make('Destino')
                    ->schema([
                        Select::make('secretaria_destino_id')
                            ->relationship('secretariaDestino', 'nome')
                            ->label('Secretaria de Destino')
                            ->disabled(),
                        Select::make('departamento_destino_id')
                            ->relationship('departamentoDestino', 'nome')
                            ->label('Departamento de Destino')
                            ->disabled(),
                    ])
                    ->columns(2),
                Section::make()
                    ->schema([
                        Textarea::make('motivo')->disabled(),
                        Textarea::make('observacao')->label('Observação')->disabled(),
                    ]),
            ]);
    }
}
