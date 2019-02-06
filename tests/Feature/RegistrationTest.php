<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    public function testAUserCanRegisterForANewAccount()
    {
        $requestData = [
            'email' => 'testUser@test.test',
            'password' => 'testPass',
            'password_confirmation' => 'testPass',
        ];

        $response = $this->json('POST', 'user/register', $requestData);

        $response->assertStatus(201);
        $response->assertJsonFragment(['email' => $requestData['email']]);
        $this->assertDatabaseHas('users', ['email' => $requestData['email']]);
    }

    public function testAUserCantRegisterWithABadEmail()
    {
        $requestData = [
            'email' => 'testUsersMalformedEmailAddress',
            'password' => 'testPass',
            'password_confirmation' => 'testPass',
        ];

        $response = $this->json('POST', 'user/register', $requestData);

        $response->assertStatus(422);
        $response->assertJsonFragment(['email' => ['Your email address does not appear to be valid']]);
        $this->assertDatabaseMissing('users', ['email' => $requestData['email']]);
    }

    public function testAUserMustRegisterWithTwoMatchingPasswordFields()
    {
        $requestData = [
            'email' => 'test@test.test',
            'password' => 'testPass',
            'password_confirmation' => 'testPass2',
        ];

        $response = $this->json('POST', 'user/register', $requestData);

        $response->assertStatus(422);
        $response->assertJsonFragment(['password' => ['The two password fields did not match']]);
        $this->assertDatabaseMissing('users', ['email' => $requestData['email']]);
    }
}
