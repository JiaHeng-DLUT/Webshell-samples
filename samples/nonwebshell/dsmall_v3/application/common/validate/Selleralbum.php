<?php

namespace app\common\validate;


use think\Validate;

class Selleralbum extends Validate
{
    protected $rule = [
        ['aclass_name', 'require', '相册名称必填'],
        ['aclass_des', 'require', '相册描述必填'],
        ['aclass_sort', 'require', '相册排序必填']
    ];

    protected $scene = [
        'album_add_save' => ['aclass_name','aclass_des','aclass_sort'],
        'album_edit_save' => ['aclass_name','aclass_des','aclass_sort']
    ];
}