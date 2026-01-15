<?php

namespace Packages\Automotive\Garage\Filament\Resources;

use App\Library\Extensions\Resource;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource\Pages;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource\Schemas\CarModelForm;
use Packages\Automotive\Garage\Filament\Resources\CarModelResource\Tables\CarModelsTable;
use Packages\Automotive\Garage\Models\CarModel;
use UnitEnum;

class CarModelResource extends Resource
{
    protected static ?string $model = CarModel::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = 99;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Configuration');
    }

    public static function getModelLabel(): string
    {
        return __('automotive::vehicles.car_model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('automotive::vehicles.car_models');
    }

    public static function form(Schema $schema): Schema
    {
        return CarModelForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return CarModelsTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCarModels::route('/'),
            'create' => Pages\CreateCarModel::route('/create'),
            'edit' => Pages\EditCarModel::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes()
            ->with(['carBrand'])
            ->withCount('vehicles')
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
