<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
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
            'logo'=>'required',
            'name'=>'required|unique:products,name,,id,deleted_at,NULL',
            'slogan'=>'required',
            'rate_value'=>'required|between:0,100',
            'rate_unit'=>'required',
            'repay_min'=>'required|between:1,999',
            'repay_max'=>'required|between:1,999',
            'repay_unit'=>'required',
            'quota_min'=>'required|between:0,999999',
            'quota_max'=>'required|between:0,999999',
            'fast_lend_value'=>'required|between:1,999',
            'fast_lend_unit'=>'required',
            'success_rate'=>'required|between:1,100',
            'redirect_url'=>'required|url',
            'platform'=>'required',
            'apply_condition'=>'required|max:999',
            'auto_down_sale_num'=>'required|between:0,99999',
            'sort'=>'required|between:-999,999',
            'deal_type'=>'required',
            'deal_price'=>'required|between:0.01,999.99'
        ];
    }

    public function messages()
    {

        return [
            'logo.required'=>'请上传logo',
            'name.required'=>'请填写产品名称',
            'name.unique'=>'该产品名称已存在',
            'slogan.required'=>'请填写产品描述',
            'rate_value.required'=>'请填写贷款利率',
            'rate_value.between'=>'贷款利率范围为0,100',
            'rate_unit.required'=>'请选择利率单位',
            'repay_min.required'=>'请填写还款周期',
            'repay_min.between'=>'还款周期取值范围为1~999',
            'repay_max.required'=>'请填写还款周期',
            'repay_max.between'=>'还款周期取值范围为1~999',
            'repay_unit.required'=>'请选择还款周期单位',
             'quota_min.required'=>'请填写贷款额度',
            'quota_min.between'=>'贷款额度取值范围为0~999999',
            'quota_max.required'=>'请填写贷款额度',
            'quota_max.between'=>'贷款额度取值范围为0~999999',
            'fast_lend_value.required'=>'请填写最快放款时间',
            'fast_lend_value.between'=>'最快放款时间范围为1~999',
            'fast_lend_unit.required'=>'请选择最快放款时间单位',
            'success_rate.required'=>'请填写放款成功率',
            'success_rate.between'=>'放款成功率范围为1~100',
            'redirect_url.required'=>'请填写成功申请跳转链接',
            'redirect_url.url'=>'成功申请跳转链接格式有误',
            'platform.required'=>'请选择上线平台',
            'apply_condition.required'=>'请填写申请条件',
            'apply_condition.max'=>'申请条件最大长度为999',
            'auto_down_sale_num.required'=>'请填写自动下架申请数',
            'auto_down_sale_num.between'=>'自动下架申请数范围为0~99999',
            'sort.required'=>'请填写排序值',
            'sort.between'=>'排序值范围为-99~999',
            'deal_type.required'=>'请选择结算模式',
            'deal_price.required'=>'请填写结算价格',
            'deal_price.between'=>'结算价格范围为0.01~999.99',
        ];
    }
}
