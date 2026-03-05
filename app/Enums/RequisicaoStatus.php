<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RequisicaoStatus: string implements HasColor, HasLabel
{
    case Rascunho = 'rascunho';
    case Confirmada = 'confirmada';

    public function getLabel(): string
    {
        return match ($this) {
            self::Rascunho => 'Rascunho',
            self::Confirmada => 'Confirmada',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Rascunho => 'gray',
            self::Confirmada => 'success',
        };
    }
}
