<?php

namespace app\common\model;

use think\Model;

define('DELIVERY_ORDER_DEFAULT', 10);   // 未到站
define('DELIVERY_ORDER_ARRIVE', 20);   // 已到站
define('DELIVERY_ORDER_PICKUP', 30);   // 已提取

class Deliveryorder extends Model {

    public $page_info;
    private $order_state = array(
        DELIVERY_ORDER_DEFAULT => '未到站',
        DELIVERY_ORDER_ARRIVE => '已到站',
        DELIVERY_ORDER_PICKUP => '已提取'
    );

    /**
     * 取单条订单信息
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param str $fields 字段
     * @return type
     */
    public function getDeliveryorderInfo($condition = array(), $fields = '*') {
        return db('deliveryorder')->field($fields)->where($condition)->find();
    }

    /**
     * 插入订单支付表信息
     * @access public
     * @author csdeshang 
     * @param array $data 参数内容
     * @return type
     */
    public function addDeliveryorder($data) {
        return db('deliveryorder')->insert($data);
    }

    /**
     * 更改信息
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @param array $condition 条件
     * @return type
     */
    public function editDeliveryorder($data, $condition) {
        return db('deliveryorder')->where($condition)->update($data);
    }

  
    /**
     * 更改信息(包裹到达自提服务站)
     * @access public
     * @author csdeshang 
     * @param array $data
     * @param array $condition 条件
     * @return bool
     */
    public function editDeliveryorderArrive($data, $condition) {
        $data['dlyo_state'] = DELIVERY_ORDER_ARRIVE;
        return $this->editDeliveryorder($data, $condition);
    }

    /**
     * 更改信息（买家从物流自提服务张取走包裹）
     * @access public
     * @author csdeshang 
     * @param array $data 更新数据
     * @param array $condition 条件
     * @return bool
     */
    public function editDeliveryorderPickup($data, $condition) {
        $data['dlyo_state'] = DELIVERY_ORDER_PICKUP;
        return $this->editDeliveryorder($data, $condition);
    }

    /**
     * 取订单列表信息
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param string $fields 字段
     * @param number $page 分页信息
     * @param string $order 排序
     * @param int $limit 数目限制
     * @return array
     */
    public function getDeliveryorderList($condition = array(), $fields = '*', $page = 0, $order = 'order_id desc', $limit = '') {
        if ($page) {
            $res = db('deliveryorder')->field($fields)->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        } else {
            return db('deliveryorder')->field($fields)->where($condition)->order($order)->limit($limit)->select();
        }
    }

    /**
     * 取未到站订单列表
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param string $fields 字段
     * @param number $page 分页信息
     * @param string $order 排序
     * @param int $limit 数目限制
     * @return array
     */
    public function getDeliveryorderDefaultList($condition = array(), $fields = '*', $page = 0, $order = 'order_id desc', $limit = '') {
        $condition['dlyo_state'] = DELIVERY_ORDER_DEFAULT;
        return $this->getDeliveryorderList($condition, $fields, $page, $order, $limit);
    }

    /**
     * 取未到站/已到站订单列表
     * @access public
     * @author csdeshang
     * @param unknown $condition 检索条件
     * @param string $fields 字段
     * @param number $page 分页信息
     * @param string $order 排序
     * @param int $limit 数目限制
     * @return array
     */
    public function getDeliveryorderDefaultAndArriveList($condition = array(), $fields = '*', $page = 0, $order = 'order_id desc', $limit = '') {
        $condition['dlyo_state'] = array('neq', DELIVERY_ORDER_PICKUP);
        return $this->getDeliveryorderList($condition, $fields, $page, $order, $limit);
    }

    /**
     * 取订单状态
     * @access public
     * @author csdeshang  
     * @return type
     */
    public function getDeliveryorderState() {
        return $this->order_state;
    }

    /**
     * 删除
     * @access public
     * @author csdeshang 
     * @param array $condition 条件
     * @return type
     */
    public function delDeliveryorder($condition) {
        return db('deliveryorder')->where($condition)->delete();
    }

}
