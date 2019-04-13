<?php
namespace app\common\logic;
use think\Model;
use think\Db;
class Order extends Model
{

    /**
     * 取消订单
     * @param array $order_info
     * @param string $role 操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $user 操作人
     * @param string $msg 操作备注
     * @param boolean $if_update_account 是否变更账户金额
     * @param boolean $if_queue 是否使用队列
     * @param boolean $if_pay 是否已经支付,已经支付则全部退回支付金额
     * @return array
     */
    public function changeOrderStateCancel($order_info, $role, $user = '', $msg = '', $if_update_account = true, $if_quque = true,$if_pay=false)
    {
        try {
            $order_model = model('order');
            $order_model->startTrans();
            $order_id = $order_info['order_id'];

            //库存销量变更
            $goods_list = $order_model->getOrdergoodsList(array('order_id' => $order_id));
            $data = array();
            foreach ($goods_list as $goods) {
                $data[$goods['goods_id']] = $goods['goods_num'];
            }
            if ($if_quque) {
                \mall\queue\QueueClient::push('cancelOrderUpdateStorage', $data);
            }
            else {
                \model('queue','logic')->cancelOrderUpdateStorage($data);
            }

            if ($if_update_account) {
                $predeposit_model = model('predeposit');
                //解冻充值卡
                $rcb_amount = floatval($order_info['rcb_amount']);
                if ($rcb_amount > 0) {
                    $data_pd = array();
                    $data_pd['member_id'] = $order_info['buyer_id'];
                    $data_pd['member_name'] = $order_info['buyer_name'];
                    $data_pd['amount'] = $rcb_amount;
                    $data_pd['order_sn'] = $order_info['order_sn'];
                    $predeposit_model->changeRcb('order_cancel', $data_pd);
                }
                
                //注意：当用户全额使用预存款进行支付,并不会冻结, 当用户使用部分预存款进行支付,支付的预存款则会冻结.也就是支付成功之后不会有冻结资金,当未支付成功,使用的预付款变为冻结资金。
                
                if($order_info['order_state'] == ORDER_STATE_NEW){
                    //当是已下单,未支付(可能包含部分款项使用预存款,预存款在冻结资金),则退还预存款,取消订单
                    $pd_amount = floatval($order_info['pd_amount']);
                    if ($pd_amount > 0) {
                        $data_pd = array();
                        $data_pd['member_id'] = $order_info['buyer_id'];
                        $data_pd['member_name'] = $order_info['buyer_name'];
                        $data_pd['amount'] = $pd_amount;
                        $data_pd['order_sn'] = $order_info['order_sn'];
                        $predeposit_model->changePd('order_cancel', $data_pd);
                    }
                }
                
                if($order_info['order_state'] == ORDER_STATE_PAY){
                    //当是已付款,未发货状态,则直接取消订单, 订单金额减去充值卡  表示为支付的总金额(预存款部分支付,以及直接支付),已付款预存款部分支付的金额已被取消冻结了.
                    $payment_amount = $order_info['order_amount'] - $rcb_amount;
                    if ($payment_amount > 0) {
                        $data_pd = array();
                        $data_pd['member_id'] = $order_info['buyer_id'];
                        $data_pd['member_name'] = $order_info['buyer_name'];
                        $data_pd['amount'] = $payment_amount;
                        $data_pd['order_sn'] = $order_info['order_sn'];
                        $predeposit_model->changePd('refund', $data_pd);
                    }
                }
                
            }

            //更新订单信息
            $update_order = array('order_state' => ORDER_STATE_CANCEL, 'pd_amount' => 0);
            $update = $order_model->editOrder($update_order, array('order_id' => $order_id));
            if (!$update) {
                exception('保存失败');
            }

            //添加订单日志
            $data = array();
            $data['order_id'] = $order_id;
            $data['log_role'] = $role;
            $data['log_msg'] = '取消了订单';
            $data['log_user'] = $user;
            if ($msg) {
                $data['log_msg'] .= ' ( ' . $msg . ' )';
            }
            $data['log_orderstate'] = ORDER_STATE_CANCEL;
            $order_model->addOrderlog($data);
            $order_model->commit();

            return ds_callback(true, '操作成功');

        } catch (Exception $e) {
            $this->rollback();
            return ds_callback(false, '操作失败');
        }
    }

    /**
     * 收货
     * @param array $order_info
     * @param string $role 操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $user 操作人
     * @param string $msg 操作备注
     * @return array
     */
    public function changeOrderStateReceive($order_info, $role, $user = '', $msg = '')
    {
        try {
            $member_id = $order_info['buyer_id'];
            $order_id = $order_info['order_id'];
            $order_model = model('order');

            //更新订单状态
            $update_order = array();
            $update_order['finnshed_time'] = TIMESTAMP;
            $update_order['order_state'] = ORDER_STATE_SUCCESS;
            $update = $order_model->editOrder($update_order, array('order_id' => $order_id));
            if (!$update) {
                exception('保存失败');
            }

            //添加订单日志
            $data = array();
            $data['order_id'] = $order_id;
            $data['log_role'] = 'buyer';
            $data['log_msg'] = '签收了货物';
            $data['log_user'] = $user;
            if ($msg) {
                $data['log_msg'] .= ' ( ' . $msg . ' )';
            }
            $data['log_orderstate'] = ORDER_STATE_SUCCESS;
            $order_model->addOrderlog($data);

            //添加会员积分
            if (config('points_isuse') == 1) {
                model('points')->savePointslog('order', array(
                    'pl_memberid' => $order_info['buyer_id'], 'pl_membername' => $order_info['buyer_name'],
                    'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'],
                    'order_id' => $order_info['order_id']
                ), true);
            }
            //添加会员经验值
            model('exppoints')->saveExppointslog('order', array(
                'explog_memberid' => $order_info['buyer_id'], 'explog_membername' => $order_info['buyer_name'],
                'orderprice' => $order_info['order_amount'], 'order_sn' => $order_info['order_sn'],
                'order_id' => $order_info['order_id']
            ), true);
            //邀请人获得返利积分
            $inviter_id = ds_getvalue_byname('member', 'member_id', $member_id, 'inviter_id');
            if(!empty($inviter_id)) {
                $inviter_name = ds_getvalue_byname('member', 'member_id', $inviter_id['inviter_id'], 'member_name');
                $rebate_amount = ceil(0.01 * $order_info['order_amount'] * config('points_rebate'));
                model('points')->savePointslog('rebate', array(
                    'pl_memberid' => $inviter_id['inviter_id'], 'pl_membername' => $inviter_name, 'pl_points' => $rebate_amount
                ), true);
            }

            return ds_callback(true, '操作成功');
        } catch (Exception $e) {
            return ds_callback(false, '操作失败');
        }
    }

    /**
     * 更改运费
     * @param array $order_info
     * @param string $role 操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $user 操作人
     * @param float $price 运费
     * @return array
     */
    public function changeOrderShipPrice($order_info, $role, $user = '', $price)
    {
        try {

            $order_id = $order_info['order_id'];
            $order_model = model('order');

            $data = array();
            $data['shipping_fee'] = abs(floatval($price));
            $data['order_amount'] = Db::raw('goods_amount+'.$data['shipping_fee']);
            $update = $order_model->editOrder($data, array('order_id' => $order_id));
            if (!$update) {
                exception('保存失败');
            }
            //记录订单日志
            $data = array();
            $data['order_id'] = $order_id;
            $data['log_role'] = $role;
            $data['log_user'] = $user;
            $data['log_msg'] = '修改了运费' . '( ' . $price . ' )';;
            $data['log_orderstate'] = $order_info['payment_code'] == 'offline' ? ORDER_STATE_PAY : ORDER_STATE_NEW;
            $order_model->addOrderlog($data);
            return ds_callback(true, '操作成功');
        } catch (Exception $e) {
            return ds_callback(false, '操作失败');
        }
    }

    /**
     * 更改商品费用
     * @param array $order_info
     * @param string $role 操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $user 操作人
     * @param float $price 运费
     * @return array
     */
    public function changeOrderSpayPrice($order_info, $role, $user = '', $price)
    {
        try {

            $order_id = $order_info['order_id'];
            $order_model = model('order');

            $data = array();
            $data['goods_amount'] = abs(floatval($price));
            $data['order_amount'] = Db::raw('shipping_fee+'.$data['goods_amount']);
            $update = $order_model->editOrder($data, array('order_id' => $order_id));
            if (!$update) {
                exception('保存失败');
            }
            //记录订单日志
            $data = array();
            $data['order_id'] = $order_id;
            $data['log_role'] = $role;
            $data['log_user'] = $user;
            $data['log_msg'] = '修改了商品费用' . '( ' . $price . ' )';;
            $data['log_orderstate'] = $order_info['payment_code'] == 'offline' ? ORDER_STATE_PAY : ORDER_STATE_NEW;
            $order_model->addOrderlog($data);
            return ds_callback(true, '操作成功');
        } catch (Exception $e) {
            return ds_callback(false, '操作失败');
        }
    }

    /**
     * 回收站操作（放入回收站、还原、永久删除）
     * @param array $order_info
     * @param string $role 操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $state_type 操作类型
     * @return array
     */
    public function changeOrderStateRecycle($order_info, $role, $state_type)
    {
        $order_id = $order_info['order_id'];
        $order_model = model('order');
        //更新订单删除状态
        $state = str_replace(array('delete', 'drop', 'restore'), array(
            ORDER_DEL_STATE_DELETE, ORDER_DEL_STATE_DROP, ORDER_DEL_STATE_DEFAULT
        ), $state_type);
        $update = $order_model->editOrder(array('delete_state' => $state), array('order_id' => $order_id));
        if (!$update) {
            return ds_callback(false, '操作失败');
        }
        else {
            return ds_callback(true, '操作成功');
        }
    }

    /**
     * 发货
     * @param array $order_info
     * @param string $role 操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $user 操作人
     * @return array
     */
    public function changeOrderSend($order_info, $role, $user = '', $post = array())
    {
        $order_id = $order_info['order_id'];
        $order_model = model('order');
        
        //查看是否为拼团订单
        $condition = array();
        $condition['order_id'] = $order_id;
        $pintuanorder = model('ppintuanorder')->getOnePpintuanorder($condition);
        if (!empty($pintuanorder) && $pintuanorder['pintuanorder_state'] != 2) {
            return ds_callback(FALSE, '拼团订单暂时不允许发货');
        }
        
        if(!isset($post['daddress_id'])){
            return ds_callback(FALSE, '请先设置发货地址');
        }

        try {
            $order_model->startTrans();
            $data = array();
            $data['reciver_name'] = $post['reciver_name'];
            $data['reciver_info'] = $post['reciver_info'];
            $data['deliver_explain'] = $post['deliver_explain'];
            $data['daddress_id'] = intval($post['daddress_id']);
            $data['shipping_express_id'] = intval($post['shipping_express_id']);
            $data['shipping_time'] = TIMESTAMP;

            $condition = array();
            $condition['order_id'] = $order_id;
            $condition['store_id'] = $order_info['store_id'];
            $update = $order_model->editOrdercommon($data, $condition);
            if (!$update) {
                exception('操作失败');
            }

            $data = array();
            $data['shipping_code'] = isset($post['shipping_code'])?$post['shipping_code']:'';
            $data['order_state'] = ORDER_STATE_SEND;
            $data['delay_time'] = TIMESTAMP;
            $update = $order_model->editOrder($data, $condition);
            if (!$update) {
                exception('操作失败');
            }
            $order_model->commit();
        } catch (Exception $e) {
            $order_model->rollback();
            return ds_callback(false, $e->getMessage());
        }

        //更新表发货信息
        if ($post['shipping_express_id'] && isset($order_info['extend_order_common']['reciver_info']['dlyp'])) {
            $data = array();
            $data['shipping_code'] = $post['shipping_code'];
            $data['order_sn'] = $order_info['order_sn'];
            $express_info = model('express')->getExpressInfo(intval($post['shipping_express_id']));
            $data['express_code'] = $express_info['express_code'];
            $data['express_name'] = $express_info['express_name'];
            model('deliveryorder')->editDeliveryorder($data, array('order_id' => $order_info['order_id']));
        }

        //添加订单日志
        $data = array();
        $data['order_id'] = intval($order_id);
        $data['log_role'] = 'seller';
        $data['log_user'] = session('member_name');
        $data['log_msg'] = '发出了货物 ( 编辑了发货信息 )';
        $data['log_orderstate'] = ORDER_STATE_SEND;
        $order_model->addOrderlog($data);

        // 发送买家消息
        $param = array();
        $param['code'] = 'order_deliver_success';
        $param['member_id'] = $order_info['buyer_id'];
        $param['param'] = array(
            'order_sn' => $order_info['order_sn'],
            'order_url' => url('Memberorder/show_order', array('order_id' => $order_id))
        );
         \mall\queue\QueueClient::push('sendMemberMsg', $param);
        return ds_callback(true, '操作成功');
    }

    /**
     * 收到货款
     * @param array $order_info
     * @param string $role 操作角色 buyer、seller、admin、system 分别代表买家、商家、管理员、系统
     * @param string $user 操作人
     * @return array
     */
    public function changeOrderReceivePay($order_list, $role, $user = '', $post = array())
    {
        $order_model = model('order');

        try {
            $order_model->startTrans();

            $data = array();
            $data['api_paystate'] = 1;

            $update = $order_model->editOrderpay($data, array('pay_sn' => $order_list[0]['pay_sn']));
            if (!$update) {
                 Exception('更新支付单状态失败');
            }

            $predeposit_model = model('predeposit');
            foreach ($order_list as $order_info) {
                $order_id = $order_info['order_id'];
                if ($order_info['order_state'] != ORDER_STATE_NEW)
                    continue;
                //下单，支付被冻结的充值卡
                $rcb_amount = floatval($order_info['rcb_amount']);
                if ($rcb_amount > 0) {
                    $data_pd = array();
                    $data_pd['member_id'] = $order_info['buyer_id'];
                    $data_pd['member_name'] = $order_info['buyer_name'];
                    $data_pd['amount'] = $rcb_amount;
                    $data_pd['order_sn'] = $order_info['order_sn'];
                    $predeposit_model->changeRcb('order_comb_pay', $data_pd);
                }

                //下单，支付被冻结的预存款
                $pd_amount = floatval($order_info['pd_amount']);
                if ($pd_amount > 0) {
                    $data_pd = array();
                    $data_pd['member_id'] = $order_info['buyer_id'];
                    $data_pd['member_name'] = $order_info['buyer_name'];
                    $data_pd['amount'] = $pd_amount;
                    $data_pd['order_sn'] = $order_info['order_sn'];
                    $predeposit_model->changePd('order_comb_pay', $data_pd);
                }
            }

            //更新订单状态
            $update_order = array();
            $update_order['order_state'] = ORDER_STATE_PAY;
            $update_order['payment_time'] = (isset($post['payment_time']) ? strtotime($post['payment_time']) : TIMESTAMP);
            $update_order['payment_code'] = $post['payment_code'];
            $update = $order_model->editOrder($update_order, array(
                'pay_sn' => $order_info['pay_sn'], 'order_state' => ORDER_STATE_NEW
            ));
            if (!$update) {
                exception('操作失败');
            }
            $order_model->commit();
        } catch (Exception $e) {
            $order_model->rollback();
            return ds_callback(false, $e->getMessage());
        }

        foreach ($order_list as $order_info) {
            //防止重复发送消息
            if ($order_info['order_state'] != ORDER_STATE_NEW)
                continue;
            $order_id = $order_info['order_id'];
            // 支付成功发送买家消息
            $param = array();
            $param['code'] = 'order_payment_success';
            $param['member_id'] = $order_info['buyer_id'];
            $param['param'] = array(
                'order_sn' => $order_info['order_sn'],
                'order_url' => url('home/Memberorder/show_order', array('order_id' => $order_info['order_id']))
            );
             \mall\queue\QueueClient::push('sendMemberMsg', $param);

            // 支付成功发送店铺消息
            $param = array();
            $param['code'] = 'new_order';
            $param['store_id'] = $order_info['store_id'];
            $param['param'] = array(
                'order_sn' => $order_info['order_sn']
            );
             \mall\queue\QueueClient::push('sendStoremsg', $param);

            //添加订单日志
            $data = array();
            $data['order_id'] = $order_id;
            $data['log_role'] = $role;
            $data['log_user'] = $user;
            $data['log_msg'] = '收到了货款 ( 支付平台交易号 : ' . $post['trade_no'] . ' )';
            $data['log_orderstate'] = ORDER_STATE_PAY;
            $order_model->addOrderlog($data);
        }

        return ds_callback(true, '操作成功');
    }
}