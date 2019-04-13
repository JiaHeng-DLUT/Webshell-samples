<?php

namespace app\common\validate;


use think\Validate;

class Wechat extends Validate
{
    protected $rule = [
        ['name', 'require', '菜单名称不能为空'],
        ['sort', 'number','排序只能为数字'],
        ['type', 'require', '类型不能为空'],
        ['value', 'checkValue:1', 'URL地址错误']
    ];

    protected $scene = [
        'menu_add' => ['name', 'sort', 'type', 'value'],
        'menu_edit' => ['name', 'sort', 'type', 'value'],
    ];

    protected function checkValue($value){
        if(input('post.menu_type') == 'view'){
            if (empty($value)){
                return 'URL地址格式不能为空';
            }
            if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$value)) {
                return "URL地址格式不正确";
            }
        }
        return true;
    }
}