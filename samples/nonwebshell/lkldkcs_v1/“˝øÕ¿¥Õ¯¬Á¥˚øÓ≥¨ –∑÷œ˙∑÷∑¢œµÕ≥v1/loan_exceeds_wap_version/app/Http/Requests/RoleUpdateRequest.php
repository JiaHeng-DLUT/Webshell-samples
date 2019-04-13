<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
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
            'type'=>'required',
            'name'=>'required|unique:roles,name,'.$this->get('id').',id|max:200',
            'display_name'  => 'required|unique:roles,name,'.$this->get('id').',id',
        ];
    }

    public function messages()
    {
        return [
            'type.required'=>'请选择角色类型',
            'name.required'=>'请填写角色标识',
            'name.unique'=>'该角色标识已存在',
            'display_name.required'=>'请填写角色显示名称',
            'display_name.unique'=>'该角色显示名称已存在',

        ];
    }
}
