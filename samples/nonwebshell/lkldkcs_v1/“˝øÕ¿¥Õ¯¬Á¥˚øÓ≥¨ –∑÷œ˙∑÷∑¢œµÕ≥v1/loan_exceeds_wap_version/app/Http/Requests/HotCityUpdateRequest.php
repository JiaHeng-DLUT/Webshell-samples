<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotCityUpdateRequest extends FormRequest
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
            'city_id'  => 'required|unique:hot_cities,city_id,'.$this->get('id').',id',
        ];
    }

    public function messages()
    {
        return [
            'city_id.required'=>'请选择城市',
            'city_id.unique'=>'该城市已经是热门城市,请勿重复添加'
        ];
    }
}
