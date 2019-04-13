<?php

namespace app\home\controller;

use think\Lang;

class Seller extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/seller.lang.php');
    }

    /**
     * 商户中心首页
     *
     */
    public function index() {
        // 店铺信息
        $store_info = $this->store_info;
        $store_info['reopen_tip'] = FALSE;
        if (intval($store_info['store_endtime']) > 0) {
            $store_info['store_endtime_text'] = date('Y-m-d', $store_info['store_endtime']);
            $reopen_time = $store_info['store_endtime'] - 3600 * 24 + 1 - TIMESTAMP;
            if (!session('is_platform_store') && $store_info['store_endtime'] - TIMESTAMP >= 0 && $reopen_time < 2592000) {
                //到期续签提醒(<30天)
                $store_info['reopen_tip'] = true;
            }
        } else {
            $store_info['store_endtime_text'] = lang('store_no_limit');
        }
        // 店铺等级信息
        $store_info['grade_name'] = $this->store_grade['storegrade_name'];
        $store_info['grade_goodslimit'] = $this->store_grade['storegrade_goods_limit'];
        $store_info['grade_albumlimit'] = $this->store_grade['storegrade_album_limit'];

        $this->assign('store_info', $store_info);
        // 商家帮助
        $help_model = model('help');
        $condition = array();
        $condition['helptype_show'] = '1'; //是否显示,0为否,1为是
        $help_list = $help_model->getStoreHelptypeList($condition, '', 6);
        $this->assign('help_list', $help_list);

        // 销售情况统计
        $field = ' COUNT(*) as ordernum,SUM(order_amount) as orderamount ';
        $where = array();
        $where['store_id'] = session('store_id');
        $where['order_isvalid'] = 1; //计入统计的有效订单
        // 昨日销量
        $where['order_add_time'] = array('between', array(strtotime(date('Y-m-d', (time() - 3600 * 24))), strtotime(date('Y-m-d', time())) - 1));
        $daily_sales = model('stat')->getoneByStatorder($where, $field);
        $this->assign('daily_sales', $daily_sales);
        // 月销量
        $where['order_add_time'] = array('gt', strtotime(date('Y-m', time())));
        $monthly_sales = model('stat')->getoneByStatorder($where, $field);
        $this->assign('monthly_sales', $monthly_sales);
        unset($field, $where);

        //单品销售排行
        //最近30天
        $stime = strtotime(date('Y-m-d', (time() - 3600 * 24))) - (86400 * 29); //30天前
        $etime = strtotime(date('Y-m-d', time())) - 1; //昨天23:59
        $where = array();
        $where['store_id'] = session('store_id');
        $where['order_isvalid'] = 1; //计入统计的有效订单
        $where['order_add_time'] = array('between', array($stime, $etime));
        $field = ' goods_id,goods_name,SUM(goods_num) as goodsnum,goods_image ';
        $orderby = 'goodsnum desc,goods_id';
        $goods_list = model('stat')->statByStatordergoods($where, $field, 0, 8, $orderby, 'goods_id');
        unset($stime, $etime, $where, $field, $orderby);
        $this->assign('goods_list', $goods_list);
        
        if (!session('is_platform_store')) {
            
            if (config('groupbuy_allow') == 1) {
                // 抢购套餐
                $groupquota_info = model('groupbuyquota')->getGroupbuyquotaCurrent(session('store_id'));
                $this->assign('groupquota_info', $groupquota_info);
            }
            if (intval(config('promotion_allow')) == 1) {
                // 限时折扣套餐
                $xianshiquota_info = model('pxianshiquota')->getXianshiquotaCurrent(session('store_id'));
                $this->assign('xianshiquota_info', $xianshiquota_info);
                // 满即送套餐
                $mansongquota_info = model('pmansongquota')->getMansongquotaCurrent(session('store_id'));
                $this->assign('mansongquota_info', $mansongquota_info);
                // 优惠套装套餐
                $binglingquota_info = model('pbundling')->getBundlingQuotaInfoCurrent(session('store_id'));
                $this->assign('binglingquota_info', $binglingquota_info);
                // 推荐展位套餐
                $boothquota_info = model('pbooth')->getBoothquotaInfoCurrent(session('store_id'));
                $this->assign('boothquota_info', $boothquota_info);
            }
            if (config('voucher_allow') == 1) {
                $voucherquota_info = model('voucher')->getVoucherquotaCurrent(session('store_id'));
                $this->assign('voucherquota_info', $voucherquota_info);
            }
        } else {
            $this->assign('isPlatformStore', true);
        }
        $phone_array = explode(',', config('site_phone'));
        $this->assign('phone_array', $phone_array);

        $this->assign('menu_sign', 'index');


        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_index');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem();
        return $this->fetch($this->template_dir.'index');
    }

    /**
     * 异步取得卖家统计类信息
     *
     */
    public function statistics() {
//        $add_time_to = strtotime(date("Y-m-d") + 60 * 60 * 24);   //当前日期 ,从零点来时
//        $add_time_from = strtotime(date("Y-m-d", (strtotime(date("Y-m-d")) - 60 * 60 * 24 * 30)));   //30天前
        $goods_online = 0;      // 出售中商品
        $goods_waitverify = 0;  // 等待审核
        $goods_verifyfail = 0;  // 审核失败
        $goods_offline = 0;     // 仓库待上架商品
        $goods_lockup = 0;      // 违规下架商品
        $consult = 0;           // 待回复商品咨询
        $no_payment = 0;        // 待付款
        $no_delivery = 0;       // 待发货
        $no_receipt = 0;        // 待收货
        $refund_lock = 0;      // 售前退款
        $refund = 0;            // 售后退款
        $return_lock = 0;      // 售前退货
        $return = 0;            // 售后退货
        $complain = 0;          //进行中投诉

        $goods_model = model('goods');
        // 全部商品数
        $goodscount = $goods_model->getGoodsCommonCount(array('store_id' => session('store_id')));
        // 出售中的商品
        $goods_online = $goods_model->getGoodsCommonOnlineCount(array('store_id' => session('store_id')));
        if (config('goods_verify')) {
            // 等待审核的商品
            $goods_waitverify = $goods_model->getGoodsCommonWaitVerifyCount(array('store_id' => session('store_id')));
            // 审核失败的商品
            $goods_verifyfail = $goods_model->getGoodsCommonVerifyFailCount(array('store_id' => session('store_id')));
        }
        // 仓库待上架的商品
        $goods_offline = $goods_model->getGoodsCommonOfflineCount(array('store_id' => session('store_id')));
        // 违规下架的商品
        $goods_lockup = $goods_model->getGoodsCommonLockUpCount(array('store_id' => session('store_id')));
        // 等待回复商品咨询
        $consult = model('consult')->getConsultCount(array('store_id' => session('store_id'), 'consult_reply' => ''));

        // 商品图片数量
        $imagecount = model('album')->getAlbumpicCount(array('store_id' => session('store_id')));

        $order_model = model('order');
        // 交易中的订单
        $progressing = $order_model->getOrderCountByID('store', session('store_id'), 'TradeCount');
        // 待付款
        $no_payment = $order_model->getOrderCountByID('store', session('store_id'), 'NewCount');
        // 待发货
        $no_delivery = $order_model->getOrderCountByID('store', session('store_id'), 'PayCount');

        $refundreturn_model = model('refundreturn');
        // 售前退款
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['refund_type'] = 1;
        $condition['order_lock'] = 2;
        $condition['refund_state'] = array('lt', 3);
        $refund_lock = $refundreturn_model->getRefundreturnCount($condition);
        // 售后退款
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['refund_type'] = 1;
        $condition['order_lock'] = 1;
        $condition['refund_state'] = array('lt', 3);
        $refund = $refundreturn_model->getRefundreturnCount($condition);
        // 售前退货
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['refund_type'] = 2;
        $condition['order_lock'] = 2;
        $condition['refund_state'] = array('lt', 3);
        $return_lock = $refundreturn_model->getRefundreturnCount($condition);
        // 售后退货
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['refund_type'] = 2;
        $condition['order_lock'] = 1;
        $condition['refund_state'] = array('lt', 3);
        $return = $refundreturn_model->getRefundreturnCount($condition);

        $condition = array();
        $condition['accused_id'] = session('store_id');
        $condition['complain_state'] = array(array('gt', 10), array('lt', 90), 'and');
        $complain_mod=model('complain');
        $complain = $complain_mod->getComplainCount($condition);

        //待确认的结算账单
        $bill_model = model('bill');
        $condition = array();
        $condition['ob_store_id'] = session('store_id');
        $condition['ob_state'] = BILL_STATE_CREATE;
        $bill_confirm_count = $bill_model->getOrderbillCount($condition);

        //统计数组
        $statistics = array(
            'goodscount' => $goodscount,
            'online' => $goods_online,
            'waitverify' => $goods_waitverify,
            'verifyfail' => $goods_verifyfail,
            'offline' => $goods_offline,
            'lockup' => $goods_lockup,
            'imagecount' => $imagecount,
            'consult' => $consult,
            'progressing' => $progressing,
            'payment' => $no_payment,
            'delivery' => $no_delivery,
            'refund_lock' => $refund_lock,
            'refund' => $refund,
            'return_lock' => $return_lock,
            'return' => $return,
            'complain' => $complain,
            'bill_confirm' => $bill_confirm_count
        );
        exit(json_encode($statistics));
    }
}

?>
