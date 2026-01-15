<?php

namespace Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Packages\Automotive\Garage\Enums\ServiceType;

use function App\settings;

class ServiceRecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'serviceRecords';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('automotive::services.service_records');
    }

    public function form(Schema $schema): Schema
    {
        // Redirect to specific ServiceRecord resource for complex form
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('service_date')
            ->columns([
                TextColumn::make('type')
                    ->label(__('automotive::services.type'))
                    ->badge()
                    ->sortable(),

                TextColumn::make('service_date')
                    ->label(__('automotive::services.service_date'))
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('mileage_at_service')
                    ->label(__('automotive::services.mileage_at_service'))
                    ->numeric()
                    ->suffix(' km')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->label(__('automotive::services.status'))
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label(__('automotive::services.total_amount'))
                    ->money('EUR')
                    ->sortable()
                    ->alignEnd(),
            ])
            ->headerActions([
                // Create actions for each enabled service type
                ...static::getCreateActions(),
            ])
            ->recordActions([
                EditAction::make()
                    ->url(fn ($record): string => static::getEditUrl($record)),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('service_date', 'desc');
    }

    /**
     * Get create actions for each enabled service type
     */
    protected static function getCreateActions(): array
    {
        $actions = [];

        if (settings('enable_mechanics', 'services', true)) {
            $actions[] = CreateAction::make('create_mechanics')
                ->label(__('automotive::services.types.mechanics'))
                ->icon('heroicon-o-wrench-screwdriver')
                ->url(fn (RelationManager $livewire): string => route('filament.admin.resources.mechanics-services.create', [
                    'diagnosis_id' => $livewire->ownerRecord->id,
                ]));
        }

        if (settings('enable_bodywork', 'services', true)) {
            $actions[] = CreateAction::make('create_bodywork')
                ->label(__('automotive::services.types.bodywork'))
                ->icon('heroicon-o-paint-brush')
                ->url(fn (RelationManager $livewire): string => route('filament.admin.resources.bodywork-services.create', [
                    'diagnosis_id' => $livewire->ownerRecord->id,
                ]));
        }

        if (settings('enable_tires', 'services', true)) {
            $actions[] = CreateAction::make('create_tires')
                ->label(__('automotive::services.types.tires'))
                ->icon('heroicon-o-circle')
                ->url(fn (RelationManager $livewire): string => route('filament.admin.resources.tire-services.create', [
                    'diagnosis_id' => $livewire->ownerRecord->id,
                ]));
        }

        if (settings('enable_electrician', 'services', true)) {
            $actions[] = CreateAction::make('create_electrician')
                ->label(__('automotive::services.types.electrician'))
                ->icon('heroicon-o-bolt')
                ->url(fn (RelationManager $livewire): string => route('filament.admin.resources.electrician-services.create', [
                    'diagnosis_id' => $livewire->ownerRecord->id,
                ]));
        }

        return $actions;
    }

    /**
     * Get edit URL based on service type
     */
    protected static function getEditUrl(Model $record): string
    {
        $routeMap = [
            ServiceType::Mechanics->value => 'mechanics-services',
            ServiceType::Bodywork->value => 'bodywork-services',
            ServiceType::Tires->value => 'tire-services',
            ServiceType::Electrician->value => 'electrician-services',
        ];

        $resourceName = $routeMap[$record->type->value] ?? 'mechanics-services';

        return route("filament.admin.resources.{$resourceName}.edit", [
            'record' => $record,
        ]);
    }
}
