<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {   
        switch ($this->method()) {
            case 'POST':
                return auth()->user()->business_user;
                break;
            case 'PATCH':
                return auth()->user()->business_user && auth()->user()->id == $this->business->user_id;
                break;
            case 'DELETE':
                return auth()->user()->business_user && auth()->user()->id == $this->business->user_id;
                break;
            default:
                return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
