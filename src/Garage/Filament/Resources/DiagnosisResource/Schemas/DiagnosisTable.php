<?php

namespace Packages\Automotive\Garage\Filament\Resources\DiagnosisResource\Schemas;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Packages\Automotive\Garage\Enums\DiagnosisStatus;

class DiagnosisTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vehicle.license_plate')
                    ->label(__('automotive::services.vehicle'))
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->vehicle?->carModel?->carBrand?->name.' '.$record->vehicle?->carModel?->name),

                TextColumn::make('customer.name')
                    ->label(__('automotive::services.customer'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('acceptance_date')
                    ->label(__('automotive::services.diagnosis.acceptance_date'))
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('automotive::services.diagnosis.status'))
                    ->badge()
                    ->sortable(),

                TextColumn::make('service_records_count')
                    ->label(__('automotive::services.diagnosis.service_records_count'))
                    ->counts('serviceRecords')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('automotive::services.diagnosis.status'))
                    ->options(DiagnosisStatus::class)
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('acceptance_date', 'desc');
    }
}
