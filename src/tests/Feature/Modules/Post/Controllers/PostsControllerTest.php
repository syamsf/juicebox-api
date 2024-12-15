<?php

namespace Feature\Modules\Post\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\User\Models\UserModel;
use Tests\TestCase;

class PostsControllerTest extends TestCase {
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

    public function test_create_post_success() {
        $token = $this->authenticate();

        $data = [
            'title'   => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

        $response = $this->postJson('/api/posts', $data, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'data' => [
                         'title'   => $data['title'],
                         'content' => $data['content'],
                     ],
                 ]);

        $this->assertDatabaseHas('posts', [
            'title'   => $data['title'],
            'content' => $data['content'],
        ]);
    }

    public function test_create_post_validation_error() {
        $token = $this->authenticate();

        $invalidData = [
            'title' => '',
        ];

        $response = $this->postJson('/api/posts', $invalidData, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(400)
                 ->assertJsonValidationErrors(['title'], 'detail');

        $this->assertDatabaseCount('posts', 0);
    }

    public function test_update_post_success() {
        $token = $this->authenticate();

        $createData = [
            'title'   => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

        $createResponse = $this->postJson('/api/posts', $createData, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $postId = $createResponse->json('data.id');

        $updatedData = [
            'title'   => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

        $response = $this->patchJson("/api/posts/{$postId}", $updatedData, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'title'   => $updatedData['title'],
                    'content' => $updatedData['content'],
                ],
            ]);

        $this->assertDatabaseHas('posts', [
            'title'   => $updatedData['title'],
            'content' => $updatedData['content'],
        ]);
    }

    public function test_delete_post_successfully() {
        $token = $this->authenticate();

        $createData = [
            'title'   => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

        $createResponse = $this->postJson('/api/posts', $createData, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $postId = $createResponse->json('data.id');

        $this->assertDatabaseHas('posts', [
            'id' => $postId,
            'deleted_at' => null,
        ]);

        $response = $this->deleteJson("/api/posts/{$postId}", [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertOk()->assertJson([
            'data' => ['message' => 'Post deleted successfully']
        ]);

        $this->assertSoftDeleted("posts", ["id" => $postId]);
    }


    public function test_delete_non_existent_post() {
        $token = $this->authenticate();

        $postId = 99999;

        $response = $this->deleteJson("/api/posts/{$postId}", [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertNotFound();
    }

    public function testFetchAllWithPagination() {
        $token = $this->authenticate();

        $createData = [
            'title'   => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

        $totalData = 5;
        for ($i = 0; $i < $totalData; $i++) {
            $this->postJson('/api/posts', $createData, [
                'Authorization' => 'Bearer ' . $token,
            ]);
        }

        $response = $this->getJson("/api/posts", [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'title',
                    'content',
                ],
            ],
            'meta' => [
                'pagination' => [
                    'total'
                ],
            ],
        ]);

        $response->assertJsonCount($totalData, 'data');
    }

    public function testFetchById() {
        $token = $this->authenticate();

        $createData = [
            'title'   => $this->faker->sentence,
            'content' => $this->faker->paragraph,
        ];

        $createResponse = $this->postJson('/api/posts', $createData, [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $postId = $createResponse->json('data.id');

        $response = $this->getJson("/api/posts/{$postId}", [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'content',
            ],
        ]);

        $response->assertJson(['data' => $createResponse->json('data')]);
    }
}
