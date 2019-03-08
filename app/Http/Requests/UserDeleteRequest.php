<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDeleteRequest extends FormRequest
{
    public function rules()
    {
        return [
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
            'current_password.required' => 'You must enter your password',
            'current_password.string' => 'Password is an invalid data type',
            'current_password.max' => 'Your password cannot be longer than 255 characters',
        ];
    }
}
