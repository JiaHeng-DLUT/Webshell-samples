<?php

namespace app\common\model;

use think\Model;

class Storemsgtpl extends Model {
    

    /**
     * 店铺消息模板列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $order 排序
     * @return array 
     */
    public function getStoremsgtplList($condition, $field = '*',  $order = 'storemt_code asc') {
        return db('storemsgtpl')->field($field)->where($condition)->order($order)->select();
    }

    /**
     * 店铺消息模板详细信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return array 
     */
    public function getStoremsgtplInfo($condition, $field = '*') {
        return db('storemsgtpl')->field($field)->where($condition)->find();
    }

    /**
     * 编辑店铺消息模板
     * @access public
     * @author csdeshang
     * @param arrat $condition 条件
     * @param array $update 更新数据
     * @return array 
     */
    public function editStoremsgtpl($condition, $update) {
        return db('storemsgtpl')->where($condition)->update($update);
    }
    
}
?>
