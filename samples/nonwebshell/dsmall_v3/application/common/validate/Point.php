<?php

namespace app\common\validate;


use think\Validate;

class Point extends Validate
{
    protected $rule = [
        ['member_name', 'require', '会员信息错误，请重新填写会员名'],
        ['points_num', 'number|min:1', '积分值必须为数字|积分值必须大于0'],
        ['goodsname', 'require', '请添加礼品名称'],
        ['goodsprice', 'require', '礼品原价必须为数字且大于等于0'],
        ['goodspoints', 'require|number', '兑换积分为整数且大于等于0'],
        ['goodsserial', 'require', '请添加礼品编号'],
        ['goodsstorage', 'require|number', '礼品库存必须为整数且大于等于0'],
        ['sort', 'require|number', '礼品排序为整数且大于等于0'],
        ['limitnum', 'checkPointLimitnum:1', '礼品排序为整数且大于等于0'],
        ['starttime', 'checkPointStartTime:1', '请添加开始时间'],
        ['endtime', 'checkPointEndTime:1', '请添加结束时间'],
        ['shippingcode', 'require', '请添加物流单号']
    ];

    protected $scene = [
        'pointslog' => ['member_name', 'points_num'],
        'prod_add' => ['goodsname', 'goodsprice', 'goodspoints', 'goodsserial', 'goodsstorage', 'sort', 'limitnum', 'starttime', 'endtime'],
        'prod_edit' => ['goodsname', 'goodsprice', 'goodspoints', 'goodsserial', 'goodsstorage', 'sort', 'limitnum', 'starttime', 'endtime'],
        'order_ship' => ['shippingcode'],
    ];

    protected function checkPointLimitnum($value)
    {
        if (input('post.sort') == 1 && !is_numeric($value)) {
            return '礼品排序为整数且大于等于0';
        }
        return true;
    }

    protected function checkPointStartTime($value)
    {
        if (input('post.islimittime')) {
            if (empty($value)) {
                return '请添加开始时间';
            }
        }
        return true;
    }

    protected function checkPointEndTime($value)
    {
        if (input('post.islimittime')) {
            if (empty($value)) {
                return '请添加结束时间';
            }
        }
        return true;
    }
}