<?php

namespace App\Filament\Resources\BaixaPatrimonials\Schemas;

use App\Enums\BaixaMotivo;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BaixaPatrimonialForm
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
                        DatePicker::make('data_baixa')
                            ->label('Data da Baixa')
                            ->required()
                            ->disabled(),
                        Select::make('motivo')
                            ->options(BaixaMotivo::class)
                            ->required()
                            ->disabled(),
                        Textarea::make('descricao')
                            ->label('Descrição')
                            ->columnSpanFull()
                            ->disabled(),
                    ])
                    ->columns(2),
            ]);
    }
}
