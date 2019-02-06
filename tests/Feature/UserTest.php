<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    public function testReturnsUnauthorizedResponseWhenTokenIsWrong()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. 'asfsafsadfasf'
        ])->json('GET', '/deals/saved');

        $response->assertStatus(401);
    }
}
