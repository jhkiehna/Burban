<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use App\Events\NewUserRegistration;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmailVerificationMail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserEmailVerificationTest extends TestCase
{
    public function testAnEmailIsSentToVerifyUserEmails()
    {
        Mail::fake();

        $user = factory(User::class)->create();
        event(new NewUserRegistration($user));

        Mail::assertSent(UserEmailVerificationMail::class);
    }
}
