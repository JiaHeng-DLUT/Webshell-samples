<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ChannelRequest extends FormRequest
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

        switch ($this->method()) {
            // CREATE
            case 'POST':
                {
                    return [
//                        'channel_code' => 'required|unique:channels,channel_code',
                        'channel_name' => 'required|max:15|unique:channels,channel_name',
                        'department_id' => 'required',
                        'manager' => 'required|max:10',
                        'reduce_type' => 'required',
                        'role_id' => 'required',
                        'ceiling_num' => 'nullable|integer',
//                        'username' => 'required|min:6',
                        'username' => 'required|min:6|unique:users,username',
                        'password' => 'required|between:6,18',
                    ];
                }
            // UPDATE
            case 'PUT':
            case 'PATCH':
                {
                    return [
//                        'channel_code' => 'required',
                        'channel_name' => 'required|max:15',
                        'department_id' => 'required',
                        'manager' => 'nullable|max:10',
                        'reduce_type' => 'required',
                        'role_id' => 'required',
                        'ceiling_num' => 'nullable|integer',
//                        'username' => 'required|min:6',
                        'username' => 'required|min:6|unique:users,username,'.$this->get('user_id'),',id',
                        'password' => 'nullable|between:6,18|regex:/[^\s　]+/',
                    ];
                }
            case 'GET':
            case 'DELETE':
            default:
                {
                    return [];
                };
        }
    }


    public function messages()
    {
        return [
            'channel_code.required' => '渠道码不能为空。',
            'channel_code.unique' => '渠道码已存在。',
            'channel_name.required' => '渠道名称不能为空。',
            'channel_name.unique' => '渠道名称已经存在。',
            'channel_name.max' => '渠道名称控制在15个字内。',
            'department_id.required' => '渠道所属部门是必选项。',
            'manager.required' => '渠道负责人是必填的。',
            'manager.max' => '渠道负责人控制在10个内。',
            'reduce_type.required' => '渠道包扣量模式是必选项。',
            'role_id.required' => '渠道角色是必选项。',
            'ceiling_num.integer' => '单日注册上限必选是整数。',
            'username.required' => '登录用户是必填的。',
            'username.min' => '请设置6位以上的登录用户。',
            'password.between' => '登录密码控制在6~18个字符内',
            'password.regex' => '登录密码中不能有空格',
            'username.unique'=>'该登录名已经存在'

        ];
    }
}
