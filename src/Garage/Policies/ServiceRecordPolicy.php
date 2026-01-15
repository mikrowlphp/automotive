<?php

namespace Packages\Automotive\Garage\Policies;

use App\Models\Tenant\User;
use Illuminate\Auth\Access\Response;
use Packages\Automotive\Garage\Models\ServiceRecord;

/**
 * ServiceRecord Policy
 *
 * Authorization for service record operations with status-based rules
 *
 * @see .claude/skills/permission-security-expert/references/RULES-PERMISSIONS.md
 */
class ServiceRecordPolicy
{
    /**
     * Determine if user can view any service records
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-service-records');
    }

    /**
     * Determine if user can view the service record
     */
    public function view(User $user, ServiceRecord $serviceRecord): bool
    {
        return $user->isAbleTo('manage-service-records');
    }

    /**
     * Determine if user can create service records
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-service-records');
    }

    /**
     * Determine if user can update the service record
     *
     * Business Rule: Cannot update if status is Completed or Cancelled
     */
    public function update(User $user, ServiceRecord $serviceRecord): Response
    {
        if (! $user->isAbleTo('manage-service-records')) {
            return Response::deny('You do not have permission to manage service records.');
        }

        // Cannot update completed or cancelled service records
        if (in_array($serviceRecord->status, ['completed', 'cancelled'])) {
            return Response::deny('Cannot edit completed or cancelled service records');
        }

        return Response::allow();
    }

    /**
     * Determine if user can delete the service record
     *
     * Business Rule: Can only delete draft service records
     */
    public function delete(User $user, ServiceRecord $serviceRecord): Response
    {
        if (! $user->isAbleTo('manage-service-records')) {
            return Response::deny('You do not have permission to manage service records.');
        }

        // Can only delete draft service records
        if ($serviceRecord->status !== 'draft') {
            return Response::deny('Can only delete draft service records');
        }

        return Response::allow();
    }

    /**
     * Determine if user can restore the service record
     */
    public function restore(User $user, ServiceRecord $serviceRecord): bool
    {
        return $user->isAbleTo('manage-service-records');
    }

    /**
     * Determine if user can force delete the service record
     */
    public function forceDelete(User $user, ServiceRecord $serviceRecord): bool
    {
        return $user->isAbleTo('manage-service-records');
    }
}
