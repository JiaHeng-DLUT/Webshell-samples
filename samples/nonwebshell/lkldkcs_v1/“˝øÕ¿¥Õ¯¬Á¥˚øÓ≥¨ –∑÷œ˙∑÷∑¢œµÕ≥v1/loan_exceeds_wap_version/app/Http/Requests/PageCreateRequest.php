<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageCreateRequest extends FormRequest
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
            'title'  => 'required|max:255|unique:pages',
            'slug'  => 'required|max:50|unique:pages',
            'content'  => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required'=>'请填写页面名称',
            'title.max'=>'页面名称最大长度为255',
            'title.unique'=>'该页面名称已存在',
            'slug.required'=>'请填写页面标识',
            'slug.max'=>'页面标识最大长度为50',
            'slug.unique'=>'该页面标识已存在',
            'content.required'=>'请填写内容',
        ];
    }
}
