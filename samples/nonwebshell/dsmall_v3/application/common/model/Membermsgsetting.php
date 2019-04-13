<?php

namespace app\common\model;


use think\Model;

class Membermsgsetting extends Model
{
    public $page_info;
    /**
     * 用户消息模板列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @param number $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getMembermsgsettingList($condition, $field = '*', $page = 0, $order = 'membermt_code asc') {
       $result= db('membermsgsetting')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
       $this->page_info=$result;
       return $result->items();
    }

    /**
     * 用户消息模板详细信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array
     */
    public function getMembermsgsettingInfo($condition, $field = '*') {
        return db('membermsgsetting')->field($field)->where($condition)->find();
    }

  
    /**
     * 编辑用户消息模板
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @return type
     */
    public function addMembermsgsettingAll($data) {
        return db('membermsgsetting')->insertAll($data);
    }
}