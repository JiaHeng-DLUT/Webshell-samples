<?php

namespace app\common\validate;


use think\Validate;

class Notice extends Validate
{
    protected $rule = [
        ['user_name', 'require', '会员列表不能为空'],
        ['content1', 'require', '通知内容不能为空']
    ];

    protected $scene = [
        'notice1' => ['user_name'],
        'notice2' => ['content1'],
    ];
}