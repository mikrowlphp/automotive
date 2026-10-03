<?php

namespace Packages\Automotive\Garage\Filament\Resources\ServiceRecordResource\Schemas;

use App\Filament\Components\SheetRepeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Packages\Automotive\Garage\Enums\ServiceLineType;
use Packages\Sales\Shared\Filament\Components\ProductSelect;
use Packages\Sales\Shared\Models\Product;

/**
 * Priced lines of a service record, shared by the generic form and the forms of each service type.
 * The total amount of the record is their sum.
 */
class ServiceLinesSection
{
    /**
     * @param  bool  $withTotal  Show the total below the lines, for forms that have no total field of their own
     */
    public static function make(bool $withTotal = true): Section
    {
        return Section::make(__('automotive::services.service_lines'))
            ->schema([
                SheetRepeater::make('lines')
                    ->hiddenLabel()
                    ->relationship('lines')
                    ->keyField('description')
                    ->compact()
                    ->table([
                        TableColumn::make(__('automotive::services.line_type'))
                            ->markAsRequired()
                            ->width(170),
                        TableColumn::make(__('automotive::services.part'))
                            ->width(260),
                        TableColumn::make(__('automotive::services.description'))
                            ->markAsRequired(),
                        TableColumn::make(__('automotive::services.quantity'))
                            ->markAsRequired()
                            ->width(120),
                        TableColumn::make(__('automotive::services.unit_price'))
                            ->markAsRequired()
                            ->width(160),
                        TableColumn::make(__('automotive::services.line_total'))
                            ->width(160),
                    ])
                    ->schema([
                        Select::make('type')
                            ->label(__('automotive::services.line_type'))
                            ->options(ServiceLineType::class)
                            ->default(ServiceLineType::Labor)
                            ->selectablePlaceholder(false)
                            ->required(),

                        // A part is a product: picking it fills the line, which stays editable
                        ProductSelect::make('product_id')
                            ->label(__('automotive::services.part'))
                            ->nullable()
                            ->live()
                            ->afterStateUpdated(fn (mixed $state, Get $get, Set $set) => static::fillFromProduct($state, $get, $set)),

                        TextInput::make('description')
                            ->label(__('automotive::services.description'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('quantity')
                            ->label(__('automotive::services.quantity'))
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->minValue(0.01)
                            ->step(0.01)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Get $get, Set $set) => static::updateLineTotal($get, $set)),

                        TextInput::make('unit_price')
                            ->label(__('automotive::services.unit_price'))
                            ->numeric()
                            ->required()
                            ->prefix('€')
                            ->default(0)
                            ->minValue(0)
                            ->step(0.01)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Get $get, Set $set) => static::updateLineTotal($get, $set)),

                        TextInput::make('line_total')
                            ->label(__('automotive::services.line_total'))
                            ->numeric()
                            ->prefix('€')
                            ->disabled()
                            ->default(0),
                    ])
                    // Line totals are saved from quantity and price, never from the browser
                    ->mutateRelationshipDataBeforeCreateUsing(fn (array $data): array => static::withLineTotal($data))
                    ->mutateRelationshipDataBeforeSaveUsing(fn (array $data): array => static::withLineTotal($data))
                    ->afterStateUpdated(fn (?array $state, Set $set) => $set('total_amount', static::sumLines($state)))
                    ->reorderable(false),

                ...($withTotal ? [
                    Grid::make(12)->schema([
                        static::totalField()
                            ->inlineLabel()
                            ->columnSpan(['default' => 12, 'md' => 4])
                            ->columnStart(['default' => 1, 'md' => 9]),
                    ]),
                ] : []),
            ])
            ->columnSpanFull();
    }

    public static function totalField(): TextInput
    {
        return TextInput::make('total_amount')
            ->label(__('automotive::services.total_amount'))
            ->numeric()
            ->prefix('€')
            ->disabled()
            ->dehydrated()
            ->default(0)
            // Saved from the lines, not from what the browser shows
            ->dehydrateStateUsing(fn (Get $get): float => static::sumLines($get('lines')))
            ->helperText(__('automotive::services.total_amount_help'));
    }

    protected static function fillFromProduct(mixed $productId, Get $get, Set $set): void
    {
        $product = filled($productId) ? Product::find($productId) : null;

        if (! $product) {
            return;
        }

        $set('type', ServiceLineType::Part->value);
        $set('description', $product->full_name ?: $product->name);
        $set('unit_price', (float) $product->effective_selling_price);

        static::updateLineTotal($get, $set);
    }

    protected static function updateLineTotal(Get $get, Set $set): void
    {
        $set('line_total', round((float) $get('quantity') * (float) $get('unit_price'), 2));
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected static function withLineTotal(array $data): array
    {
        $data['line_total'] = round((float) ($data['quantity'] ?? 0) * (float) ($data['unit_price'] ?? 0), 2);

        return $data;
    }

    /**
     * Sum of the lines that will be saved: the empty row of the sheet has no description.
     *
     * @param  array<array<string, mixed>>|null  $lines
     */
    protected static function sumLines(?array $lines): float
    {
        return round(collect($lines ?? [])
            ->filter(fn (array $line): bool => filled($line['description'] ?? null))
            ->sum(fn (array $line): float => (float) ($line['quantity'] ?? 0) * (float) ($line['unit_price'] ?? 0)), 2);
    }
}
