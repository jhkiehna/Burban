<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordChangeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'current_password' => [
                'required',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:8',
                'max:255',
            ]
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'You must enter your current password',
            'password.string' => 'Password is an invalid data type',
            'password.max' => 'Your current password cannot be longer than 255 characters',

            'new_password.required' => 'You must enter a new password',
            'new_password.confirmed' => 'The two new password fields did not match',
            'new_password.string' => 'Password is an invalid data type',
            'new_password.min' => 'Your new password must be at least 8 characters long',
            'new_password.max' => 'Your new password cannot be longer than 255 characters',
        ];
    }
}
