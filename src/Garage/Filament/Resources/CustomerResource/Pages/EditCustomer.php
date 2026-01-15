<?php

namespace Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages;

use Packages\Automotive\Garage\Filament\Resources\CustomerResource;
use Packages\Sales\Shared\Filament\Resources\Customers\Pages\EditCustomer as BaseEditCustomer;

class EditCustomer extends BaseEditCustomer
{
    protected static string $resource = CustomerResource::class;
}
