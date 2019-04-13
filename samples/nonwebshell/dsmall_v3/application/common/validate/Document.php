<?php

namespace app\common\validate;


use think\Validate;

class Document extends Validate
{
    protected $rule = [
        ['document_title', 'require','文章标题不能为空'],
        ['document_content', 'require', '文章内容不能为空']
    ];

    protected $scene = [
        'edit' => ['document_title', 'document_content'],
    ];
}