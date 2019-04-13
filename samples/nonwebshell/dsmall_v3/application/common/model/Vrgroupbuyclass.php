<?php

namespace app\common\model;


use think\Model;

class Vrgroupbuyclass extends Model
{
    /**
     * 线下分类信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getVrgroupbuyclassInfo($condition, $field = '*')
    {
        return db('vrgroupbuyclass')->field($field)->where($condition)->find();
    }

    /**
     * 线下分类列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param str $field 字段
     * @param str $order 排序
     * @param int $limit 限制
     * @return array
     */
    public function getVrgroupbuyclassList($condition = array(), $field = '*', $order = 'vrgclass_sort', $limit = '0,1000')
    {
        return db('vrgroupbuyclass')->where($condition)->order($order)->limit($limit)->select();
    }

    /**
     * 添加线下分类
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @return type
     */
    public function addVrgroupbuyclass($data)
    {
        return db('vrgroupbuyclass')->insertGetId($data);
    }

    /**
     * 编辑线下分类
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $data 更新数据
     * @return type
     */
    public function editVrgroupbuyclass($condition, $data)
    {
        return db('vrgroupbuyclass')->where($condition)->update($data);
    }

    /**
     * 删除线下分类
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return bool
     */
    public function delVrgroupbuyclass($condition)
    {
        return db('vrgroupbuyclass')->where($condition)->delete();
    }
}