<?php

namespace App\Filament\Resources\Requisicaos\Tables;

use App\Enums\RequisicaoStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RequisicaosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Nº')
                    ->sortable(),
                TextColumn::make('secretaria.sigla')
                    ->label('Secretaria')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('departamento.nome')
                    ->label('Departamento')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('responsavel')
                    ->label('Responsável')
                    ->searchable(),
                TextColumn::make('data_requisicao')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('usuario.name')
                    ->label('Usuário')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options(RequisicaoStatus::class),
                SelectFilter::make('secretaria_id')
                    ->relationship('secretaria', 'sigla')
                    ->label('Secretaria')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
