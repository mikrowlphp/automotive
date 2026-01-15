<?php

namespace Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CarBrandsTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label(__('automotive::vehicles.logo'))
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->toggleable(),

                TextColumn::make('name')
                    ->label(__('automotive::vehicles.name'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('country')
                    ->label(__('automotive::vehicles.country'))
                    ->searchable()
                    ->sortable()
                    ->placeholder(__('automotive::vehicles.not_specified')),

                TextColumn::make('car_models_count')
                    ->label(__('automotive::vehicles.models_count'))
                    ->counts('carModels')
                    ->sortable()
                    ->alignCenter()
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
