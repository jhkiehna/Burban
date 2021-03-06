<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmailVerificationMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEmailVerification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {
        $mailObject = new UserEmailVerificationMail($event->user);

        Mail::to($event->user->email)
            ->send($mailObject);
        
        return;
    }
}
