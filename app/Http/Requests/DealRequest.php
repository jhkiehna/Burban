<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->method()) {
            case "POST":
                return $this->postRules();
                break;
            case "PATCH":
                return $this->patchRules();
        }
    }

    public function messages()
    {
        return [
            'title.required' => 'A title is required',
            'title.string' => 'The title must be a string',
            'title.max' => 'The title cannot be longer than 255 characters',

            'description.required' => 'A description is required',
            'description.string' => 'The description must be a string',
            'descirption.max' => 'Description cannot be longer than 255 characters',

            'start_date.required' => 'A start date is required',
            'start_date.date' => 'The start date must be a valid date',
            'start_date.after_or_equal' => 'The start date cannot be before today',
            'start_date.before_or_equal' => 'The start date cannot be after the end date',

            'end_date.required' => 'An end date is required',
            'end_date.date' => 'The end date must be a valid date',
            'end_date.after_or_equal' => 'The end date cannot be before the start date',
        ];
    }

    public function postRules()
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'required',
                'string',
                'max:255',
            ],
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today',
                'before_or_equal:end_date'
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
            ]
        ];
    }

    public function patchRules()
    {
        return [
            'title' => [
                'string',
                'max:255',
            ],
            'description' => [
                'string',
                'max:255',
            ],
            'start_date' => [
                'date',
                'before_or_equal:end_date'
            ],
            'end_date' => [
                'date',
                'after_or_equal:start_date',
            ]
        ];
    }
}
