<?php

namespace App\Filament\Resources\Requisicaos\RelationManagers;

use App\Enums\TombamentoStatus;
use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RequisicaoTombamentosRelationManager extends RelationManager
{
    protected static string $relationship = 'tombamentos';

    protected static ?string $title = 'Bens Tombados';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('numero_tombamento')
            ->columns([
                TextColumn::make('numero_tombamento')
                    ->label('Nº Tombamento')
                    ->placeholder('Pendente')
                    ->searchable(),
                TextColumn::make('item.nome')
                    ->label('Item'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('secretaria.sigla')
                    ->label('Secretaria Atual'),
                TextColumn::make('valor')
                    ->label('Valor')
                    ->money('BRL'),
            ])
            ->headerActions([
                AttachAction::make()
                    ->label('Vincular Tombamento')
                    ->recordSelectOptionsQuery(fn ($query) => $query
                        ->where('status', TombamentoStatus::Ativo)
                        ->whereNull('secretaria_id')
                        ->whereNull('departamento_id'))
                    ->preloadRecordSelect()
                    ->visible(fn () => $this->getOwnerRecord()->isRascunho()),
            ])
            ->recordActions([
                DetachAction::make()
                    ->visible(fn () => $this->getOwnerRecord()->isRascunho()),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make()
                        ->visible(fn () => $this->getOwnerRecord()->isRascunho()),
                ]),
            ]);
    }
}
