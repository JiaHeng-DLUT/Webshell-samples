<?php

namespace app\common\validate;


use think\Validate;

class Sellergoodsonline extends Validate
{
    protected $rule = [
        ['goods_name', 'require', '商品名称不能为空'],
        ['goods_price', 'require', '商品价格不能为空'],
    ];

    protected $scene = [
        'edit_save_goods' => ['goods_name','goods_price'],
    ];
}