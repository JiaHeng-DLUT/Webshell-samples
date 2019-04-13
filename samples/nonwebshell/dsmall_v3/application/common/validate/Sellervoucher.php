<?php

namespace app\common\validate;


use think\Validate;

class Sellervoucher extends Validate
{
    protected $rule = [
        ['txt_template_title', 'require|length:1,50', '模版名称不能为空且不能大于50个字符'],
        ['txt_template_total', 'require|number', '可发放数量不能为空且必须为整数'],
        ['select_template_price', 'require|number','模版面额不能为空且必须为整数，且面额不能大于限额'],
        ['txt_template_limit', 'require', '模版使用消费限额不能为空且必须是数字'],
        ['txt_template_describe', 'require|length:1,255', '模版描述不能为空且不能大于255个字符']
    ];

    protected $scene = [
        'templateadd' => ['txt_template_title', 'txt_template_total', 'select_template_price', 'txt_template_limit', 'txt_template_describe'],
        'templateedit' => ['txt_template_title', 'txt_template_total', 'select_template_price', 'txt_template_limit', 'txt_template_describe'],
    ];
}