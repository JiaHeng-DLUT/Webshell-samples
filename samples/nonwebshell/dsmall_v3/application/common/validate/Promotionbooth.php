<?php

namespace app\common\validate;


use think\Validate;

class Promotionbooth extends Validate
{
    protected $rule = [
        ['promotion_booth_price', 'require|number', '请填写展位价格'],
        ['promotion_booth_goods_sum', 'require|number', '不能为空，且不小于1的整数']
    ];

    protected $scene = [
        'booth_setting' => ['promotion_booth_price', 'promotion_booth_goods_sum'],
    ];
}