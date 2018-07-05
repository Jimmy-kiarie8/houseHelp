<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'form.name' => 'required', 
            'form.password' => 'required',
            'form.email' => 'required|email|unique:users',
            'form.phone' => 'required|numeric',
            'form.city' => 'required',
            'form.country' => 'required',
            'form.id_no' => 'required|numeric',
            'form.age' => 'required|numeric'
        ];
    }
}
