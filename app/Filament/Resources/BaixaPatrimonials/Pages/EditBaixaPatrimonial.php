<?php

namespace App\Filament\Resources\BaixaPatrimonials\Pages;

use App\Filament\Resources\BaixaPatrimonials\BaixaPatrimonialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBaixaPatrimonial extends EditRecord
{
    protected static string $resource = BaixaPatrimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
