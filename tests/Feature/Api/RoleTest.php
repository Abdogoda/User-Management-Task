<?php

namespace Tests\Feature\Api;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase{
    use RefreshDatabase;

    public function test_role_create_succesfully_requires_permission() {
        $user = $this->createUserWithRoleAndPermissions(
            RoleEnum::ADMIN->value,
            [ PermissionEnum::CREATE_ROLE->value ]
        );
        
        $response = $this->actingAs($user)->postJson('/api/roles', [
            'name' => 'New Role',
        ]);
    
        $response->assertStatus(201);
    }

    public function test_role_deletion_requires_permission_and_leave_users_without_a_role() {
        $user = $this->createUserWithRoleAndPermissions(
            RoleEnum::ADMIN->value,
            [ PermissionEnum::DELETE_ROLE->value ]
        );
        $role = Role::where('name', RoleEnum::ADMIN->value)->first();
        
        $this->assertTrue($user->roles()->where('name', RoleEnum::ADMIN->value)->exists());

        $response = $this->actingAs($user)->deleteJson('/api/roles/'.$role->id);
    
        $response->assertStatus(200);
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
        $user->refresh();
        $this->assertFalse($user->roles()->where('name', RoleEnum::ADMIN->value)->exists());
    }


    // =========================================================================
    // === Helper function to create a user with role and permission for testing
    // =========================================================================
    protected function createUserWithRoleAndPermissions(string $roleName, array $permissions = []){
        $user = User::factory()->create();
        $role = Role::factory()->create(['name' => $roleName]);
        $permissionModels = Permission::factory()->createMany(
            array_map(fn ($permission) => ['name' => $permission], $permissions)
        );
        $role->permissions()->sync($permissionModels);
        $user->roles()->sync($role);
        return $user;
    }
}