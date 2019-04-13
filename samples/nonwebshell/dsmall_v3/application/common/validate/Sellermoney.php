<?php

namespace app\common\validate;


use think\Validate;

class Sellermoney extends Validate
{
    protected $rule = [
        ['pdc_amount', 'require|number|min', '请填写取出金额|取出金额必须是数字|0.01']
    ];

    protected $scene = [
        'withdraw_add' => ['pdc_amount'],
    ];
}