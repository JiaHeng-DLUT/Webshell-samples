<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductColumnUpdateRequest extends FormRequest
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
            'name'=>'required|max:6|unique:product_columns,name,'.$this->get('id').',id',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'请填写栏目名称',
            'name.unique'=>'该栏目名称已存在',
            'name.max'=>'栏目名称最大长度为6',
        ];
    }
}
