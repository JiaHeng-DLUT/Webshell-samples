<?php

namespace app\common\validate;


use think\Validate;

class Storesnshome extends Validate
{
    protected $rule = [
        ['commentcontent', 'require|length:0,140', '需要评论点内容|不能超过140字'],
        ['forwardcontent', 'require|length:0,140', '需要评论点内容|不能超过140字'],
    ];

    protected $scene = [
        'addcomment' => ['commentcontent'],
        'addforward' => ['forwardcontent'],
    ];
}