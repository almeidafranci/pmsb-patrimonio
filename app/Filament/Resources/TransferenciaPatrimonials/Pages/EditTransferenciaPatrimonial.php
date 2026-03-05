<?php

namespace App\Filament\Resources\TransferenciaPatrimonials\Pages;

use App\Filament\Resources\TransferenciaPatrimonials\TransferenciaPatrimonialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTransferenciaPatrimonial extends EditRecord
{
    protected static string $resource = TransferenciaPatrimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
