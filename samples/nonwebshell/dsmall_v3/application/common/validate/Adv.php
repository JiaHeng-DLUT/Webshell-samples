<?php

namespace app\common\validate;


use think\Validate;

class Adv extends Validate
{
    protected $rule = [
        ['ap_name', 'require', '广告位名称不能为空'],
        ['ap_width', 'require', '广告位宽度只能为数字形式'],
        ['ap_height', 'require', '广告位高度只能为数字形式'],
        ['adv_title', 'require', '名称不能为空'],
        ['ap_id', 'require', '必须选择一个广告位'],
        ['adv_startdate', 'require','必须选择开始时间'],
        ['adv_enddate', 'require', '必须选择结束时间']
    ];

    protected $scene = [
        'ap_add' => ['ap_name', 'ap_width', 'ap_height'],
        'ap_edit' => ['ap_name', 'ap_width', 'ap_height'],
        'adv_add' => ['adv_title', 'ap_id', 'adv_startdate', 'adv_enddate'],
        'adv_edit' => ['adv_title', 'adv_startdate', 'adv_enddate'],
        'app_ap_add' => ['ap_name', 'ap_width', 'ap_height'],
        'app_ap_edit' => ['ap_name', 'ap_width', 'ap_height'],
        'app_adv_add' => ['adv_title', 'ap_id', 'adv_startdate', 'adv_enddate'],
        'app_adv_edit' => ['adv_title', 'adv_startdate', 'adv_enddate'],
    ];
}