<?php

namespace app\common\validate;


use think\Validate;

class Activity extends Validate
{
    protected $rule = [
        ['activity_title', 'require', '活动标题不能为空'],
        ['activity_startdate', 'require', '开始时间不能为空'],
        ['activity_enddate', 'require|checkEnddate:1', '结束时间不能为空'],
        ['activity_style', 'require', '必须选择活动类别'],
        ['activity_type', 'require', '必须选择活动类别'],
        ['activity_banner', 'require', '横幅图片不能为空'],
        ['activity_sort', 'require', '排序为0~255的数字']
    ];

    protected $scene = [
        'add' => ['activity_title', 'activity_startdate', 'activity_enddate', 'activity_style', 'activity_type', 'activity_banner', 'activity_sort'],
        'edit' => ['activity_title', 'activity_startdate', 'activity_enddate', 'activity_style', 'activity_type', 'activity_sort'],
    ];

    protected function checkEnddate($value)
    {
        $activity_startdate = strtotime(input('post.activity_startdate'));
        if ($activity_startdate >= $value){
            return '结束时间早于开始时间或相同时间';
        }
        return true;
    }
}