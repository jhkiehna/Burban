<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserEmailVerificationTest extends TestCase
{
    public function testEndpointCanVerifyAUsersEmail()
    {
        $user = factory(User::class)->create();

        $response = $this->json('GET', '/users/verifyEmail?token=' . $user->api_token);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email_verified' => true]);
    }
}
