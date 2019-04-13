<?php

namespace app\common\validate;


use think\Validate;

class Snsmember extends Validate
{
    protected $rule = [
        ['membertag_name', 'require', '会员标签名称不能为空'],
        ['membertag_sort', 'require|number', '会员标签排序只能为数字'],
    ];

    protected $scene = [
        'tag_add' => ['membertag_name', 'membertag_sort'],
        'tag_edit' => ['membertag_name', 'membertag_sort'],
    ];
}