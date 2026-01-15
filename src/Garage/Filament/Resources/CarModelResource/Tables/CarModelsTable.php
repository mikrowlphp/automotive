<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarModelResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CarModelsTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('carBrand.name')
                    ->label(__('automotive::vehicles.car_brand'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('name')
                    ->label(__('automotive::vehicles.model_name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('year_range')
                    ->label(__('automotive::vehicles.year_range'))
                    ->getStateUsing(function ($record): string {
                        $from = $record->year_from ?? '?';
                        $to = $record->year_to ?? __('automotive::vehicles.present');

                        return "{$from} - {$to}";
                    })
                    ->placeholder(__('automotive::vehicles.not_specified')),

                TextColumn::make('body_type')
                    ->label(__('automotive::vehicles.body_type'))
                    ->formatStateUsing(fn (string $state): string => __('automotive::vehicles.body_types.'.$state)
                    )
                    ->badge()
                    ->color('primary')
                    ->placeholder(__('automotive::vehicles.not_specified')),

                TextColumn::make('vehicles_count')
                    ->label(__('automotive::vehicles.vehicles_count'))
                    ->counts('vehicles')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color('success'),

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
                    ->relationship('carBrand', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                SelectFilter::make('body_type')
                    ->label(__('automotive::vehicles.filter_body_type'))
                    ->options([
                        'sedan' => __('automotive::vehicles.body_types.sedan'),
                        'suv' => __('automotive::vehicles.body_types.suv'),
                        'hatchback' => __('automotive::vehicles.body_types.hatchback'),
                        'coupe' => __('automotive::vehicles.body_types.coupe'),
                        'convertible' => __('automotive::vehicles.body_types.convertible'),
                        'wagon' => __('automotive::vehicles.body_types.wagon'),
                        'van' => __('automotive::vehicles.body_types.van'),
                        'truck' => __('automotive::vehicles.body_types.truck'),
                    ])
                    ->multiple(),

                SelectFilter::make('is_active')
                    ->label(__('automotive::vehicles.filter_status'))
                    ->options([
                        true => __('automotive::vehicles.active'),
                        false => __('automotive::vehicles.inactive'),
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }
}
