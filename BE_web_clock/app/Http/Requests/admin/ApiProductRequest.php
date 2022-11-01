<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class ApiProductRequest extends FormRequest
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
            'image'=>'required|image|mimes:jpeg,png,jpg',
            'type_product'=>'required',
            'price'=>'required',
            'trademark'=>'required',
            'description'=>'required',
        ];
        //|mime:jpg,jpeg,png|
    }
}
