<?php

namespace App\Filament\Resources\BaixaPatrimonials\Pages;

use App\Filament\Resources\BaixaPatrimonials\BaixaPatrimonialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBaixaPatrimonials extends ListRecords
{
    protected static string $resource = BaixaPatrimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
