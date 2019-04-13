<?php

namespace app\common\validate;


use think\Validate;

class Sellersns extends Validate
{
    protected $rule = [
        ['content','require|length:1,140','内容不能为空且不能超过140个字'],
        ['goods_url','url','url格式不正确,请输入这正确的格式!']
    ];

    protected $scene = [
        'store_sns_save' => ['content', 'goods_url'],
    ];
}