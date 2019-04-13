<?php
namespace app\common\model;
use think\Model;

class Goodsfcode extends Model
{
    /**
     * 插入数据
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return boolean
     */
    public function addGoodsfcodeAll($data) {
        return db('goodsfcode')->insertAll($data);
    }

    /**
     * 取得F码列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $order 排序
     * @return type
     */
    public function getGoodsfcodeList($condition, $order = 'goodsfcode_state asc,goodsfcode_id asc') {
        return db('goodsfcode')->where($condition)->order($order)->select();
    }

    /**
     * 删除F码
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return bool
     */
    public function delGoodsfcode($condition) {
        return db('goodsfcode')->where($condition)->delete();
    }

    /**
     * 取得F码
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return bool
     */
    public function getGoodsfcode($condition) {
        return db('goodsfcode')->where($condition)->find();
    }

    /**
     * 更新F码
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @param array $condition 条件
     * @return bool
     */
    public function editGoodsfcode($data, $condition) {
        return db('goodsfcode')->where($condition)->update($data);
    }
}