<?php

namespace app\home\controller;

use think\Lang;

class Buy extends BaseMember {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/buy.lang.php');
        //验证该会员是否禁止购买
        if(!session('is_buy')){
            $this->error(lang('cart_buy_noallow'));
        }
    }

    public function buy_step1() {
        if(empty(input('post.'))){
            $this->error(lang('wrong_argument'));
        }
        //虚拟商品购买分流
        $this->_buy_branch(input('post.'));
        $ifcart = input('post.ifcart');

        $buy_logic = model('buy','logic');
        $result = $buy_logic->buyStep1(input('post.cart_id/a'), $ifcart, session('member_id'), session('store_id'));
        if ($result['code'] != 'SUCCESS') {
            $this->error($result['msg']);
        } else {
            $result = $result['data'];
        }
        
        //商品金额计算(分别对每个商品/优惠套装小计、每个店铺小计)
        $this->assign('store_cart_list', $result['store_cart_list']);
        $this->assign('store_goods_total', $result['store_goods_total']);

        //取得店铺优惠 - 满即送(赠品列表，店铺满送规则列表)
        $this->assign('store_premiums_list', $result['store_premiums_list']);
        $this->assign('store_mansong_rule_list', $result['store_mansong_rule_list']);

        //返回店铺可用的代金券
        $this->assign('store_voucher_list', $result['store_voucher_list']);

        //返回需要计算运费的店铺ID数组 和 不需要计算运费(满免运费活动的)店铺ID及描述
        $this->assign('need_calc_sid_list', $result['need_calc_sid_list']);
        $this->assign('cancel_calc_sid_list', $result['cancel_calc_sid_list']);

        //将商品ID、数量、售卖区域、运费序列化，加密，输出到模板，选择地区AJAX计算运费时作为参数使用
        $this->assign('freight_hash', $result['freight_list']);

        //输出用户默认收货地址
        $this->assign('address_info', $result['address_info']);

        //输出有货到付款时，在线支付和货到付款及每种支付下商品数量和详细列表
        $this->assign('pay_goods_list', $result['pay_goods_list']);
        $this->assign('ifshow_offpay', $result['ifshow_offpay']);
        $this->assign('deny_edit_payment', isset($result['deny_edit_payment'])?$result['deny_edit_payment']:0);
        //不提供增值税发票时抛出true(模板使用)
        $this->assign('vat_deny', $result['vat_deny']);
        
        //增值税发票哈希值(php验证使用)
        $this->assign('vat_hash', $result['vat_hash']);

        //输出默认使用的发票信息
        $this->assign('inv_info', $result['inv_info']);

        //显示预存款、支付密码、充值卡
        $this->assign('available_pd_amount', isset($result['available_predeposit'])?$result['available_predeposit']:'');
        $this->assign('member_paypwd', $result['member_paypwd']);
        $this->assign('available_rcb_amount', isset($result['available_rc_balance'])?$result['available_rc_balance']:'');

        //标识购买流程执行步骤
        $this->assign('buy_step', 'step2');
        $this->assign('ifcart', $ifcart);
        //店铺信息
        $store_list = model('store')->getStoreMemberIDList(array_keys($result['store_cart_list']));
        $this->assign('store_list', $store_list);
        $this->assign('baidu_ak', config('baidu_ak'));
        return $this->fetch($this->template_dir.'buy_step1');
    }

    /**
     * 生成订单
     *
     */
    public function buy_step2() {
        $buy_logic = model('buy','logic');
        $result = $buy_logic->buyStep2(input('post.'), session('member_id'), session('member_name'), session('member_email'));
        if (!$result['code']) {
            $this->error($result['msg']);
        }
        //转向到商城支付页面
        $this->redirect('Buy/pay', ['pay_sn' => $result['data']['pay_sn']]);
    }

    /**
     * 下单时支付页面
     */
    public function pay() {
        $pay_sn = input('param.pay_sn');
        if (!preg_match('/^\d{20}$/', $pay_sn)) {
            $this->error(lang('cart_order_pay_not_exists'), 'Home/Memberorder/index');
        }

        //查询支付单信息
        $order_model = model('order');
        $pay_info = $order_model->getOrderpayInfo(array('pay_sn' => $pay_sn, 'buyer_id' => session('member_id')), true);
        if (empty($pay_info)) {
            $this->error(lang('cart_order_pay_not_exists'), 'Home/Memberorder/index');
        }
        $this->assign('pay_info', $pay_info);

        //取子订单列表
        $condition = array();
        $condition['pay_sn'] = $pay_sn;
        $condition['order_state'] = array('in', array_values(array(ORDER_STATE_NEW, ORDER_STATE_PAY)));
        $order_list = $order_model->getOrderList($condition, '', 'order_id,order_state,payment_code,order_amount,rcb_amount,pd_amount,order_sn', '', '', array(), true);
        if (empty($order_list)) {
            $this->error(lang('no_order_paid_was_found'), 'Home/Memberorder/index');
        }

        //重新计算在线支付金额
        $pay_amount_online = 0;
        $pay_amount_offline = 0;
        //订单总支付金额(不包含货到付款)
        $pay_amount = 0;

        foreach ($order_list as $key => $order_info) {

            $payed_amount = floatval($order_info['rcb_amount']) + floatval($order_info['pd_amount']);
            //计算相关支付金额
            if ($order_info['payment_code'] != 'offline') {
                if ($order_info['order_state'] == ORDER_STATE_NEW) {
                    $pay_amount_online += ds_price_format(floatval($order_info['order_amount']) - $payed_amount);
                }
                $pay_amount += floatval($order_info['order_amount']);
            } else {
                $pay_amount_offline += floatval($order_info['order_amount']);
            }

            //显示支付方式与支付结果
            if ($order_info['payment_code'] == 'offline') {
                $order_list[$key]['payment_state'] = lang('cart_step2_arrival_pay');
            } else {
                $order_list[$key]['payment_state'] = lang('cart_step2_online_pay');
                if ($payed_amount > 0) {
                    $payed_tips = '';
                    if (floatval($order_info['rcb_amount']) > 0) {
                        $payed_tips = lang('card_has_been_paid').'：￥' . $order_info['rcb_amount'];
                    }
                    if (floatval($order_info['pd_amount']) > 0) {
                        $payed_tips .= lang('prepaid_deposits_beenpaid').'：￥' . $order_info['pd_amount'];
                    }
                    $order_list[$key]['order_amount'] .= " ( {$payed_tips} )";
                }
            }
        }
        $this->assign('order_list', $order_list);

        //如果线上线下支付金额都为0，转到支付成功页
        if (empty($pay_amount_online) && empty($pay_amount_offline)) {
            $this->redirect('Buy/pay_ok', ['pay_sn' => $pay_sn, 'pay_amount' => ds_price_format($pay_amount)]);
        }

        //输出订单描述
        if (empty($pay_amount_online)) {
            $order_remind = lang('successful_ordering_delivery');
        } elseif (empty($pay_amount_offline)) {
            $order_remind = lang('timely_payment');
        } else {
            $order_remind = lang('payment_soon_possible');
        }
        $this->assign('order_remind', $order_remind);
        $this->assign('pay_amount_online', ds_price_format($pay_amount_online));
//        $this->assign('pd_amount', ds_price_format($pd_amount));
        //显示支付接口列表
        if ($pay_amount_online > 0) {
            $payment_model = model('payment');
            $condition = array();
            $condition['payment_platform'] = 'pc';
            $payment_list = $payment_model->getPaymentOpenList($condition);
            if(empty($payment_list)){
                $this->error(lang('appropriate_payment_method'),'Home/Memberorder/index');
            }
            foreach ($payment_list as $key => $payment) {
                if(in_array($payment['payment_code'], array('predeposit','offline'))){
                    unset($payment_list[$key]);
                }
            }
            $this->assign('payment_list', $payment_list);
        }

        //标识 购买流程执行第几步
        $this->assign('buy_step', 'step3');
        return $this->fetch($this->template_dir.'buy_step2');
    }

    /**
     * 预存款充值下单时支付页面
     */
    public function pd_pay() {
        $pay_sn = input('param.pay_sn');
        if (!preg_match('/^\d{20}$/', $pay_sn)) {
            $this->error(lang('param_error'), url('Predeposit/index'));
        }

        //查询支付单信息
        $predeposit_model = model('predeposit');
        $pd_info = $predeposit_model->getPdRechargeInfo(array('pdr_sn' => $pay_sn, 'pdr_member_id' => session('member_id')));
        if (empty($pd_info)) {
            $this->error(lang('param_error'));
        }
        if (intval($pd_info['pdr_payment_state'])) {
            $this->error(lang('not_repeat_payment'), url('Predeposit/index'));
        }
        $this->assign('pdr_info', $pd_info);

        //显示支付接口列表
        $payment_model = model('payment');
        $condition = array();
        $condition['payment_code'] = array('not in', array('offline', 'predeposit'));
        $condition['payment_state'] = 1;
        $condition['payment_platform'] = 'pc';
        $payment_list = $payment_model->getPaymentList($condition);
        if (empty($payment_list)) {
            $this->error(lang('appropriate_payment_method'), url('Predeposit/index'));
        }
        $this->assign('payment_list', $payment_list);

        //标识 购买流程执行第几步
        $this->assign('buy_step', 'step3');
        return $this->fetch($this->template_dir.'predeposit_pay');
    }

    /**
     * 支付成功页面
     */
    public function pay_ok() {
        $pay_sn = input('param.pay_sn');
        if (!preg_match('/^\d{20}$/', $pay_sn)) {
            $this->error(lang('cart_order_pay_not_exists'), 'memberorder/index');
        }

        //查询支付单信息
        $order_model = model('order');
        $pay_info = $order_model->getOrderpayInfo(array('pay_sn' => $pay_sn, 'buyer_id' => session('member_id')));
        if (empty($pay_info)) {
            $this->error(lang('cart_order_pay_not_exists'), 'Home/Memberorder/index');
        }
        $this->assign('pay_info', $pay_info);

        $this->assign('buy_step', 'step4');
        return $this->fetch($this->template_dir.'buy_step3');
    }

    function load_addr() {
        $id = intval(input('param.id'));
        $address_model=model('address');
        //如果传入ID 则删除再查询
        if ($id > 0) {
            $address_model->delAddress(array('address_id'=>$id,'member_id'=> session('member_id')));
        }
        $address_list = $address_model->getAddressList(array('member_id'=>session('member_id')));
        $this->assign('address_list', $address_list);
        echo $this->fetch($this->template_dir.'buy_address_load');
    }

    /*
     * 新增收货地址
     */

    function add_addr() {
        if (!request()->isPost()) {
            //设置类型关联的分类
            $area_mod=model('area');
            $region_list = $area_mod->getAreaList(array('area_parent_id'=>'0'));
            $this->assign('region_list', $region_list);

            echo $this->fetch($this->template_dir.'buy_address_add');
        } else {
            $data = array(
                'member_id' => session('member_id'),
                'address_realname' => input('post.true_name'),
                'area_id' => intval(input('post.area_id')),
                'city_id' => intval(input('post.city_id')),
                'area_info'=>input('post.area_info'),
                'address_detail' => input('post.address'),
                'address_tel_phone' => input('post.tel_phone'),
                'address_mob_phone' => input('post.mob_phone'),
                'address_longitude' => input('post.longitude'),
                'address_latitude' => input('post.latitude'),
                'address_is_default' => 0,
            );
            $buy_validate = validate('buy');
            if (!$buy_validate->scene('add_addr')->check($data)) {
                exit(json_encode(array('state' => false, 'msg' => $buy_validate->getError())));
            }

            $insert_id = model('address')->addAddress($data);
            if ($insert_id) {
                exit(json_encode(array('state' => true, 'addr_id' => $insert_id)));
            } else {
                exit(json_encode(array('state' => true, 'msg' => lang('add_cart_failed'))));
            }
        }
    }

    /**
     * 选择不同地区时，异步处理并返回每个店铺总运费以及本地区是否能使用货到付款
     * 如果店铺统一设置了满免运费规则，则售卖区域无效
     * 如果店铺未设置满免规则，且使用售卖区域，按售卖区域计算，如果其中有商品使用相同的售卖区域，则两种商品数量相加后再应用该售卖区域计算（即作为一种商品算运费）
     * 如果未找到售卖区域，按免运费处理
     * 如果没有使用售卖区域，商品运费按快递价格计算，运费不随购买数量增加
     */
    public function change_addr() {
        $buy_logic = model('buy','logic');

        $data = $buy_logic->changeAddr(input('post.freight_hash'), input('post.city_id'), input('post.area_id'), session('member_id'));
        if (!empty($data)) {
            exit(json_encode($data));
        } else {
            exit();
        }
    }

    function load_inv() {
        $id = intval(input('param.id'));
        $invoice_model = model('invoice');
        //如果传入ID 则删除再查询
        if ($id > 0) {
            $condition['invoice_id'] = $id;
            $condition['member_id'] = session('member_id');
            $invoice_model->delInvoice($condition);
        }
        $inv_list = $invoice_model->getInvoiceList(array('member_id'=> session('member_id')));
        if (!empty($inv_list)) {
            foreach ($inv_list as $key => $value) {
                if ($value['invoice_state'] == 1) {
                    $inv_list[$key]['content'] = lang('commercial_invoice') . ' ' . $value['invoice_title'] . ' ' . $value['invoice_code']. ' ' . $value['invoice_content'];
                } else {
                    $inv_list[$key]['content'] = lang('vat_invoice') . ' ' . $value['invoice_company'] . ' ' . $value['invoice_company_code'] . ' ' . $value['invoice_reg_addr'];
                }
            }
        }
        $this->assign('inv_list', $inv_list);
        echo $this->fetch($this->template_dir.'buy_invoice_load');
    }

    function add_inv() {
        if (!request()->isPost()) {
            echo $this->fetch($this->template_dir.'buy_address_add');
        } else {
            $invoice_type = input('post.invoice_type');
            //如果是增值税发票验证表单信息
            if ($invoice_type == 2) {
                if (empty(input('post.invoice_company')) || empty(input('post.invoice_company_code')) || empty(input('post.invoice_reg_addr'))) {
                    exit(json_encode(array('state' => false, 'msg' => lang('save_information_failed'))));
                }
            }
            $data = array();
            if ($invoice_type == 1) {
                $data['invoice_state'] = 1;
                $data['invoice_title'] = input('post.invoice_title_select') == 'person' ? lang('individual') : input('post.invoice_title');
                $data['invoice_content'] = input('post.invoice_content');
                $data['invoice_code'] = input('post.invoice_code');
            } else {
                $data['invoice_state'] = 2;
                $data['invoice_company'] = input('post.invoice_company');
                $data['invoice_company_code'] = input('post.invoice_company_code');
                $data['invoice_reg_addr'] = input('post.invoice_reg_addr');
                $data['invoice_reg_phone'] = input('post.invoice_reg_phone');
                $data['invoice_reg_bname'] = input('post.invoice_reg_bname');
                $data['invoice_reg_baccount'] = input('post.invoice_reg_baccount');
                $data['invoice_rec_name'] = input('post.invoice_rec_name');
                $data['invoice_rec_mobphone'] = input('post.invoice_rec_mobphone');
                $data['invoice_rec_province'] = input('post.area_info');
                $data['invoice_goto_addr'] = input('post.invoice_goto_addr');
            }
            $data['member_id'] = session('member_id');
            $insert_id = model('invoice')->addInvoice($data);
            if ($insert_id) {
                exit(json_encode(array('state' => 'success', 'id' => $insert_id)));
            } else {
                exit(json_encode(array('state' => 'fail', 'msg' => lang('save_information_failed'))));
            }
        }
    }

    /**
     * AJAX验证支付密码
     */
    public function check_pd_pwd() {
        $password = input('param.password');
        if (empty($password))
            exit('0');
        $buyer_info = model('member')->getMemberInfoByID(session('member_id'));
        echo ($buyer_info['member_paypwd'] != '' && $buyer_info['member_paypwd'] === md5($password)) ? '1' : '0';
    }
    /**
     * F码验证
     */
    public function check_fcode() {
        $result = model('buy','logic')->checkFcode(input('goods_commonid'), input('fcode'));
        echo $result['code'] ? '1' : '0';
        exit;
    }
    /**
     * 得到所购买的id和数量
     *
     */
    private function _parseItems($cart_id) {
        //存放所购商品ID和数量组成的键值对
        $buy_items = array();
        if (is_array($cart_id)) {
            foreach ($cart_id as $value) {
                if (preg_match_all('/^(\d{1,10})\|(\d{1,6})$/', $value, $match)) {
                    $buy_items[$match[1][0]] = $match[2][0];
                }
            }
        }
        return $buy_items;
    }

    /**
     * 购买分流
     */
    private function _buy_branch($post) {
        if (!isset($post['ifcart'])) {
            //取得购买商品信息
            $buy_items = $this->_parseItems($post['cart_id']);
            $goods_id = key($buy_items);
            $quantity = current($buy_items);

            $goods_info = model('goods')->getGoodsOnlineInfoAndPromotionById($goods_id);
            if ($goods_info['is_virtual']) {
                $this->redirect('Buyvirtual/buy_step1',['goods_id'=>$goods_id,'quantity'=>$quantity]);
            }
        }
    }

}