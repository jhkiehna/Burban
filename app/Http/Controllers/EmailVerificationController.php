<?php

namespace App\Http\Controllers;

class EmailVerificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $user->setEmailVerified();

        return redirect(config('app.frontend_url'));
    }
}
