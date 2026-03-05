<?php

namespace App\Filament\Resources\Entradas\Pages;

use App\Actions\ConfirmarEntrada;
use App\Filament\Resources\Entradas\EntradaResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;

class EditEntrada extends EditRecord
{
    protected static string $resource = EntradaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('confirmar')
                ->label('Confirmar Entrada')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Confirmar Entrada de Material')
                ->modalDescription('Ao confirmar, o estoque será atualizado e a entrada não poderá mais ser editada. Deseja continuar?')
                ->visible(fn () => $this->getRecord()->isRascunho())
                ->action(function () {
                    try {
                        app(ConfirmarEntrada::class)->execute($this->getRecord());

                        Notification::make()
                            ->title('Entrada confirmada com sucesso!')
                            ->success()
                            ->send();

                        $this->redirect($this->getResource()::getUrl('edit', ['record' => $this->getRecord()]));
                    } catch (\RuntimeException $e) {
                        Notification::make()
                            ->title($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            DeleteAction::make()
                ->visible(fn () => $this->getRecord()->isRascunho()),
        ];
    }
}
