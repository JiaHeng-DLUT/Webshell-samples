<?php

namespace app\common\validate;


use think\Validate;

class Message extends Validate
{
    protected $rule = [
        ['to_member_name','require','收件人不能为空'],
        ['msg_content','require','内容不能为空'],
    ];

    protected $scene = [
        'savemsg' => ['to_member_name','msg_content'],
    ];
}