<?php

declare(strict_types=1);

use App\Models\Admin;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

it('seeds the prd business roles for application users', function (): void {
    $this->seed(RolesAndPermissionsSeeder::class);

    expect(
        Role::query()
            ->where('guard_name', 'web')
            ->pluck('name')
            ->sort()
            ->values()
            ->all(),
    )->toBe([
        'admin',
        'budgeteer',
        'director',
        'site_manager',
    ]);
});

it('allows a super admin to access the admin users resource', function (): void {
    Permission::findOrCreate('ViewAny:User', 'admin');

    $admin = Admin::factory()->create();
    $admin->assignRole(Role::findOrCreate('super_admin', 'admin')->givePermissionTo('ViewAny:User'));

    $this->actingAs($admin, 'admin')
        ->get('/admin/users')
        ->assertSuccessful();
});

it('forbids an admin without permissions from accessing the admin users resource', function (): void {
    $admin = Admin::factory()->create();

    $this->actingAs($admin, 'admin')
        ->get('/admin/users')
        ->assertForbidden();
});

it('supports creating users with business roles through factory states', function (): void {
    $user = User::factory()->director()->create();

    expect($user->fresh()->hasRole('director'))->toBeTrue();
});
