<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategoryCreateRequest extends FormRequest
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
        $return=[
            'name'=>'required|unique:product_categories|max:5',
            'icon'=>'required',
            'banner'=>'required'
        ];
        if($this->get('banner_redirect')){
            $return['banner_redirect']='url';
        }
        return $return;
    }

    public function messages()
    {
        return [
            'name.required'=>'请填写栏目名称',
            'name.unique'=>'该栏目名称已存在',
            'name.max'=>'栏目名称最大长度为5',
            'icon.required'=>'请上传icon',
            'banner.required'=>'请上传banner',
            'banner_redirect.url'=>'banner跳转链接格式有误'
        ];
    }
}
