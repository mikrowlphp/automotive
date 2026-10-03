<?php

namespace Packages\Automotive\Garage\Filament\Widgets;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Packages\Automotive\Garage\Enums\ServiceRecordStatus;
use Packages\Core\Shared\Filament\Widgets\FormToolbarWidget;

/**
 * ServiceRecordToolbar
 *
 * Status toolbar for service records: the generic resource and the mechanics, bodywork,
 * tires and electrician ones share the model and the flow.
 * Flow: Draft → In progress → Completed; Cancelled sits outside the flow.
 */
class ServiceRecordToolbar extends FormToolbarWidget
{
    protected static string $statusEnum = ServiceRecordStatus::class;

    protected static string $statusField = 'status';

    protected static bool $stepperClickable = true;

    protected int|string|array $columnSpan = 'full';

    public function getFlowStatuses(): array
    {
        return [
            ServiceRecordStatus::Draft,
            ServiceRecordStatus::InProgress,
            ServiceRecordStatus::Completed,
        ];
    }

    public function getTerminalLabel(): ?string
    {
        return $this->record?->status === ServiceRecordStatus::Cancelled
            ? ServiceRecordStatus::Cancelled->getLabel()
            : null;
    }

    /**
     * Stepper guard: once work has started the record does not go back to draft.
     */
    public function getPointOfNoReturn(): ?BackedEnum
    {
        return ServiceRecordStatus::InProgress;
    }

    public function getToolbarActionNames(): array
    {
        return ['start', 'complete', 'cancel', 'reopen'];
    }

    public function startAction(): Action
    {
        return Action::make('start')
            ->label(__('automotive::services.toolbar.start'))
            ->icon('heroicon-o-play')
            ->color('primary')
            ->size('sm')
            ->visible(fn () => $this->record?->status === ServiceRecordStatus::Draft)
            ->action(fn () => $this->moveTo(ServiceRecordStatus::InProgress, 'started_notice'));
    }

    public function completeAction(): Action
    {
        return Action::make('complete')
            ->label(__('automotive::services.toolbar.complete'))
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->size('sm')
            ->visible(fn () => $this->record?->status === ServiceRecordStatus::InProgress)
            ->requiresConfirmation()
            ->action(fn () => $this->moveTo(ServiceRecordStatus::Completed, 'completed_notice'));
    }

    public function cancelAction(): Action
    {
        return Action::make('cancel')
            ->label(__('automotive::services.toolbar.cancel'))
            ->icon('heroicon-o-no-symbol')
            ->color('danger')
            ->size('sm')
            ->visible(fn () => in_array($this->record?->status, [ServiceRecordStatus::Draft, ServiceRecordStatus::InProgress], true))
            ->requiresConfirmation()
            ->action(fn () => $this->moveTo(ServiceRecordStatus::Cancelled, 'cancelled_notice'));
    }

    public function reopenAction(): Action
    {
        return Action::make('reopen')
            ->label(__('automotive::services.toolbar.reopen'))
            ->icon('heroicon-o-arrow-path')
            ->color('gray')
            ->size('sm')
            ->visible(fn () => $this->record?->status === ServiceRecordStatus::Cancelled)
            ->action(fn () => $this->moveTo(ServiceRecordStatus::Draft, 'reopened_notice'));
    }

    protected function moveTo(BackedEnum $status, string $notice): void
    {
        $this->record->update(['status' => $status]);

        Notification::make()->success()->title(__("automotive::services.toolbar.{$notice}"))->send();
        $this->dispatch('$refresh');
    }
}
