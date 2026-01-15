<?php

namespace Packages\Automotive\Garage\Policies;

use App\Models\Tenant\User;
use Illuminate\Auth\Access\Response;
use Packages\Automotive\Garage\Models\Diagnosis;

/**
 * Diagnosis Policy
 *
 * Authorization for diagnosis operations with service record protection
 *
 * @see .claude/skills/permission-security-expert/references/RULES-PERMISSIONS.md
 */
class DiagnosisPolicy
{
    /**
     * Determine if user can view any diagnoses
     */
    public function viewAny(User $user): bool
    {
        return $user->isAbleTo('manage-diagnoses');
    }

    /**
     * Determine if user can view the diagnosis
     */
    public function view(User $user, Diagnosis $diagnosis): bool
    {
        return $user->isAbleTo('manage-diagnoses');
    }

    /**
     * Determine if user can create diagnoses
     */
    public function create(User $user): bool
    {
        return $user->isAbleTo('manage-diagnoses');
    }

    /**
     * Determine if user can update the diagnosis
     */
    public function update(User $user, Diagnosis $diagnosis): bool
    {
        return $user->isAbleTo('manage-diagnoses');
    }

    /**
     * Determine if user can delete the diagnosis
     *
     * Business Rule: Cannot delete if diagnosis has service records
     */
    public function delete(User $user, Diagnosis $diagnosis): Response
    {
        if (! $user->isAbleTo('manage-diagnoses')) {
            return Response::deny('You do not have permission to manage diagnoses.');
        }

        // Check if diagnosis has service records
        if ($diagnosis->serviceRecords()->exists()) {
            return Response::deny('Cannot delete diagnosis with linked service records. Delete service records first.');
        }

        return Response::allow();
    }

    /**
     * Determine if user can restore the diagnosis
     */
    public function restore(User $user, Diagnosis $diagnosis): bool
    {
        return $user->isAbleTo('manage-diagnoses');
    }

    /**
     * Determine if user can force delete the diagnosis
     */
    public function forceDelete(User $user, Diagnosis $diagnosis): bool
    {
        return $user->isAbleTo('manage-diagnoses');
    }
}
