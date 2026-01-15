<?php

namespace Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Packages\Automotive\Garage\Enums\ServiceRecordStatus;

class ServiceRecordsTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('service_date')
                    ->label(__('automotive::services.service_date'))
                    ->date('d/m/Y')
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('vehicle.license_plate')
                    ->label(__('automotive::services.vehicle'))
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->vehicle
                        ? ($record->vehicle->carModel?->carBrand?->name ?? '').' '.($record->vehicle->carModel?->name ?? '')
                        : null
                    ),

                TextColumn::make('customer.name')
                    ->label(__('automotive::services.customer'))
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('mileage_at_service')
                    ->label(__('automotive::services.mileage'))
                    ->numeric()
                    ->suffix(' km')
                    ->sortable()
                    ->alignEnd()
                    ->placeholder(__('automotive::services.not_specified')),

                TextColumn::make('status')
                    ->badge()
                    ->label(__('automotive::services.status'))
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label(__('automotive::services.total_amount'))
                    ->money('EUR')
                    ->sortable()
                    ->alignEnd()
                    ->weight('semibold'),

                TextColumn::make('created_at')
                    ->label(__('automotive::services.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('automotive::services.filter_status'))
                    ->options(ServiceRecordStatus::class)
                    ->multiple(),

                SelectFilter::make('vehicle_id')
                    ->label(__('automotive::services.filter_vehicle'))
                    ->relationship('vehicle', 'license_plate')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('customer_id')
                    ->label(__('automotive::services.filter_customer'))
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('service_date', 'desc');
    }
}
