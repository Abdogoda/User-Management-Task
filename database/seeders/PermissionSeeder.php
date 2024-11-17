<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder{

    public function run(): void{
        foreach (PermissionEnum::cases() as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}