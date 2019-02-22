<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordChangeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'exists:users,email',
                'max:255',
            ],
            'password' => [
                'required',
                'confirmed',
                'string',
                'max:255',
            ],
            'new_password' => [
                'required',
                'string',
                'min:8',
                'max:255',
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'You must enter an email address',
            'email.email' => 'Your email address does not appear to be valid',
            'email.exists' => 'We have no users with that email address',
            'email.max' => 'Your email address cannot be longer than 255 characters',

            'password.required' => 'You must enter your current password',
            'password.confirmed' => 'The two current password fields did not match',
            'password.string' => 'Password is an invalid data type',
            'password.max' => 'Your current password cannot be longer than 255 characters',

            'new_password.required' => 'You must enter a new password',
            'new_password.string' => 'Password is an invalid data type',
            'new_password.min' => 'Your new password must be at least 8 characters long',
            'new_password.max' => 'Your new password cannot be longer than 255 characters',
        ];
    }
}
