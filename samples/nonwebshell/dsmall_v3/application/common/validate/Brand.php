<?php

namespace app\common\validate;


use think\Validate;

class Brand extends Validate
{
    protected $rule = [
        ['brand_name', 'require', '品牌名称不能为空'],
        ['brand_initial', 'require', '请填写首字母'],
        ['brand_sort', 'require|number', '排序仅可以为数字']
    ];

    protected $scene = [
        'brand_add' => ['brand_name', 'brand_initial', 'brand_sort'],
        'brand_edit' => ['brand_name', 'brand_initial', 'brand_sort'],
    ];
}