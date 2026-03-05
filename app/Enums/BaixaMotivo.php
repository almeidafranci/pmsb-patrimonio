<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BaixaMotivo: string implements HasLabel
{
    case Perda = 'perda';
    case Furto = 'furto';
    case Obsolescencia = 'obsolescencia';
    case Doacao = 'doacao';
    case Outro = 'outro';

    public function getLabel(): string
    {
        return match ($this) {
            self::Perda => 'Perda',
            self::Furto => 'Furto',
            self::Obsolescencia => 'Obsolescência',
            self::Doacao => 'Doação',
            self::Outro => 'Outro',
        };
    }
}
