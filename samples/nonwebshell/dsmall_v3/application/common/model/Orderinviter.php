<?php

namespace app\common\model;

use think\Model;

class Orderinviter extends Model {

    /**
     * 支付给钱
     * @access public
     * @author csdeshang
     * @param type $order_id 订单编号
     */
    public function giveMoney($order_id, $type) {
        $orderinviter_list = db('orderinviter')->where(array('orderinviter_order_id' => $order_id, 'orderinviter_valid' => 0, 'orderinviter_order_type' => $type))->lock(true)->select();
        if ($orderinviter_list) {
            $predeposit_model = model('predeposit');
            foreach ($orderinviter_list as $val) {
                //如果是被清退的分销员，则得不到分销佣金，对冲分销员分销完商品后，退款的情况
                $inviter = db('inviter')->where(array('inviter_id' => $val['orderinviter_member_id'], 'inviter_state' => 1))->lock(true)->find();
                if ($inviter) {
                    $data = array();
                    $data['member_id'] = $val['orderinviter_member_id'];
                    $data['member_name'] = $val['orderinviter_member_name'];
                    $data['amount'] = $val['orderinviter_money'];
                    $data['order_sn'] = $val['orderinviter_order_sn'];
                    $data['lg_desc'] = $val['orderinviter_remark'];
                    $predeposit_model->changePd('order_inviter', $data);
                    $goodscommon = db('goodscommon')->where('goods_commonid=' . $val['orderinviter_goods_commonid'])->lock(true)->find();

                    if ($goodscommon) {
                        $goodscommon_data = array();
                        if (!db('orderinviter')->where(array('orderinviter_order_id' => $order_id, 'orderinviter_goods_commonid' => $val['orderinviter_goods_commonid'], 'orderinviter_valid' => array('<>', 0)))->lock(true)->find()) {
                            //更新商品的分销情况
                            $goodscommon_data['inviter_total_quantity'] = $goodscommon['inviter_total_quantity'] + $val['orderinviter_goods_quantity'];
                            $goodscommon_data['inviter_total_amount'] = bcadd($goodscommon['inviter_total_amount'], $val['orderinviter_goods_amount'], 2);
                        }
                        if ($val['orderinviter_money'] > 0) {
                            $goodscommon_data['inviter_amount'] = bcadd($goodscommon['inviter_amount'], $val['orderinviter_money'], 2);
                        }

                        if (!empty($goodscommon_data)) {
                            $mysql_flag = db('goodscommon')->where('goods_commonid=' . $val['orderinviter_goods_commonid'])->update($goodscommon_data);
                            if (!$mysql_flag) {
                                exception('[订单id：' . $order_id . ']商品分销信息更新失败');
                            }
                        }
                    }
                    $inviter_data = array(
                        'inviter_goods_quantity' => $inviter['inviter_goods_quantity'] + $val['orderinviter_goods_quantity'],
                        'inviter_goods_amount' => bcadd($inviter['inviter_goods_amount'], $val['orderinviter_goods_amount'], 2),
                        'inviter_total_amount' => bcadd($inviter['inviter_total_amount'], $val['orderinviter_money'], 2),
                    );
                    //更新分销员的分销情况
                    $mysql_flag = db('inviter')->where(array('inviter_id' => $val['orderinviter_member_id']))->update($inviter_data);
                    if (!$mysql_flag) {
                        exception('[订单id：' . $order_id . ']分销员分销信息更新失败');
                    }
                    $mysql_flag = db('orderinviter')->where('orderinviter_id', $val['orderinviter_id'])->update(['orderinviter_valid' => 1]);
                    if (!$mysql_flag) {
                        exception('[订单id：' . $order_id . ']分销佣金状态更新失败');
                    }
                }
            }
        }
    }

}
