<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase{
    use RefreshDatabase;

    public $user;

    protected function setUp(): void{
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_register_successfully_with_valid_inputs(): void{
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123456',
            'password_confirmation' => '123456',
        ];

        $response = $this->postJson('/api/register', $data);
        
        $response->assertStatus(201);
        $response->assertJsonStructure(['token', 'user' => ['name', 'email']]);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_can_login_successfully_with_valid_credentials(): void{
        $user = User::factory()->create(['password' => '123456']);
        
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '123456'
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([ "token", "user" => ['name', 'email']]);status: 
    }

    public function test_user_cannot_access_profile_without_authentication(){
        $response = $this->getJson('/api/profile');
        
        $response->assertStatus(401);
    }

    public function test_user_can_access_profile_successfully(){
        $response = $this->actingAs($this->user)->getJson('/api/profile');
        
        $response->assertOk();
        $response->assertJsonStructure(["name", "email"]);
    }

    public function test_user_can_logout_successfully(){
        $response = $this->actingAs($this->user)->postJson('/api/logout');
        
        $response->assertOk();
        $response->assertJson(["message" => "Logged out successfully"]);
    }
}