<?php

namespace app\common\model;

use think\Model;

class Storereopen extends Model {
    public $page_info;
 
    /**
     * 取得列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param int $pagesize 分页
     * @param string $order 排序
     * @return array
     */
    public function getStorereopenList($condition = array(), $pagesize = '', $order = 'storereopen_id desc') {
        if($pagesize){
            $result =  db('storereopen')->where($condition)->order($order)->paginate($pagesize,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        }else{
            return db('storereopen')->where($condition)->order($order)->select();
        }
        
    }

    /**
     * 增加新记录
     * @access public
     * @author csdeshang
     * @param arrat $data 参数内容
     * @return bool
     */
    public function addStorereopen($data) {
        return db('storereopen')->insertGetId($data);
    }

    /**
     * 取单条信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getStorereopenInfo($condition) {
        return db('storereopen')->where($condition)->find();
    }

    /**更新记录
     * @access public
     * @author csdeshang
     * @param type $data 更新数据
     * @param type $condition 条件
     * @return type
     */
    public function editStorereopen($data, $condition) {
        return db('storereopen')->where($condition)->update($data);
    }

    /**
     * 取得数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getStorereopenCount($condition) {
        return db('storereopen')->where($condition)->count();
    }

    /**
     * 删除记录
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delStorereopen($condition) {
        return db('storereopen')->where($condition)->delete();
    }

}

?>
