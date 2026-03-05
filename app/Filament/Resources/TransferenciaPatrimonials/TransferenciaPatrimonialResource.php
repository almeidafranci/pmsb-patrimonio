<?php

namespace App\Filament\Resources\TransferenciaPatrimonials;

use App\Enums\NavigationGroup;
use App\Filament\Resources\TransferenciaPatrimonials\Pages\CreateTransferenciaPatrimonial;
use App\Filament\Resources\TransferenciaPatrimonials\Pages\EditTransferenciaPatrimonial;
use App\Filament\Resources\TransferenciaPatrimonials\Pages\ListTransferenciaPatrimonials;
use App\Filament\Resources\TransferenciaPatrimonials\Schemas\TransferenciaPatrimonialForm;
use App\Filament\Resources\TransferenciaPatrimonials\Tables\TransferenciaPatrimonialsTable;
use App\Models\TransferenciaPatrimonial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TransferenciaPatrimonialResource extends Resource
{
    protected static ?string $model = TransferenciaPatrimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowsRightLeft;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Patrimonio;

    protected static ?string $modelLabel = 'Transferência Patrimonial';

    protected static ?string $pluralModelLabel = 'Transferências Patrimoniais';

    public static function form(Schema $schema): Schema
    {
        return TransferenciaPatrimonialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TransferenciaPatrimonialsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTransferenciaPatrimonials::route('/'),
            'create' => CreateTransferenciaPatrimonial::route('/create'),
            'edit' => EditTransferenciaPatrimonial::route('/{record}/edit'),
        ];
    }
}
