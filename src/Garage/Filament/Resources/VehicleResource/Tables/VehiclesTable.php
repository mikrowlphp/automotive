<?php

namespace Packages\Automotive\Garage\Filament\Resources\VehicleResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VehiclesTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('license_plate')
                    ->label(__('automotive::vehicles.license_plate'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('customer.name')
                    ->label(__('automotive::vehicles.customer'))
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('car_info')
                    ->label(__('automotive::vehicles.car_info'))
                    ->getStateUsing(function ($record): string {
                        if (! $record->carModel) {
                            return __('automotive::vehicles.not_specified');
                        }
                        $brand = $record->carModel->carBrand->name ?? '?';
                        $model = $record->carModel->name ?? '?';

                        return "{$brand} {$model}";
                    })
                    ->searchable(['car_models.name', 'car_brands.name'])
                    ->description(fn ($record) => $record->color
                        ? __('automotive::vehicles.color').': '.$record->color
                        : null
                    ),

                TextColumn::make('year')
                    ->label(__('automotive::vehicles.year'))
                    ->sortable()
                    ->alignCenter()
                    ->placeholder(__('automotive::vehicles.not_specified')),

                TextColumn::make('mileage')
                    ->label(__('automotive::vehicles.mileage'))
                    ->numeric()
                    ->suffix(' km')
                    ->sortable()
                    ->alignEnd()
                    ->placeholder(__('automotive::vehicles.not_specified')),

                TextColumn::make('fuel_type')
                    ->label(__('automotive::vehicles.fuel_type'))
                    ->formatStateUsing(fn (?string $state): string => $state
                        ? __('automotive::vehicles.fuel_types.'.$state)
                        : __('automotive::vehicles.not_specified')
                    )
                    ->badge()
                    ->color('primary'),

                TextColumn::make('is_active')
                    ->label(__('automotive::vehicles.status'))
                    ->formatStateUsing(fn (bool $state): string => $state
                        ? __('automotive::vehicles.active')
                        : __('automotive::vehicles.inactive'))
                    ->badge()
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('automotive::vehicles.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('car_brand_id')
                    ->label(__('automotive::vehicles.filter_brand'))
                    ->relationship('carModel.carBrand', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('fuel_type')
                    ->label(__('automotive::vehicles.filter_fuel_type'))
                    ->options([
                        'gasoline' => __('automotive::vehicles.fuel_types.gasoline'),
                        'diesel' => __('automotive::vehicles.fuel_types.diesel'),
                        'electric' => __('automotive::vehicles.fuel_types.electric'),
                        'hybrid' => __('automotive::vehicles.fuel_types.hybrid'),
                        'lpg' => __('automotive::vehicles.fuel_types.lpg'),
                        'cng' => __('automotive::vehicles.fuel_types.cng'),
                    ])
                    ->multiple(),

                SelectFilter::make('is_active')
                    ->label(__('automotive::vehicles.filter_status'))
                    ->options([
                        true => __('automotive::vehicles.active'),
                        false => __('automotive::vehicles.inactive'),
                    ]),

                SelectFilter::make('customer_id')
                    ->label(__('automotive::vehicles.filter_customer'))
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
            ->defaultSort('license_plate');
    }
}
