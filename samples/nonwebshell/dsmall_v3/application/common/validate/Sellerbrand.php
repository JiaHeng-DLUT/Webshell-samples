<?php

namespace app\common\validate;


use think\Validate;

class Sellerbrand extends Validate
{
    protected $rule = [
        ['brand_name', 'require', '品牌名称不能为空'],
        ['brand_initial', 'require', '请填写首字母']
    ];

    protected $scene = [
        'brand_save' => ['brand_name', 'brand_initial'],
        'brand_edit' => ['brand_name', 'brand_initial'],
    ];
}