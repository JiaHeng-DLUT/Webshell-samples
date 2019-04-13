<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
                        'cover' => 'required',
                        'title' => 'required|between:1,30',
                        'corner_id' => 'nullable',
                        'category_id' => 'required',
                        'base_views' => 'required|numeric|between:0,99999',
                        'intro' => 'required|max:50',
                    ];
                }
            // UPDATE
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'cover' => 'required',
                        'title' => 'required|between:1,30',
                        'corner_id' => 'nullable',
                        'category_id' => 'required',
                        'base_views' => 'required|numeric|between:0,99999',
                        'intro' => 'required|max:50',
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
            'cover.required' => '封面图不能为空。',
            'title.required' => '标题不能为空。',
            'title.between' => '标题控制在30个字以内。',
            'category_id.required' => '发现分类是必选项。',
            'base_views.required' => '阅读数基数是必填项。',
            'base_views.numeric' => '阅读数基数只能是数字。',
            'base_views.between' => '阅读数基数请输入0~99999的数字。',
            'intro.required' => '摘要是必填项。',
            'intro.max' => '摘要最多50个字。',
        ];
    }
}
