<?php

namespace app\common\validate;

use think\Validate;

class Member extends Validate
{
    protected $rule = [
        ['member_name', 'require|length:3,12', '用户名必填|用户名长度在3到12位'],
        ['member_password', 'require|length:6,20', '密码为必填|密码长度必须为6-20之间'],
        ['member_email', 'email', '邮箱格式错误'],
        ['member_mobile', 'length:11,11', '手机格式错误'],
        ['member_nickname', 'max:10', '真实姓名长度超过10位'],
    ];
    protected $scene = [
        'add' => ['member_name', 'member_password', 'member_email'],
        'edit' => ['member_email', 'member_mobile', 'member_email'],
        'edit_information' => ['member_nickname'],
        'login' => ['member_name', 'member_password'],
        'register' => ['member_name', 'member_password'],
    ];
}