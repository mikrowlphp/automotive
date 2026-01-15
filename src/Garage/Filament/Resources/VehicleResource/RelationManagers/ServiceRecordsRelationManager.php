<?php

namespace Packages\Automotive\Garage\Filament\Resources\VehicleResource\RelationManagers;

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

class ServiceRecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'serviceRecords';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('automotive::services.service_records');
    }

    public function form(Schema $schema): Schema
    {
        // Redirect to full ServiceRecord resource for complex form
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('service_date')
            ->columns([
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

                TextColumn::make('created_at')
                    ->label(__('automotive::services.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                CreateAction::make()
                    ->url(fn (): string => route('filament.admin.resources.service-records.create', [
                        'vehicle_id' => $this->ownerRecord->id,
                    ])),
            ])
            ->recordActions([
                EditAction::make()
                    ->url(fn ($record): string => route('filament.admin.resources.service-records.edit', [
                        'record' => $record,
                    ])),
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
