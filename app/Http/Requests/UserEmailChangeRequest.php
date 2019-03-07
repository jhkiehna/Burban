<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserEmailChangeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'new_email' => [
                'required',
                'email',
                'unique:users,email',
                'max:255',
            ],
            'current_password' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function messages()
    {
        return [
            'new_email.required' => 'You must enter a new email address',
            'new_email.email' => 'Your new email address does not appear to be valid',
            'new_email.unique' => 'The new email address you entered is already registered',
            'new_email.max' => 'Your new email address cannot be longer than 255 characters',

            'current_password.required' => 'You must enter your password',
            'current_password.string' => 'Password is an invalid data type',
            'current_password.max' => 'Your password cannot be longer than 255 characters',
        ];
    }
}
