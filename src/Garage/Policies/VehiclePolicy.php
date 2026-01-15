<?php

namespace Packages\Automotive\Garage\Policies;

use App\Models\Tenant\User;
use Illuminate\Auth\Access\Response;
use Packages\Automotive\Garage\Models\Vehicle;

/**
 * Vehicle Policy
 *
 * Authorization for vehicle operations with service record protection
 *
 * @see .claude/skills/permission-security-expert/references/RULES-PERMISSIONS.md
 */
class VehiclePolicy
{
    /**
     * Determine if user can view any vehicles
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-vehicles');
    }

    /**
     * Determine if user can view the vehicle
     */
    public function view(User $user, Vehicle $vehicle): bool
    {
        return $user->isAbleTo('manage-vehicles');
    }

    /**
     * Determine if user can create vehicles
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-vehicles');
    }

    /**
     * Determine if user can update the vehicle
     */
    public function update(User $user, Vehicle $vehicle): bool
    {
        return $user->isAbleTo('manage-vehicles');
    }

    /**
     * Determine if user can delete the vehicle
     *
     * Business Rule: Cannot delete if vehicle has service records
     * (except draft or cancelled service records)
     */
    public function delete(User $user, Vehicle $vehicle): Response
    {
        if (! $user->isAbleTo('manage-vehicles')) {
            return Response::deny('You do not have permission to manage vehicles.');
        }

        // Check if vehicle has service records
        // Allow deletion only if all service records are draft or cancelled
        $hasActiveServiceRecords = $vehicle->serviceRecords()
            ->whereNotIn('status', ['draft', 'cancelled'])
            ->exists();

        if ($hasActiveServiceRecords) {
            return Response::deny('Cannot delete vehicle with active service records. Delete or cancel service records first.');
        }

        return Response::allow();
    }

    /**
     * Determine if user can restore the vehicle
     */
    public function restore(User $user, Vehicle $vehicle): bool
    {
        return $user->isAbleTo('manage-vehicles');
    }

    /**
     * Determine if user can force delete the vehicle
     */
    public function forceDelete(User $user, Vehicle $vehicle): bool
    {
        return $user->isAbleTo('manage-vehicles');
    }
}
