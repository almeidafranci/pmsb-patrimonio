<?php

namespace App\Filament\Resources\Tombamentos\Schemas;

use App\Enums\TombamentoStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TombamentoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dados do Bem')
                    ->schema([
                        TextInput::make('numero_tombamento')
                            ->label('Número do Tombamento')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('item_id')
                            ->relationship('item', 'nome')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->disabled(fn (?string $operation) => $operation === 'edit'),
                        TextInput::make('valor')
                            ->label('Valor (R$)')
                            ->numeric()
                            ->prefix('R$'),
                        DatePicker::make('data_tombamento')
                            ->label('Data do Tombamento'),
                        Select::make('status')
                            ->options(TombamentoStatus::class)
                            ->default(TombamentoStatus::Pendente)
                            ->required()
                            ->disabled(),
                    ])
                    ->columns(2),
                Section::make('Localização')
                    ->schema([
                        Select::make('secretaria_id')
                            ->relationship('secretaria', 'nome')
                            ->searchable()
                            ->preload()
                            ->live(),
                        Select::make('departamento_id')
                            ->relationship(
                                'departamento',
                                'nome',
                                fn ($query, Get $get) => $query->where('secretaria_id', $get('secretaria_id'))
                            )
                            ->searchable()
                            ->preload()
                            ->visible(fn (Get $get): bool => filled($get('secretaria_id'))),
                    ])
                    ->columns(2),
                Section::make()
                    ->schema([
                        Textarea::make('observacao')
                            ->label('Observação')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
