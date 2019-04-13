<?php

namespace app\common\validate;


use think\Validate;

class Storegrade extends Validate
{
    protected $rule = [
        ['storegrade_name', 'require', '店铺等级名称必填'],
        ['storegrade_sort', 'require|number|between:1,100', '排序为必填|排序必须是数字|等级级别不能大于100']

    ];

    protected $scene = [
        'add' => ['storegrade_name', 'storegrade_sort'],
        'edit' => ['storegrade_name', 'storegrade_sort'],
    ];
}