<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
                        'url' => 'required',
//                        'redirect_url' => 'required|url',
                        'sort' => 'required|between:-999,999',
                    ];
                }
            // UPDATE
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'url' => 'required',
//                        'redirect_url' => 'required|url',
                        'sort' => 'required|between:-999,999',
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
            'url.required' => '图片不能为空。',
            'redirect_url.url' => '跳转链接格式不对。',
            'redirect_url.required' => '跳转链接不能为空。',
            'sort.required' => '排序不能为空。',
            'sort.between' => '排序请输入-999~999的值。',
        ];
    }
}
