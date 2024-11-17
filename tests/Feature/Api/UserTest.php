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

class UserTest extends TestCase{
    use RefreshDatabase;

    public function test_users_endpoint_return_data_successfully_and_must_have_the_authorize(): void{
        $user = $this->createUserWithRoleAndPermissions(
            RoleEnum::ADMIN->value,
            [ PermissionEnum::VIEW_USER->value ]
        );

        User::factory(20)->create();
        $response = $this->actingAs($user)->getJson('/api/users');

        $response->assertStatus(200);
        $response->assertJsonStructure(["data" => []]);
    }
    
    public function test_user_create_requires_permission() {
        $user = $this->createUserWithRoleAndPermissions(
            RoleEnum::ADMIN->value,
            [ PermissionEnum::CREATE_USER->value ]
        );

        $response = $this->actingAs($user)->postJson('/api/users', [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
        ]);
    
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }

    public function test_user_update_requires_permission() {
        $user = $this->createUserWithRoleAndPermissions(
            RoleEnum::ADMIN->value,
            [ PermissionEnum::EDIT_USER->value ]
        );
        $updateUser = User::factory()->create();
    
        $response = $this->actingAs($user)->putJson("/api/users/{$updateUser->id}", [
            'name' => 'Updated User',
            'email' => 'updateduser@example.com',
        ]);
    
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => 'updateduser@example.com']);
        $this->assertDatabaseMissing('users', ['email' => $updateUser->email]);
    }

    public function test_user_update_can_assign_roles_to_user() {
        $user = $this->createUserWithRoleAndPermissions(
            RoleEnum::ADMIN->value,
            [ PermissionEnum::EDIT_USER->value ]
        );
        $updateUser = User::factory()->create();
    
        $response = $this->actingAs($user)->putJson("/api/users/{$updateUser->id}", [
            'roles' => [1],
        ]);
    
        $response->assertStatus(200);
    }

    public function test_user_delete_requires_permission() {
        $user = $this->createUserWithRoleAndPermissions(
            RoleEnum::ADMIN->value,
            [ PermissionEnum::DELETE_USER->value ]
        );
        $deleteUser = User::factory()->create();
    
        $response = $this->actingAs($user)->deleteJson("/api/users/{$deleteUser->id}");
    
        $response->assertStatus(200);
        $this->assertDatabaseMissing('users', ['email' => $deleteUser->email]);
    }

    public function test_user_delete_requires_permission_fail() {
        $user = User::factory()->create();
        $deleteUser = User::factory()->create();
    
        $response = $this->actingAs($user)->deleteJson("/api/users/{$deleteUser->id}");
    
        $response->assertStatus(403); // Forbidden
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