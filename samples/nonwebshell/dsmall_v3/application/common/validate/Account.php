<?php

namespace app\common\validate;


use think\Validate;

class Account extends Validate
{
    protected $rule = [
        ['qq_appid', 'require', '请添加应用标识'],
        ['qq_appkey', 'require', '请添加应用密钥'],
        ['sina_wb_akey', 'require', '请添加应用标识'],
        ['sina_wb_skey', 'require', '请添加应用密钥'],
        ['weixin_appid', 'require', '请添加应用标识'],
        ['weixin_secret', 'require', '请添加应用密钥']
    ];

    protected $scene = [
        'qq' => ['qq_appid', 'qq_appkey'],
        'sina' => ['sina_wb_akey', 'sina_wb_skey'],
        'wx' => ['weixin_appid', 'weixin_secret']
    ];
}