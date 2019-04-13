<?php

namespace app\common\model;


use think\Model;

class Consulttype extends Model
{
    /**
     * 咨询类型列表
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @param string $field 字段
     * @param string $order 排序
     * @return array
     */
    public function getConsulttypeList($condition, $field = '*', $order = 'consulttype_sort asc,consulttype_id desc')
    {
        return db('consulttype')->where($condition)->field($field)->order($order)->select();
    }

    /**
     * 单条咨询类型
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @param string $field 字段
     * @return array
     */
    public function getConsulttypeInfo($condition, $field = '*')
    {
        return db('consulttype')->where($condition)->field($field)->find();
    }

    /**
     * 添加咨询类型
     * @access public
     * @author csdeshang 
     * @param array $data 参数内容
     * @return bool
     */
    public function addConsulttype($data)
    {
        return db('consulttype')->insertGetId($data);
    }

    /**
     * 编辑咨询类型
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param array $update 更新数据
     * @return boolean
     */
    public function editConsulttype($condition, $update)
    {
        return db('consulttype')->where($condition)->update($update);
    }

    /**
     * 删除咨询类型
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function delConsulttype($condition)
    {
        return db('consulttype')->where($condition)->delete();
    }
}