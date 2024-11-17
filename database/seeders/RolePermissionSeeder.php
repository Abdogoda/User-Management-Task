<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Enums\RoleEnum;
use App\Enums\PermissionEnum;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder{

    public function run(): void{
        $adminRole = Role::where('name', RoleEnum::ADMIN->value)->first();
        $adminPermissions = PermissionEnum::cases();
        foreach ($adminPermissions as $permission) {
            $adminRole->permissions()->attach(
                Permission::where('name', $permission->value)->first()
            );
        }

        $userRole = Role::where('name', RoleEnum::USER->value)->first();
        $userPermissions = [PermissionEnum::VIEW_USER, PermissionEnum::VIEW_ROLE, PermissionEnum::VIEW_PERMISSION];
        foreach ($userPermissions as $permission) {
            $userRole->permissions()->attach(
                Permission::where('name', $permission->value)->first()
            );
        }
    }
}