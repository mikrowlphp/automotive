<?php

namespace Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages;

use Packages\Automotive\Garage\Filament\Resources\CustomerResource;
use Packages\Sales\Shared\Filament\Resources\Customers\Pages\CreateCustomer as BaseCreateCustomer;

class CreateCustomer extends BaseCreateCustomer
{
    protected static string $resource = CustomerResource::class;
}
