<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;

class EmailVerificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $user->setEmailVerified();

        return redirect(config('app.frontend_url'));
    }
}
