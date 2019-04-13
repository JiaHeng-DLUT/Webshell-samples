<?php

namespace app\common\model;
use think\Model;
use think\Db;
class Refundreturn extends Model {

    public $page_info;



    /**
     * 增加退款退货
     * @access public
     * @author csdeshang
     * @param type $refund_array 退款数组
     * @param type $order 排序
     * @param type $goods 商品数组
     * @return type
     */
    public function addRefundreturn($refund_array, $order = array(), $goods = array()) {
        if (!empty($order) && is_array($order)) {
            $refund_array['order_id'] = $order['order_id'];
            $refund_array['order_sn'] = $order['order_sn'];
            $refund_array['store_id'] = $order['store_id'];
            $refund_array['store_name'] = $order['store_name'];
            $refund_array['buyer_id'] = $order['buyer_id'];
            $refund_array['buyer_name'] = $order['buyer_name'];
        }
        if (!empty($goods) && is_array($goods)) {
            $refund_array['goods_id'] = $goods['goods_id'];
            $refund_array['order_goods_id'] = $goods['rec_id'];
            $refund_array['order_goods_type'] = $goods['goods_type'];
            $refund_array['goods_name'] = $goods['goods_name'];
            $refund_array['commis_rate'] = $goods['commis_rate'];
            $refund_array['goods_image'] = $goods['goods_image'];
        }
        $refund_array['refund_sn'] = $this->getRefundsn($refund_array['store_id']);
        $refund_id = db('refundreturn')->insertGetId($refund_array);

        // 发送商家提醒
        $message = array();
        if (intval($refund_array['refund_type']) == 1) {    // 退款
            $message['code'] = 'refund';
        } else {    // 退货
            $message['code'] = 'return';
        }
        $message['store_id'] = $order['store_id'];
        $type = $refund_array['order_lock'] == 2 ? '售前' : '售后';
        $message['param'] = array(
            'type' => $type,
            'refund_sn' => $refund_array['refund_sn']
        );
        \mall\queue\QueueClient::push('sendStoremsg', $message);
        return $refund_id;
    }

    /**
     * 订单锁定
     * @access public
     * @author csdeshang
     * @param type $order_id 订单编号
     * @return boolean
     */
    public function editOrderLock($order_id) {
        $order_id = intval($order_id);
        if ($order_id > 0) {
            $condition = array();
            $condition['order_id'] = $order_id;
            $data = array();
            $data['lock_state'] = Db::raw('lock_state+1');
            $order_model = model('order');
            $result = $order_model->editOrder($data, $condition);
            return $result;
        }
        return false;
    }

    /**
     * 订单解锁
     * @access public
     * @author csdeshang
     * @param type $order_id 订单编号
     * @return boolean
     */
    public function editOrderUnlock($order_id) {
        $order_id = intval($order_id);
        if ($order_id > 0) {
            $condition = array();
            $condition['order_id'] = $order_id;
            $condition['lock_state'] = array('egt', '1');
            $data = array();
            $data['lock_state'] = Db::raw('lock_state-1');
            $data['delay_time'] = time();
            $order_model = model('order');
            $result = $order_model->editOrder($data, $condition);
            return $result;
        }
        return false;
    }

    /**
     * 
     * 修改记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $data 数据
     * @return boolean
     */
    public function editRefundreturn($condition, $data) {
        if (empty($condition)) {
            return false;
        }
        if (is_array($data)) {
            $result = db('refundreturn')->where($condition)->update($data);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 平台确认退款处理
     * @access public
     * @author csdeshang
     * @param type $refund 退款
     * @return boolean
     */
    public function editOrderRefund($refund) {
        $refund_id = intval($refund['refund_id']);
        if ($refund_id > 0) {
            lang('model_lang_index');
            $order_id = $refund['order_id']; //订单编号
            $field = 'order_id,buyer_id,buyer_name,store_id,order_sn,order_amount,payment_code,order_state,refund_amount,rcb_amount';
            $order_model = model('order');
            $order = $order_model->getOrderInfo(array('order_id' => $order_id), array(), $field);

            $predeposit_model = model('predeposit');
            try {
                $this->startTrans();
                $order_amount = $order['order_amount']; //订单金额
                $rcb_amount = $order['rcb_amount']; //充值卡支付金额
                $predeposit_amount = $order_amount - $order['refund_amount'] - $rcb_amount; //可退预存款金额
                $state = 1;
                if (($rcb_amount > 0) && ($refund['refund_amount'] > $predeposit_amount)) {//退充值卡
                    $log_array = array();
                    $log_array['member_id'] = $order['buyer_id'];
                    $log_array['member_name'] = $order['buyer_name'];
                    $log_array['order_sn'] = $order['order_sn'];
                    $log_array['amount'] = $refund['refund_amount'];
                    if ($predeposit_amount > 0) {
                        $log_array['amount'] = $refund['refund_amount'] - $predeposit_amount;
                    }
                    $state = $predeposit_model->changeRcb('refund', $log_array); //增加买家可用充值卡金额
                }
                if ($predeposit_amount > 0) {//退预存款
                    $log_array = array();
                    $log_array['member_id'] = $order['buyer_id'];
                    $log_array['member_name'] = $order['buyer_name'];
                    $log_array['order_sn'] = $order['order_sn'];
                    $log_array['amount'] = $refund['refund_amount']; //退预存款金额
                    if ($refund['refund_amount'] > $predeposit_amount) {
                        $log_array['amount'] = $predeposit_amount;
                    }
                    $state = $predeposit_model->changePd('refund', $log_array); //增加买家可用预存款金额
                }

                /*
                $order_state = $order['order_state'];
                $trade_model = model('trade');
                $order_paid = $trade_model->getOrderState('order_paid'); //订单状态20:已付款
                //订单中商品的数量
                $order_goods_count=db('ordergoods')->where('order_id',$order['order_id'])->count();
                //订单中退款商品的数量
                $refund_goods_count=db('refundreturn')->where('order_id',$order['order_id'])->count();
                if ($state && $order_state >= $order_paid) {
                    if(($refund_goods_count>=$order_goods_count && $order_state>$trade_model->getOrderState('order_paid')) || $order_state==$trade_model->getOrderState('order_paid')){
                        $order_logic = model('order','logic');
                        $order_logic->changeOrderStateCancel($order, 'system', '系统', '商品全部退款完成取消订单', false);
                    }
                }
                 */
                
                //同意退款之后,订单状态自动设置为已完成 , 因为涉及到月结算  成交的金额减去退款的金额, 交易成功后,买家次月产生的其他退款，由再下月进行结算
                if ($state && $order['order_state']!=ORDER_STATE_SUCCESS) {
                    $update_order['order_state']=ORDER_STATE_SUCCESS;
                    $order_model->editOrder($update_order, array('order_id' => $order_id));
                    
                    //添加订单日志
                    $data = array();
                    $data['order_id'] = $order_id;
                    $data['log_role'] = 'system';
                    $data['log_msg'] = '平台审核退款,自动确认收货';
                    $data['log_user'] = '系统';
                    $data['log_orderstate'] = ORDER_STATE_SUCCESS;
                    $order_model->addOrderlog($data);
                }



                if ($state) {
                    $order_array = array();
                    $order_amount = $order['order_amount']; //订单金额
                    $refund_amount = $order['refund_amount'] + $refund['refund_amount']; //退款金额
                    $order_array['refund_state'] = ($order_amount - $refund_amount) > 0 ? 1 : 2;
                    $order_array['refund_amount'] = ds_price_format($refund_amount);
                    $order_array['delay_time'] = time();
                    $state = $order_model->editOrder($order_array, array('order_id' => $order_id)); //更新订单退款
                }
                if ($state && $refund['order_lock'] == '2') {
                    $state = $this->editOrderUnlock($order_id); //订单解锁
                }
                $this->commit();
                return $state;
            } catch (Exception $e) {
                $this->rollback();
                return false;
            }
        }
        return false;
    }

    /**
     * 增加退款退货原因
     * @access public
     * @author csdeshang
     * @param type $reason_array 原因数组
     * @return type
     */
    public function addReason($reason_array) {
        $reason_id = db('refundreason')->insertGetId($reason_array);
        return $reason_id;
    }

    /**
     * 修改退款退货原因记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $data 数据
     * @return boolean
     */
    public function editReason($condition, $data) {
        if (empty($condition)) {
            return false;
        }
        if (is_array($data)) {
            $result = db('refundreason')->where($condition)->update($data);
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 删除退款退货原因记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return boolean
     */
    public function delReason($condition) {
        if (empty($condition)) {
            return false;
        } else {
            $result = db('refundreason')->where($condition)->delete();
            return $result;
        }
    }

    /**
     * 退款退货原因记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $limit 限制
     * @param type $fields 字段
     * @return array
     */
    public function getReasonList($condition = array(), $page = '', $limit = '', $fields = '*') {
        $result_paginate = db('refundreason')->field($fields)->where($condition)->order('reason_sort asc,reason_id desc')->paginate($page,false,['query' => request()->param()]);
        $this->page_info = $result_paginate;
        $result = $result_paginate->items();
        $result = ds_change_arraykey($result, 'reason_id');
        return $result;
    }

    /**
     * 获取退款退货记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $fields 字段
     * @param type $limit 限制
     * @return type
     */
    public function getRefundreturnList($condition = array(), $page = '', $field = '*', $order = 'refund_id desc', $limit = '') {
        if ($page) {
            $result = db('refundreturn')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $result;
            $result = $result->items();
        } else {
            $result = db('refundreturn')->field($field)->where($condition)->order($order)->limit($limit)->select();
        }

        return $result;
    }

    /**
     * 取退款记录列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param type $page 分页
     * @return type
     */

    public function getRefundList($condition = array(), $page = '',$field = '*', $order = 'refund_id desc', $limit = '') {
        $condition['refund_type'] = '1'; //类型:1为退款,2为退货
        $result = $this->getRefundreturnList($condition, $page, $field, $order, $limit);
        return $result;
    }

    /**
     * 取退货记录
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param type $page 分页
     * @return type
     */
    public function getReturnList($condition = array(), $page = '',$field = '*', $order = 'refund_id desc', $limit = '') {
        $condition['refund_type'] = '2'; //类型:1为退款,2为退货
        $result = $this->getRefundreturnList($condition, $page, $field, $order, $limit);
        return $result;
    }

    /**
     * 退款退货申请编号
     * @access public
     * @author csdeshang
     * @param type $store_id 店铺id
     * @return string
     */
    public function getRefundsn($store_id) {
        $result = mt_rand(100, 999) . substr(100 + $store_id, -3) . date('ymdHis');
        return $result;
    }

    /**
     * 取一条记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $fields 字段
     * @return type
     */
    public function getRefundreturnInfo($condition = array(), $fields = '*') {
        return db('refundreturn')->where($condition)->field($fields)->find();
    }

    /**
     * 根据订单取商品的退款退货状态
     * @access public
     * @author csdeshang
     * @param type $order_list 订单列表
     * @param type $order_refund 退款订单
     * @return string
     */
    public function getGoodsRefundList($order_list = array(), $order_refund = 0) {
        $order_ids = array(); //订单编号数组
        $order_ids = array_keys($order_list);
        $trade_model = model('trade');
        $condition = array();
        $condition['order_id'] = array('in', $order_ids);
        $refund_list = db('refundreturn')->where($condition)->order('refund_id desc')->select();
        $refund_goods = array(); //已经提交的退款退货商品
        if (!empty($refund_list) && is_array($refund_list)) {
            foreach ($refund_list as $key => $value) {
                $order_id = $value['order_id']; //订单编号
                $goods_id = $value['order_goods_id']; //订单商品表编号
                if (empty($refund_goods[$order_id][$goods_id])) {
                    $refund_goods[$order_id][$goods_id] = $value;
                    if ($order_refund > 0) {//订单下的退款退货所有记录
                        $order_list[$order_id]['refund_list'] = $refund_goods[$order_id];
                    }
                }
            }
        }
        if (!empty($order_list) && is_array($order_list)) {
            foreach ($order_list as $key => $value) {
                $order_id = $key;
                $goods_list = $value['extend_order_goods']; //订单商品
                $order_state = $value['order_state']; //订单状态
                $order_paid = $trade_model->getOrderState('order_paid'); //订单状态20:已付款
                $payment_code = $value['payment_code']; //支付方式
                if ($order_state == $order_paid && $payment_code != 'offline') {//已付款未发货的非货到付款订单可以申请取消
                    $order_list[$order_id]['refund'] = '1';
                } elseif ($order_state > $order_paid && !empty($goods_list) && is_array($goods_list)) {//已发货后对商品操作
                    $refund = $this->getRefundState($value); //根据订单状态判断是否可以退款退货
                    foreach ($goods_list as $k => $v) {
                        $goods_id = $v['rec_id']; //订单商品表编号
                        if ($v['goods_pay_price'] > 0) {//实际支付额大于0的可以退款
                            $v['refund'] = $refund;
                        }
                        if (!empty($refund_goods[$order_id][$goods_id])) {
                            $seller_state = $refund_goods[$order_id][$goods_id]['seller_state']; //卖家处理状态:1为待审核,2为同意,3为不同意
                            if ($seller_state == 3) {
                                $order_list[$order_id]['extend_complain'][$goods_id] = '1'; //不同意可以发起退款投诉
                            } else {
                                $v['refund'] = '0'; //已经存在处理中或同意的商品不能再操作
                            }
                            $v['extend_refund'] = $refund_goods[$order_id][$goods_id];
                        }elseif(!empty($refund_goods[$order_id][0])){
                            $v['refund'] = '0';
                        }
                        $goods_list[$k] = $v;
                    }
                }
                $order_list[$order_id]['extend_order_goods'] = $goods_list;
            }
        }

        return $order_list;
    }

    /**
     * 根据订单判断投诉订单商品是否可退款
     * @access public
     * @author csdeshang
     * @param type $order 订单
     * @param type $order_goods_id 订单商品id
     * @return type
     */
    public function getComplainRefundList($order, $order_goods_id = 0) {
        $list = array();
        $refund_list = array(); //已退或处理中商品
        $refund_goods = array(); //可退商品
        if (!empty($order) && is_array($order)) {
            $order_id = $order['order_id'];
            $order_list[$order_id] = $order;
            $order_list = $this->getGoodsRefundList($order_list);
            $order = $order_list[$order_id];
            $goods_list = $order['extend_order_goods'];
            $order_amount = $order['order_amount']; //订单金额
            $order_refund_amount = $order['refund_amount']; //订单退款金额
            foreach ($goods_list as $k => $v) {
                $goods_id = $v['rec_id']; //订单商品表编号
                if ($order_goods_id > 0 && $goods_id != $order_goods_id) {
                    continue;
                }
                $v['refund_state'] = 3;
                if (!empty($v['extend_refund'])) {
                    $v['refund_state'] = $v['extend_refund']['seller_state']; //卖家处理状态为3,不同意时能退款
                }
                if ($v['refund_state'] > 2) {//可退商品
                    $goods_pay_price = $v['goods_pay_price']; //商品实际成交价
                    if ($order_amount < ($goods_pay_price + $order_refund_amount)) {
                        $goods_pay_price = $order_amount - $order_refund_amount;
                        $v['goods_pay_price'] = $goods_pay_price;
                    }
                    $v['goods_refund'] = $v['goods_pay_price'];
                    $refund_goods[$goods_id] = $v;
                } else {//已经存在处理中或同意的商品不能再退款
                    $refund_list[$goods_id] = $v;
                }
            }
        }
        $list = array(
            'refund' => $refund_list,
            'goods' => $refund_goods
        );
        return $list;
    }

    /**
     * 详细页右侧订单信息
     * @access public
     * @author csdeshang
     * @param type $order_condition 条件
     * @param type $order_goods_id 订单商品id
     * @return type
     */
    public function getRightOrderList($order_condition, $order_goods_id = 0) {
        $order_model = model('order');
        $order_info = $order_model->getOrderInfo($order_condition, array('order_common', 'store'));

        $order_id = $order_info['order_id'];
        $order_common = $order_info['extend_order_common'];
        $order_info['order_common'] = $order_common;

        if ($order_common['shipping_express_id'] > 0) {
            $express = rkcache('express', true);
            $order_info['express_code'] = $express[$order_common['shipping_express_id']]['express_code'];
            $order_info['express_name'] = $express[$order_common['shipping_express_id']]['express_name'];
        }

        $condition = array();
        $condition['order_id'] = $order_id;
        if ($order_goods_id > 0) {
            $condition['rec_id'] = $order_goods_id; //订单商品表编号
        }
        $goods_list = $order_model->getOrdergoodsList($condition);
        $order_info['goods_list'] = $goods_list;

        return $order_info;
    }

    /**
     * 根据订单状态判断是否可以退款退货
     * @access public
     * @author csdeshang
     * @param type $order 订单
     * @return bool
     */
    public function getRefundState($order) {
        $refund = '0'; //默认不允许退款退货
        $order_state = $order['order_state']; //订单状态
        $trade_model = model('trade');
        $order_shipped = $trade_model->getOrderState('order_shipped'); //30:已发货
        $order_completed = $trade_model->getOrderState('order_completed'); //40:已收货
        switch ($order_state) {
            case $order_shipped:
                $payment_code = $order['payment_code']; //支付方式
                if ($payment_code != 'offline') {//货到付款订单在没确认收货前不能退款退货
                    $refund = '1';
                } else {
                    $refund = '0';
                }
                break;
            case $order_completed:
                $order_refund = $trade_model->getMaxDay('order_refund'); //15:收货完成后可以申请退款退货
                $delay_time = $order['delay_time'] + 60 * 60 * 24 * $order_refund;
                if ($delay_time > time()) {
                    $refund = '1';
                } else {
                    $refund = '0';
                }
                if($order['ob_no']){//已结算不可以退款
                    $refund = '0';
                }
                break;
            default:
                $refund = '0';
                break;
        }

        return $refund;
    }

    /**
     * 退货退款数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getRefundreturnCount($condition) {
        return db('refundreturn')->where($condition)->count();
    }

    /**
     * 取得退款数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return type
     */
    public function getRefundCount($condition) {
        $condition['refund_type'] = 1;
        return db('refundreturn')->where($condition)->count();
    }

    /**
     * 取得退款退货数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getReturnCount($condition) {
        $condition['refund_type'] = 2;
        return db('refundreturn')->where($condition)->count();
    }

    /**
     * 获得退货退款的店铺列表
     * @access public
     * @author csdeshang
     * @param type $list 店铺列表
     * @return array
     */
    public function getRefundStoreList($list) {
        $store_ids = array();
        if (!empty($list) && is_array($list)) {
            foreach ($list as $key => $value) {
                $store_ids[] = $value['store_id']; //店铺编号
            }
        }
        $field = 'store_id,store_name,member_id,member_name,store_qq,store_ww,store_phone';
        return model('store')->getStoreMemberIDList($store_ids, $field);
    }

}

?>
