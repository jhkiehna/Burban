<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => [
                'required',
                'email',
                'unique:users',
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
            'email.required' => 'You must enter an email address',
            'email.email' => 'Your email address does not appear to be valid',
            'email.unique' => 'That email address is already registered',
            'email.max' => 'Your email address cannot be longer than 255 characters',

            'password.required' => 'You must enter your password',
            'password.confirmed' => 'The two password fields did not match',
            'password.string' => 'Password is an invalid data type',
            'password.min' => 'Your password must be at least 8 characters long',
            'password.max' => 'Your password cannot be longer than 255 characters',
        ];
    }
}
