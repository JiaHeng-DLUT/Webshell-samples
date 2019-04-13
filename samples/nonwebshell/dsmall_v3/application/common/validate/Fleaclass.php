<?php

namespace app\common\validate;


use think\Validate;

class Fleaclass extends Validate
{
    protected $rule = [
        ['fleaclass_name','require','分类名称不能为空'],
        ['fleaclass_sort','require|number','分类排序仅能为数字']
    ];

    protected $scene = [
        'goods_class_add' => ['fleaclass_name', 'fleaclass_sort'],
        'goods_class_edit' => ['fleaclass_name', 'fleaclass_sort'],
    ];
}