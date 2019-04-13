<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppRequest extends FormRequest
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
                        'package_name' => 'required|max:30|unique:apps,package_name',

                    ];
                }
            // UPDATE
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'package_name' => 'required|max:30',
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
            'package_name.required' => 'app包名称不能为空。',
            'package_name.max' => 'app包名称控制在30个字之内。',
            'package_name.unique' => 'app包名已存在。',
        ];
    }
}
