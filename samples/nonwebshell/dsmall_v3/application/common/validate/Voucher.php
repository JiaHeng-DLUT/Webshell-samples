<?php

namespace app\common\validate;


use think\Validate;

class Voucher extends Validate
{
    protected $rule = [
        ['promotion_voucher_price', 'require|number', '购买单价应为大于0的整数'],
        ['promotion_voucher_storetimes_limit', 'require|number','每月活动数量应为大于0的整数'],
        ['promotion_voucher_buyertimes_limit', 'require|number', '最大领取数量应为大于0的整数'],
        ['voucher_price', 'require', '代金券面额应为大于0的整数'],
        ['voucher_price_describe', 'require', '描述不能为空'],
        ['voucher_points', 'require', '默认兑换积分数应为大于0的整数'],
        
        ['vouchertemplate_title', 'require|length:1,50', '模版名称不能为空且不能大于50个字符'],
        ['vouchertemplate_total', 'require|number', '可发放数量不能为空且必须为整数'],
        ['vouchertemplate_price', 'require|number', '模版面额不能为空且必须为整数，且面额不能大于限额'],
        ['vouchertemplate_limit', 'require', '模版使用消费限额不能为空且必须是数字'],
        ['vouchertemplate_desc', 'require|length:1,255', '模版描述不能为空且不能大于255个字符']
    ];

    protected $scene = [
        'setting' => ['promotion_voucher_price', 'promotion_voucher_storetimes_limit', 'promotion_voucher_buyertimes_limit'],
        'priceadd' => ['voucher_price', 'voucher_price_describe', 'voucher_points'],
        'priceedit' => ['voucher_price', 'voucher_price_describe', 'voucher_points'],
        'templateadd' => ['vouchertemplate_title', 'vouchertemplate_total', 'vouchertemplate_price', 'vouchertemplate_limit', 'vouchertemplate_desc'],
        'templateedit' => ['vouchertemplate_title', 'vouchertemplate_total', 'vouchertemplate_price', 'vouchertemplate_limit', 'vouchertemplate_desc'],
    ];
}