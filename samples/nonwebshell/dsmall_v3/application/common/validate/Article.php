<?php

namespace app\common\validate;

use think\Validate;

class Article extends Validate
{
    protected $rule = [
        ['article_sort', 'number', '排序只能为数字'],
        ['article_title', 'require', '标题名称不能为空'],
        ['ac_name', 'require', '分类名称不能为空'],
        ['ac_sort', 'number', '分类排序仅能为数字']
    ];

    protected $scene = [
        'add' => ['article_sort', 'article_title'],
        'edit' => ['article_sort', 'article_title'],
        'article_class_add' => ['ac_name', 'ac_sort'],
        'article_class_edit' => ['ac_name', 'ac_sort'],
    ];
}