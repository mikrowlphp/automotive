<?php

namespace Packages\Automotive\Garage\Filament\Resources\CustomerResource\Pages;

use Packages\Automotive\Garage\Filament\Resources\CustomerResource;
use Packages\Sales\Shared\Filament\Resources\Customers\Pages\ListCustomers as BaseListCustomers;

class ListCustomers extends BaseListCustomers
{
    protected static string $resource = CustomerResource::class;
}
