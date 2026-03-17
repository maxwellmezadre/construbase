<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        Admin::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@filakit.com',
        ])->assignRole('super_admin');

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@filakit.com',
        ])->assignRole('admin');
    }
}
