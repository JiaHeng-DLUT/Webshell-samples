<?php

namespace app\common\validate;


use think\Validate;

class Complain extends Validate
{
    protected $rule = [
        ['final_handle_message','require|max:255|min:1','处理意见不能为空|必须小于255个字符|必须大于1个字符'],
        ['complain_subject_content','require|max:50|min:1','投诉主题不能为空|必须小于50个字符|必须大于1个字符'],
        ['complain_subject_desc','require|max:50|min:1','投诉主题描述不能为空|必须小于50个字符|必须大于1个字符'],
    ];

    protected $scene = [
        'complain_close' => ['final_handle_message'],
        'complain_subject_add' => ['complain_subject_content','complain_subject_desc'],
    ];
}