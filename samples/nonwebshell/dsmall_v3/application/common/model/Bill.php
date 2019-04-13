<?php

namespace app\common\model;

use think\Model;

//以下是定义结算单状态
//默认
define('BILL_STATE_CREATE', 1);
//店铺已确认
define('BILL_STATE_STORE_COFIRM', 2);
//平台已审核
define('BILL_STATE_SYSTEM_CHECK', 3);
//结算完成
define('BILL_STATE_SUCCESS', 4);

class Bill extends Model {
    public $page_info;

    /**
     * 取得平台月结算单
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param str $fields 字段
     * @param int $pagesize 分页信息
     * @param str $order 排序
     * @param int $limit 数量限制
     * @return array
     */
    public function getOrderstatisList($condition = array(), $fields = '*', $pagesize = null, $order = '', $limit = '') {
        if($pagesize){
            $result = db('orderstatis')->where($condition)->field($fields)->order($order)->paginate($pagesize,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        }else{
            return db('orderstatis')->where($condition)->field($fields)->order($order)->limit($limit)->select();
        }
    }

    /**
     * 取得平台月结算单条信息
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param string $fields 字段
     * @param string $order 排序
     * @return array
     */
    public function getOrderstatisInfo($condition = array(), $fields = '*', $order = null) {
        return db('orderstatis')->where($condition)->field($fields)->order($order)->find();
    }
    
    /**
     * 取得店铺月结算单列表
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param str $fields 字段
     * @param int $pagesize 分页信息
     * @param str $order 排序
     * @param int $limit 数量限制
     * @return array
     */
    public function getOrderbillList($condition = array(), $fields = '*', $pagesize = null, $order = '', $limit = null) {
        if($pagesize){
            $result = db('orderbill')->where($condition)->field($fields)->order($order)->paginate($pagesize,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        }else{
            return db('orderbill')->where($condition)->field($fields)->order($order)->limit($limit)->select();
        }
        
        
    }

    /**
     * 取得店铺月结算单单条
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @param string $fields 字段
     * @return array
     */
    public function getOrderbillInfo($condition = array(), $fields = '*') {
        return db('orderbill')->where($condition)->field($fields)->find();
    }


    /**
     * 取得订单数量
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @return int
     */
    public function getOrderbillCount($condition) {
        return db('orderbill')->where($condition)->count();
    }

    /**
     * 取得平台月结算单数量
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @return int
     */
    public function getOrderstatisCount($condition) {
        return db('orderstatis')->where($condition)->count();
    }

    /**
     * 添加订单统计
     * @access public
     * @author csdeshang 
     * @param type $data 参数内容
     * @return type
     */
    public function addOrderstatis($data) {
        return db('orderstatis')->insert($data);
    }
    /**
     * 添加订单账单
     * @access public
     * @author csdeshang  
     * @param array $data 参数数据
     * @return type
     */
    public function addOrderbill($data) {
        return db('orderbill')->insertGetId($data);
    }
    
    /**
     * 编辑订单账单
     * @access public
     * @author csdeshang 
     * @param array $data 更新数据
     * @param array $condition 条件
     * @return bool
     */
    public function editOrderbill($data, $condition = array()) {
        return db('orderbill')->where($condition)->update($data);
    }

}

?>
