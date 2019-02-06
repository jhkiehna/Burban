<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    public function testAUserCanLogin()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('testPass')
        ]);

        $payload = [
            'email' => $user->email,
            'password' => 'testPass'
        ];

        $response = $this->json('POST', '/user/login', $payload);

        $user->refresh();
        $response->assertStatus(200);
        $response->assertJsonFragment(['api_token' => $user->api_token]);
    }

    public function testAUserCantLoginWithBadPassword()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('testPass')
        ]);

        $payload = [
            'email' => $user->email,
            'password' => 'testPass2'
        ];

        $response = $this->json('POST', '/user/login', $payload);

        $response->assertStatus(401);
        $response->assertJsonFragment(['error' => 'Invalid email or password']);
    }

    public function testAUseCanLogOut()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json('GET', '/user/logout');

        $response->assertStatus(204);
    }
}
