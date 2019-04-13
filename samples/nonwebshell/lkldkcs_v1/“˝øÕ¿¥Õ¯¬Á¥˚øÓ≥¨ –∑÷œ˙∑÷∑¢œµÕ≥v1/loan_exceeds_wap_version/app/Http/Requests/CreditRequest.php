<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreditRequest extends FormRequest
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
                    'qrcode_app' => 'required',//图片
                    'name' => 'required|between:1,15',
                    'credit_bank_id' => 'required',
//                    'corner_id' => 'required',
                    'introduce' => 'between:0,255',
                    'credit_level_id' => 'required',
                    'credit_organization_id' => 'required',
                    'year_fee' => 'required|between:1,30',
                    'free_period' => 'required|between:1,15',
                    'cash_amount' => 'required|between:1,15',
                    'status' => 'required',
                    'base_apply_num' => 'required|min:0|max:99999',
                    'sort' => 'required|min:-999|max:999'
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'qrcode_app' => 'required',//图片
                    'name' => 'required|between:1,15',
                    'credit_bank_id' => 'required',
//                    'corner_id' => 'required',
                    'introduce' => 'between:0,255',
                    'credit_level_id' => 'required',
                    'credit_organization_id' => 'required',
                    'year_fee' => 'required|between:1,30',
                    'free_period' => 'required|between:1,15',
                    'cash_amount' => 'required|between:1,15',
                    'status' => 'required',
                    'base_apply_num' => 'required|min:0|max:99999',
                    'sort' => 'required|min:-999|max:999'
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
            'qrcode_app.required' => '信用卡图片不能为空',
            'name.required' => '名称不能为空。',
            'name.between' => '名称字数介于 1-15 个字之间 ',
            'credit_bank_id.required' => '发卡行不能为空',
            'introduce.required' => '特权不能为空 ',
            'introduce.between' => '特权字数介于 1-200 个字之间。 ',
            'credit_level_id.required' => '卡等级不能为空 ',
            'credit_organization_id.between' => '卡组织不能为空 ',
            'year_fee.required' => '年费不能为空',
            'year_fee.between' => '年费不能超过30个字',
            'free_period.required' => '免息期不能为空',
            'free_period.between' => '免息期不能超过15个字',
            'cash_amount.required' => '取现额度不能为空',
            'cash_amount.between' => '取现额度不能超过15个字',
            'base_apply_num.required' => '申请基数不能为空。 ',
            'base_apply_num.min' => '今日借款基数最小数字是0。 ',
            'base_apply_num.max' => '今日借款基数最大数字是99999。 ',
            'sort.required' => '申请基数不能为空。',
            'sort.min' => '今日借款基数最小数字是-999。',
            'sort.max' => '今日借款基数最大数字是999。',

        ];
    }
}
