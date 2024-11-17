<?php

namespace Tests\Feature\Api;

use App\Enums\RoleEnum;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardTest extends TestCase{
    use RefreshDatabase;

    public $user, $admin;
    
    public function setUp(): void{
        parent::setUp();

        $this->user = User::factory()->create();
        $this->user->roles()->sync(Role::factory()->create(['name' => RoleEnum::USER]));
        $this->admin = User::factory()->create();
        $this->admin->roles()->sync(Role::factory()->create(['name' => RoleEnum::ADMIN]));
    }

    public function test_user_with_user_role_can_visit_user_dashboard_and_cannot_visit_admin_dashboard(): void{
        $user_response = $this->actingAs($this->user)->getJson('/api/user/dashboard');
        $user_response->assertStatus(200);

        $admin_response = $this->actingAs($this->user)->getJson('/api/admin/dashboard');
        $admin_response->assertStatus(403);
    }

    public function test_user_with_admin_role_can_visit_admin_dashboard_and_cannot_visit_user_dashboard(): void{
        $admin_response = $this->actingAs($this->admin)->getJson('/api/admin/dashboard');
        $admin_response->assertStatus(200);

        $user_response = $this->actingAs($this->admin)->getJson('/api/user/dashboard');
        $user_response->assertStatus(403);
    }
}