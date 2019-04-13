<?php

namespace app\common\validate;


use think\Validate;

class Mallconsult extends Validate
{
    protected $rule = [
        ['mallconsulttype_name', 'require', '请填写咨询类型名称'],
        ['mallconsulttype_sort', 'require|number', '请正确填写咨询类型排序'],
        ['type_id', 'require|number','请选择咨询类型'],
        ['consult_content', 'require', '请填写咨询内容']
    ];

    protected $scene = [
        'type_add' => ['mallconsulttype_name', 'mallconsulttype_sort'],
        'type_edit' => ['mallconsulttype_name', 'mallconsulttype_sort'],
        'save_mallconsult' => ['type_id', 'consult_content'],
    ];
}