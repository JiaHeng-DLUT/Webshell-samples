<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HelpRequest extends FormRequest
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
//                        'question' => 'required|max:50',

                    ];
                }
            // UPDATE
            case 'PUT':
            case 'PATCH':
                {
                    return [
//                        'question' => 'required|max:50',
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
//            'question.required' => '问题不能为空。',
//            'question.max' => '问题最多50个字。',
//            'answer.required' => '回答不能为空。',
//            'answer.max' => '回答最多500个字。',
        ];
    }
}
