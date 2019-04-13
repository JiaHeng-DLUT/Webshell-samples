<?php

namespace app\common\model;


use think\Model;

class Storesnssetting extends Model
{
    /**
     * 获取单条动态设置设置信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getStoresnssettingInfo($condition, $field = '*')
    {
        return db('storesnssetting')->field($field)->where($condition)->find();
    }

    /**
     * 保存店铺动态设置
     * @access public
     * @author csdeshang
     * @param array $data 参数数据
     * @return boolean
     */
    public function addStoresnssetting($data)
    {
        return db('storesnssetting')->insert($data);
    }
}