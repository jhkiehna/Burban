<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAuthTest extends TestCase
{
    public function testRouteCanReturnUserBasedOnApiToken()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json('GET', '/user');

        $response->assertStatus(200);
        $response->assertJsonFragment(['email' => $user->email]);
    }

    public function testReturnsUnauthorizedResponseWhenTokenIsWrong()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. 'asfsafsadfasf'
        ])->json('GET', '/user');

        $response->assertStatus(401);
    }
}
