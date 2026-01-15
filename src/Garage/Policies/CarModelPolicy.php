<?php

namespace Packages\Automotive\Garage\Policies;

use App\Models\Tenant\User;
use Illuminate\Auth\Access\Response;
use Packages\Automotive\Garage\Models\CarModel;

/**
 * CarModel Policy
 *
 * Authorization for car model operations with cascade protection
 *
 * @see .claude/skills/permission-security-expert/references/RULES-PERMISSIONS.md
 */
class CarModelPolicy
{
    /**
     * Determine if user can view any car models
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-car-models');
    }

    /**
     * Determine if user can view the car model
     */
    public function view(User $user, CarModel $carModel): bool
    {
        return $user->isAbleTo('manage-car-models');
    }

    /**
     * Determine if user can create car models
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-car-models');
    }

    /**
     * Determine if user can update the car model
     */
    public function update(User $user, CarModel $carModel): bool
    {
        return $user->isAbleTo('manage-car-models');
    }

    /**
     * Determine if user can delete the car model
     *
     * Business Rule: Cannot delete if model has vehicles (cascade protection)
     */
    public function delete(User $user, CarModel $carModel): Response
    {
        if (! $user->isAbleTo('manage-car-models')) {
            return Response::deny('You do not have permission to manage car models.');
        }

        // Cannot delete if model has vehicles
        if ($carModel->vehicles()->exists()) {
            return Response::deny('Cannot delete car model with existing vehicles. Delete vehicles first.');
        }

        return Response::allow();
    }

    /**
     * Determine if user can restore the car model
     */
    public function restore(User $user, CarModel $carModel): bool
    {
        return $user->isAbleTo('manage-car-models');
    }

    /**
     * Determine if user can force delete the car model
     */
    public function forceDelete(User $user, CarModel $carModel): bool
    {
        return $user->isAbleTo('manage-car-models');
    }
}
