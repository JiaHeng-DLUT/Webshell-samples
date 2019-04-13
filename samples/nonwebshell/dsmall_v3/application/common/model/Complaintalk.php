<?php

namespace app\common\model;

use think\Model;

class Complaintalk extends Model {

    /**
     * 增加
     * @access public
     * @author csdeshang 
     * @param array $data 参数内容
     * @return bool
     */
    public function addComplaintalk($data) {
        return db('complaintalk')->insertGetId($data);
    }

    /**
     * 更新
     * @access public
     * @author csdeshang 
     * @param array $update_array 更新数据
     * @param array $condition 更新条件
     * @return bool
     */
    public function editComplaintalk($update_array, $condition) {
        return db('complaintalk')->where($condition)->update($update_array);
    }

    /**
     * 删除投诉用语
     * @access public
     * @author csdeshang  
     * @param array $condition 检索条件
     * @return bool
     */
    public function delComplaintalk($condition) {
        return db('complaintalk')->where($condition)->delete();
    }

    /**
     * 获得列表
     * @param array $condition 检索条件
     * @param str $field 字段
     * @param str $order 排序
     * @return array
     */
    public function getComplaintalkList($condition = '', $field = '*',$order='talk_id desc ') {
        return db('complaintalk')->where($condition)->field($field)->order($order)->select();
    }

}