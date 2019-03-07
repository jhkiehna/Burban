<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class UserEmailVerificationTest extends TestCase
{
    public function testEndpointCanVerifyAUsersEmail()
    {
        $user = factory(User::class)->create([
            'email_verified' => false,
            'email_verified_at' => null
        ]);

        $response = $this->json('GET', '/user/verify-email?api_token=' . $user->api_token);
        $user->refresh();

        $response->assertStatus(302);
        $this->assertTrue($user->email_verified);
        $this->assertNotNull($user->email_verified_at);
    }
}
