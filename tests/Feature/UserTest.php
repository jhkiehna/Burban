<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function testAuthTokenIsAcceptedforAUser()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $user->api_token
        ])->json('GET', '/user/logout');

        $response->assertStatus(204);
    }

    public function testReturnsUnauthorizedResponseWhenTokenIsWrong()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. 'asfsafsadfasf'
    ])->json('GET', '/user/logout');

        $response->assertStatus(401);
    }
}
