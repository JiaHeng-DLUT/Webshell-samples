<?php

namespace app\common\validate;


use think\Validate;

class Vrgroupbuy extends Validate
{
    protected $rule = [
        ['vrgclass_name', 'require|length:1,10', '分类名不能为空且只能在1-10之间'],
        ['vrgclass_sort', 'require|between:0,255', '分类排序不能为空且只能在0-255之间']
    ];

    protected $scene = [
        'class_add' => ['vrgclass_name', 'vrgclass_sort'],
        'class_edit' => ['vrgclass_name', 'vrgclass_sort'],
    ];
}