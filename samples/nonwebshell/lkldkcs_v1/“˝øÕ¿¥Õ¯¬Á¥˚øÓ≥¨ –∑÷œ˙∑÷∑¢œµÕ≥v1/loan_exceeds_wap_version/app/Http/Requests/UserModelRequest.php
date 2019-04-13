<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserModelRequest extends FormRequest
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
        $method=$this->getMethod();
        switch ($method){
            case 'POST':{
                $rules['name']='required|unique:user_models';break;
            }
            case 'PATCH':{
                $rules['name']='required|unique:user_models,name,'.$this->get('id');break;
            }
            default:$rules=[];
        }
        $rules['register_at_type']='required';
        $rules['last_active_at_type']='required';
        $rules['last_apply_loan_at_type']='required';
        if($this->get('register_at_type')==1){
            $rules['register_at_abstract_start']='required|date';
            $rules['register_at_abstract_end']='required|date|after_or_equal:register_at_abstract_start';
        }
        if($this->get('register_at_type')==2){
            $rules['register_at_relative_num']='required|regex:/^[1-9][0-9]*$/';
            $rules['register_at_relative_unit']='required';
            $rules['register_at_relative_type']='required';
        }
        if($this->get('last_active_at_type')==1){
            $rules['last_active_at_abstract_start']='required|date';
            $rules['last_active_at_abstract_end']='required|date|after_or_equal:last_active_at_abstract_start';
        }
        if($this->get('last_active_at_type')==2){
            $rules['last_active_at_relative_num']='required|regex:/^[1-9][0-9]*$/';
            $rules['last_active_at_relative_unit']='required';
            $rules['last_active_at_relative_type']='required';
        }
        if($this->get('last_apply_loan_at_type')==1){
            $rules['last_apply_loan_at_abstract_start']='required|date';
            $rules['last_apply_loan_at_abstract_end']='required|date|after_or_equal:last_apply_loan_at_abstract_start';
        }
        if($this->get('last_apply_loan_at_type')==2){
            $rules['last_apply_loan_at_relative_num']='required|regex:/^[1-9][0-9]*$/';
            $rules['last_apply_loan_at_relative_unit']='required';
            $rules['last_apply_loan_at_relative_type']='required';
        }
        if($this->get('all_login_day_start') && $this->get('all_login_day_end')){
            $rules['all_login_day_end']='required|numeric|min:'.$this->get('all_login_day_start');
        }
        if($this->get('all_apply_num_start') && $this->get('all_apply_num_end')){
            $rules['all_apply_num_end']='required|numeric|min:'.$this->get('all_apply_num_start');
        }


        return $rules;
    }


    public function messages()
    {
        return[
            'name.required'=>'请填写模型名称',
            'name.unique'=>'改模型名称已存在',

            'register_at_type.required'=>'请选择注册时间类型',
            'register_at_abstract_start.required'=>'请选择注册绝对开始时间',
            'register_at_abstract_start.date'=>'注册绝对开始时间格式错误',
            'register_at_abstract_end.required'=>'请选择注册绝对结束时间',
            'register_at_abstract_end.date'=>'注册绝对结束时间格式错误',
            'register_at_abstract_end.after_or_equal'=>'注册绝对结束时间必须大于等于开始时间',
            'register_at_relative_num.required'=>'请填写注册相对时间值',
            'register_at_relative_num.regex'=>'注册相对时间必须是正整数',
            'register_at_relative_unit.required'=>'请填写注册相对时间单位',
            'register_at_relative_type.required'=>'请填写注册相对时间类型',

            'last_active_at_type.required'=>'请选择最后活跃时间类型',
            'last_active_at_abstract_start.required'=>'请选择最后活跃绝对开始时间',
            'last_active_at_abstract_start.date'=>'最后活跃绝对开始时间格式错误',
            'last_active_at_abstract_end.required'=>'请选择最后活跃绝对结束时间',
            'last_active_at_abstract_end.date'=>'最后活跃绝对结束时间格式错误',
            'last_active_at_abstract_end.after_or_equal'=>'最后活跃绝对结束时间必须大于等于开始时间',
            'last_active_at_relative_num.required'=>'请填写最后活跃相对时间值',
            'last_active_at_relative_num.regex'=>'最后活跃相对时间必须是正整数',
            'last_active_at_relative_unit.required'=>'请填写最后活跃相对时间单位',
            'last_active_at_relative_type.required'=>'请填写最后活跃相对时间类型',

            'last_apply_loan_at_type.required'=>'请选择最后申请产品时间类型',
            'last_apply_loan_at_abstract_start.required'=>'请选择最后申请产品绝对开始时间',
            'last_apply_loan_at_abstract_start.date'=>'最后申请产品绝对开始时间格式错误',
            'last_apply_loan_at_abstract_end.required'=>'请选择最后申请产品绝对结束时间',
            'last_apply_loan_at_abstract_end.date'=>'最后申请产品绝对结束时间格式错误',
            'last_apply_loan_at_abstract_end.after_or_equal'=>'最后申请产品绝对结束时间必须大于等于开始时间',
            'last_apply_loan_at_relative_num.required'=>'请填写最后申请产品相对时间值',
            'last_apply_loan_at_relative_num.regex'=>'最后申请产品相对时间必须是正整数',
            'last_apply_loan_at_relative_unit.required'=>'请填写最后申请产品相对时间单位',
            'last_apply_loan_at_relative_type.required'=>'请填写最后申请产品相对时间类型',

            'all_login_day_end.min'=>'累计登陆天数后值不能比前值小',
            'all_apply_num_end.min'=>'累计产品申请数后值不能比前值小',



        ];
    }
}
