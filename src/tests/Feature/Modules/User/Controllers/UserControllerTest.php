<?php

namespace Feature\Modules\User\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\User\Models\UserModel;
use Tests\TestCase;

class UserControllerTest extends TestCase {
    use RefreshDatabase, WithFaker;

    protected function authenticate() {
        $user = UserModel::create([
            'name'     => 'Test User',
            'email'    => 'testuser@example.com',
            'password' => 'password',
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);

        return $response['data']['access_token'];
    }

    public function test_create_user_successfully() {
        $userData = [
            'name'                  => 'Test User',
            'email'                 => 'testuser@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['id', 'name', 'email']]);
    }

    public function test_fetch_user_by_id_successfully() {
        $password = $this->faker->password;
        $user = UserModel::create([
            'name'     => $this->faker->name,
            'email'    => $this->faker->email,
            'password' => $password,
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => $password,
        ]);

        $token = $response['data']['access_token'];

        $response = $this->getJson("/api/users/{$user->id}", [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id'    => $user->id,
                    'name'  => $user->name,
                    'email' => $user->email,
                ]
            ]);
    }

    public function test_login_successful() {
        $user = UserModel::create([
            'name'     => 'Test User',
            'email'    => 'testuser@example.com',
            'password' => 'password',
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['access_token']]);
    }

    public function test_logout_successful() {
        $token = $this->authenticate();

        $response = $this->postJson('/api/logout', [], [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => ['message' => 'user logged out successfully']
            ]);
    }

    public function test_refresh_token_successful() {
        $token = $this->authenticate();

        $response = $this->getJson('/api/token/refresh', [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => ['access_token']]);
    }

    public function test_validate_token_successful() {
        $token = $this->authenticate();

        $response = $this->getJson('/api/token/validate', [
            "Authorization" => "Bearer $token"
        ]);

        $response->assertStatus(200)
            ->assertJson(['data' => true]);
    }
}
