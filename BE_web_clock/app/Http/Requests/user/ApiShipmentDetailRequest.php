<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class ApiShipmentDetailRequest extends FormRequest
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
            'id_user'=>'required',
            'surname'=>'required',
            'name'=>'required',
            'phone_number'=>'required|min:8|max:11',
            'city_province'=>'required',
            'district'=>'required',
            'wards'=>'required',
            'address'=>'required'
        ];
    }
}
