<?php

namespace app\common\validate;


use think\Validate;

class Sellerplate extends Validate
{
    protected $rule = [
        ['storeplate_name', 'require', '请填写版式名称'],
        ['storeplate_content', 'require', '请填写版式内容'],
    ];

    protected $scene = [
        'plate_add' => ['storeplate_name', 'storeplate_content'],
        'plate_edit' => ['storeplate_name', 'storeplate_content'],
    ];
}