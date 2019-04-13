<?php

namespace app\common\validate;


use think\Validate;

class Storeclass extends Validate
{
    protected $rule = [
        ['storeclass_name', 'require', '分类名称必填']
    ];

    protected $scene = [
        'store_class_add' => ['storeclass_name'],
        'store_class_edit' => ['storeclass_name']
    ];
}