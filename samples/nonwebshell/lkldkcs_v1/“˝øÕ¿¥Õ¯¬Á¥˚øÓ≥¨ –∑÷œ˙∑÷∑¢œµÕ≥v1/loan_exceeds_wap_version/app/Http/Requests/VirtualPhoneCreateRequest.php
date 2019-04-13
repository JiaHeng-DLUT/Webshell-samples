<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VirtualPhoneCreateRequest extends FormRequest
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
            'path'=>'required',
            'import_type'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'path.required'=>'文件上传失败',
            'import_type.required'=>'请选择导入方式'
        ];
    }
}
