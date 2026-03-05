<?php

namespace App\Filament\Resources\Entradas;

use App\Enums\NavigationGroup;
use App\Filament\Resources\Entradas\Pages\CreateEntrada;
use App\Filament\Resources\Entradas\Pages\EditEntrada;
use App\Filament\Resources\Entradas\Pages\ListEntradas;
use App\Filament\Resources\Entradas\RelationManagers\EntradaItensRelationManager;
use App\Filament\Resources\Entradas\Schemas\EntradaForm;
use App\Filament\Resources\Entradas\Tables\EntradasTable;
use App\Models\Entrada;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class EntradaResource extends Resource
{
    protected static ?string $model = Entrada::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowDownTray;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Almoxarifado;

    protected static ?string $modelLabel = 'Entrada de Material';

    protected static ?string $pluralModelLabel = 'Entradas de Material';

    public static function form(Schema $schema): Schema
    {
        return EntradaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EntradasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            EntradaItensRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEntradas::route('/'),
            'create' => CreateEntrada::route('/create'),
            'edit' => EditEntrada::route('/{record}/edit'),
        ];
    }
}
