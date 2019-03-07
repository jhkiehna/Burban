<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserEmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $link = url('user/verify-email') . '?api_token=' . $user->api_token;

        return $this->from(config('mail.from'))
            ->view('email.UserVerificationEmail')
            ->text('email.UserVerificationEmailText')
            ->with(['verificationLink' => $link]);
    }
}
