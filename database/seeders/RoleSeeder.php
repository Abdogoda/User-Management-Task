<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder{
    
    public function run(): void{
        foreach (RoleEnum::cases() as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
    }
}