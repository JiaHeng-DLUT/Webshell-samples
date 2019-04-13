<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
        $return = [
//            'email' => 'required|unique:users,email,'.$this->get('id').',id|email',
//            'phone' => 'required|numeric|regex:/^1[34578][0-9]{9}$/|unique:users,phone,'.$this->get('id').',id',
            'username'  => 'required|between:6,50|unique:users,username,'.$this->get('id').',id',
            'name'  => 'required',
            'role_id'=>'required'
        ];
        if ($this->get('password') || $this->get('password_confirmation')){
            $return['password'] = 'required|confirmed|between:6,18';
        }
        return $return;
    }


    public function messages()
    {
        return [
            'username.required'=>'请填写登录名',
            'username.between'=>'登录名长度为6~50位',
            'username.unique'=>'该登录名已存在',
            'name.required'=>'请填写显示名称',
            'password.required'=>'请填写密码',
            'password.confirmed'=>'两次密码输入不一致',
            'password.between'=>'密码长度范围为6~18位',
            'password.regex'=>'密码中不能包含空格',
            'role_id.required'=>'请选择角色',
        ];
    }
}

