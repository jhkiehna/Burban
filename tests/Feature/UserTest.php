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

        $response = $this->actingAs($user)->json('DELETE', '/user/delete');
        $user->refresh();

        $response->assertStatus(204);
        $this->assertTrue($user->deleted_at != null);
    }

    public function testItCantDeleteAUserWithTheWrongToken()
    {
        $user = factory(User::class)->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer thisIsABadToken'
        ])->json('DELETE', '/user/delete');
        
        $user->refresh();

        $response->assertStatus(401);
        $this->assertTrue($user->deleted_at == null);
    }

    public function testItCanUpdateAUsersPassword()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('currentTestPassword')
        ]);

        $response = $this->actingAs($user)->json('PATCH', '/user/updatePassword', [
            'current_password' => 'currentTestPassword',
            'password' => 'newTestPassword',
            'password_confirmation' => 'newTestPassword'
        ]);
        $user->refresh();

        $response->assertStatus(200);
        $response->assertJsonFragment(['email' => $user->email]);
        $this->assertTrue(Hash::check('newTestPassword', $user->password));
    }

    public function testItCantUpdatePasswordWhenCurrentPasswordIsInvalid()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('currentTestPassword')
        ]);

        $response = $this->actingAs($user)->json('PATCH', '/user/updatePassword', [
            'current_password' => 'badPassword',
            'password' => 'newTestPassword',
            'password_confirmation' => 'newTestPassword'
        ]);

        $response->assertStatus(403);
        $this->assertTrue(Hash::check('currentTestPassword', $user->password));
    }

    public function testItCanUpdateAUsersEmail()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make('testPassword')
        ]);

        $response = $this->actingAs($user)->json('PATCH', '/user/updateEmail', [
            'current_password' => 'testPassword',
            'new_email' => 'updatedTestEmail@test.com',
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

        $response = $this->actingAs($user)->json('PATCH', '/user/updateEmail', [
            'password' => 'badPassword',
            'new_email' => 'updatedTestEmail@test.com',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('users', ['email' => 'oldTestEmail@test.com']);
    }

    public function testUserIsUnauthorizedUnlessTheirEmailIsVerified()
    {
        $user = factory(User::class)->create([
            'email_verified' => false,
            'email_verified_at' => null,
        ]);

        $response = $this->actingAs($user)->json('GET', '/deals/saved');

        $response->assertStatus(403);
    }
}
