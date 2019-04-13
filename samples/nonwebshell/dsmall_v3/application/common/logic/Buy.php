<?php

namespace app\common\logic;
use think\Model;

class Buy extends Model
{
    /**
     * 会员信息
     * @var array
     */
    private $_member_info = array();

    /**
     * 下单数据
     * @var array
     */
    private $_order_data = array();

    /**
     * 表单数据
     * @var array
     */
    private $_post_data = array();

    /**
     * buy_1.logic 对象
     * @var obj
     */
    private $_logic_buy_1;

    public function __construct()
    {
        $this->_logic_buy_1 = model('buy_1','logic');
    }

    /**
     * 购买第一步
     * @param type $cart_id
     * @param type $ifcart
     * @param type $member_id
     * @param type $store_id
     * @param type $extra  额外特殊判断处理数据，比如拼团功能  
     * @return type
     */
    public function buyStep1($cart_id, $ifcart, $member_id, $store_id,$extra=array())
    {

        //得到购买商品信息
        if ($ifcart) {
            $result = $this->getCartList($cart_id, $member_id);
        }
        else {
            $result = $this->getGoodsList($cart_id, $member_id, $store_id,$extra);
        }

        if (!$result['code']) {
            return $result;
        }

        //得到页面所需要数据：收货地址、发票、代金券、预存款、商品列表等信息
        $result = $this->getBuyStep1Data($member_id, $result['data']);
        return $result;
    }

    /**
     * 第一步：处理购物车
     * @param type $cart_id 购物车
     * @param type $member_id 会员编号
     * @param type $extra 额外特殊判断处理数据，比如拼团功能  
     * @return type
     */
    public function getCartList($cart_id, $member_id,$extra=array())
    {
        $cart_model = model('cart');

        //取得POST ID和购买数量
        $buy_items = $this->_parseItems($cart_id);
        if (empty($buy_items)) {
            return ds_callback(false, '所购商品无效');
        }

        if (count($buy_items) > 50) {
            return ds_callback(false, '一次最多只可购买50种商品');
        }

        //购物车列表
        $condition = array('cart_id' => array('in', array_keys($buy_items)), 'buyer_id' => $member_id);
        $cart_list = $cart_model->getCartList('db', $condition);

        //购物车列表 [得到最新商品属性及促销信息]
        $cart_list = $this->_logic_buy_1->getGoodsCartList($cart_list);

        //商品列表 [优惠套装子商品与普通商品同级罗列]
        $goods_list = $this->_getGoodsList($cart_list);

        //以店铺下标归类
        $store_cart_list = $this->_getStoreCartList($cart_list);

        return ds_callback(true, '', array('goods_list' => $goods_list, 'store_cart_list' => $store_cart_list));

    }
    /**
     * 第一步：处理立即购买
     * @param type $cart_id 购物车
     * @param type $member_id 会员编号
     * @param type $store_id 店铺编号
     * @param type $extra 额外特殊判断处理数据，比如拼团功能  
     * @return type
     */
    public function getGoodsList($cart_id, $member_id, $store_id,$extra=array())
    {

        //取得POST ID和购买数量
        $buy_items = $this->_parseItems($cart_id);
        if (empty($buy_items)) {
            return ds_callback(false, '所购商品无效');
        }

        $goods_id = key($buy_items);
        $quantity = current($buy_items);

        //商品信息[得到最新商品属性及促销信息]
        $goods_info = $this->_logic_buy_1->getGoodsOnlineInfo($goods_id, intval($quantity),$extra);
        if (empty($goods_info)) {
            return ds_callback(false, '商品已下架或不存在');
        }

        //不能购买自己店铺的商品
        if ($goods_info['store_id'] == $store_id) {
            return ds_callback(false, '不能购买自己店铺的商品');
        }

        //进一步处理数组
        $store_cart_list = array();
        $goods_list = array();
        $goods_list[0] = $store_cart_list[$goods_info['store_id']][0] = $goods_info;

        return ds_callback(true, '', array('goods_list' => $goods_list, 'store_cart_list' => $store_cart_list));
    }

    /**
     * 购买第一步：返回商品、促销、地址、发票等信息，然后交前台抛出
     * @param unknown $member_id
     * @param unknown $data 商品信息
     * @return
     */
    public function getBuyStep1Data($member_id, $data)
    {
        //list($goods_list, $store_cart_list) = $data;
        $goods_list = $data['goods_list'];
        $store_cart_list = $data['store_cart_list'];

        //定义返回数组
        $result = array();

        //商品金额计算(分别对每个商品/优惠套装小计、每个店铺小计)
        list($store_cart_list, $store_goods_total) = $this->_logic_buy_1->calcCartList($store_cart_list);
        $result['store_cart_list'] = $store_cart_list;
        $result['store_goods_total'] = $store_goods_total;

        //取得店铺优惠 - 满即送(赠品列表，店铺满送规则列表)
        list($store_premiums_list, $store_mansong_rule_list) = $this->_logic_buy_1->getMansongruleCartListByTotal($store_goods_total);
        $result['store_premiums_list'] = $store_premiums_list;
        $result['store_mansong_rule_list'] = $store_mansong_rule_list;

        //重新计算优惠后(满即送)的店铺实际商品总金额
        $store_goods_total = $this->_logic_buy_1->reCalcGoodsTotal($store_goods_total, $store_mansong_rule_list, 'mansong');

        //返回店铺可用的代金券
        $store_voucher_list = $this->_logic_buy_1->getStoreAvailableVoucherList($store_goods_total, $member_id);
        $result['store_voucher_list'] = $store_voucher_list;

        //返回需要计算运费的店铺ID数组 和 不需要计算运费(满免运费活动的)店铺ID及描述
        list($need_calc_sid_list, $cancel_calc_sid_list) = $this->_logic_buy_1->getStoreFreightDescList($store_goods_total);
        $result['need_calc_sid_list'] = $need_calc_sid_list;
        $result['cancel_calc_sid_list'] = $cancel_calc_sid_list;

        //将商品ID、数量、售卖区域、运费序列化，加密，输出到模板，选择地区AJAX计算运费时作为参数使用
        $freight_list = $this->_logic_buy_1->getStoreFreightList($goods_list, array_keys($cancel_calc_sid_list));
        $result['freight_list'] = $this->buyEncrypt($freight_list, $member_id);

        //输出用户默认收货地址
        $result['address_info'] = model('address')->getDefaultAddressInfo(array('member_id' => $member_id));

        //输出有货到付款时，在线支付和货到付款及每种支付下商品数量和详细列表
        $pay_goods_list = $this->_logic_buy_1->getOfflineGoodsPay($goods_list);
        if (!empty($pay_goods_list['offline'])) {
            $result['pay_goods_list'] = $pay_goods_list;
            $result['ifshow_offpay'] = true;
        }
        else {
            //如果所购商品只支持线上支付，支付方式不允许修改
            $result['deny_edit_payment'] = true;
            $result['pay_goods_list'] = $pay_goods_list;
            $result['ifshow_offpay'] = FALSE;
        }

        //发票 :只有所有商品都支持增值税发票才提供增值税发票
        $vat_deny=false;
        foreach ($goods_list as $goods) {
            if (!intval($goods['goods_vat'])) {
                $vat_deny = true;
                break;
            }
        }
        //不提供增值税发票时抛出true(模板使用)
        $result['vat_deny'] = $vat_deny;
        $result['vat_hash'] = $this->buyEncrypt($result['vat_deny'] ? 'deny_vat' : 'allow_vat', $member_id);

        //输出默认使用的发票信息
        $inv_info = model('invoice')->getDefaultInvoiceInfo(array('member_id' => $member_id));
        if ($inv_info['invoice_state'] == '2' && !$vat_deny) {
            $inv_info['content'] = '增值税发票 ' . $inv_info['invoice_company'] . ' ' . $inv_info['invoice_company_code'] . ' ' . $inv_info['invoice_reg_addr'];
        }
        elseif ($inv_info['invoice_state'] == '2' && $vat_deny) {
            $inv_info = array();
            $inv_info['content'] = '不需要发票';
        }
        elseif (!empty($inv_info)) {
            $inv_info['content'] = '普通发票 ' . $inv_info['invoice_title'] . ' ' . $inv_info['invoice_code']. ' ' . $inv_info['invoice_content'];
        }
        else {
            $inv_info = array();
            $inv_info['content'] = '不需要发票';
        }
        $result['inv_info'] = $inv_info;

        $buyer_info = model('member')->getMemberInfoByID($member_id);
        if (floatval($buyer_info['available_predeposit']) > 0) {
            $result['available_predeposit'] = $buyer_info['available_predeposit'];
        }
        if (floatval($buyer_info['available_rc_balance']) > 0) {
            $result['available_rc_balance'] = $buyer_info['available_rc_balance'];
        }
        $result['member_paypwd'] = $buyer_info['member_paypwd'] ? true : false;

        return ds_callback(true, '', $result);
    }

    /**
     * 购买第二步
     * @param array $post
     * @param int $member_id
     * @param string $member_name
     * @param string $member_email
     * @return array
     */
    public function buyStep2($post, $member_id, $member_name, $member_email)
    {

        $this->_member_info['member_id'] = $member_id;
        $this->_member_info['member_name'] = $member_name;
        $this->_member_info['member_email'] = $member_email;
        $this->_post_data = $post;

        try {

            $order_model = model('order');
            $order_model->startTrans();

            //第1步 表单验证
            $this->_createOrderStep1();

            //第2步 得到购买商品信息
            $this->_createOrderStep2();

            //第3步 得到购买相关金额计算等信息
            $this->_createOrderStep3();

            //第4步 生成订单
            $this->_createOrderStep4();

            //第5步 处理预存款
            $this->_createOrderStep5();
            $order_model->commit();

            //第6步 订单后续处理
            $this->_createOrderStep6();
            
            return ds_callback(true, '', $this->_order_data);

        } catch (\think\Exception $e) {
            $this->rollback();
            return ds_callback(false, $e->getMessage());
        }

    }
    /**
     * 生成推广记录
     * @param array $order_list
     */
    public function addOrderInviter($order_list = array()) {
        if(!config('inviter_open')){
            return;
        }
        if (empty($order_list) || !is_array($order_list))
            return;
        $inviter_ratio_1=config('inviter_ratio_1');
        $inviter_ratio_2=config('inviter_ratio_2');
        $inviter_ratio_3=config('inviter_ratio_3');
        $orderinviter_model = model('orderinviter');
        foreach ($order_list as $order_id => $order) {
            foreach($order['order_goods'] as $goods){
                //查询商品的分销信息
                $goods_common_info=db('goodscommon')->alias('gc')->join('__GOODS__ g','g.goods_commonid=gc.goods_commonid')->where('g.goods_id='.$goods['goods_id'])->field('gc.goods_commonid,gc.inviter_open,gc.inviter_ratio_1,gc.inviter_ratio_2,gc.inviter_ratio_3')->find();
                if(!$goods_common_info['inviter_open']){
                    continue;
                }
            $goods_amount=$goods['goods_price']*$goods['goods_num'];
            $inviter_ratios=array(
                ($goods_common_info['inviter_ratio_1']>$inviter_ratio_1?$inviter_ratio_1:$goods_common_info['inviter_ratio_1']),
                ($goods_common_info['inviter_ratio_2']>$inviter_ratio_2?$inviter_ratio_2:$goods_common_info['inviter_ratio_2']),
                ($goods_common_info['inviter_ratio_3']>$inviter_ratio_3?$inviter_ratio_3:$goods_common_info['inviter_ratio_3']),
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
                                        'orderinviter_order_type' => 0,
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
            $inviter_1_id=db('member')->where('member_id',$order['buyer_id'])->value('inviter_id');
            if(!$inviter_1_id || !db('inviter')->where('inviter_state=1 AND inviter_id='.$inviter_1_id)->value('inviter_id')){
                continue;
            }
            
            
            $inviter_1=db('member')->where('member_id',$inviter_1_id)->field('inviter_id,member_id,member_name')->find();
            if($inviter_1 && isset($inviter_ratios[0]) && floatval($inviter_ratios[0])>0){
                $money_1=round($inviter_ratios[0]/100*$goods_amount,2);
                if($money_1>0){
              
                        //生成推广记录
                        db('orderinviter')->insert(array(
                            'orderinviter_addtime' => TIMESTAMP,
                            'orderinviter_store_name' => $order['store_name'],
                            'orderinviter_goods_amount'=>$goods_amount,
                            'orderinviter_goods_quantity'=>$goods['goods_num'],
                            'orderinviter_order_type'=>0,
                            'orderinviter_store_id'=>$goods['store_id'],
                            'orderinviter_goods_commonid'=>$goods_common_info['goods_commonid'],
                            'orderinviter_goods_id'=>$goods['goods_id'],
                            'orderinviter_level'=>1,
                            'orderinviter_goods_name'=>$goods['goods_name'],
                            'orderinviter_order_id'=>$order_id,
                            'orderinviter_order_sn'=>$order['order_sn'],
                            'orderinviter_member_id'=>$inviter_1['member_id'],
                            'orderinviter_member_name'=>$inviter_1['member_name'],
                            'orderinviter_money'=>$money_1,
                            'orderinviter_remark'=>'获得一级推荐佣金，佣金比例'.$inviter_ratios[0].'%，推荐关系'.$inviter_1['member_name'].'->'.$order['buyer_name'].'，订单号'.$order['order_sn'],
                        ));
            
                }
            }
            if(config('inviter_level')<=1){
                continue;
            }
            //二级推荐人
            $inviter_2_id=db('member')->where('member_id',$inviter_1_id)->value('inviter_id');
            if(!$inviter_2_id || !db('inviter')->where('inviter_state=1 AND inviter_id='.$inviter_2_id)->value('inviter_id')){
                continue;
            }
            $inviter_2=db('member')->where('member_id',$inviter_2_id)->field('inviter_id,member_id,member_name')->find();
            if($inviter_2 && isset($inviter_ratios[1]) && floatval($inviter_ratios[1])>0){
                $money_2=round($inviter_ratios[1]/100*$goods_amount,2);
                if($money_2>0){
               
                        //生成推广记录
                        db('orderinviter')->insert(array(
                            'orderinviter_addtime' => TIMESTAMP,
                            'orderinviter_store_name' => $order['store_name'],
                            'orderinviter_goods_amount'=>$goods_amount,
                            'orderinviter_goods_quantity'=>$goods['goods_num'],
                            'orderinviter_order_type'=>0,
                            'orderinviter_store_id'=>$goods['store_id'],
                            'orderinviter_goods_commonid'=>$goods_common_info['goods_commonid'],
                            'orderinviter_goods_id'=>$goods['goods_id'],
                            'orderinviter_level'=>2,
                            'orderinviter_goods_name'=>$goods['goods_name'],
                            'orderinviter_order_id'=>$order_id,
                            'orderinviter_order_sn'=>$order['order_sn'],
                            'orderinviter_member_id'=>$inviter_2['member_id'],
                            'orderinviter_member_name'=>$inviter_2['member_name'],
                            'orderinviter_money'=>$money_2,
                            'orderinviter_remark'=>'获得二级推荐佣金，佣金比例'.$inviter_ratios[1].'%，推荐关系'.$inviter_2['member_name'].'->'.$inviter_1['member_name'].'->'.$order['buyer_name'].'，订单号'.$order['order_sn'],
                        ));
           
                }
            }
            if(config('inviter_level')<=2){
                continue;
            }
            //三级推荐人
            $inviter_3_id=db('member')->where('member_id',$inviter_2_id)->value('inviter_id');
            if(!$inviter_3_id || !db('inviter')->where('inviter_state=1 AND inviter_id='.$inviter_3_id)->value('inviter_id')){
                continue;
            }
            $inviter_3=db('member')->where('member_id',$inviter_3_id)->field('inviter_id,member_id,member_name')->find();
            if($inviter_3 && isset($inviter_ratios[2]) && floatval($inviter_ratios[2])>0){
                $money_3=round($inviter_ratios[2]/100*$goods_amount,2);
                if($money_3>0){
    
                        //生成推广记录
                        db('orderinviter')->insert(array(
                            'orderinviter_addtime' => TIMESTAMP,
                            'orderinviter_store_name' => $order['store_name'],
                            'orderinviter_goods_amount'=>$goods_amount,
                            'orderinviter_goods_quantity'=>$goods['goods_num'],
                            'orderinviter_order_type'=>0,
                            'orderinviter_store_id'=>$goods['store_id'],
                            'orderinviter_goods_commonid'=>$goods_common_info['goods_commonid'],
                            'orderinviter_goods_id'=>$goods['goods_id'],
                            'orderinviter_level'=>3,
                            'orderinviter_goods_name'=>$goods['goods_name'],
                            'orderinviter_order_id'=>$order_id,
                            'orderinviter_order_sn'=>$order['order_sn'],
                            'orderinviter_member_id'=>$inviter_3['member_id'],
                            'orderinviter_member_name'=>$inviter_3['member_name'],
                            'orderinviter_money'=>$money_3,
                            'orderinviter_remark'=>'获得三级推荐佣金，佣金比例'.$inviter_ratios[2].'%，推荐关系'.$inviter_3['member_name'].'->'.$inviter_2['member_name'].'->'.$inviter_1['member_name'].'->'.$order['buyer_name'].'，订单号'.$order['order_sn'],
                        ));
               
                }
            }
        }
        }
    }
    /**
     * 删除购物车商品
     * @param unknown $ifcart
     * @param unknown $cart_ids
     */
    public function delCart($ifcart, $member_id, $cart_ids)
    {
        if (!$ifcart || !is_array($cart_ids))
            return;
        $cart_id_str = implode(',', $cart_ids);
        if (preg_match('/^[\d,]+$/', $cart_id_str)) {
            \mall\queue\QueueClient::push('delCart', array('buyer_id' => $member_id, 'cart_ids' => $cart_ids));
        }
    }

    /**
     * 选择不同地区时，异步处理并返回每个店铺总运费以及本地区是否能使用货到付款
     * 如果店铺统一设置了满免运费规则，则售卖区域无效
     * 如果店铺未设置满免规则，且使用售卖区域，按售卖区域计算，如果其中有商品使用相同的售卖区域，则两种商品数量相加后再应用该售卖区域计算（即作为一种商品算运费）
     * 如果未找到售卖区域，按免运费处理
     * 如果没有使用售卖区域，商品运费按快递价格计算，运费不随购买数量增加
     */
    public function changeAddr($freight_hash, $city_id, $area_id, $member_id)
    {
        //$city_id计算售卖区域,$area_id计算货到付款
        $city_id = intval($city_id);
        $area_id = intval($area_id);
        if ($city_id <= 0 || $area_id <= 0)
            return null;

        //将hash解密，得到运费信息(店铺ID，运费,售卖区域ID,购买数量),hash内容有效期为1小时
        $freight_list = $this->buyDecrypt($freight_hash, $member_id);

        //算运费
        $store_freight_list = $this->_logic_buy_1->calcStoreFreight($freight_list, $city_id);

        $data = array();
        $data['state'] = empty($store_freight_list) ? 'fail' : 'success';
        $data['content'] = $store_freight_list;

        //是否能使用货到付款(只有包含平台店铺的商品才会判断)
        //$if_include_platform_store = array_key_exists(DEFAULT_PLATFORM_STORE_ID,$freight_list['iscalced']) || array_key_exists(DEFAULT_PLATFORM_STORE_ID,$freight_list['nocalced']);

        //$offline_store_id_array = model('store')->getOwnShopIds();
        $order_platform_store_ids = array();

        if (!empty($freight_list['iscalced']) && is_array($freight_list['iscalced']))
            foreach (array_keys($freight_list['iscalced']) as $k)
                $order_platform_store_ids[$k] = null;

        if (!empty($freight_list['nocalced']) && is_array($freight_list['nocalced']))
            foreach (array_keys($freight_list['nocalced']) as $k)
                //if (in_array($k, $offline_store_id_array))
                $order_platform_store_ids[$k] = null;

        //if ($order_platform_store_ids) {
        $allow_offpay_batch = model('offpayarea')->checkSupportOffpayBatch($area_id, array_keys($order_platform_store_ids));
        /*
                //JS验证使用
                $data['allow_offpay'] = array_filter($allow_offpay_batch) ? '1' : '0';
                $data['allow_offpay_batch'] = $allow_offpay_batch;
            } else {*/
        //JS验证使用
        $data['allow_offpay'] = array_filter($allow_offpay_batch) ? '1' : '0';
        $data['allow_offpay_batch'] = $allow_offpay_batch;
        //}

        //PHP验证使用
        $data['offpay_hash'] = $this->buyEncrypt($data['allow_offpay'] ? 'allow_offpay' : 'deny_offpay', $member_id);
        $data['offpay_hash_batch'] = $this->buyEncrypt($data['allow_offpay_batch'], $member_id);

        return $data;
    }

    /**
     * 验证F码
     * @param int $goods_commonid
     * @param string $fcode
     * @return array
     */
    public function checkFcode($goods_goodid, $fcode)
    {
        $fcode_info = model('goodsfcode')->getGoodsfcode(array(
                                                              'goods_commonid' => $goods_goodid, 'goodsfcode_code' => $fcode,
                                                              'goodsfcode_state' => 0
                                                          ));
        if ($fcode_info) {
            return ds_callback(true, '', $fcode_info);
        }
        else {
            return ds_callback(false, 'F码错误');
        }
    }

    /**
     * 订单生成前的表单验证与处理
     *
     */
    private function _createOrderStep1()
    {
        $post = $this->_post_data;

        //取得商品ID和购买数量
        $input_buy_items = $this->_parseItems($post['cart_id']);
        if (empty($input_buy_items)) {
            exception('所购商品无效');
        }

        //验证收货地址
        $input_address_id = intval($post['address_id']);
        if ($input_address_id <= 0) {
            exception('请选择收货地址');
        }
        else {
            $input_address_info = model('address')->getAddressInfo(array('address_id' => $input_address_id));
            if ($input_address_info['member_id'] != $this->_member_info['member_id']) {
                exception('请选择收货地址');
            }
        }

        //收货地址城市编号
        $input_city_id = intval($input_address_info['city_id']);

        //是否开增值税发票
        $input_if_vat = $this->buyDecrypt($post['vat_hash'], $this->_member_info['member_id']);
        if (!in_array($input_if_vat, array('allow_vat', 'deny_vat'))) {
            exception('订单保存出现异常[值税发票出现错误]，请重试');
        }
        $input_if_vat = ($input_if_vat == 'allow_vat') ? true : false;

        //是否支持货到付款
        $input_if_offpay = $this->buyDecrypt($post['offpay_hash'], $this->_member_info['member_id']);
        if (!in_array($input_if_offpay, array('allow_offpay', 'deny_offpay'))) {
            exception('订单保存出现异常[货到付款验证错误]，请重试');
        }
        $input_if_offpay = ($input_if_offpay == 'allow_offpay') ? true : false;

        // 是否支持货到付款 具体到各个店铺
        $input_if_offpay_batch = $this->buyDecrypt($post['offpay_hash_batch'], $this->_member_info['member_id']);
        if (!is_array($input_if_offpay_batch)) {
            exception('订单保存出现异常[部分店铺付款方式出现异常]，请重试');
        }

        //付款方式:在线支付/货到付款(online/offline)
        if (!in_array($post['pay_name'], array('online', 'offline'))) {
            exception('付款方式错误，请重新选择');
        }
        $input_pay_name = $post['pay_name'];

        //验证发票信息
        $input_invoice_info=array();
        if (!empty($post['invoice_id'])) {
            $input_invoice_id = intval($post['invoice_id']);
            if ($input_invoice_id > 0) {
                $input_invoice_info = model('invoice')->getInvoiceInfo(array('invoice_id' => $input_invoice_id));
                if ($input_invoice_info['member_id'] != $this->_member_info['member_id']) {
                    exception('请正确填写发票信息');
                }
            }
        }

        //验证代金券
        $input_voucher_list = array();
        if (!empty($post['voucher']) && is_array($post['voucher'])) {
            foreach ($post['voucher'] as $store_id => $voucher) {
                if (preg_match_all('/^(\d+)\|(\d+)\|([\d.]+)$/', $voucher, $matchs)) {
                    if (floatval($matchs[3][0]) > 0) {
                        $input_voucher_list[$store_id]['vouchertemplate_id'] = $matchs[1][0];
                        $input_voucher_list[$store_id]['voucher_price'] = $matchs[3][0];
                    }
                }
            }
        }

        //保存数据
        $this->_order_data['input_buy_items'] = $input_buy_items;
        $this->_order_data['input_city_id'] = $input_city_id;
        $this->_order_data['input_pay_name'] = $input_pay_name;
        $this->_order_data['input_if_offpay'] = $input_if_offpay;
        $this->_order_data['input_if_offpay_batch'] = $input_if_offpay_batch;
        $this->_order_data['input_pay_message'] = $post['pay_message'];
        $this->_order_data['input_address_info'] = $input_address_info;
        $this->_order_data['input_invoice_info'] = $input_invoice_info;
        $this->_order_data['input_voucher_list'] = $input_voucher_list;
        $this->_order_data['order_from'] = $post['order_from'] == 2 ? 2 : 1;

    }

    /**
     * 得到购买商品信息
     *
     */
    private function _createOrderStep2()
    {
        $post = $this->_post_data;
        $input_buy_items = $this->_order_data['input_buy_items'];

        if ($post['ifcart']) {
            //购物车列表
            $cart_model = model('cart');
            $condition = array(
                'cart_id' => array('in', array_keys($input_buy_items)), 'buyer_id' => $this->_member_info['member_id']
            );
            $cart_list = $cart_model->getCartList('db', $condition);

            //购物车列表 [得到最新商品属性及促销信息]
            $cart_list = $this->_logic_buy_1->getGoodsCartList($cart_list);

            //商品列表 [优惠套装子商品与普通商品同级罗列]
            $goods_list = $this->_getGoodsList($cart_list);

            //以店铺下标归类
            $store_cart_list = $this->_getStoreCartList($cart_list);
        }
        else {

            //来源于直接购买
            $goods_id = key($input_buy_items);
            $quantity = current($input_buy_items);
            
            
            //额外数据用来处理拼团等其他活动
            $pintuan_id = isset($post['pintuan_id']) ? intval($post['pintuan_id']):0;
            $extra = array();
            if ($pintuan_id >= 0) {
                $extra['pintuan_id'] = $pintuan_id; #拼团ID
                #是否为开团订单
                $extra['pintuangroup_id'] = empty(input('param.pintuangroup_id'))?0:intval(input('param.pintuangroup_id'));
            }
            
            //商品信息[得到最新商品属性及促销信息]
            $goods_info = $this->_logic_buy_1->getGoodsOnlineInfo($goods_id, intval($quantity),$extra);
            if (empty($goods_info)) {
                exception('商品已下架或不存在');
            }

            //进一步处理数组
            $store_cart_list = array();
            $goods_list = array();
            $goods_list[0] = $store_cart_list[$goods_info['store_id']][0] = $goods_info;

        }

        //F码验证
        $goodsfcode_id='';
        if(!empty($post['fcode'])) {
            $goodsfcode_id = $this->_checkFcode($goods_list, $post['fcode']);
            if (!$goodsfcode_id) {
                exception('F码商品验证错误');
            }
        }
        $this->_order_data['goodsfcode_id'] = $goodsfcode_id;
        //保存数据
        $this->_order_data['goods_list'] = $goods_list;
        $this->_order_data['store_cart_list'] = $store_cart_list;
    }

    /**
     * 得到购买相关金额计算等信息
     *
     */
    private function _createOrderStep3()
    {
        $goods_list = $this->_order_data['goods_list'];
        $store_cart_list = $this->_order_data['store_cart_list'];
        $input_voucher_list = $this->_order_data['input_voucher_list'];
        $input_city_id = $this->_order_data['input_city_id'];

        //商品金额计算(分别对每个商品/优惠套装小计、每个店铺小计)
        list($store_cart_list, $store_goods_total) = $this->_logic_buy_1->calcCartList($store_cart_list);

        //取得店铺优惠 - 满即送(赠品列表，店铺满送规则列表)
        list($store_premiums_list, $store_mansong_rule_list) = $this->_logic_buy_1->getMansongruleCartListByTotal($store_goods_total);

        //重新计算店铺扣除满即送后商品实际支付金额
        $store_final_goods_total = $this->_logic_buy_1->reCalcGoodsTotal($store_goods_total, $store_mansong_rule_list, 'mansong');

        //得到有效的代金券
        $input_voucher_list = $this->_logic_buy_1->reParseVoucherList($input_voucher_list, $store_goods_total, $this->_member_info['member_id']);

        //重新计算店铺扣除优惠券送商品实际支付金额
        $store_final_goods_total = $this->_logic_buy_1->reCalcGoodsTotal($store_final_goods_total, $input_voucher_list, 'voucher');

        //计算每个店铺(所有店铺级优惠活动)总共优惠多少
        $store_promotion_total = $this->_logic_buy_1->getStorePromotionTotal($store_goods_total, $store_final_goods_total);

        //计算每个店铺运费
        list($need_calc_sid_list, $cancel_calc_sid_list) = $this->_logic_buy_1->getStoreFreightDescList($store_final_goods_total);
        $freight_list = $this->_logic_buy_1->getStoreFreightList($goods_list, array_keys($cancel_calc_sid_list));
        $store_freight_total = $this->_logic_buy_1->calcStoreFreight($freight_list, $input_city_id);
        if(empty($store_freight_total)){
            exception('抱歉，商品在所在地区无货');
        }
        //计算店铺最终订单实际支付金额(加上运费)
        $store_final_order_total = $this->_logic_buy_1->reCalcGoodsTotal($store_final_goods_total, $store_freight_total, 'freight');

        //计算店铺分类佣金[改由任务计划]
        $store_gc_id_commis_rate_list = model('storebindclass')->getStoreGcidCommisRateList($goods_list);

        //将赠品追加到购买列表(如果库存0，则不送赠品)
        $append_premiums_to_cart_list = $this->_logic_buy_1->appendPremiumsToCartList($store_cart_list, $store_premiums_list, $store_mansong_rule_list, $this->_member_info['member_id']);
        if ($append_premiums_to_cart_list === false) {
            exception('抱歉，您购买的商品库存不足，请重购买');
        }
        else {
            list($store_cart_list, $goods_buy_quantity, $store_mansong_rule_list) = $append_premiums_to_cart_list;
        }

        //保存数据
        $this->_order_data['store_goods_total'] = $store_goods_total;
        $this->_order_data['store_final_order_total'] = $store_final_order_total;
        $this->_order_data['store_freight_total'] = $store_freight_total;
        $this->_order_data['store_promotion_total'] = $store_promotion_total;
        
        $this->_order_data['store_gc_id_commis_rate_list'] = $store_gc_id_commis_rate_list;
        $this->_order_data['store_mansong_rule_list'] = $store_mansong_rule_list;
        $this->_order_data['store_cart_list'] = $store_cart_list;
        $this->_order_data['goods_buy_quantity'] = $goods_buy_quantity;
        $this->_order_data['input_voucher_list'] = $input_voucher_list;

    }

    /**
     * 生成订单
     * @param array $input
     * @throws Exception
     * @return array array(支付单sn,订单列表)
     */
    private function _createOrderStep4()
    {

        extract($this->_order_data);

        $member_id = $this->_member_info['member_id'];
        $member_name = $this->_member_info['member_name'];
        $member_email = $this->_member_info['member_email'];

        $order_model = model('order');

        //存储生成的订单数据
        $order_list = array();
        //存储通知信息
        $notice_list = array();

        //每个店铺订单是货到付款还是线上支付,店铺ID=>付款方式[在线支付/货到付款]
        $store_pay_type_list = $this->_logic_buy_1->getStorePayTypeList(array_keys($store_cart_list), $input_if_offpay, $input_pay_name);

        foreach ($store_pay_type_list as $k => & $v) {
            if (empty($input_if_offpay_batch[$k]))
                $v = 'online';
        }

        $pay_sn = makePaySn($member_id);
        $order_pay = array();
        $order_pay['pay_sn'] = $pay_sn;
        $order_pay['buyer_id'] = $member_id;
        $order_pay_id = $order_model->addOrderpay($order_pay);
        if (!$order_pay_id) {
            exception('订单保存失败[未生成支付单]');
        }

        //收货人信息
        list($reciver_info, $reciver_name) = $this->_logic_buy_1->getReciverAddr($input_address_info);

        foreach ($store_cart_list as $store_id => $goods_list) {

            //取得本店优惠额度(后面用来计算每件商品实际支付金额，结算需要)
            $promotion_total = !empty($store_promotion_total[$store_id]) ? $store_promotion_total[$store_id] : 0;
            //本店总的优惠比例,保留3位小数
            $should_goods_total = $store_final_order_total[$store_id] - $store_freight_total[$store_id] + $promotion_total;
            $promotion_rate = abs(number_format($promotion_total / $should_goods_total, 5));
            if ($promotion_rate <= 1) {
                $promotion_rate = floatval(substr($promotion_rate, 0, 5));
            }
            else {
                $promotion_rate = 0;
            }

            //每种商品的优惠金额累加保存入 $promotion_sum
            $promotion_sum = 0;

            $order = array();
            $order_common = array();
            $order_goods = array();

            $order['order_sn'] = $this->_logic_buy_1->makeOrderSn($order_pay_id);
            $order['pay_sn'] = $pay_sn;
            $order['store_id'] = $store_id;
            $order['store_name'] = $goods_list[0]['store_name'];
            $order['buyer_id'] = $member_id;
            $order['buyer_name'] = $member_name;
            $order['buyer_email'] = $member_email;
            $order['add_time'] = TIMESTAMP;
            $order['payment_code'] = $store_pay_type_list[$store_id];
            $order['order_state'] = $store_pay_type_list[$store_id] == 'online' ? ORDER_STATE_NEW : ORDER_STATE_PAY;
            $order['order_amount'] = $store_final_order_total[$store_id];
            $order['shipping_fee'] = $store_freight_total[$store_id];
            $order['goods_amount'] = $order['order_amount'] - $order['shipping_fee'];
            $order['order_from'] = $order_from;
            //如果支持方式为空时，默认为货到付款 
            if ($order['payment_code'] == "") {
                $order['payment_code'] = "offline";
            }
            $order_id = $order_model->addOrder($order);
            if (!$order_id) {
                exception('订单保存失败[未生成订单数据]');
            }
            $order['order_id'] = $order_id;
            $order_list[$order_id] = $order;

            $order_common['order_id'] = $order_id;
            $order_common['store_id'] = $store_id;
            $order_common['order_message'] = $input_pay_message[$store_id];

            //代金券
            if (isset($input_voucher_list[$store_id])) {
                $order_common['voucher_price'] = $input_voucher_list[$store_id]['voucher_price'];
                $order_common['voucher_code'] = $input_voucher_list[$store_id]['voucher_code'];
            }

            $order_common['reciver_info'] = $reciver_info;
            $order_common['reciver_name'] = $reciver_name;
            $order_common['reciver_city_id'] = $input_city_id;

            //发票信息
            $order_common['invoice_info'] = $this->_logic_buy_1->createInvoiceData($input_invoice_info);

            //保存促销信息
            if (isset($store_mansong_rule_list[$store_id])) {
                $order_common['promotion_info'] = addslashes($store_mansong_rule_list[$store_id]['desc']);
            }

            $order_id = $order_model->addOrdercommon($order_common);
            if (!$order_id) {
                exception('订单保存失败[未生成订单扩展数据]');
            }

            //生成order_goods订单商品数据
            $i = 0;
            foreach ($goods_list as $goods_info) {
                if (!$goods_info['state'] || !$goods_info['storage_state']) {
                    exception('部分商品已经下架或库存不足，请重新选择');
                }
                if (!intval($goods_info['bl_id'])) {
                    //如果不是优惠套装
                    $order_goods[$i]['order_id'] = $order_id;
                    $order_goods[$i]['goods_id'] = $goods_info['goods_id'];
                    $order_goods[$i]['store_id'] = $store_id;
                    $order_goods[$i]['goods_name'] = $goods_info['goods_name'];
                    $order_goods[$i]['goods_price'] = $goods_info['goods_price'];
                    $order_goods[$i]['goods_num'] = $goods_info['goods_num'];
                    $order_goods[$i]['goods_image'] = $goods_info['goods_image'];
                    $order_goods[$i]['buyer_id'] = $member_id;
                    $ifgroupbuy = false;
                    if (isset($goods_info['ifgroupbuy'])) {
                        $ifgroupbuy = true;
                        $order_goods[$i]['goods_type'] = 2;
                    }
                    elseif (isset($goods_info['ifxianshi'])) {
                        $order_goods[$i]['goods_type'] = 3;
                    }
                    elseif (isset($goods_info['ifzengpin'])) {
                        $order_goods[$i]['goods_type'] = 5;
                    }
                    elseif (isset($goods_info['ifpintuan']) && intval($this->_post_data['pintuan_id'])>0) {
                        //拼团订单
                        /**
                         * $goods_info['ifpintuan'] , $goods_info['pintuan_id']  此数据是通过商品ID 获取到是否为拼团订单
                         * $this->_post_data['pintuan_id']   $this->_post_data['pintuangroup_id'] 此数据是通过post 过来的数据，用来判断是否为首个拼团订单:0首个订单 其他为所属订单
                         */
                        $order_goods[$i]['goods_type'] = 6;
                        //拼团订单的特殊性,还需要额外的进行处理.
                        $pintuangroup_id = intval($this->_post_data['pintuangroup_id']);
                        $pintuan_id = intval($this->_post_data['pintuan_id']);
                        
                        $pintuanorder_isfirst = 0;#是否为首团订单
                        if($pintuangroup_id == 0){
                            //首团订单新增
                            $data = array(
                                'pintuan_id'=>$pintuan_id,
                                'pintuangroup_goods_id'=>$goods_info['goods_id'],
                                'pintuangroup_joined'=>0,
                                'pintuangroup_limit_number'=>$goods_info['pintuan_info']['pintuan_limit_number'],
                                'pintuangroup_limit_hour'=>$goods_info['pintuan_info']['pintuan_limit_hour'],
                                'pintuangroup_headid'=>$member_id,
                                'pintuangroup_starttime'=>TIMESTAMP,
                            );
                            $pintuangroup_id = model('ppintuangroup')->addPpintuangroup($data);
                            //拼团统计新增开团数量
                            db('ppintuan')->where('pintuan_id',$pintuan_id)->setInc('pintuan_count');
                            $pintuanorder_isfirst = 1;
                        }
                        //新增订单
                        $data = array(
                            'pintuan_id'=>$pintuan_id,
                            'pintuangroup_id'=>$pintuangroup_id,
                            'order_id'=>$order_id,
                            'order_sn' => $order['order_sn'],
                            'pintuanorder_isfirst'=>$pintuanorder_isfirst,
                        );
                        model('ppintuanorder')->addPpintuanorder($data);
                        //开团统计新增人数
                        db('ppintuangroup')->where('pintuangroup_id',$pintuangroup_id)->setInc('pintuangroup_joined');
                        //下单后清除缓存
                        model('ppintuan')->_dGoodsPintuanCache($goods_info['pintuan_info']['pintuan_goods_commonid']);
                    }
                    elseif (isset($goods_info['ifmgdiscount'])) {
                        $order_goods[$i]['goods_type'] = 7;
                    }
                    else {
                        $order_goods[$i]['goods_type'] = 1;
                    }
                    $order_goods[$i]['promotions_id'] = isset($goods_info['promotions_id']) ? $goods_info['promotions_id'] : 0;

                    $order_goods[$i]['commis_rate'] = floatval(@$store_gc_id_commis_rate_list[$store_id][$goods_info['gc_id']]);

                    $order_goods[$i]['gc_id'] = $goods_info['gc_id'];
                    //计算商品金额
                    $goods_total = $goods_info['goods_price'] * $goods_info['goods_num'];
                    //计算本件商品优惠金额
                    $promotion_value = floor($goods_total * ($promotion_rate));
                    $order_goods[$i]['goods_pay_price'] = $goods_total - $promotion_value;
                    $promotion_sum += $promotion_value;
                    $i++;

                    //存储库存报警数据
                    if (isset($goods_info['goods_storage_alarm'])&&$goods_info['goods_storage_alarm'] >= ($goods_info['goods_storage'] - $goods_info['goods_num'])) {
                        $param = array();
                        $param['common_id'] = $goods_info['goods_commonid'];
                        $param['sku_id'] = $goods_info['goods_id'];
                        $notice_list['goods_storage_alarm'][$goods_info['store_id']] = $param;
                    }

                }
                elseif (!empty($goods_info['bl_goods_list']) && is_array($goods_info['bl_goods_list'])) {
                    $ifgroupbuy = false;
                    //优惠套装
                    foreach ($goods_info['bl_goods_list'] as $bl_goods_info) {
                        $order_goods[$i]['order_id'] = $order_id;
                        $order_goods[$i]['goods_id'] = $bl_goods_info['goods_id'];
                        $order_goods[$i]['store_id'] = $store_id;
                        $order_goods[$i]['goods_name'] = $bl_goods_info['goods_name'];
                        $order_goods[$i]['goods_price'] = $bl_goods_info['blgoods_price'];
                        $order_goods[$i]['goods_num'] = $goods_info['goods_num'];
                        $order_goods[$i]['goods_image'] = $bl_goods_info['goods_image'];
                        $order_goods[$i]['buyer_id'] = $member_id;
                        $order_goods[$i]['goods_type'] = 4;
                        $order_goods[$i]['promotions_id'] = $bl_goods_info['bl_id'];
                        $order_goods[$i]['commis_rate'] = floatval(@$store_gc_id_commis_rate_list[$store_id][$goods_info['gc_id']]);
                        $order_goods[$i]['gc_id'] = $bl_goods_info['gc_id'];

                        //计算商品实际支付金额(goods_price减去分摊优惠金额后的值)
                        $goods_total = $bl_goods_info['blgoods_price'] * $goods_info['goods_num'];
                        //计算本件商品优惠金额
                        $promotion_value = floor($goods_total * ($promotion_rate));
                        $order_goods[$i]['goods_pay_price'] = $goods_total - $promotion_value;
                        $promotion_sum += $promotion_value;
                        $i++;

                        //存储库存报警数据
                        if ($bl_goods_info['goods_storage_alarm'] >= ($bl_goods_info['goods_storage'] - $goods_info['goods_num'])) {
                            $param = array();
                            $param['common_id'] = $bl_goods_info['goods_commonid'];
                            $param['sku_id'] = $bl_goods_info['goods_id'];
                            $notice_list['goods_storage_alarm'][$bl_goods_info['store_id']] = $param;
                        }
                    }
                }
            }

            //将因舍出小数部分出现的差值补到最后一个商品的实际成交价中(商品goods_price=0时不给补，可能是赠品)
            if ($promotion_total > $promotion_sum) {
                $i--;
                for ($i; $i >= 0; $i--) {
                    if (floatval($order_goods[$i]['goods_price']) > 0) {
                        $order_goods[$i]['goods_pay_price'] -= $promotion_total - $promotion_sum;
                        break;
                    }
                }
            }
            $insert = $order_model->addOrdergoods($order_goods);
            if (!$insert) {
                exception('订单保存失败[未生成商品数据]');
            }
            $order_list[$order_id]['order_goods']=$order_goods;
            //存储商家发货提醒数据
            if ($store_pay_type_list[$store_id] == 'offline') {
                $notice_list['new_order'][$order['store_id']] = array('order_sn' => $order['order_sn']);
            }
        }

        //保存数据
        $this->_order_data['pay_sn'] = $pay_sn;
        $this->_order_data['order_list'] = $order_list;
        $this->_order_data['notice_list'] = $notice_list;
        $this->_order_data['ifgroupbuy'] = $ifgroupbuy;
    }

    /**
     * 充值卡、预存款支付
     */
    private function _createOrderStep5()
    {
        if (empty($this->_post_data['password']))
            return;
        $buyer_info = model('member')->getMemberInfoByID($this->_member_info['member_id']);
        if ($buyer_info['member_paypwd'] == '' || $buyer_info['member_paypwd'] != md5($this->_post_data['password']))
            return;

        //使用充值卡支付
        if (!empty($this->_post_data['rcb_pay'])) {
            $order_list = $this->_logic_buy_1->rcbPay($this->_order_data['order_list'], $this->_post_data, $buyer_info);
        }

        //使用预存款支付
        if (!empty($this->_post_data['pd_pay'])) {
            $this->_logic_buy_1->pdPay(isset($order_list) ? $order_list : $this->_order_data['order_list'], $this->_post_data, $buyer_info);
        }
    }

    /**
     * 订单后续其它处理
     */
    private function _createOrderStep6()
    {
        $ifcart = $this->_post_data['ifcart'];
        $goods_buy_quantity = $this->_order_data['goods_buy_quantity'];
        $input_voucher_list = $this->_order_data['input_voucher_list'];
        $store_cart_list = $this->_order_data['store_cart_list'];
        $input_buy_items = $this->_order_data['input_buy_items'];
        $order_list = $this->_order_data['order_list'];
        $input_address_info = $this->_order_data['input_address_info'];
        $notice_list = $this->_order_data['notice_list'];
        $goodsfcode_id = $this->_order_data['goodsfcode_id'];
        $ifgroupbuy = $this->_order_data['ifgroupbuy'];

        //变更库存和销量
        \mall\queue\QueueClient::push('createOrderUpdateStorage', $goods_buy_quantity);

        //更新使用的代金券状态
        if (!empty($input_voucher_list) && is_array($input_voucher_list)) {
            \mall\queue\QueueClient::push('editVoucherState', $input_voucher_list);
        }

        //更新F码使用状态
        if ($goodsfcode_id) {
            \mall\queue\QueueClient::push('updateGoodsfcode', $goodsfcode_id);
        }

        //更新抢购购买人数和数量
        if ($ifgroupbuy) {
            foreach ($store_cart_list as $goods_list) {
                foreach ($goods_list as $goods_info) {
                    if ($goods_info['ifgroupbuy'] && $goods_info['groupbuy_id']) {
                        $groupbuy_info = array();
                        $groupbuy_info['groupbuy_id'] = $goods_info['groupbuy_id'];
                        $groupbuy_info['quantity'] = $goods_info['goods_num'];
                        \mall\queue\QueueClient::push('editGroupbuySaleCount', $groupbuy_info);
                    }
                }
            }
        }

        //删除购物车中的商品
        $this->delCart($ifcart, $this->_member_info['member_id'], array_keys($input_buy_items));
        cookie('cart_goods_num', '', -3600);

        //保存订单自提点信息
        if (config('delivery_isuse') && intval($input_address_info['dlyp_id'])) {
            $data = array();
            $data['mob_phone'] = $input_address_info['address_mob_phone'];
            $data['tel_phone'] = $input_address_info['address_tel_phone'];
            $data['reciver_name'] = $input_address_info['address_realname'];
            $data['dlyp_id'] = $input_address_info['dlyp_id'];
            foreach ($order_list as $v) {
                $data['order_sn_list'][$v['order_id']]['order_sn'] = $v['order_sn'];
                $data['order_sn_list'][$v['order_id']]['add_time'] = $v['add_time'];
            }
            \mall\queue\QueueClient::push('saveDeliveryOrder', $data);
        }
        //生成推广记录
        $this->addOrderInviter($order_list);
        //发送提醒类信息
        if (!empty($notice_list)) {
            foreach ($notice_list as $code => $value) {
                \mall\queue\QueueClient::push('sendStoremsg', array(
                    'code' => $code, 'store_id' => key($value), 'param' => current($value)
                ));
            }
        }

    }

    /**
     * 加密
     * @param array /string $string
     * @param int $member_id
     * @return mixed arrray/string
     */
    public function buyEncrypt($string, $member_id)
    {
        $buy_key = sha1(md5($member_id . '&' . MD5_KEY));
        if (is_array($string)) {
            $string = serialize($string);
        }
        else {
            $string = strval($string);
        }
        return ds_encrypt(base64_encode($string), $buy_key);
    }

    /**
     * 解密
     * @param string $string
     * @param int $member_id
     * @param number $ttl
     */
    public function buyDecrypt($string, $member_id, $ttl = 0)
    {
        $buy_key = sha1(md5($member_id . '&' . MD5_KEY));
        if (empty($string))
            return;
        $string = base64_decode(ds_decrypt(strval($string), $buy_key, $ttl));
        return ($tmp = @unserialize($string)) !== false ? $tmp : $string;
    }

    /**
     * 得到所购买的id和数量
     *
     */
    private function _parseItems($cart_id)
    {
        //存放所购商品ID和数量组成的键值对
        $buy_items = array();
        if (is_array($cart_id)) {
            foreach ($cart_id as $value) {
                if (preg_match_all('/^(\d{1,10})\|(\d{1,6})$/', $value, $match)) {
                    if (intval($match[2][0]) > 0) {
                        $buy_items[$match[1][0]] = $match[2][0];
                    }
                }
            }
        }
        return $buy_items;
    }

    /**
     * 从购物车数组中得到商品列表
     * @param unknown $cart_list
     */
    private function _getGoodsList($cart_list)
    {
        if (empty($cart_list) || !is_array($cart_list))
            return $cart_list;
        $goods_list = array();
        $i = 0;
        foreach ($cart_list as $key => $cart) {
            if (!$cart['state'] || !$cart['storage_state'])
                continue;
            //购买数量
            $quantity = $cart['goods_num'];
            if (!intval($cart['bl_id'])) {
                //如果是普通商品
                $goods_list[$i]['goods_num'] = $quantity;
                $goods_list[$i]['goods_id'] = $cart['goods_id'];
                $goods_list[$i]['store_id'] = $cart['store_id'];
                $goods_list[$i]['gc_id'] = $cart['gc_id'];
                $goods_list[$i]['goods_name'] = $cart['goods_name'];
                $goods_list[$i]['goods_price'] = $cart['goods_price'];
                $goods_list[$i]['store_name'] = $cart['store_name'];
                $goods_list[$i]['goods_image'] = $cart['goods_image'];
                $goods_list[$i]['transport_id'] = $cart['transport_id'];
                $goods_list[$i]['goods_freight'] = $cart['goods_freight'];
                $goods_list[$i]['goods_vat'] = $cart['goods_vat'];
                $goods_list[$i]['is_goodsfcode'] = $cart['is_goodsfcode'];
                $goods_list[$i]['bl_id'] = 0;
                $i++;
            }
            else {
                //如果是优惠套装商品
                foreach ($cart['bl_goods_list'] as $bl_goods) {
                    $goods_list[$i]['goods_num'] = $quantity;
                    $goods_list[$i]['goods_id'] = $bl_goods['goods_id'];
                    $goods_list[$i]['store_id'] = $cart['store_id'];
                    $goods_list[$i]['gc_id'] = $bl_goods['gc_id'];
                    $goods_list[$i]['goods_name'] = $bl_goods['goods_name'];
                    $goods_list[$i]['goods_price'] = $bl_goods['blgoods_price'];
                    $goods_list[$i]['store_name'] = $bl_goods['store_name'];
                    $goods_list[$i]['goods_image'] = $bl_goods['goods_image'];
                    $goods_list[$i]['transport_id'] = $bl_goods['transport_id'];
                    $goods_list[$i]['goods_freight'] = $bl_goods['goods_freight'];
                    $goods_list[$i]['goods_vat'] = $bl_goods['goods_vat'];
                    $goods_list[$i]['bl_id'] = $cart['bl_id'];
                    $i++;
                }
            }
        }
        return $goods_list;
    }

    /**
     * 将下单商品列表转换为以店铺ID为下标的数组
     *
     * @param array $cart_list
     * @return array
     */
    private function _getStoreCartList($cart_list)
    {
        if (empty($cart_list) || !is_array($cart_list))
            return $cart_list;
        $new_array = array();
        foreach ($cart_list as $cart) {
            $new_array[$cart['store_id']][] = $cart;
        }
        return $new_array;
    }

    /**
     * 本次下单是否需要码及F码合法性
     * 无需使用F码，返回 true
     * 需要使用F码，返回($goodsfcode_id/false)
     */
    private function _checkFcode($goods_list, $fcode)
    {
        $is_goodsfcode = false;
        foreach ($goods_list as $k => $v) {
            if ($v['is_goodsfcode'] == 1) {
                $is_goodsfcode = true;
                break;
            }
        }
        if (!$is_goodsfcode)
            return true;
        if (empty($fcode) || count($goods_list) > 1) {
            return false;
        }
        $goods_info = $goods_list[0];
        $fcode_info = $this->checkFcode($goods_info['goods_commonid'], $fcode);
        if ($fcode_info['code'] && !$fcode_info['data']['goodsfcode_state']) {
            return intval($fcode_info['data']['goodsfcode_id']);
        }
        else {
            return false;
        }
    }
}