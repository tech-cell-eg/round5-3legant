<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */

    /**
     * @test
     */
    
    public function it_can_list_users()
    {
      $user = User::create([
            'username'   => 'test',
            'email'      => 'test@Example.com',
            'password'   => Hash::make('pasword'),
            'first_name' => 'admin',
            'last_name'  => 'admin',
            'avatar'  => 'Image',
        ]);
         $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => ['id', 'username', 'email', 'created_at', 'updated_at']
                ]
            ]);
    }

    /**
     * @test
     */

    public function it_can_create_a_user()
    {
        $admin = User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'first_name' => 'Admin',
            'last_name' => 'User',
        ]);

    // Authenticate as this user
    $this->actingAs($admin, 'sanctum');
        $data = [
            'username' => 'testuser',
            'email' => 'test@gmail.com',
            'password' => 'pasword',
        ];

        $response = $this->postJson('/api/users', $data);
        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'User created successfully',
            ]);
        $this->assertDatabaseHas('users', [
            'email' => 'test@gmail.com',
            'username' => 'testuser',
        ]);
    }


   
/** @test */

     public function it_can_show_user_details()
     {
        $user = User::create([
        'username'   => 'mariam',
        'email'      => 'mariam@example.com',
        'password'   => bcrypt('123456'),
        'first_name' => 'Mariam',
        'last_name'  => 'Emam',
        'avatar'     => 'default.png',
        ]);

        $this->actingAs($user, 'sanctum');
        $response = $this->getJson("/api/users/{$user->id}");
        $response->assertStatus(200)
             ->assertJson([
                 'success' => true,
                 'data' => ['id' => $user->id],
             ]);
     }
     /** @test */
    public function it_can_delete_a_user()
    {
        // Arrange: create a user manually
        $user = User::create([
            'username' => 'mariam',
            'email' => 'mariam@example.com',
            'password' => bcrypt('123456'),
            'first_name' => 'Mariam',
            'last_name' => 'Emam',
            'avatar' => 'default.png',
        ]);
        $this->actingAs($user, 'sanctum');
        // Act: send a DELETE request to the user endpoint
        $response = $this->deleteJson("/api/users/{$user->id}");

        // Assert: check the response and database
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'User deleted successfully',
            ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }





}

