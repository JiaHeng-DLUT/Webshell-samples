<?php

namespace app\common\logic;
use think\Model;
use think\Db;
class Queue extends Model
{
    public function addConsume($member_info){
        return ds_callback(true);
    }
    /**
     * 添加会员积分
     * @param unknown $member_info
     */
    public function addPoint($member_info)
    {
        $points_model = model('points');
        $points_model->savePointslog('login', array(
            'pl_memberid' => $member_info['member_id'], 'pl_membername' => $member_info['member_name']
        ), true);
        return ds_callback(true);
    }

    /**
     * 添加会员经验值
     * @param unknown $member_info
     */
    public function addExppoint($member_info)
    {
        $exppoints_model = model('exppoints');
        $exppoints_model->saveExppointslog('login', array(
            'explog_memberid' => $member_info['member_id'], 'explog_membername' => $member_info['member_name']
        ), true);
        return ds_callback(true);
    }

    /**
     * 更新抢购信息
     * @param unknown $groupbuy_info
     * @throws Exception
     */
    public function editGroupbuySaleCount($groupbuy_info)
    {
        $groupbuy_model = model('groupbuy');
        $data = array();
        $data['groupbuy_buyer_count'] = Db::raw('groupbuy_buyer_count+1');
        $data['groupbuy_buy_quantity'] = Db::raw('groupbuy_buy_quantity+'.$groupbuy_info['quantity']);
        $update = $groupbuy_model->editGroupbuy($data, array('groupbuy_id' => $groupbuy_info['groupbuy_id']));
        if (!$update) {
            return ds_callback(false, '更新抢购信息失败groupbuy_id:' . $groupbuy_info['groupbuy_id']);
        }
        else {
            return ds_callback(true);
        }
    }

    /**
     * 更新使用的代金券状态
     * @param $input_voucher_list
     * @throws Exception
     */
    public function editVoucherState($voucher_list)
    {
        $voucher_model = model('voucher');
        $send = new \sendmsg\sendMemberMsg();
        foreach ($voucher_list as $store_id => $voucher_info) {
            $update = $voucher_model->editVoucher(array('voucher_state' => 2), array('voucher_id' => $voucher_info['voucher_id']), $voucher_info['voucher_owner_id']);
            if ($update) {
                // 发送用户店铺消息
                $send->set('member_id', $voucher_info['voucher_owner_id']);
                $send->set('code', 'voucher_use');
                $param = array();
                $param['voucher_code'] = $voucher_info['voucher_code'];
                $param['voucher_url'] = url('Membervoucher/index');
                $send->send($param);
            }
            else {
                return ds_callback(false, '更新代金券状态失败vcode:' . $voucher_info['voucher_code']);
            }
        }
        return ds_callback(true);
    }

    /**
     * 下单变更库存销量
     * @param unknown $goods_buy_quantity
     */
    public function createOrderUpdateStorage($goods_buy_quantity)
    {
        $goods_model = model('goods');
        foreach ($goods_buy_quantity as $goods_id => $quantity) {
            $data = array();
            $data['goods_storage'] = Db::raw('goods_storage-'.$quantity);
            $data['goods_salenum'] = Db::raw('goods_salenum+'.$quantity);
            $result = $goods_model->editGoodsById($data, $goods_id);
        }
        if (!$result) {
            return ds_callback(false, '变更商品库存与销量失败');
        }
        else {
            return ds_callback(true);
        }
    }

    /**
     * 取消订单变更库存销量
     * @param unknown $goods_buy_quantity
     */
    public function cancelOrderUpdateStorage($goods_buy_quantity)
    {
        $goods_model = model('goods');
        foreach ($goods_buy_quantity as $goods_id => $quantity) {
            $data = array();
            $data['goods_storage'] = Db::raw('goods_storage+'.$quantity);
            $data['goods_salenum'] = Db::raw('goods_salenum-'.$quantity);
            $result = $goods_model->editGoodsById($data, $goods_id);
            if (!$result) {
                return ds_callback(false, '变更商品库存与销量失败');
            }
        }
            return ds_callback(true);
    }

    /**
     * 更新F码为使用状态
     * @param int $goodsfcode_id
     */
    public function updateGoodsfcode($goodsfcode_id)
    {
        $update = model('goodsfcode')->editGoodsfcode(array('goodsfcode_state' => 1), array('goodsfcode_id' => $goodsfcode_id));
        if (!$update) {
            return ds_callback(false, '更新F码使用状态失败goodsfcode_id:' . $goodsfcode_id);
        }
        else {
            return ds_callback(true);
        }
    }

    /**
     * 删除购物车
     * @param unknown $cart
     */
    public function delCart($cart)
    {
        if (!is_array($cart['cart_ids']) || empty($cart['buyer_id']))
            return ds_callback(true);
        $del = model('cart')->delCart('db', array(
            'buyer_id' => $cart['buyer_id'], 'cart_id' => array('in', $cart['cart_ids'])
        ));
        if (!$del) {
            return ds_callback(false, '删除购物车数据失败');
        }
        else {
            return ds_callback(true);
        }
    }

    /**
     * 根据商品id更新促销价格
     *
     * @param int /array $goods_commonid
     * @return boolean
     */
    public function updateGoodsPromotionPriceByGoodsId($goods_id)
    {
        $update = model('goods')->editGoodsPromotionPrice(array('goods_id' => array('in', $goods_id)));
        if (!$update) {
            return ds_callback(false, '根据商品ID更新促销价格失败');
        }
        else {
            return ds_callback(true);
        }
    }

    /**
     * 根据商品公共id更新促销价格
     *
     * @param int /array $goods_commonid
     * @return boolean
     */
    public function updateGoodsPromotionPriceByGoodsCommonId($goods_commonid)
    {
        $update = model('goods')->editGoodsPromotionPrice(array('goods_commonid' => array('in', $goods_commonid)));
        if (!$update) {
            return ds_callback(false, '根据商品公共id更新促销价格失败');
        }
        else {
            return ds_callback(true);
        }
    }

    /**
     * 发送店铺消息
     */
    public function sendStoremsg($param)
    {
        $send = new \sendmsg\sendStoremsg();
        $send->set('code', $param['code']);
        $send->set('store_id', $param['store_id']);
        $send->send($param['param']);
        return ds_callback(true);
    }

    /**
     * 发送会员消息
     */
    public function sendMemberMsg($param)
    {
        $send = new \sendmsg\sendMemberMsg();
        $send->set('code', $param['code']);
        $send->set('member_id', $param['member_id']);
        if (!empty($param['number']['mobile']))
            $send->set('mobile', $param['number']['mobile']);
        if (!empty($param['number']['email']))
            $send->set('email', $param['number']['email']);
        $send->send($param['param']);
        return ds_callback(true);
    }

    /**
     * 生成商品F码
     */
    public function createGoodsfcode($param)
    {
        $insert = array();
        for ($i = 0; $i < $param['goodsfcode_count']; $i++) {
            $array = array();
            $array['goods_commonid'] = $param['goods_commonid'];
            $array['goodsfcode_code'] = strtoupper($param['goodsfcode_prefix']) . mt_rand(100000, 999999);
            $insert[$array['goodsfcode_code']] = $array;
        }
        if (!empty($insert)) {
            $insert = array_values($insert);
            $insert = model('goodsfcode')->addGoodsfcodeAll($insert);
            if (!$insert) {
                return ds_callback(false, '生成商品F码失败goods_commonid:' . $param['goods_commonid']);
            }
        }
        return ds_callback(true);
    }


    /**
     * 清理特殊商品促销信息
     */
    public function clearSpecialGoodsPromotion($param)
    {
        // 抢购
        model('groupbuy')->delGroupbuy(array('goods_commonid' => $param['goods_commonid']));
        // 显示折扣
        model('pxianshigoods')->delXianshigoods(array('goods_id' => array('in', $param['goodsid_array'])));
        // 优惠套装
        model('pbundling')->delBundlingGoods(array('goods_id' => array('in', $param['goodsid_array'])));
        // 更新促销价格
        model('goods')->editGoods(array('goods_promotion_price' => Db::raw('goods_price'),'goods_promotion_type' => 0), array('goods_commonid' => $param['goods_commonid']));
        return ds_callback(true);
    }

    /**
     * 删除(买/卖家)订单全部数量缓存
     * @param array $data 订单信息
     * @return boolean
     */
    public function delOrderCountCache($order_info)
    {
        if (empty($order_info))
            return ds_callback(true);
        $order_model = model('order');
        if (isset($order_info['order_id'])) {
            $order_info = $order_model->getOrderInfo(array('order_id' => $order_info['order_id']), array(), 'buyer_id,store_id');
        }
        if(isset($order_info['buyer_id'])) {
            $order_model->delOrderCountCache('buyer', $order_info['buyer_id']);
        }
        if (isset($order_info['store_id'])) {
            $order_model->delOrderCountCache('store', $order_info['store_id']);
        }
        return ds_callback(true);
    }

    /**
     * 发送兑换码
     * @param unknown $param
     * @return boolean
     */
    public function sendVrCode($param)
    {
        if (empty($param) && !is_array($param))
            return ds_callback(true);
        $condition = array();
        $condition['order_id'] = $param['order_id'];
        $condition['buyer_id'] = $param['buyer_id'];
        $condition['vr_state'] = 0;
        $condition['refund_lock'] = 0;
        $code_list = model('vrorder')->getShowVrordercodeList($condition, 'vr_code,vr_indate');
        if (empty($code_list))
            return ds_callback(true);

        $content = '';
        foreach ($code_list as $v) {
            $content .= $v['vr_code'] . ',';
        }

        $tpl_info = model('mailtemplates')->getTplInfo(array('mailmt_code' => 'send_vr_code'));
        $data = array();
        $data['site_name'] = config('site_name');
        $data['vr_code'] = rtrim($content, ',');
        $message = ds_replace_text($tpl_info['mailmt_content'], $data);
        $sms = new \sendmsg\Sms();
        $result = $sms->send($param["buyer_phone"], $message);
        if (!$result) {
            return ds_callback(false, '兑换码发送失败order_id:' . $param['order_id']);
        }
        else {
            return ds_callback(true);
        }
    }

    /**
     * 添加订单自提表内容
     */
    public function saveDeliveryOrder($param)
    {
        if (!is_array($param['order_sn_list']))
            return ds_callback(true);
        $data = array();
        $deliveryorder_model = model('deliveryorder');
        foreach ($param['order_sn_list'] as $order_id => $v) {
            $data['order_id'] = $order_id;
            $data['order_sn'] = $v['order_sn'];
            $data['dlyo_addtime'] = $v['add_time'];
            $data['dlyp_id'] = $param['dlyp_id'];
            $data['reciver_name'] = $param['reciver_name'];
            $data['reciver_telphone'] = $param['tel_phone'];
            $data['reciver_mobphone'] = $param['mob_phone'];
            $insert = $deliveryorder_model->addDeliveryorder($data);
            if (!$insert) {
                return ds_callback(false, '保存自提站订单信息失败order_sn:' . $v['order_sn']);
            }
        }
        return ds_callback(true);
    }

    /**
     * 发送提货码短信消息
     */
    public function sendPickupcode($param)
    {
        $dorder_info = model('deliveryorder')->getDeliveryorderInfo(array('order_id' => $param['order_id']), 'reciver_mobphone');
        $tpl_info = model('mailtemplates')->getTplInfo(array('mailmt_code' => 'send_pickup_code'));
        $data = array();
        $data['site_name'] = config('site_name');
        $data['pickup_code'] = $param['pickup_code'];
        $message = ds_replace_text($tpl_info['mailmt_content'], $data);
        $sms = new \sendmsg\Sms();
        $result = $sms->send($dorder_info['reciver_mobphone'], $message);
        if (!$result) {
            return ds_callback(false, '发送提货码短信消息失败order_id:' . $param['order_id']);
        }
        else {
            return ds_callback(true);
        }
    }

    /**
     * 刷新搜索索引
     */
    public function flushIndexer()
    {
        require_once(EXTEND_PATH . 'xs/lib/XS.php');
        $obj_doc = new \XSDocument();
        $obj_xs = new \XS(config('fullindexer.appname'));
        $obj_xs->index->flushIndex();
    }

    /**
     * 生成卡密代金券
     */
    public function build_pwdvoucher($t_id)
    {
        $t_id = intval($t_id);
        if ($t_id <= 0) {
            return ds_callback(false, '参数错误');
        }
        $voucher_model = model('voucher');
        //查询代金券详情
        $where = array();
        $where['vouchertemplate_id'] = $t_id;
        $gettype_arr = $voucher_model->getVoucherGettypeArray();
        $where['vouchertemplate_gettype'] = $gettype_arr['pwd']['sign'];
        $where['vouchertemplate_isbuild'] = 0;
        $where['vouchertemplate_state'] = 1;
        $t_info = $voucher_model->getVouchertemplateInfo($where);
        $t_total = intval($t_info['vouchertemplate_total']);
        if ($t_total <= 0) {
            return ds_callback(false, '代金券模板信息错误');
        }
        while ($t_total > 0) {
            $is_succ = false;
            $insert_arr = array();
            $step = $t_total > 1000 ? 1000 : $t_total;
            for ($t = 0; $t < $step; $t++) {
                $voucher_code = $voucher_model->getVoucherCode(0);
                if (!$voucher_code) {
                    continue;
                }
                $voucher_pwd_arr = $voucher_model->createVoucherPwd($t_info['vouchertemplate_id']);
                if (!$voucher_pwd_arr) {
                    continue;
                }
                $tmp = array();
                $tmp['voucher_code'] = $voucher_code;
                $tmp['vouchertemplate_id'] = $t_info['vouchertemplate_id'];
                $tmp['voucher_title'] = $t_info['vouchertemplate_title'];
                $tmp['voucher_desc'] = $t_info['vouchertemplate_desc'];
                $tmp['voucher_startdate'] = $t_info['vouchertemplate_startdate'];
                $tmp['voucher_enddate'] = $t_info['vouchertemplate_enddate'];
                $tmp['voucher_price'] = $t_info['vouchertemplate_price'];
                $tmp['voucher_limit'] = $t_info['vouchertemplate_limit'];
                $tmp['voucher_store_id'] = $t_info['vouchertemplate_store_id'];
                $tmp['voucher_state'] = 1;
                $tmp['voucher_activedate'] = time();
                $tmp['voucher_owner_id'] = 0;
                $tmp['voucher_owner_name'] = '';
                $tmp['voucher_order_id'] = 0;
                $tmp['voucher_pwd'] = $voucher_pwd_arr[0];//md5
                $tmp['voucher_pwd2'] = $voucher_pwd_arr[1];
                $insert_arr[] = $tmp;
                $t_total--;
            }

            $result = $voucher_model->addVoucherBatch($insert_arr);
            if ($result && $is_succ == false) {
                $is_succ = true;
            }
        }
        //更新代金券模板
        if ($is_succ) {
            $voucher_model->editVouchertemplate(array('vouchertemplate_id' => $t_info['vouchertemplate_id']), array('vouchertemplate_isbuild' => 1));
            return ds_callback(true);
        }
        else {
            return ds_callback(false);
        }
    }

}