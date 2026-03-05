<?php

namespace App\Filament\Resources\Requisicaos;

use App\Enums\NavigationGroup;
use App\Filament\Resources\Requisicaos\Pages\CreateRequisicao;
use App\Filament\Resources\Requisicaos\Pages\EditRequisicao;
use App\Filament\Resources\Requisicaos\Pages\ListRequisicaos;
use App\Filament\Resources\Requisicaos\RelationManagers\RequisicaoItensRelationManager;
use App\Filament\Resources\Requisicaos\RelationManagers\RequisicaoTombamentosRelationManager;
use App\Filament\Resources\Requisicaos\Schemas\RequisicaoForm;
use App\Filament\Resources\Requisicaos\Tables\RequisicaosTable;
use App\Models\Requisicao;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RequisicaoResource extends Resource
{
    protected static ?string $model = Requisicao::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Almoxarifado;

    protected static ?string $modelLabel = 'Requisição de Material';

    protected static ?string $pluralModelLabel = 'Requisições de Material';

    public static function form(Schema $schema): Schema
    {
        return RequisicaoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RequisicaosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RequisicaoItensRelationManager::class,
            RequisicaoTombamentosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRequisicaos::route('/'),
            'create' => CreateRequisicao::route('/create'),
            'edit' => EditRequisicao::route('/{record}/edit'),
        ];
    }
}
