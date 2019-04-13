<?php

namespace app\common\validate;


use think\Validate;

class Type extends Validate
{
    protected $rule = [
        ['type_name', 'require', '类型名不能为空'],
        ['type_sort', 'require|number', '请填写类型排序|类型排序必须为数字'],
        ['class_id', 'require|number', '分类为必填|分类ID必须为数字'],
        ['attr_name', 'require', '属性名称为必填'],
        ['type_id', 'require|number', '类型ID为必填|类型ID必须为数字'],
        ['attr_show', 'require|number', '属性是否显示为必填|属性是否显示必须为数字'],
        ['attr_sort', 'require|number', '属性排序为必填|属性排序必须为数字'],
    ];

    protected $scene = [
        'type_add' => ['type_name', 'type_sort', 'class_id'],
        'type_edit' => ['type_name', 'type_sort', 'class_id'],
        'attr_edit' => ['attr_name', 'type_id', 'attr_show', 'attr_sort'],
    ];
}