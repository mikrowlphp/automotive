<?php

namespace Packages\Automotive\Garage\Filament\Widgets;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Packages\Automotive\Garage\Enums\DiagnosisStatus;
use Packages\Core\Shared\Filament\Widgets\FormToolbarWidget;

/**
 * DiagnosisToolbar
 *
 * Status toolbar for the diagnosis edit page. Flow: Draft → Open → Closed.
 */
class DiagnosisToolbar extends FormToolbarWidget
{
    protected static string $statusEnum = DiagnosisStatus::class;

    protected static string $statusField = 'status';

    protected static bool $stepperClickable = true;

    protected int|string|array $columnSpan = 'full';

    public function getFlowStatuses(): array
    {
        return [
            DiagnosisStatus::Draft,
            DiagnosisStatus::Open,
            DiagnosisStatus::Closed,
        ];
    }

    /**
     * Stepper guard: an opened diagnosis does not go back to draft.
     */
    public function getPointOfNoReturn(): ?BackedEnum
    {
        return DiagnosisStatus::Open;
    }

    public function getToolbarActionNames(): array
    {
        return ['open', 'close', 'reopen'];
    }

    public function openAction(): Action
    {
        return Action::make('open')
            ->label(__('automotive::services.toolbar.open_diagnosis'))
            ->icon('heroicon-o-clipboard-document-check')
            ->color('primary')
            ->size('sm')
            ->visible(fn () => $this->record?->status === DiagnosisStatus::Draft)
            ->action(fn () => $this->moveTo(DiagnosisStatus::Open, 'diagnosis_opened_notice'));
    }

    public function closeAction(): Action
    {
        return Action::make('close')
            ->label(__('automotive::services.toolbar.close_diagnosis'))
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->size('sm')
            ->visible(fn () => $this->record?->status === DiagnosisStatus::Open)
            ->requiresConfirmation()
            ->action(fn () => $this->moveTo(DiagnosisStatus::Closed, 'diagnosis_closed_notice'));
    }

    public function reopenAction(): Action
    {
        return Action::make('reopen')
            ->label(__('automotive::services.toolbar.reopen'))
            ->icon('heroicon-o-arrow-path')
            ->color('gray')
            ->size('sm')
            ->visible(fn () => $this->record?->status === DiagnosisStatus::Closed)
            ->action(fn () => $this->moveTo(DiagnosisStatus::Open, 'diagnosis_opened_notice'));
    }

    protected function moveTo(BackedEnum $status, string $notice): void
    {
        $this->record->update(['status' => $status]);

        Notification::make()->success()->title(__("automotive::services.toolbar.{$notice}"))->send();
        $this->dispatch('$refresh');
    }
}
