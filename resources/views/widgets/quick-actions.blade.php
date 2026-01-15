<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('automotive::services.dashboard.quick_actions') }}
        </x-slot>

        <div class="flex flex-wrap gap-3">
            {{ $this->newDiagnosisAction }}
            {{ $this->newVehicleAction }}
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
