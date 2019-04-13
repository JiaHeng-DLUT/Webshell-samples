<?php

namespace app\common\model;

use think\Model;

class Membermsgtpl extends Model {
    
  
    /**
     * 用户消息模板列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @param int $order 排序
     * @return array
     */
    public function getMembermsgtplList($condition, $field = '*', $order = 'membermt_code asc') {
        return db('membermsgtpl')->field($field)->where($condition)->order($order)->select();
    }
    
    /**
     * 用户消息模板详细信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     */
    public function getMembermsgtplInfo($condition, $field = '*') {
        return db('membermsgtpl')->field($field)->where($condition)->find();
    }
    
    /**
     * 编辑用户消息模板
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param unknown $update 更新数据
     * @return bool
     */
    public function editMembermsgtpl($condition, $update) {
        return db('membermsgtpl')->where($condition)->update($update);
    }
    
    
}
?>
