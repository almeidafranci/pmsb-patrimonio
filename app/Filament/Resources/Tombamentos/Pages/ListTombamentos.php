<?php

namespace App\Filament\Resources\Tombamentos\Pages;

use App\Filament\Resources\Tombamentos\TombamentoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTombamentos extends ListRecords
{
    protected static string $resource = TombamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
