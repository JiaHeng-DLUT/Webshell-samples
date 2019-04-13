<?php

namespace app\common\validate;


use think\Validate;

class Sellercomplain extends Validate
{
    protected $rule = [
        ['appeal_message', 'require|length:1,255', '投诉内容不能为空且必须小于100个字符|投诉内容不能为空且必须小于100个字符'],
    ];

    protected $scene = [
        'appeal_save' => ['appeal_message'],
    ];
}