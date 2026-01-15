<?php

namespace Packages\Automotive\Garage\Policies;

use App\Models\Tenant\User;
use Illuminate\Auth\Access\Response;
use Packages\Automotive\Garage\Models\CarBrand;

/**
 * CarBrand Policy
 *
 * Authorization for car brand operations with cascade protection
 *
 * @see .claude/skills/permission-security-expert/references/RULES-PERMISSIONS.md
 */
class CarBrandPolicy
{
    /**
     * Determine if user can view any car brands
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-car-brands');
    }

    /**
     * Determine if user can view the car brand
     */
    public function view(User $user, CarBrand $carBrand): bool
    {
        return $user->isAbleTo('manage-car-brands');
    }

    /**
     * Determine if user can create car brands
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-car-brands');
    }

    /**
     * Determine if user can update the car brand
     */
    public function update(User $user, CarBrand $carBrand): bool
    {
        return $user->isAbleTo('manage-car-brands');
    }

    /**
     * Determine if user can delete the car brand
     *
     * Business Rule: Cannot delete if brand has models (cascade protection)
     */
    public function delete(User $user, CarBrand $carBrand): Response
    {
        if (! $user->isAbleTo('manage-car-brands')) {
            return Response::deny('You do not have permission to manage car brands.');
        }

        // Cannot delete if brand has models
        if ($carBrand->carModels()->exists()) {
            return Response::deny('Cannot delete car brand with existing models. Delete models first.');
        }

        return Response::allow();
    }

    /**
     * Determine if user can restore the car brand
     */
    public function restore(User $user, CarBrand $carBrand): bool
    {
        return $user->isAbleTo('manage-car-brands');
    }

    /**
     * Determine if user can force delete the car brand
     */
    public function forceDelete(User $user, CarBrand $carBrand): bool
    {
        return $user->isAbleTo('manage-car-brands');
    }
}
