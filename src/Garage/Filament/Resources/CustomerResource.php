<?php

namespace Packages\Automotive\Garage\Filament\Resources;

use Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages\CreateCustomer;
use Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages\EditCustomer;
use Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages\ListCustomers;
use Packages\Automotive\Garage\Filament\Resources\CustomerResource\RelationManagers\VehiclesRelationManager;
use Packages\Sales\Shared\Filament\Resources\Customers\CustomerResource as BaseCustomerResource;

class CustomerResource extends BaseCustomerResource
{
    public static function getRelations(): array
    {
        return [
            VehiclesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCustomers::route('/'),
            'create' => CreateCustomer::route('/create'),
            'edit' => EditCustomer::route('/{record}/edit'),
        ];
    }
}
