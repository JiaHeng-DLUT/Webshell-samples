<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WebSiteRequest extends FormRequest
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
//                        'company_name' => 'required|between:1,10|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
                        'company_name' => 'required|between:1,10',
                        'phone' => 'required|nullable|max:20',
                        'record_num' => 'required|between:1,30',
                        'base_loan' => 'between:0,999999',
                        'base_today_loan' => 'between:0,999999',
                        'qrcode_weixin' => 'required',
                        'qrcode_app' => 'required',
                    ];
                }
            // UPDATE
            case 'PUT':
            case 'PATCH':
                {
                    return [
//                        'company_name' => 'required|between:1,10|regex:/^[\x{4e00}-\x{9fa5}]+$/u',
                        'company_name' => 'required|between:1,10',
                        'phone' => 'required|nullable|max:20',
                        'record_num' => 'required|between:1,30',
                        'base_loan' => 'required|min:0|max:999999',
                        'base_today_loan' => 'required|min:0|max:999999',
                        'qrcode_weixin' => 'required',
                        'qrcode_app' => 'required',
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
            'company_name.required' => '公司名称不能为空。',
            'company_name.between' => '公司名称字数介于 1-10 个字之间 ',
//            'company_name.regex' => '公司名称只能是汉字 ',
            'phone.required' => '联系电话不能为空。 ',
            'phone.max' => '联系电话最多输入20个字符。 ',
            'phone.nullable' => '联系电话请输入数字。 ',
            'record_num.required' => '备案号不能为空。 ',
            'record_num.between' => '备案号字数介于 1-30 个字之间。 ',
            'base_loan.min' => '累计借款基数最小数字是0。 ',
            'base_loan.max' => '累计借款基数最大数字是999999。 ',
            'base_loan.required' => '累计借款基数不能为空。 ',
            'base_today_loan.min' => '今日借款基数最小数字是0。 ',
            'base_today_loan.max' => '今日借款基数最大数字是999999。 ',
            'base_today_loan.required' => '今日借款基数不能为空。 ',
            'qrcode_weixin.required' => '微信二维码图片不能为空',
            'qrcode_app.required' => 'App二维码图片不能为空',
        ];
    }
}
