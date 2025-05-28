<?php

namespace Modules\Permission\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()['cache']->forget('spatie.permission.cache');

        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
                     Role::firstOrCreate(['name' => 'Manager', 'guard_name' => 'web']);
                     Role::firstOrCreate(['name' => 'Staff', 'guard_name' => 'web']);

        $permissions = [
            ['name' => 'Access Role', 'module' => 'Permission', 'section' => 'Roles', 'guard_name' => 'web'],
            ['name' => 'Create Role', 'module' => 'Permission', 'section' => 'Roles', 'guard_name' => 'web'],
            ['name' => 'Edit Role', 'module' => 'Permission', 'section' => 'Roles', 'guard_name' => 'web'],
            ['name' => 'Delete Role', 'module' => 'Permission', 'section' => 'Roles', 'guard_name' => 'web'],
            ['name' => 'Assign Permission', 'module' => 'Permission', 'section' => 'Roles', 'guard_name' => 'web'],
        ];

        $permissionInstances = [];
        foreach ($permissions as $perm) {
            $permissionInstances[] = Permission::firstOrCreate($perm);
        }

        $adminRole->syncPermissions($permissionInstances);

        $user = User::find(1);
        if ($user) {
            $user->assignRole('Admin');
        }
    }
}
