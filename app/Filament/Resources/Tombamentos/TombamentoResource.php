<?php

namespace App\Filament\Resources\Tombamentos;

use App\Enums\NavigationGroup;
use App\Filament\Resources\Tombamentos\Pages\CreateTombamento;
use App\Filament\Resources\Tombamentos\Pages\EditTombamento;
use App\Filament\Resources\Tombamentos\Pages\ListTombamentos;
use App\Filament\Resources\Tombamentos\RelationManagers\BaixaRelationManager;
use App\Filament\Resources\Tombamentos\RelationManagers\TransferenciasRelationManager;
use App\Filament\Resources\Tombamentos\Schemas\TombamentoForm;
use App\Filament\Resources\Tombamentos\Tables\TombamentosTable;
use App\Models\Tombamento;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class TombamentoResource extends Resource
{
    protected static ?string $model = Tombamento::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Patrimonio;

    protected static ?string $modelLabel = 'Tombamento';

    protected static ?string $pluralModelLabel = 'Tombamentos';

    protected static ?string $recordTitleAttribute = 'numero_tombamento';

    public static function form(Schema $schema): Schema
    {
        return TombamentoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TombamentosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            TransferenciasRelationManager::class,
            BaixaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTombamentos::route('/'),
            'create' => CreateTombamento::route('/create'),
            'edit' => EditTombamento::route('/{record}/edit'),
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
