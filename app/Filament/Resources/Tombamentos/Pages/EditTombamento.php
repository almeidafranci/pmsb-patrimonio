<?php

namespace App\Filament\Resources\Tombamentos\Pages;

use App\Actions\RegistrarBaixa;
use App\Actions\RegistrarTransferencia;
use App\Enums\BaixaMotivo;
use App\Enums\TombamentoStatus;
use App\Filament\Resources\Tombamentos\TombamentoResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Support\Icons\Heroicon;

class EditTombamento extends EditRecord
{
    protected static string $resource = TombamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('ativar')
                ->label('Ativar Tombamento')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->getRecord()->isPendente() && $this->getRecord()->numero_tombamento)
                ->action(function () {
                    $this->getRecord()->update([
                        'status' => TombamentoStatus::Ativo,
                        'data_tombamento' => $this->getRecord()->data_tombamento ?? now(),
                    ]);
                    Notification::make()->title('Tombamento ativado!')->success()->send();
                    $this->redirect($this->getResource()::getUrl('edit', ['record' => $this->getRecord()]));
                }),
            Action::make('transferir')
                ->label('Transferir')
                ->icon(Heroicon::OutlinedArrowsRightLeft)
                ->color('warning')
                ->visible(fn () => $this->getRecord()->isAtivo())
                ->schema([
                    Select::make('secretaria_destino_id')
                        ->label('Secretaria Destino')
                        ->relationship('secretaria', 'nome', fn ($query) => $query->where('ativo', true))
                        ->required()
                        ->searchable()
                        ->preload()
                        ->live(),
                    Select::make('departamento_destino_id')
                        ->label('Departamento Destino')
                        ->relationship(
                            'departamento',
                            'nome',
                            fn ($query, Get $get) => $query->where('secretaria_id', $get('secretaria_destino_id'))->where('ativo', true)
                        )
                        ->searchable()
                        ->preload()
                        ->visible(fn (Get $get): bool => filled($get('secretaria_destino_id'))),
                    DatePicker::make('data_transferencia')
                        ->label('Data da Transferência')
                        ->required()
                        ->default(now()),
                    Textarea::make('motivo'),
                    Textarea::make('observacao')->label('Observação'),
                ])
                ->action(function (array $data) {
                    try {
                        app(RegistrarTransferencia::class)->execute($this->getRecord(), $data);
                        Notification::make()->title('Transferência registrada!')->success()->send();
                        $this->redirect($this->getResource()::getUrl('edit', ['record' => $this->getRecord()]));
                    } catch (\RuntimeException $e) {
                        Notification::make()->title($e->getMessage())->danger()->send();
                    }
                }),
            Action::make('baixa')
                ->label('Dar Baixa')
                ->icon(Heroicon::OutlinedXCircle)
                ->color('danger')
                ->visible(fn () => $this->getRecord()->isAtivo())
                ->schema([
                    DatePicker::make('data_baixa')
                        ->label('Data da Baixa')
                        ->required()
                        ->default(now()),
                    Select::make('motivo')
                        ->options(BaixaMotivo::class)
                        ->required(),
                    Textarea::make('descricao')->label('Descrição'),
                ])
                ->action(function (array $data) {
                    try {
                        app(RegistrarBaixa::class)->execute($this->getRecord(), $data);
                        Notification::make()->title('Baixa registrada!')->success()->send();
                        $this->redirect($this->getResource()::getUrl('edit', ['record' => $this->getRecord()]));
                    } catch (\RuntimeException $e) {
                        Notification::make()->title($e->getMessage())->danger()->send();
                    }
                }),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
