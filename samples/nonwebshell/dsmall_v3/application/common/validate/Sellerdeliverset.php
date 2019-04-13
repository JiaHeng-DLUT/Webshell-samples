<?php

namespace app\common\validate;


use think\Validate;

class Sellerdeliverset extends Validate
{
    protected $rule = [
        ['seller_name', 'require', '联系人必填'],
        ['daddress_detail', 'require', '地址必填'],
        ['daddress_telphone', 'require', '电话必填'],
        ['seal_printexplain', 'require|length:1,200','说明不能为空|长度在1-200之间']
    ];

    protected $scene = [
        'daddress_add' => ['seller_name', 'daddress_detail', 'daddress_telphone'],
        'print_set' => ['seal_printexplain'],
    ];
}