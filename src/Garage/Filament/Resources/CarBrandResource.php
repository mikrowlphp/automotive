<?php

namespace Packages\Automotive\Garage\Filament\Resources;

use App\Library\Extensions\Resource;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Pages;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Schemas\CarBrandForm;
use Packages\Automotive\Garage\Filament\Resources\CarBrandResource\Tables\CarBrandsTable;
use Packages\Automotive\Garage\Models\CarBrand;
use UnitEnum;

class CarBrandResource extends Resource
{
    protected static ?string $model = CarBrand::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 99;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Configuration');
    }

    public static function getModelLabel(): string
    {
        return __('automotive::vehicles.car_brand');
    }

    public static function getPluralModelLabel(): string
    {
        return __('automotive::vehicles.car_brands');
    }

    public static function form(Schema $schema): Schema
    {
        return CarBrandForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return CarBrandsTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarBrands::route('/'),
            'create' => Pages\CreateCarBrand::route('/create'),
            'edit' => Pages\EditCarBrand::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes()
            ->withCount('carModels')
            ->orderBy('name');
    }

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }
}
