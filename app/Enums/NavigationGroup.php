<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum NavigationGroup: string implements HasLabel
{
    case Cadastros = 'cadastros';
    case Almoxarifado = 'almoxarifado';
    case Patrimonio = 'patrimonio';
    case Requisicoes = 'requisicoes';
    case Relatorios = 'relatorios';
    case Administracao = 'administracao';

    public function getLabel(): string
    {
        return match ($this) {
            self::Cadastros => 'Cadastros',
            self::Almoxarifado => 'Almoxarifado',
            self::Patrimonio => 'Patrimônio',
            self::Requisicoes => 'Requisições',
            self::Relatorios => 'Relatórios',
            self::Administracao => 'Administração',
        };
    }
}
