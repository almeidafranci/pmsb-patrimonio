<?php

namespace App\Filament\Resources\Requisicaos\Pages;

use App\Filament\Resources\Requisicaos\RequisicaoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRequisicaos extends ListRecords
{
    protected static string $resource = RequisicaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
