<?php

namespace App\Filament\Resources\BaixaPatrimonials;

use App\Enums\NavigationGroup;
use App\Filament\Resources\BaixaPatrimonials\Pages\CreateBaixaPatrimonial;
use App\Filament\Resources\BaixaPatrimonials\Pages\EditBaixaPatrimonial;
use App\Filament\Resources\BaixaPatrimonials\Pages\ListBaixaPatrimonials;
use App\Filament\Resources\BaixaPatrimonials\Schemas\BaixaPatrimonialForm;
use App\Filament\Resources\BaixaPatrimonials\Tables\BaixaPatrimonialsTable;
use App\Models\BaixaPatrimonial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BaixaPatrimonialResource extends Resource
{
    protected static ?string $model = BaixaPatrimonial::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedXCircle;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Patrimonio;

    protected static ?string $modelLabel = 'Baixa Patrimonial';

    protected static ?string $pluralModelLabel = 'Baixas Patrimoniais';

    public static function form(Schema $schema): Schema
    {
        return BaixaPatrimonialForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BaixaPatrimonialsTable::configure($table);
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
            'index' => ListBaixaPatrimonials::route('/'),
            'create' => CreateBaixaPatrimonial::route('/create'),
            'edit' => EditBaixaPatrimonial::route('/{record}/edit'),
        ];
    }
}
