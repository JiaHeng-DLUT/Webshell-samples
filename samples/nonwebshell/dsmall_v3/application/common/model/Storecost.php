<?php

namespace app\common\model;

use think\Model;

class Storecost extends Model {
    public  $page_info;
 
    /**
     * 读取列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param int $page 分页
     * @param string $order 排序
     * @param string $field 字段
     * @return array
     */
    public function getStorecostList($condition, $page = '', $order = '', $field = '*') {
        if($page){
            $result = db('storecost')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        }else{
            $result = db('storecost')->field($field)->where($condition)->order($order)->select();
            return $result;
        }
    }

    /**
     * 读取单条记录
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $fields 字段
     * @return array
     */
    public function getStorecostInfo($condition, $fields = '*') {
        $result = db('storecost')->where($condition)->field($fields)->find();
        return $result;
    }

    /**
     * 增加 
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @return bool
     */
    public function addStorecost($data) {
        return db('storecost')->insertGetId($data);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delStorecost($condition) {
        return db('storecost')->where($condition)->delete();
    }

    /**
     * 更新
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @param array $condition 条件
     * @return bool
     */
    public function editStorecost($data, $condition) {
        return db('storecost')->where($condition)->update($data);
    }

}

?>
