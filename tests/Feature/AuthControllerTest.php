<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function test_register()
    {
        $user = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->postJson(route('register'), $user);

        $response->assertCreated();

        $response->assertJsonStructure([
            'user' => [
                'name',
                'email',
            ],
            'message',
        ]);

        $response->assertJson([
            'user' => [
                'name' => $user['name'],
                'email' => $user['email'],
            ],
            'message' => 'User created successfully',
        ]);
    }

    public function test_login()
    {
        $user = [
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
        ];

        $this->postJson(route('register'), [
            'name' => $this->faker->name,
            'email' => $user['email'],
            'password' => $user['password'],
            'password_confirmation' => $user['password'],
        ]);

        $response = $this->postJson(route('login'), $user);

        $response->assertOk();

        $response->assertJsonStructure([
            'user' => [
                'name',
                'email',
            ],
            'token',
        ]);

        $response->assertJson([
            'user' => [
                'email' => $user['email'],
            ],
        ]);
    }
}
