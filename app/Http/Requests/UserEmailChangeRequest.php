<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEmailChangeRequest extends FormRequest
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
            'new_email' => [
                'required',
                'email',
                'unique:users,email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'You must enter your current email address',
            'email.email' => 'Your current email address does not appear to be valid',
            'email.exists' => 'Please double check your current email address',
            'email.max' => 'Your email address cannot be longer than 255 characters',

            'new_email.required' => 'You must enter a new email address',
            'new_email.email' => 'Your new email address does not appear to be valid',
            'new_email.unique' => 'The new email address you entered is already registered',
            'new_email.max' => 'Your new email address cannot be longer than 255 characters',

            'password.required' => 'You must enter your password',
            'password.string' => 'Password is an invalid data type',
            'password.max' => 'Your password cannot be longer than 255 characters',
        ];
    }
}
