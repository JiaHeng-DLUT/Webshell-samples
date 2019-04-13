<?php

/**
 * 发货
 */

namespace app\home\controller;
use think\Lang;
use think\Db;
class Sellerdeliver extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerdeliver.lang.php');
    }
    /**
     * 发货列表
     *
     */
    public function index() {
        $order_model = model('order');
        $state = input('state');
        if (!in_array($state, array('deliverno', 'delivering', 'delivered'))) {
            $state = 'deliverno';
        }

        $order_state = str_replace(array('deliverno', 'delivering', 'delivered'), array(ORDER_STATE_PAY, ORDER_STATE_SEND, ORDER_STATE_SUCCESS), $state);
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['order_state'] = $order_state;


        $buyer_name = input('buyer_name');
        if ($buyer_name != '') {
            $condition['buyer_name'] = $buyer_name;
        }
        $order_sn = input('order_sn');
        if ($order_sn != '') {
            $condition['order_sn'] = $order_sn;
        }
        $query_start_date = input('query_start_date');
        $query_end_date = input('query_end_date');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_start_date);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_end_date);
        $start_unixtime = $if_start_date ? strtotime($query_start_date) : null;
        $end_unixtime = $if_end_date ? strtotime($query_end_date) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('between', array($start_unixtime, $end_unixtime));
        }
        $order_list = $order_model->getOrderList($condition, '15', '*', 'order_id desc', '', array('order_goods', 'order_common','ppintuanorder', 'member'));

        foreach ($order_list as $key => $order_info) {
            if(isset($order_info['extend_order_goods'])){
                foreach ($order_info['extend_order_goods'] as $value) {
                    $value['image_240_url'] = goods_cthumb($value['goods_image'], 240, $value['store_id']);
                    $value['goods_type_cn'] = get_order_goodstype($value['goods_type']);
                    $value['goods_url'] = url('Goods/index', ['goods_id' => $value['goods_id']]);
                    if ($value['goods_type'] == 5) {
                        $order_info['zengpin_list'][] = $value;
                    } else {
                        $order_info['goods_list'][] = $value;
                    }
                }

                if (empty($order_info['zengpin_list'])) {
                $order_info['goods_count'] = count($order_info['goods_list']);
            } else {
                $order_info['goods_count'] = count($order_info['goods_list']) + 1;
            }
            }
            $order_list[$key] = $order_info;
        }
        $this->assign('order_list', $order_list);
        $this->assign('show_page', $order_model->page_info->render());
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellerdeliver');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem(input('param.state'));
        return $this->fetch($this->template_dir.'index');
    }

    /**
     * 发货
     */
    public function send() {
        $order_id = input('param.order_id');
        if ($order_id <= 0) {
            ds_json_encode(10001,lang('wrong_argument'));
        }

        $order_model = model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = session('store_id');
        $order_info = $order_model->getOrderInfo($condition, array('order_common', 'order_goods'));
        $if_allow_send = intval($order_info['lock_state']) || !in_array($order_info['order_state'], array(ORDER_STATE_PAY, ORDER_STATE_SEND));
        if ($if_allow_send) {
            ds_json_encode(10001,lang('wrong_argument'));
        }

        if (!request()->isPost()) {
            $this->assign('order_info', $order_info);
            //取发货地址
            $daddress_model = model('daddress');
            $daddress_info = array();
            if ($order_info['extend_order_common']['daddress_id'] > 0) {
                $daddress_info = $daddress_model->getAddressInfo(array('daddress_id' => $order_info['extend_order_common']['daddress_id']));
            }
            if(empty($daddress_info)){
                //取默认地址
                $daddress_info = $daddress_model->getAddressList(array('store_id' => session('store_id')), '*', 'daddress_isdefault desc', 1);
                if (!empty($daddress_info)) {
                    $daddress_info = $daddress_info[0];
                    //写入发货地址编号
                    $this->_edit_order_daddress($daddress_info['daddress_id'], $order_id);
                } else {
                    //写入发货地址编号
                    $this->_edit_order_daddress(0, $order_id);
                }
            }
            $this->assign('daddress_info', $daddress_info);

            //如果是自提订单，只保留自提快递公司
            $express_list = rkcache('express', true);

            if (!empty($order_info['extend_order_common']['reciver_info']['dlyp'])) {
                foreach ($express_list as $k => $v) {
                    if ($v['express_zt_state'] == '0')
                        unset($express_list[$k]);
                }
                $my_express_list = array_keys($express_list);
            } else {
                //快递公司
                $my_express_list = ds_getvalue_byname('storeextend', 'store_id', session('store_id'), 'express');
                if (!empty($my_express_list)) {
                    $my_express_list = explode(',', $my_express_list);
                }
            }

            $this->assign('my_express_list', $my_express_list);
            $this->assign('express_list', $express_list);
            
            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('sellerdeliver');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('');
            return $this->fetch($this->template_dir.'send');
        } else {
            $logic_order = model('order','logic');
            $post = input('post.');
            $post['reciver_info'] = $this->_get_reciver_info();
            $result = $logic_order->changeOrderSend($order_info, 'seller', session('member_name'), $post);
            if (!$result['code']) {
                ds_json_encode(10001,$result['msg']);
            } else {
                ds_json_encode(10000,$result['msg']);
            }
        }
    }

    /**
     * 编辑收货地址
     * @return boolean
     */
    public function buyer_address_edit() {
        $order_id = input('param.order_id');
        if ($order_id <= 0){
            return false;
        }
        $order_model = model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = session('store_id');
        $order_common_info = $order_model->getOrdercommonInfo($condition);
        if (!$order_common_info){
            return false;
        }
        $order_common_info['reciver_info'] = @unserialize($order_common_info['reciver_info']);
        $this->assign('address_info', $order_common_info);
        return $this->fetch($this->template_dir.'buyer_address_edit');
    }

    /**
     * 收货地址保存
     */
    public function buyer_address_save() {
        $order_model = model('order');
        $data = array();
        $data['reciver_name'] = input('post.reciver_name');
        $data['reciver_info'] = $this->_get_reciver_info();
        $condition = array();
        $condition['order_id'] = intval(input('post.order_id'));
        $condition['store_id'] = session('store_id');
        $result = $order_model->editOrdercommon($data, $condition);
        if ($result) {
            echo 'true';
        } else {
            echo 'flase';
        }
    }

    /**
     * 组合reciver_info
     */
    private function _get_reciver_info() {
        $reciver_info = array(
            'address' => input('post.reciver_area') . ' ' . input('post.reciver_street'),
            'phone' => trim(input('post.reciver_mob_phone') . ',' . input('post.reciver_tel_phone'), ','),
            'area' => input('post.reciver_area'),
            'street' => input('post.reciver_street'),
            'mob_phone' => input('post.reciver_mob_phone'),
            'tel_phone' => input('post.reciver_tel_phone'),
            'dlyp' => input('post.reciver_dlyp'),
        );
        return serialize($reciver_info);
    }

    /**
     * 选择发货地址
     * @return boolean
     */
    public function send_address_select() {
        $address_list = model('daddress')->getAddressList(array('store_id' => session('store_id')));
        $this->assign('address_list', $address_list);
        $this->assign('order_id', input('param.order_id'));
        return $this->fetch($this->template_dir.'send_address_select');
    }

    /**
     * 保存发货地址修改
     */
    public function send_address_save() {
        $result = $this->_edit_order_daddress(input('post.daddress_id'), input('post.order_id'));
        if ($result>=0) {
            echo 'true';
        } else {
            echo 'flase';
        }
    }

    /**
     * 修改发货地址
     */
    private function _edit_order_daddress($daddress_id, $order_id) {
        $order_model = model('order');
        $data = array();
        $data['daddress_id'] = intval($daddress_id);
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = session('store_id');
        return $order_model->editOrdercommon($data, $condition);
    }

    /**
     * 物流跟踪
     */
    public function search_deliver() {
        $order_sn = input('param.order_sn');
        if (!is_numeric($order_sn)) {
            $this->error(lang('wrong_argument'));
        }

        $order_model = model('order');
        $condition['order_sn'] = $order_sn;
        $condition['store_id'] = session('store_id');
        $order_info = $order_model->getOrderInfo($condition, array('order_common', 'order_goods'));
        if (empty($order_info) || $order_info['shipping_code'] == '') {
            $this->error(lang('no_information_found'));
        }
        $order_info['state_info'] = get_order_state($order_info);
        $this->assign('order_info', $order_info);
        //卖家发货信息
        $daddress_info = model('daddress')->getAddressInfo(array('daddress_id' => $order_info['extend_order_common']['daddress_id']));
        $this->assign('daddress_info', $daddress_info);

        //取得配送公司代码
        $express = rkcache('express', true);
        $this->assign('express_code', $express[$order_info['extend_order_common']['shipping_express_id']]['express_code']);
        $this->assign('express_name', $express[$order_info['extend_order_common']['shipping_express_id']]['express_name']);
        $this->assign('express_url', $express[$order_info['extend_order_common']['shipping_express_id']]['express_url']);
        $this->assign('shipping_code', $order_info['shipping_code']);
        
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellerdeliver');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('');
        return $this->fetch($this->template_dir.'search_deliver');
    }

    /**
     * 延迟收货
     */
    public function delay_receive() {
        $order_id = input('param.order_id');
        $order_model = model('order');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = session('store_id');
        $condition['lock_state'] = 0;
        $order_info = $order_model->getOrderInfo($condition);

        //取目前系统最晚收货时间
        $delay_time = $order_info['delay_time'] +config('order_auto_receive_day') * 3600 * 24;
        if (request()->isPost()) {
            $delay_date = intval(input('post.delay_date'));
            if (!in_array($delay_date, array(5, 10, 15))) {
                ds_json_encode(10001,lang('wrong_argument'));
            }
            $update = $order_model->editOrder(array('delay_time' => Db::raw('delay_time+'.$delay_date * 3600 * 24)), $condition);
            if ($update) {
                //新的最晚收货时间
                $dalay_date = date('Y-m-d H:i:s', $delay_time + $delay_date * 3600 * 24);
                ds_json_encode(10000,lang('successful_delivery_deadline') . $dalay_date . '&emsp;');
            } else {
                ds_json_encode(10000,lang('delayed_failure'));
            }
        } else {
            $order_info['delay_time'] = $delay_time;
            $this->assign('order_info', $order_info);
            return $this->fetch($this->template_dir.'delay_receive');
        }
    }

    /**
     * 从第三方取快递信息
     *
     */
    public function get_express() {
        $url = 'http://www.kuaidi100.com/query?type=' . input('param.express_code') . '&postid=' . input('param.shipping_code') . '&id=1&valicode=&temp=' . random(4) . '&sessionid=&tmp=' . random(4);
        $content = http_request($url);
        $content = json_decode($content, true);
        if ($content['status'] != 200)
            exit(json_encode(false));
        $content['data'] = array_reverse($content['data']);
        $output = '';
        if (is_array($content['data'])) {
            foreach ($content['data'] as $k => $v) {
                if ($v['time'] == '')
                    continue;
                $output .= '<li>' . $v['time'] . '&nbsp;&nbsp;' . $v['context'] . '</li>';
            }
        }
        if ($output == '')
            exit(json_encode(false));
        echo json_encode($output);
    }

    /**
     * 运单打印
     */
    public function waybill_print() {
        $order_id = intval(input('param.order_id'));
        if ($order_id <= 0) {
            $this->error(lang('param_error'));
        }

        $order_model = model('order');
        $storewaybill_model = model('storewaybill');
        $waybill_model = model('waybill');

        $order_info = $order_model->getOrderInfo(array('order_id' => intval($order_id)), array('order_common'));

        $storewaybill_list = $storewaybill_model->getStorewaybillList(array('store_id' => $order_info['store_id']), 'storewaybill_isdefault desc');
        
        
        $storewaybill_id = intval(input('param..storewaybill_id'));
        $storewaybill_info = $this->_getCurrentWaybill($storewaybill_list, $storewaybill_id);
        
        
        if (empty($storewaybill_info)) {
            $this->error(lang('first_bind_print_template'), 'Sellerwaybill/index');
        }

        $waybill_info = $waybill_model->getWaybillInfo(array('waybill_id' => $storewaybill_info['waybill_id']));
        if (empty($waybill_info)) {
            $this->error(lang('first_bind_print_template'), 'Sellerwaybill/index');
        }

        //根据订单内容获取打印数据
        $print_info = $waybill_model->getPrintInfoByOrderInfo($order_info);

        //整理打印模板
        $storewaybill_data = unserialize($storewaybill_info['storewaybill_data']);
        
        if (!empty($waybill_info['waybill_data'])) {
            foreach ($waybill_info['waybill_data'] as $key => $value) {
                $waybill_info['waybill_data'][$key]['show'] = $storewaybill_data[$key]['show'];
                $waybill_info['waybill_data'][$key]['content'] = $print_info[$key];
            }
        }

        //使用商家自定义的偏移尺寸
        $waybill_info['waybill_pixel_top'] = $storewaybill_info['waybill_pixel_top'];
        $waybill_info['waybill_pixel_left'] = $storewaybill_info['waybill_pixel_left'];

        $this->assign('waybill_info', $waybill_info);
        $this->assign('storewaybill_list', $storewaybill_list);
        
        
        return $this->fetch($this->template_dir.'waybill_print');
    }

    /**
     * 获取当前打印模板
     */
    private function _getCurrentWaybill($storewaybill_list, $storewaybill_id) {
        if (empty($storewaybill_list)) {
            return false;
        }

        $storewaybill_id = intval($storewaybill_id);

        $storewaybill_info = null;

        //如果指定模板使用指定的模板，未指定使用默认模板
        if ($storewaybill_id > 0) {
            foreach ($storewaybill_list as $key => $value) {
                if ($storewaybill_id == $value['storewaybill_id']) {
                    $storewaybill_info = $storewaybill_list[$key];
                    break;
                }
            }
        }

        if (empty($storewaybill_info)) {
            $storewaybill_info = $storewaybill_list[0];
        }

        return $storewaybill_info;
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string	$menu_type	导航类型
     * @param string 	$name	当前导航的name
     * @return
     */
    protected function getSellerItemList()
    {
        $menu_array = array();
        $menu_type=request()->action();
        switch ($menu_type) {
            case 'index':
                $menu_array = array(
                    array('name' => 'deliverno', 'text' => lang('ds_member_path_deliverno'), 'url' => url('Sellerdeliver/index','state=deliverno')),
                    array('name' => 'delivering', 'text' => lang('ds_member_path_delivering'),  'url' => url('Sellerdeliver/index','state=delivering')),
                    array('name' => 'delivered', 'text' => lang('ds_member_path_delivered'), 'url' => url('Sellerdeliver/index','state=delivered')),
                );
                break;
            case 'search':
                $menu_array = array(
                     array('name' => 'nodeliver', 'text' => lang('ds_member_path_deliverno'), 'url' => url('Sellerdeliver/index/state/nodeliver')),
                     array('name' => 'delivering', 'text' => lang('ds_member_path_delivering'), 'url' => url('Sellerdeliver/index/state/delivering')),
                     array('name' => 'delivered', 'text' => lang('ds_member_path_delivered'), 'url' => url('Sellerdeliver/index/state/delivered')),
                     array('name' => 'search', 'text' => lang('ds_member_path_deliver_info'), 'url' => '###'),
                );
                break;
        }
        return $menu_array;
    }

}
