<?php

namespace Packages\Automotive\Garage\Database\Seeders;

use App\Models\Tenant\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Seed permissions for Services module
     */
    public function run(): void
    {
        $permissions = require __DIR__.'/permissions.php';

        foreach ($permissions as $permission) {
            Permission::updateOrCreate([
                'code' => $permission['code'],
            ], [
                'name' => __($permission['name']),
                'namespace' => $permission['namespace'],
                'resource' => $permission['resource'] ?? null,
                'action' => $permission['action'] ?? null,
                'description' => $permission['description'] ?? null,
            ]);
        }
    }

    /**
     * Remove all permissions for this module
     *
     * Called during module uninstallation to clean up permissions.
     * Also removes permissions from all users and roles.
     */
    public static function cleanup(): void
    {
        $permissions = require __DIR__.'/permissions.php';

        $codes = array_column($permissions, 'code');
        Permission::whereIn('code', $codes)->delete();
    }
}
