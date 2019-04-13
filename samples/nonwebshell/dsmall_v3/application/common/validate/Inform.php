<?php

namespace app\common\validate;


use think\Validate;

class Inform extends Validate
{
    protected $rule=[
        ['informtype_name','require|max:50|min:1','举报类型不能为空且不能大于50个字符'],
        ['informtype_desc','require|max:50|min:1','举报类型描述不能为空且不能大于100个字符'],
        ['informsubject_type_name','require|min:1|max:50','举报主题不能为空且不能大于50个字符'],
        ['informsubject_content','require|min:1|max:50','举报内容不能为空且不能大于50个字符'],
        ['informsubject_type_id','require|min:1|max:50','举报ID不能为空且不能大于50个字符'],
        ['inform_handle_message','require|max:100|min:1','处理信息不能为空且不能大于100个字符'],
        ['inform_content', 'require|max:100|min:1', '举报内容不能为空且不能大于100个字符'],
    ];

    protected $scene = [
        'inform_subject_type_save' => ['informtype_name', 'informtype_desc'],
        'inform_subject_save' => ['informsubject_type_name', 'informsubject_content', 'informsubject_type_id'],
        'inform_handle' => ['inform_handle_message'],
        'inform_save' => ['inform_content', 'informsubject_content'],
    ];
}