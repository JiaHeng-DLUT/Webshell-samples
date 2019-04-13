<?php

namespace app\common\validate;


use think\Validate;

class Selleraddress extends Validate
{
    protected $rule = [
        ['seller_name', 'require', '收件人不能为空'],
        ['area_id', 'require|number', '请选择地址|请选择地址'],
        ['city_id', 'require|number', '请选择地址|请选择地址'],
        ['area_info', 'require', '请选择地址'],
        ['daddress_detail', 'require', '详细地址不能为空'],
    ];

    protected $scene = [
        'address_add' => ['seller_name', 'area_id', 'city_id', 'area_info', 'daddress_detail', 'daddress_telphone'],
    ];
}