<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class ApiRegisterRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name'=>'required|max:255',
            'username'=>'required|min:8|unique:users',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6',
        ];
    }
}
