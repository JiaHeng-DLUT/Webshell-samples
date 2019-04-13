<?php

namespace app\common\validate;

use think\Validate;

class Storedeposit extends Validate
{
    protected $rule = [
        ['seller_id', 'require|number', '请输入店主用户名|店主信息错误'],
        ['amount', 'require', '请添加金额'],
        ['operatetype', 'require', '请输入增减类型'],
    ];

    protected $scene = [
        'adjust' => ['seller_id', 'amount','operatetype'],
    ];
}