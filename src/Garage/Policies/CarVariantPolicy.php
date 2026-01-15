<?php

namespace Packages\Automotive\Garage\Policies;

use App\Models\Tenant\User;
use Illuminate\Auth\Access\Response;
use Packages\Automotive\Garage\Models\CarVariant;

/**
 * CarVariant Policy
 *
 * Authorization for car variant operations with cascade protection
 */
class CarVariantPolicy
{
    /**
     * Determine if user can view any car variants
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-car-models');
    }

    /**
     * Determine if user can view the car variant
     */
    public function view(User $user, CarVariant $carVariant): bool
    {
        return $user->isAbleTo('manage-car-models');
    }

    /**
     * Determine if user can create car variants
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-car-models');
    }

    /**
     * Determine if user can update the car variant
     */
    public function update(User $user, CarVariant $carVariant): bool
    {
        return $user->isAbleTo('manage-car-models');
    }

    /**
     * Determine if user can delete the car variant
     *
     * Business Rule: Cannot delete if variant has vehicles (cascade protection)
     */
    public function delete(User $user, CarVariant $carVariant): Response
    {
        if (! $user->isAbleTo('manage-car-models')) {
            return Response::deny('You do not have permission to manage car variants.');
        }

        // Cannot delete if variant has vehicles
        if ($carVariant->vehicles()->exists()) {
            return Response::deny('Cannot delete car variant with existing vehicles. Delete vehicles first.');
        }

        return Response::allow();
    }

    /**
     * Determine if user can restore the car variant
     */
    public function restore(User $user, CarVariant $carVariant): bool
    {
        return $user->isAbleTo('manage-car-models');
    }

    /**
     * Determine if user can force delete the car variant
     */
    public function forceDelete(User $user, CarVariant $carVariant): bool
    {
        return $user->isAbleTo('manage-car-models');
    }
}
