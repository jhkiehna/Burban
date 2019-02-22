<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
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

    public function testItCanDeleteAUser()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->get('/user/delete');
        $user->refresh();

        $response->assertStatus(204);
        $this->assertTrue($user->deleted_at != null);
    }

    public function testItCanUpdateAUsersPassword()
    {
        $user = factory(User::class)->create([
            'email' => 'testEmail@test.com',
            'password' => Hash::make('oldTestPassword')
        ]);

        $response = $this->actingAs($user)->json('POST', '/user/updatePassword', [
            'email' => 'testEmail@test.com',
            'new_password' => 'newTestPassword',
            'password' => 'oldTestPassword',
            'password_confirmation' => 'oldTestPassword'
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['email' => $user->email]);
        $this->assertTrue(Hash::check('newTestPassword', $user->password));
    }

    public function testItCantUpdatePasswordWhenCurrentPasswordIsInvalid()
    {
        $user = factory(User::class)->create([
            'email' => 'testEmail@test.com',
            'password' => Hash::make('oldTestPassword')
        ]);

        $response = $this->actingAs($user)->json('POST', '/user/updatePassword', [
            'email' => 'testEmail@test.com',
            'new_password' => 'newTestPassword',
            'password' => 'badPassword',
            'password_confirmation' => 'badPassword'
        ]);

        $response->assertStatus(401);
        $this->assertTrue(Hash::check('oldTestPassword', $user->password));
    }

    public function testItCanUpdateAUsersEmail()
    {
        $user = factory(User::class)->create([
            'email' => 'oldTestEmail@test.com',
            'password' => Hash::make('testPassword')
        ]);

        $response = $this->actingAs($user)->json('POST', '/user/updateEmail', [
            'email' => 'oldTestEmail@test.com',
            'new_email' => 'updatedTestEmail@test.com',
            'password' => 'testPassword',
        ]);

        $user->refresh();

        $response->assertStatus(200);
        $response->assertJsonFragment(['email' => 'updatedTestEmail@test.com']);
        $this->assertDatabaseHas('users', ['email' => 'updatedTestEmail@test.com']);
    }

    public function testItCantUpdateAUsersEmailWhenPasswordIsInvalid()
    {
        $user = factory(User::class)->create([
            'email' => 'oldTestEmail@test.com',
            'password' => Hash::make('testPassword')
        ]);

        $response = $this->actingAs($user)->json('POST', '/user/updateEmail', [
            'email' => 'oldTestEmail@test.com',
            'new_email' => 'updatedTestEmail@test.com',
            'password' => 'badPassword',
        ]);

        $response->assertStatus(401);
        $this->assertDatabaseHas('users', ['email' => 'oldTestEmail@test.com']);
    }
}
