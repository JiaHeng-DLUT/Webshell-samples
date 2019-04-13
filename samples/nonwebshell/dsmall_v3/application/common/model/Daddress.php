<?php


namespace app\common\model;

use think\Model;

class Daddress extends Model
{
    


    /**
     * 新增
     * @access public
     * @author csdeshang 
     * @param type $data 数据
     * @return type
     */
    public function addDaddress($data) {
        return db('daddress')->insertGetId($data);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang 
     * @param type $condition 条件
     * @return type
     */
    public function delDaddress($condition) {
        return db('daddress')->where($condition)->delete();
    }
    /**
     * 编辑更新
     * @access public
     * @author csdeshang 
     * @param type $data 更新数据
     * @param type $condition 条件
     * @return type
     */
    public function editDaddress($data, $condition) {
        return db('daddress')->where($condition)->update($data);
    }


    /**
     * 查询单条
     * @access public
     * @author csdeshang 
     * @param type $condition 检索条件
     * @param type $fields 字段
     * @return type
     */
    public function getAddressInfo($condition, $fields = '*') {
        return db('daddress')->field($fields)->where($condition)->find();
    }

    /**
     * 查询多条
     * @access public
     * @author csdeshang 
     * @param type $condition 条件
     * @param type $fields 字段
     * @param type $order 排序
     * @param type $limit 限制
     * @return type
     */
    public function getAddressList($condition, $fields = '*', $order = '', $limit = '') {
        return db('daddress')->field($fields)->where($condition)->order($order)->limit($limit)->select();
    }
    
}
