<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CircleRequest extends FormRequest
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
                        'title' => 'required|max:8',
                        'copy_content' => 'required|max:16',
                        'intro' => 'required|max:50',
                        'sort' => 'required|between:-999,999',
                    ];
                }
            // UPDATE
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'url' => 'required',
                        'title' => 'required|max:8',
                        'copy_content' => 'required|max：16',
                        'intro' => 'required|max:50',
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
            'url.required' => '二维码不能为空。',
            'title.required' => '标题不能为空。',
            'title.max' => '标题请输入1~8个字符。',
            'copy_content.required' => '可复制内容不能为空',
            'copy_content.max' => '可复制内容请输入1~16个字符。',
            'intro.required' => '描述不能为空。',
            'intro.max' => '描述请输入1~50个字符。',
            'sort.required' => '排序不能为空',
            'sort.between' => '排序请输入-999~999的数字。',
        ];
    }
}
