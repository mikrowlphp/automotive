<?php

namespace Packages\Automotive\Garage;

use Filament\Panel;
use Filament\PanelProvider;
use Packages\Sales\Shared\Filament\Resources\ProductCategories\ProductCategoryResource;
use Packages\Sales\Shared\Filament\Resources\Products\ProductResource;

class GaragePanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('garage')
            ->path('garage')
            ->discoverForPackage('automotive', 'garage')
            ->resources([
                ProductResource::class,
                ProductCategoryResource::class,
            ])
            ->tenantPanel();
    }
}
