<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        $permissionsByModule = Permission::all()
            ->groupBy(fn ($p) => self::extractModule($p->name))
            ->sortKeys();

        $sections = [
            Section::make('Dados do Perfil')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome do Perfil')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                ])
                ->columnSpanFull(),
        ];

        $sections[] = Section::make('Permissões')
            ->schema([
                CheckboxList::make('permissions')
                    ->label('')
                    ->relationship('permissions', 'name')
                    ->options(Permission::pluck('name', 'id'))
                    ->columns(3)
                    ->searchable()
                    ->bulkToggleable(),
            ])
            ->columnSpanFull();

        return $schema->components($sections);
    }

    private static function extractModule(string $permissionName): string
    {
        $parts = explode('_', $permissionName);

        if (count($parts) >= 3) {
            return implode('_', array_slice($parts, -1));
        }

        return $parts[count($parts) - 1] ?? $permissionName;
    }
}
