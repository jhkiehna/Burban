<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
                return [
                    'name' => [
                        'required',
                        'string',
                        'unique:businesses',
                        'max:255',
                    ],
                    'street_address' => [
                        'required',
                        'string',
                        'max:255',
                    ],
                    'city' => [
                        'required',
                        'string',
                        'max:255',
                    ],
                    'state' => [
                        'required',
                        'string',
                        'max:2'
                    ],
                    'phone' => [
                        'required',
                        'string',
                        'max:255'
                    ],
                    'summary' => [
                        'required',
                        'string',
                        'max:500'
                    ],
                ];
                break;
            case 'PATCH':
                return [
                    'name' => [
                        'string',
                        'unique:businesses',
                        'max:255',
                    ],
                    'street_address' => [
                        'string',
                        'max:255',
                    ],
                    'city' => [
                        'string',
                        'max:255',
                    ],
                    'state' => [
                        'string',
                        'max:2'
                    ],
                    'phone' => [
                        'string',
                        'max:255'
                    ],
                    'summary' => [
                        'string',
                        'max:500'
                    ],
                ];
                break;
            case 'DELETE':
                return [];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'You must specify a name for your business',
            'name.string' => 'Name is an invalid data type',
            'name.unique' => 'We already have a business with that name',
            'name.max' => 'Your business\'s name cannot be longet than 255 characters',

            'street_address.required' => 'You must specify the street address of your business',
            'street_address.string' => 'street_address is an invalid data type',
            'street_address.max' => 'Your business\'s street address cannot be longer than 255 characters',

            'city.required' => 'You must specify the city that your business is located in',
            'city.string' => 'City is an invalid data type',
            'city.max' => 'Your business\'s city cannot be longer than 255 characters',

            'state.required' => 'You must specify the State that your business is located in',
            'state.string' => 'State is an invalid data type',
            'state.max' => 'Please use your State\'s 2 letter abbreviation',

            'phone.required' => 'You must specify a valid phone number for your business',
            'phone.string' => 'Phone is an invalid data type',
            'phone.max' => 'Phone cannot be longer than 255 characters',

            'summary.required' => 'You must enter a summary/description for your business',
            'summary.string' => 'Summary is an invalid data type',
            'summary.max' => 'Summary cannot be longer than 500 characters',
        ];
    }
}
