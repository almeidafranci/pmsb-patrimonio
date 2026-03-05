<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum TombamentoStatus: string implements HasColor, HasLabel
{
    case Pendente = 'pendente';
    case Ativo = 'ativo';
    case Baixado = 'baixado';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pendente => 'Pendente',
            self::Ativo => 'Ativo',
            self::Baixado => 'Baixado',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pendente => 'warning',
            self::Ativo => 'success',
            self::Baixado => 'danger',
        };
    }
}
