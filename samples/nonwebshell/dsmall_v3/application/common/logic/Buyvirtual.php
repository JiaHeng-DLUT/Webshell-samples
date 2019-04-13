<?php

namespace app\common\logic;


use think\Model;

class Buyvirtual extends Model
{
    /**
     * 虚拟商品购买第一步，得到购买数据(商品、店铺、会员)
     * @param int $goods_id 商品ID
     * @param int $quantity 购买数量
     * @param int $member_id 会员ID
     * @return array
     */
    public function getBuyStep1Data($goods_id, $quantity, $member_id) {
        return $this->getBuyStepData($goods_id, $quantity, $member_id);
    }

    /**
     * 虚拟商品购买第二步，得到购买数据(商品、店铺、会员)
     * @param int $goods_id 商品ID
     * @param int $quantity 购买数量
     * @param int $member_id 会员ID
     * @return array
     */
    public function getBuyStep2Data($goods_id, $quantity, $member_id) {
        return $this->getBuyStepData($goods_id, $quantity, $member_id);
    }

    /**
     * 得到虚拟商品购买数据(商品、店铺、会员)
     * @param int $goods_id 商品ID
     * @param int $quantity 购买数量
     * @param int $member_id 会员ID
     * @return array
     */
    public function getBuyStepData($goods_id, $quantity, $member_id) {
        $goods_info = model('goods')->getVirtualGoodsOnlineInfoByID($goods_id);
        if (empty($goods_info)) {
            return ds_callback(false, '该商品不符合购买条件，可能的原因有：下架、不存在、过期等');
        }

        if ($goods_info['virtual_limit'] > $goods_info['goods_storage']) {
            $goods_info['virtual_limit'] = $goods_info['goods_storage'];
        }

        //取得抢购信息
        $goods_info = $this->_getGroupbuyInfo($goods_info);

        $quantity = abs(intval($quantity));
        $quantity = $quantity == 0 ? 1 : $quantity;
        $quantity = $quantity > $goods_info['virtual_limit'] ? $goods_info['virtual_limit'] : $quantity;
        if ($quantity > $goods_info['goods_storage']) {
            return ds_callback(false, '该商品库存不足');
        }
        $goods_info['quantity'] = $quantity;
        $goods_info['goods_total'] = ds_price_format($goods_info['goods_price'] * $goods_info['quantity']);
        $goods_info['goods_image_url'] = goods_cthumb($goods_info['goods_image'], 240, $goods_info['store_id']);

        $return = array();
        $return['goods_info'] = $goods_info;
        $return['store_info'] = model('store')->getStoreOnlineInfoByID($goods_info['store_id'],'store_name,store_id,member_id');
        $return['member_info'] = model('member')->getMemberInfoByID($member_id);

        //        $pd_payment_info = model('payment')->getPaymentOpenInfo(array('payment_code'=>'predeposit'));
        //        if (empty($pd_payment_info)) {
        //            $return['member_info']['available_predeposit'] = 0;
        //            $return['member_info']['available_rc_balance'] = 0;
        //        }
        return ds_callback(true,'',$return);
    }

    /**
     * 虚拟商品购买第三步
     * @param array $post 接收POST数据，必须传入goods_id:商品ID，quantity:购买数量,buyer_phone:接收手机,buyer_msg:买家留言
     * @param int $member_id
     * @return array
     */
    public function buyStep3($post, $member_id) {

        $result = $this->getBuyStepData($post['goods_id'], $post['quantity'], $member_id);
        if (!$result['code']) return $result;

        $goods_info = $result['data']['goods_info'];
        $member_info = $result['data']['member_info'];

        //应付总金额计算
        $pay_total = $goods_info['goods_price'] * $goods_info['quantity'];
        $store_id = $goods_info['store_id'];
        $store_goods_total_list = array($store_id => $pay_total);
        $pay_total = $store_goods_total_list[$store_id];

        //整理数据
        $input = array();
        $input['quantity'] = $goods_info['quantity'];
        $input['buyer_phone'] = $post['buyer_phone'];
        $input['buyer_msg'] = $post['buyer_msg'];
        $input['pay_total'] = $pay_total;
        $input['order_from'] = $post['order_from'];
        try {

            $goods_model = model('goods');
            //开始事务
            $goods_model->startTrans();

            //生成订单
            $order_info = $this->_createOrder($input,$goods_info,$member_info);
            //生成推广记录
            $this->addOrderInviter($order_info);
            if (!empty($post['password'])) {
                if ($member_info['member_paypwd'] != '' && $member_info['member_paypwd'] == md5($post['password'])) {
                    //充值卡支付
                    if (!empty($post['rcb_pay'])) {
                        $order_info = $this->_rcbPay($order_info, $post, $member_info);
                    }
                    //预存款支付
                    if (!empty($post['pd_pay'])) {
                        $this->_pdPay($order_info, $post, $member_info);
                    }
                }
            }

            //提交事务
            $goods_model->commit();

        }catch (Exception $e){

            //回滚事务
            $goods_model->rollback();
            return ds_callback(false, $e->getMessage());
        }

        //变更库存和销量
        \mall\queue\QueueClient::push('createOrderUpdateStorage', array($goods_info['goods_id'] => $goods_info['quantity']));

        //更新抢购信息
        $this->_updateGroupBuy($goods_info);

        //发送兑换码到手机
        $param = array('order_id'=>$order_info['order_id'],'buyer_id'=>$member_id,'buyer_phone'=>$order_info['buyer_phone']);
        \mall\queue\QueueClient::push('sendVrCode', $param);
        return ds_callback(true,'',array('order_id' => $order_info['order_id'],'order_sn'=>$order_info['order_sn']));
    }
    /**
     * 生成推广记录
     * @param array $order_list
     */
    public function addOrderInviter($order = array()) {
        if (!config('inviter_open')) {
            return;
        }
        if (empty($order) || !is_array($order))
            return;
        $inviter_ratio_1 = config('inviter_ratio_1');
        $inviter_ratio_2 = config('inviter_ratio_2');
        $inviter_ratio_3 = config('inviter_ratio_3');
        $orderinviter_model = model('orderinviter');

        $order_id = $order['order_id'];
        $goods = $order;
        //查询商品的分销信息
        $goods_common_info = db('goodscommon')->alias('gc')->join('__GOODS__ g', 'g.goods_commonid=gc.goods_commonid')->where('g.goods_id=' . $goods['goods_id'])->field('gc.goods_commonid,gc.inviter_open,gc.inviter_ratio_1,gc.inviter_ratio_2,gc.inviter_ratio_3')->find();
        if (!$goods_common_info['inviter_open']) {
            return;
        }
        $goods_amount=$goods['goods_price']*$goods['goods_num'];
        $inviter_ratios = array(
            ($goods_common_info['inviter_ratio_1'] > $inviter_ratio_1 ? $inviter_ratio_1 : $goods_common_info['inviter_ratio_1']),
            ($goods_common_info['inviter_ratio_2'] > $inviter_ratio_2 ? $inviter_ratio_2 : $goods_common_info['inviter_ratio_2']),
            ($goods_common_info['inviter_ratio_3'] > $inviter_ratio_3 ? $inviter_ratio_3 : $goods_common_info['inviter_ratio_3']),
        );
        //判断买家是否是分销员
            if(config('inviter_return')){
                if(db('inviter')->where('inviter_state=1 AND inviter_id='.$order['buyer_id'])->value('inviter_id')){
                    if (isset($inviter_ratios[0]) && floatval($inviter_ratios[0]) > 0) {
                            $money_1 = round($inviter_ratios[0] / 100 * $goods_amount, 2);
                            if ($money_1 > 0) {
                               
                                    //生成推广记录
                                    db('orderinviter')->insert(array(
                                        'orderinviter_addtime' => TIMESTAMP,
                                        'orderinviter_store_name' => $order['store_name'],
                                        'orderinviter_goods_amount' => $goods_amount,
                                        'orderinviter_goods_quantity' => $goods['goods_num'],
                                        'orderinviter_order_type' => 1,
                                        'orderinviter_store_id' => $goods['store_id'],
                                        'orderinviter_goods_commonid' => $goods_common_info['goods_commonid'],
                                        'orderinviter_goods_id' => $goods['goods_id'],
                                        'orderinviter_level' => 1,
                                        'orderinviter_goods_name' => $goods['goods_name'],
                                        'orderinviter_order_id' => $order_id,
                                        'orderinviter_order_sn' => $order['order_sn'],
                                        'orderinviter_member_id' => $order['buyer_id'],
                                        'orderinviter_member_name' => $order['buyer_name'],
                                        'orderinviter_money' => $money_1,
                                        'orderinviter_remark' => '获得分销员返佣，佣金比例' . $inviter_ratios[0] . '%，订单号' . $order['order_sn'],
                                    ));
                                    
                            }
                        }
                    }
            }
        //一级推荐人
        $inviter_1_id = db('member')->where('member_id', $order['buyer_id'])->value('inviter_id');
        if (!$inviter_1_id || !db('inviter')->where('inviter_state=1 AND inviter_id=' . $inviter_1_id)->value('inviter_id')) {
            return;
        }
        
        
        $inviter_1 = db('member')->where('member_id', $inviter_1_id)->field('inviter_id,member_id,member_name')->find();
        if ($inviter_1 && isset($inviter_ratios[0]) && floatval($inviter_ratios[0]) > 0) {
            $money_1 = round($inviter_ratios[0] / 100 * $goods_amount, 2);
            if ($money_1 > 0) {
   
                    //生成推广记录
                    db('orderinviter')->insert(array(
                        'orderinviter_addtime' => TIMESTAMP,
                        'orderinviter_store_name' => $order['store_name'],
                        'orderinviter_goods_amount'=>$goods_amount,
                        'orderinviter_goods_quantity'=>$goods['goods_num'],
                        'orderinviter_order_type'=>1,
                        'orderinviter_store_id' => $goods['store_id'],
                        'orderinviter_goods_commonid' => $goods_common_info['goods_commonid'],
                        'orderinviter_goods_id' => $goods['goods_id'],
                        'orderinviter_level' => 1,
                        'orderinviter_goods_name' => $goods['goods_name'],
                        'orderinviter_order_id' => $order_id,
                        'orderinviter_order_sn' => $order['order_sn'],
                        'orderinviter_member_id' => $inviter_1['member_id'],
                        'orderinviter_member_name' => $inviter_1['member_name'],
                        'orderinviter_money' => $money_1,
                        'orderinviter_remark' => '获得一级推荐佣金，佣金比例' . $inviter_ratios[0] . '%，推荐关系' . $inviter_1['member_name'] . '->' . $order['buyer_name'] . '，订单号' . $order['order_sn'],
                    ));
   
            }
        }
        if (config('inviter_level') <= 1) {
            return;
        }
        //二级推荐人
        $inviter_2_id = db('member')->where('member_id', $inviter_1_id)->value('inviter_id');
        if (!$inviter_2_id || !db('inviter')->where('inviter_state=1 AND inviter_id=' . $inviter_2_id)->value('inviter_id')) {
            return;
        }
        $inviter_2 = db('member')->where('member_id', $inviter_2_id)->field('inviter_id,member_id,member_name')->find();
        if ($inviter_2 && isset($inviter_ratios[1]) && floatval($inviter_ratios[1]) > 0) {
            $money_2 = round($inviter_ratios[1] / 100 * $goods_amount, 2);
            if ($money_2 > 0) {
     
                    //生成推广记录
                    db('orderinviter')->insert(array(
                        'orderinviter_addtime' => TIMESTAMP,
                        'orderinviter_store_name' => $order['store_name'],
                        'orderinviter_goods_amount'=>$goods_amount,
                        'orderinviter_goods_quantity'=>$goods['goods_num'],
                        'orderinviter_order_type'=>1,
                        'orderinviter_store_id' => $goods['store_id'],
                        'orderinviter_goods_commonid' => $goods_common_info['goods_commonid'],
                        'orderinviter_goods_id' => $goods['goods_id'],
                        'orderinviter_level' => 2,
                        'orderinviter_goods_name' => $goods['goods_name'],
                        'orderinviter_order_id' => $order_id,
                        'orderinviter_order_sn' => $order['order_sn'],
                        'orderinviter_member_id' => $inviter_2['member_id'],
                        'orderinviter_member_name' => $inviter_2['member_name'],
                        'orderinviter_money' => $money_2,
                        'orderinviter_remark' => '获得二级推荐佣金，佣金比例' . $inviter_ratios[1] . '%，推荐关系' . $inviter_2['member_name'] . '->' . $inviter_1['member_name'] . '->' . $order['buyer_name'] . '，订单号' . $order['order_sn'],
                    ));
     
            }
        }
        if (config('inviter_level') <= 2) {
            return;
        }
        //三级推荐人
        $inviter_3_id = db('member')->where('member_id', $inviter_2_id)->value('inviter_id');
        if (!$inviter_3_id || !db('inviter')->where('inviter_state=1 AND inviter_id=' . $inviter_3_id)->value('inviter_id')) {
            return;
        }
        $inviter_3 = db('member')->where('member_id', $inviter_3_id)->field('inviter_id,member_id,member_name')->find();
        if ($inviter_3 && isset($inviter_ratios[2]) && floatval($inviter_ratios[2]) > 0) {
            $money_3 = round($inviter_ratios[2] / 100 * $goods_amount, 2);
            if ($money_3 > 0) {
    
                    //生成推广记录
                    db('orderinviter')->insert(array(
                        'orderinviter_addtime' => TIMESTAMP,
                        'orderinviter_store_name' => $order['store_name'],
                        'orderinviter_goods_amount'=>$goods_amount,
                        'orderinviter_goods_quantity'=>$goods['goods_num'],
                        'orderinviter_order_type'=>1,
                        'orderinviter_store_id' => $goods['store_id'],
                        'orderinviter_goods_commonid' => $goods_common_info['goods_commonid'],
                        'orderinviter_goods_id' => $goods['goods_id'],
                        'orderinviter_level' => 3,
                        'orderinviter_goods_name' => $goods['goods_name'],
                        'orderinviter_order_id' => $order_id,
                        'orderinviter_order_sn' => $order['order_sn'],
                        'orderinviter_member_id' => $inviter_3['member_id'],
                        'orderinviter_member_name' => $inviter_3['member_name'],
                        'orderinviter_money' => $money_3,
                        'orderinviter_remark' => '获得三级推荐佣金，佣金比例' . $inviter_ratios[2] . '%，推荐关系' . $inviter_3['member_name'] . '->' . $inviter_2['member_name'] . '->' . $inviter_1['member_name'] . '->' . $order['buyer_name'] . '，订单号' . $order['order_sn'],
                    ));
    
            }
        }
    }
    /**
     * 生成订单
     * @param array $input 表单数据
     * @param unknown $goods_info 商品数据
     * @param unknown $member_info 会员数据
     * @throws Exception
     * @return array
     */
    private function _createOrder($input, $goods_info, $member_info) {
        extract($input);
        $vrorder_model = model('vrorder');

        //存储生成的订单,函数会返回该数组
        $order_list = array();

        $order = array();
        $order_code = array();

        $order['order_sn'] = makePaySn($member_info['member_id']);
        $order['store_id'] = $goods_info['store_id'];
        $order['store_name'] = $goods_info['store_name'];
        $order['buyer_id'] = $member_info['member_id'];
        $order['buyer_name'] = $member_info['member_name'];
        $order['buyer_phone'] = $input['buyer_phone'];
        $order['buyer_msg'] = $input['buyer_msg'];
        $order['add_time'] = TIMESTAMP;
        $order['order_state'] = ORDER_STATE_NEW;
        $order['order_amount'] = $pay_total;
        $order['goods_id'] = $goods_info['goods_id'];
        $order['goods_name'] = $goods_info['goods_name'];
        $order['goods_price'] = $goods_info['goods_price'];
        $order['goods_num'] = $input['quantity'];
        $order['goods_image'] = $goods_info['goods_image'];
        $store_gc_id_commis_rate_list=model('storebindclass')->getStoreGcidCommisRateList(array($goods_info));
        $order['commis_rate'] = floatval(@$store_gc_id_commis_rate_list[$goods_info['store_id']][$goods_info['gc_id']]);
        $order['gc_id'] = $goods_info['gc_id'];
        $order['vr_indate'] = $goods_info['virtual_indate'];
        $order['vr_invalid_refund'] = $goods_info['virtual_invalid_refund'];
        $order['order_from'] = $input['order_from'];
        if (isset($goods_info['ifgroupbuy'])&&$goods_info['ifgroupbuy'] == 1) {
            $order['order_promotion_type'] = 1;
            $order['promotions_id'] = $goods_info['groupbuy_id'];
        }

        $order_id = $vrorder_model->addVrorder($order);

        if (!$order_id) {
            exception('订单保存失败');
        }
        $order['order_id'] = $order_id;

        // 提醒[库存报警]
        if ($goods_info['goods_storage_alarm'] >= ($goods_info['goods_storage'] - $input['quantity'])) {
            $param = array();
            $param['common_id'] = $goods_info['goods_commonid'];
            $param['sku_id'] = $goods_info['goods_id'];
            \mall\queue\QueueClient::push('sendStoremsg', array('code' => 'goods_storage_alarm', 'store_id' => $goods_info['store_id'], 'param' => $param));
        }

        return $order;
    }

    /**
     * 更新抢购购买人数和数量
     */
    private function _updateGroupBuy($goods_info) {
        if (isset($goods_info['ifgroupbuy']) && $goods_info['groupbuy_id']) {
            $groupbuy_info = array();
            $groupbuy_info['groupbuy_id'] = $goods_info['groupbuy_id'];
            $groupbuy_info['quantity'] = $goods_info['quantity'];
            \mall\queue\QueueClient::push('editGroupbuySaleCount', $groupbuy_info);
        }
    }

    /**
     * 充值卡支付
     * 如果充值卡足够就单独支付了该订单，如果不足就暂时冻结，等API支付成功了再彻底扣除
     */
    private function _rcbPay($order_info, $input, $buyer_info) {
        $available_rcb_amount = floatval($buyer_info['available_rc_balance']);

        if ($available_rcb_amount <= 0) return;
        $vrorder_model = model('vrorder');
        $predeposit_model = model('predeposit');

        $order_amount = floatval($order_info['order_amount']);
        $data_pd = array();
        $data_pd['member_id'] = $buyer_info['member_id'];
        $data_pd['member_name'] = $buyer_info['member_name'];
        $data_pd['amount'] = $order_amount;
        $data_pd['order_sn'] = $order_info['order_sn'];

        if ($available_rcb_amount >= $order_amount) {

            // 预存款立即支付，订单支付完成
            $predeposit_model->changeRcb('order_pay',$data_pd);
            $available_rcb_amount -= $order_amount;

            // 订单状态 置为已支付
            $data_order = array();
            $order_info['order_state'] = $data_order['order_state'] = ORDER_STATE_PAY;
            $data_order['payment_time'] = TIMESTAMP;
            $data_order['payment_code'] = 'predeposit';
            $data_order['rcb_amount'] = $order_info['order_amount'];
            $result = $vrorder_model->editVrorder($data_order,array('order_id'=>$order_info['order_id']));
            if (!$result) {
                exception('订单更新失败');
            }

            //发放兑换码
            $insert = $vrorder_model->addVrorderCode($order_info);
            //发送兑换码到手机
            $param = array('order_id'=>$order_info['order_id'],'buyer_id'=>$order_info['buyer_id'],'buyer_phone'=>$order_info['buyer_phone']);
            \mall\queue\QueueClient::push('sendVrCode', $param);
            // 支付成功发送店铺消息
            $param = array();
            $param['code'] = 'new_order';
            $param['store_id'] = $order_info['store_id'];
            $param['param'] = array(
                'order_sn' => $order_info['order_sn']
            );
            \mall\queue\QueueClient::push('sendStoremsg', $param);
            if (!$insert) {
                exception('兑换码发送失败');
            }

        } else {

            //暂冻结预存款,后面还需要 API彻底完成支付
            $data_pd['amount'] = $available_rcb_amount;
            $predeposit_model->changeRcb('order_freeze',$data_pd);
            //预存款支付金额保存到订单
            $data_order = array();
            $order_info['rcb_amount'] = $data_order['rcb_amount'] = $available_rcb_amount;
            $result = $vrorder_model->editVrorder($data_order,array('order_id'=>$order_info['order_id']));
            if (!$result) {
                exception('订单更新失败');
            }
        }
        return $order_info;
    }

    /**
     * 预存款支付
     * 如果预存款足够就单独支付了该订单，如果不足就暂时冻结，等API支付成功了再彻底扣除
     */
    private function _pdPay($order_info, $input, $buyer_info) {
        if ($order_info['order_state'] == ORDER_STATE_PAY) return;

        $available_pd_amount = floatval($buyer_info['available_predeposit']);
        if ($available_pd_amount <= 0) return;

        $vrorder_model = model('vrorder');
        $predeposit_model = model('predeposit');

        //充值卡支付金额
        $rcb_amount = isset($order_info['rcb_amount'])?floatval($order_info['rcb_amount']):0;
        
        $order_amount = floatval($order_info['order_amount'])-$rcb_amount;
        $data_pd = array();
        $data_pd['member_id'] = $buyer_info['member_id'];
        $data_pd['member_name'] = $buyer_info['member_name'];
        $data_pd['amount'] = $order_amount;
        $data_pd['order_sn'] = $order_info['order_sn'];

        if ($available_pd_amount >= $order_amount) {

            //预存款立即支付，订单支付完成
            $predeposit_model->changePd('order_pay',$data_pd);
            $available_pd_amount -= $order_amount;

            //下单，支付被冻结的充值卡
            $pd_amount = $rcb_amount;
            if ($pd_amount > 0) {
                $data_pd = array();
                $data_pd['member_id'] = $buyer_info['member_id'];
                $data_pd['member_name'] = $buyer_info['member_name'];
                $data_pd['amount'] = $pd_amount;
                $data_pd['order_sn'] = $order_info['order_sn'];
                $predeposit_model->changeRcb('order_comb_pay',$data_pd);
            }

            // 订单状态 置为已支付
            $data_order = array();
            $data_order['order_state'] = ORDER_STATE_PAY;
            $data_order['payment_time'] = TIMESTAMP;
            $data_order['payment_code'] = 'predeposit';
            $data_order['pd_amount'] = $order_amount;
            $result = $vrorder_model->editVrorder($data_order,array('order_id'=>$order_info['order_id']));
            if (!$result) {
                exception('订单更新失败');
            }

            //发放兑换码
            $vrorder_model->addVrorderCode($order_info);
            //发送兑换码到手机
            $param = array('order_id'=>$order_info['order_id'],'buyer_id'=>$order_info['buyer_id'],'buyer_phone'=>$order_info['buyer_phone']);
            \mall\queue\QueueClient::push('sendVrCode', $param);
            // 支付成功发送店铺消息
            $param = array();
            $param['code'] = 'new_order';
            $param['store_id'] = $order_info['store_id'];
            $param['param'] = array(
                'order_sn' => $order_info['order_sn']
            );
            \mall\queue\QueueClient::push('sendStoremsg', $param);

        } else {

            //暂冻结预存款,后面还需要 API彻底完成支付
            $data_pd['amount'] = $available_pd_amount;
            $predeposit_model->changePd('order_freeze',$data_pd);
            //预存款支付金额保存到订单
            $data_order = array();
            $data_order['pd_amount'] = $available_pd_amount;
            $result = $vrorder_model->editVrorder($data_order,array('order_id'=>$order_info['order_id']));
            if (!$result) {
                exception('订单更新失败');
            }
        }
    }

    /**
     * 充值卡支付
     * 如果充值卡足够就单独支付了该订单，如果不足就暂时冻结，等API支付成功了再彻底扣除
     */
    public function rcbPay($order_info, $input, $buyer_info) {
        $available_rcb_amount = floatval($buyer_info['available_rc_balance']);

        if ($available_rcb_amount <= 0) $order_info;
        $vrorder_model = model('vrorder');
        $predeposit_model = model('predeposit');

        $order_amount = floatval($order_info['order_amount']);
        $data_pd = array();
        $data_pd['member_id'] = $buyer_info['member_id'];
        $data_pd['member_name'] = $buyer_info['member_name'];
        $data_pd['amount'] = $order_amount;
        $data_pd['order_sn'] = $order_info['order_sn'];

        if ($available_rcb_amount >= $order_amount) {

            // 预存款立即支付，订单支付完成
            $predeposit_model->changeRcb('order_pay',$data_pd);
            $available_rcb_amount -= $order_amount;

            // 订单状态 置为已支付
            $data_order = array();
            $order_info['order_state'] = $data_order['order_state'] = ORDER_STATE_PAY;
            $data_order['payment_time'] = TIMESTAMP;
            $data_order['payment_code'] = 'predeposit';
            $data_order['rcb_amount'] = $order_info['order_amount'];
            $result = $vrorder_model->editVrorder($data_order,array('order_id'=>$order_info['order_id']));
            if (!$result) {
                exception('订单更新失败');
            }

            //发放兑换码
            $insert = $vrorder_model->addVrorderCode($order_info);
            //发送兑换码到手机
            $param = array('order_id'=>$order_info['order_id'],'buyer_id'=>$order_info['buyer_id'],'buyer_phone'=>$order_info['buyer_phone']);
            \mall\queue\QueueClient::push('sendVrCode', $param);
            // 支付成功发送店铺消息
            $param = array();
            $param['code'] = 'new_order';
            $param['store_id'] = $order_info['store_id'];
            $param['param'] = array(
                'order_sn' => $order_info['order_sn']
            );
            \mall\queue\QueueClient::push('sendStoremsg', $param);
            if (!$insert) {
                exception('兑换码发送失败');
            }

        } else {

            //暂冻结预存款,后面还需要 API彻底完成支付
            $data_pd['amount'] = $available_rcb_amount;
            $predeposit_model->changeRcb('order_freeze',$data_pd);
            //预存款支付金额保存到订单
            $data_order = array();
            $order_info['rcb_amount'] = $data_order['rcb_amount'] = $available_rcb_amount;
            $result = $vrorder_model->editVrorder($data_order,array('order_id'=>$order_info['order_id']));
            if (!$result) {
                exception('订单更新失败');
            }
        }
        return $order_info;
    }

    /**
     * 预存款支付 主要处理
     * 如果预存款足够就单独支付了该订单，如果不足就暂时冻结，等API支付成功了再彻底扣除
     */
    public function pdPay($order_info, $input, $buyer_info) {
        if ($order_info['order_state'] == ORDER_STATE_PAY) $order_info;

        $available_pd_amount = floatval($buyer_info['available_predeposit']);
        if ($available_pd_amount <= 0) $order_info;

        $vrorder_model = model('vrorder');
        $predeposit_model = model('predeposit');

        $order_amount = floatval($order_info['order_amount'])-floatval($order_info['rcb_amount']);
        $data_pd = array();
        $data_pd['member_id'] = $buyer_info['member_id'];
        $data_pd['member_name'] = $buyer_info['member_name'];
        $data_pd['amount'] = $order_amount;
        $data_pd['order_sn'] = $order_info['order_sn'];

        if ($available_pd_amount >= $order_amount) {

            //预存款立即支付，订单支付完成
            $predeposit_model->changePd('order_pay',$data_pd);
            $available_pd_amount -= $order_amount;

            //下单，支付被冻结的充值卡
            $pd_amount = floatval($order_info['rcb_amount']);
            if ($pd_amount > 0) {
                $data_pd = array();
                $data_pd['member_id'] = $buyer_info['member_id'];
                $data_pd['member_name'] = $buyer_info['member_name'];
                $data_pd['amount'] = $pd_amount;
                $data_pd['order_sn'] = $order_info['order_sn'];
                $predeposit_model->changeRcb('order_comb_pay',$data_pd);
            }

            // 订单状态 置为已支付
            $data_order = array();
            $order_info['order_state'] = $data_order['order_state'] = ORDER_STATE_PAY;
            $order_info['payment_time'] = $data_order['payment_time'] = TIMESTAMP;
            $order_info['payment_code'] = $data_order['payment_code'] = 'predeposit';
            $order_info['pd_amount'] = $data_order['pd_amount'] = $order_amount;
            $result = $vrorder_model->editVrorder($data_order,array('order_id'=>$order_info['order_id']));
            if (!$result) {
                exception('订单更新失败');
            }

            //发放兑换码
            $vrorder_model->addVrorderCode($order_info);
            //发送兑换码到手机
            $param = array('order_id'=>$order_info['order_id'],'buyer_id'=>$order_info['buyer_id'],'buyer_phone'=>$order_info['buyer_phone']);
            \mall\queue\QueueClient::push('sendVrCode', $param);
            // 支付成功发送店铺消息
            $param = array();
            $param['code'] = 'new_order';
            $param['store_id'] = $order_info['store_id'];
            $param['param'] = array(
                'order_sn' => $order_info['order_sn']
            );
            \mall\queue\QueueClient::push('sendStoremsg', $param);

        } else {

            //暂冻结预存款,后面还需要 API彻底完成支付
            $data_pd['amount'] = $available_pd_amount;
            $predeposit_model->changePd('order_freeze',$data_pd);
            //预存款支付金额保存到订单
            $data_order = array();
            $order_info['pd_amount'] = $data_order['pd_amount'] = $available_pd_amount;
            $result = $vrorder_model->editVrorder($data_order,array('order_id'=>$order_info['order_id']));
            if (!$result) {
                exception('订单更新失败');
            }
        }
        return $order_info;
    }

    /**
     * 取得抢购信息
     * @param array $goods_info
     * @return array
     */
    private function _getGroupbuyInfo($goods_info = array()) {
        if (!config('groupbuy_allow') || empty($goods_info) || !is_array($goods_info)) return $goods_info;

        $groupbuy_info = model('groupbuy')->getGroupbuyInfoByGoodsCommonID($goods_info['goods_commonid']);
        if (empty($groupbuy_info)) return $goods_info;
        // 虚拟抢购数量限制
        if ($groupbuy_info['groupbuy_upper_limit'] > 0 && $groupbuy_info['groupbuy_upper_limit'] < $goods_info['virtual_limit']) {
            $goods_info['virtual_limit'] = $groupbuy_info['groupbuy_upper_limit'];
        }
        $goods_info['goods_price'] = $groupbuy_info['groupbuy_price'];
        $goods_info['groupbuy_id'] = $groupbuy_info['groupbuy_id'];
        $goods_info['ifgroupbuy'] = true;

        return $goods_info;
    }
}