<?php

namespace app\common\validate;


use think\Validate;

class Spec extends Validate
{
    protected $rule = [
        ['sp_name', 'require', '规格名称为必填'],
        ['sp_sort', 'require|number', '规格排序为必填|规格排序必须为数字'],
        ['gc_id', 'require|number', '分类为必填|分类ID必须为数字'],
    ];

    protected $scene = [
        'spec_add' => ['sp_name', 'sp_sort', 'gc_id'],
        'spec_edit' => ['sp_name', 'sp_sort', 'gc_id'],
    ];
}