<?php

namespace app\common\validate;


use think\Validate;

class Memberflea extends Validate
{
    protected $rule = [
        ['goods_name', 'require', '宝贝标题不能为空'],
        ['goods_price', 'require', '宝贝原价不能为空']
    ];

    protected $scene = [
        'edit_save_goods' => ['goods_name', 'goods_price'],
        'save_goods' => ['goods_name', 'goods_price'],
    ];
}