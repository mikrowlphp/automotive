<?php

namespace Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Packages\Automotive\Garage\Enums\ServiceLineType;

class LinesRelationManager extends RelationManager
{
    protected static string $relationship = 'lines';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('automotive::services.service_lines');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Grid::make(12)->schema([
                    Select::make('type')
                        ->label(__('automotive::services.line_type'))
                        ->enum(ServiceLineType::class)
                        ->required()
                        ->native(false)
                        ->columnSpan(3),

                    TextInput::make('description')
                        ->label(__('automotive::services.description'))
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(9),
                ]),

                Grid::make(12)->schema([
                    TextInput::make('quantity')
                        ->label(__('automotive::services.quantity'))
                        ->numeric()
                        ->required()
                        ->default(1)
                        ->minValue(0.01)
                        ->step(0.01)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $unitPrice = $get('unit_price') ?? 0;
                            $set('line_total', $state * $unitPrice);
                        })
                        ->columnSpan(3),

                    TextInput::make('unit_price')
                        ->label(__('automotive::services.unit_price'))
                        ->numeric()
                        ->required()
                        ->prefix('€')
                        ->default(0)
                        ->minValue(0)
                        ->step(0.01)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function ($state, callable $get, callable $set) {
                            $quantity = $get('quantity') ?? 0;
                            $set('line_total', $quantity * $state);
                        })
                        ->columnSpan(4),

                    TextInput::make('line_total')
                        ->label(__('automotive::services.line_total'))
                        ->numeric()
                        ->prefix('€')
                        ->disabled()
                        ->dehydrated()
                        ->default(0)
                        ->columnSpan(5),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('type')
                    ->badge()
                    ->label(__('automotive::services.line_type'))
                    ->sortable(),

                TextColumn::make('description')
                    ->label(__('automotive::services.description'))
                    ->searchable()
                    ->limit(50),

                TextColumn::make('quantity')
                    ->label(__('automotive::services.quantity'))
                    ->numeric(decimalPlaces: 2)
                    ->alignEnd(),

                TextColumn::make('unit_price')
                    ->label(__('automotive::services.unit_price'))
                    ->money('EUR')
                    ->alignEnd(),

                TextColumn::make('line_total')
                    ->label(__('automotive::services.line_total'))
                    ->money('EUR')
                    ->weight('bold')
                    ->alignEnd(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
