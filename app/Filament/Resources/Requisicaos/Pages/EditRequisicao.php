<?php

namespace App\Filament\Resources\Requisicaos\Pages;

use App\Actions\ConfirmarRequisicao;
use App\Filament\Resources\Requisicaos\RequisicaoResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Icons\Heroicon;
use Spatie\LaravelPdf\Facades\Pdf;

class EditRequisicao extends EditRecord
{
    protected static string $resource = RequisicaoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('confirmar')
                ->label('Confirmar Requisição')
                ->icon(Heroicon::OutlinedCheckCircle)
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Confirmar Requisição de Material')
                ->modalDescription('Ao confirmar, o estoque será decrementado e os tombamentos serão vinculados ao destino. Deseja continuar?')
                ->visible(fn () => $this->getRecord()->isRascunho())
                ->action(function () {
                    try {
                        app(ConfirmarRequisicao::class)->execute($this->getRecord());

                        Notification::make()
                            ->title('Requisição confirmada com sucesso!')
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
            Action::make('termo_pdf')
                ->label('Termo de Responsabilidade')
                ->icon(Heroicon::OutlinedDocumentArrowDown)
                ->color('gray')
                ->visible(fn () => $this->getRecord()->isConfirmada())
                ->action(function () {
                    $requisicao = $this->getRecord()->load([
                        'secretaria',
                        'departamento',
                        'itens.item',
                        'requisicaoTombamentos.tombamento.item',
                    ]);

                    return response()->streamDownload(function () use ($requisicao) {
                        echo Pdf::view('pdfs.termo-responsabilidade', [
                            'requisicao' => $requisicao,
                            'itens' => $requisicao->itens,
                            'tombamentos' => $requisicao->requisicaoTombamentos,
                        ])
                            ->driver('dompdf')
                            ->generatePdfContent();
                    }, "termo-responsabilidade-{$requisicao->id}.pdf");
                }),
            DeleteAction::make()
                ->visible(fn () => $this->getRecord()->isRascunho()),
        ];
    }
}
