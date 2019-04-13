<?php

namespace app\common\validate;


use think\Validate;

class Mailtemplates extends Validate
{
    protected $rule = [
        ['code', 'require', '编号不能为空'],
        ['title', 'require', '标题不能为空'],
        ['content', 'require', '正文不能为空'],
    ];

    protected $scene = [
        'email_tpl_edit' => ['code','title', 'content'],
    ];
}