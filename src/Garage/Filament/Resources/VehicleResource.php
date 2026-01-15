<?php

namespace Packages\Automotive\Garage\Filament\Resources;

use App\Library\Extensions\Resource;
use Filament\Schemas\Schema;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Pages;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\RelationManagers\ServiceRecordsRelationManager;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Schemas\VehicleForm;
use Packages\Automotive\Garage\Filament\Resources\VehicleResource\Tables\VehiclesTable;
use Packages\Automotive\Garage\Models\Vehicle;

class VehicleResource extends Resource
{
    protected static ?string $model = Vehicle::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-truck';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'license_plate';

    // Hide from navigation - accessible only via Customer relation manager
    protected static bool $shouldRegisterNavigation = false;

    public static function getModelLabel(): string
    {
        return __('automotive::vehicles.vehicle');
    }

    public static function getPluralModelLabel(): string
    {
        return __('automotive::vehicles.vehicles');
    }

    public static function form(Schema $schema): Schema
    {
        return VehicleForm::configure($schema);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return VehiclesTable::make($table);
    }

    public static function getRelations(): array
    {
        return [
            ServiceRecordsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVehicles::route('/'),
            'create' => Pages\CreateVehicle::route('/create'),
            'edit' => Pages\EditVehicle::route('/{record}/edit'),
            'view' => Pages\ViewVehicle::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes()
            ->with(['customer', 'carModel.carBrand'])
            ->orderBy('license_plate');
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
