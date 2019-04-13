<?php

namespace app\common\validate;


use think\Validate;

class Promotionbundling extends Validate
{
    protected $rule = [
        ['promotion_bundling_price', 'require|number','不能为空，且不小于1的整数'],
        ['promotion_bundling_sum', 'require|number', '不能为空，且不小于0的整数'],
        ['promotion_bundling_goods_sum', 'require|number', '不能为空，且为1到5之间的整数，包括1和5']
    ];

    protected $scene = [
        'bundling_setting' => ['promotion_bundling_price', 'promotion_bundling_sum', 'promotion_bundling_goods_sum'],
    ];
}