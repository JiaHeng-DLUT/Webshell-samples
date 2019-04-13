<?php

namespace app\common\validate;


use think\Validate;

class Consulting extends Validate
{
    protected $rule = array(
       ['consulttype_name', 'require', '请填写咨询类型名称'],
       ['consulttype_sort', 'require|Number', '请正确填写咨询类型排序'],
    );

    protected $scene = [
        'type_add' => ['consulttype_name', 'sort'],
        'type_edit' => ['consulttype_name', 'sort'],
    ];
}