<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

final class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        resolve(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ([
            'ViewAny:Product',
            'View:Product',
            'Create:Product',
            'Update:Product',
            'Delete:Product',
            'DeleteAny:Product',
            'Restore:Product',
            'RestoreAny:Product',
            'ForceDelete:Product',
            'ForceDeleteAny:Product',
            'Replicate:Product',
            'Reorder:Product',
        ] as $permissionName) {
            Permission::findOrCreate($permissionName, 'admin');
        }

        $superAdminRole = Role::findOrCreate('super_admin', 'admin');

        $adminPermissions = Permission::query()
            ->where('guard_name', 'admin')
            ->pluck('name')
            ->all();

        if ($adminPermissions !== []) {
            $superAdminRole->syncPermissions($adminPermissions);
        }

        foreach (['admin', 'budgeteer', 'site_manager', 'director'] as $roleName) {
            Role::findOrCreate($roleName, 'web');
        }
    }
}
