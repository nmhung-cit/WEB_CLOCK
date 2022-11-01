<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class ApiProductdetailsRequest extends FormRequest
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
            'batery'=>'required',
            'material'=>'required',
            'material_glass'=>'required',
            'glass_shape'=>'required',
            'glass_size'=>'required',
            'waterproof_lever'=>'required',
            'color'=>'required',
            'origin'=>'required',
        ];
    }
}
