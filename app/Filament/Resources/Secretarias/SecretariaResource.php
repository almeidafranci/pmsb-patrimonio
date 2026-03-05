<?php

namespace App\Filament\Resources\Secretarias;

use App\Enums\NavigationGroup;
use App\Filament\Resources\Secretarias\Pages\CreateSecretaria;
use App\Filament\Resources\Secretarias\Pages\EditSecretaria;
use App\Filament\Resources\Secretarias\Pages\ListSecretarias;
use App\Filament\Resources\Secretarias\RelationManagers\DepartamentosRelationManager;
use App\Filament\Resources\Secretarias\Schemas\SecretariaForm;
use App\Filament\Resources\Secretarias\Tables\SecretariasTable;
use App\Models\Secretaria;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class SecretariaResource extends Resource
{
    protected static ?string $model = Secretaria::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Cadastros;

    protected static ?string $modelLabel = 'Secretaria';

    protected static ?string $pluralModelLabel = 'Secretarias';

    protected static ?string $recordTitleAttribute = 'nome';

    public static function form(Schema $schema): Schema
    {
        return SecretariaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SecretariasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DepartamentosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSecretarias::route('/'),
            'create' => CreateSecretaria::route('/create'),
            'edit' => EditSecretaria::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
