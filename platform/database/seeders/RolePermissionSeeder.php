<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = config('platform.roles', []);

        foreach ($roles as $role) {
            Role::findOrCreate($role);
        }
    }
}
