<?php

namespace Database\Seeders;

use Chiiya\FilamentAccessControl\Enumerators\PermissionName;
use Chiiya\FilamentAccessControl\Enumerators\RoleName;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserAccessControlSeeder extends Seeder
{
    protected static array $roles = [RoleName::SUPER_ADMIN];

    protected static array $permissions = [
        PermissionName::UPDATE_ADMIN_USERS,
        PermissionName::UPDATE_PERMISSIONS,
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::$permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => config('auth.guard'),
            ]);
        }

        foreach (self::$roles as $role) {
            /** @var Role $role */
            $role = Role::create([
                'name' => $role,
                'guard_name' => config('auth.guard'),
            ]);

            foreach (self::$permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
    }
}
