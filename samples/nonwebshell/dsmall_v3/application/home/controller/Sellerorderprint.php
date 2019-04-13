<?php
/**
 * 订单打印
 */
namespace app\home\controller;
use think\Lang;

class Sellerorderprint extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerorderprint.lang.php');
    }

    /**
     * 查看订单
     */
    public function index() {
        $order_id = intval(input('param.order_id'));
        if ($order_id <= 0) {
            $this->error(lang('wrong_argument'));
        }
        $order_model = model('order');
        $condition['order_id'] = $order_id;
        $condition['store_id'] = session('store_id');
        $order_info = $order_model->getOrderInfo($condition, array('order_common', 'order_goods'));
        if (empty($order_info)) {
            $this->error(lang('member_printorder_ordererror'));
        }
        $this->assign('order_info', $order_info);

        //卖家信息
        $store_model = model('store');
        $store_info = $store_model->getStoreInfoByID($order_info['store_id']);
        if (!empty($store_info['store_logo'])) {
            if (file_exists(BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . $store_info['store_logo'])) {
                $store_info['store_logo'] = UPLOAD_SITE_URL . DS . ATTACH_STORE . DS . $store_info['store_logo'];
            } else {
                $store_info['store_logo'] = '';
            }
        }
        if (!empty($store_info['store_seal'])) {
            if (file_exists(BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . $store_info['store_seal'])) {
                $store_info['store_seal'] = UPLOAD_SITE_URL . DS . ATTACH_STORE . DS . $store_info['store_seal'];
            } else {
                $store_info['store_seal'] = '';
            }
        }
        $this->assign('store_info', $store_info);

        //订单商品
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = session('store_id');
        $goods_new_list = array();
        $goods_all_num = 0;
        $goods_total_price = 0;
        if (isset($order_info['extend_order_goods']) && !empty($order_info['extend_order_goods'])) {
            $i = 1;
            foreach ($order_info['extend_order_goods'] as $k => $v) {
                $v['goods_name'] = str_cut($v['goods_name'], 100);
                $goods_all_num += $v['goods_num'];
                $v['goods_all_price'] = ds_price_format($v['goods_num'] * $v['goods_price']);
                $goods_total_price += $v['goods_all_price'];
                $goods_new_list[ceil($i / 15)][$i] = $v;
                $i++;
            }
        }
        //优惠金额
        $promotion_amount = $goods_total_price - $order_info['goods_amount'];
        //运费
        $order_info['shipping_fee'] = $order_info['shipping_fee'];
        $this->assign('promotion_amount', $promotion_amount);
        $this->assign('goods_all_num', $goods_all_num);
        $this->assign('goods_total_price', ds_price_format($goods_total_price));
        $this->assign('goods_list', $goods_new_list);
        
        return $this->fetch($this->template_dir.'index');
    }

}

?>
