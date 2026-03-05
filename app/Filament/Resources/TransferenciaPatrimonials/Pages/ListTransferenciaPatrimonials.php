<?php

namespace App\Filament\Resources\TransferenciaPatrimonials\Pages;

use App\Filament\Resources\TransferenciaPatrimonials\TransferenciaPatrimonialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTransferenciaPatrimonials extends ListRecords
{
    protected static string $resource = TransferenciaPatrimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
