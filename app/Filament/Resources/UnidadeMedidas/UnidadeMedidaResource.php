<?php

namespace App\Filament\Resources\UnidadeMedidas;

use App\Enums\NavigationGroup;
use App\Filament\Resources\UnidadeMedidas\Pages\CreateUnidadeMedida;
use App\Filament\Resources\UnidadeMedidas\Pages\EditUnidadeMedida;
use App\Filament\Resources\UnidadeMedidas\Pages\ListUnidadeMedidas;
use App\Filament\Resources\UnidadeMedidas\Schemas\UnidadeMedidaForm;
use App\Filament\Resources\UnidadeMedidas\Tables\UnidadeMedidasTable;
use App\Models\UnidadeMedida;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UnidadeMedidaResource extends Resource
{
    protected static ?string $model = UnidadeMedida::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Cadastros;

    protected static ?string $modelLabel = 'Unidade de Medida';

    protected static ?string $pluralModelLabel = 'Unidades de Medida';

    protected static ?string $recordTitleAttribute = 'nome';

    public static function form(Schema $schema): Schema
    {
        return UnidadeMedidaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UnidadeMedidasTable::configure($table);
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
            'index' => ListUnidadeMedidas::route('/'),
            'create' => CreateUnidadeMedida::route('/create'),
            'edit' => EditUnidadeMedida::route('/{record}/edit'),
        ];
    }
}
