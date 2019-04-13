<?php

/*
 * 虚拟订单
 */

namespace app\home\controller;

use think\Lang;

class Sellervrorder extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellervrorder.lang.php');
    }

    /**
     * 虚拟订单列表
     *
     */
    public function index() {
        $vrorder_model = model('vrorder');

        $condition = array();
        $condition['store_id'] = session('store_id');

        $order_sn = input('get.order_sn');
        if ($order_sn != '') {
            $condition['order_sn'] = $order_sn;
        }
        $buyer_name = input('get.buyer_name');
        if ($buyer_name != '') {
            $condition['buyer_name'] = $buyer_name;
        }
        $allow_state_array = array('state_new', 'state_pay', 'state_success', 'state_cancel');
        $state_type = input('param.state_type');
        if (in_array($state_type, $allow_state_array)) {
            $condition['order_state'] = str_replace($allow_state_array, array(ORDER_STATE_NEW, ORDER_STATE_PAY, ORDER_STATE_SUCCESS, ORDER_STATE_CANCEL), $state_type);
        } else {
            $state_type = 'store_order';
        }
        $query_start_date = input('get.query_start_date');
        $query_end_date = input('get.query_end_date');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_end_date);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_start_date);
        $start_unixtime = $if_start_date ? strtotime($query_end_date) : null;
        $end_unixtime = $if_end_date ? strtotime($query_start_date) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['add_time'] = array('between', array($start_unixtime, $end_unixtime));
        }

        $skip_off = input('get.skip_off');
        if ($skip_off == 1) {
            $condition['order_state'] = array('neq', ORDER_STATE_CANCEL);
        }

        $order_list = $vrorder_model->getVrorderList($condition, 20, '*', 'order_id desc');
        $this->assign('show_page', $vrorder_model->page_info->render());
        
        foreach ($order_list as $key => $order) {
            //显示取消订单
            $order_list[$key]['if_cancel'] = $vrorder_model->getVrorderOperateState('buyer_cancel', $order);

            //追加返回买家信息
            $order_list[$key]['extend_member'] = model('member')->getMemberInfoByID($order['buyer_id']);
        }

        $this->assign('order_list', $order_list);



        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellervrorder');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem($state_type);
        return $this->fetch($this->template_dir.'index');
    }

    /**
     * 卖家订单详情
     *
     */
    public function show_order() {
        $order_id = intval(input('param.order_id'));
        if ($order_id <= 0) {
            $this->error(lang('wrong_argument'));
        }
        $vrorder_model = model('vrorder');
        $condition = array();
        $condition['order_id'] = $order_id;
        $condition['store_id'] = session('store_id');
        $order_info = $vrorder_model->getVrorderInfo($condition);
        if (empty($order_info)) {
            $this->error(lang('store_order_none_exist'));
        }

        //取兑换码列表
        $vr_code_list = $vrorder_model->getShowVrordercodeList(array('order_id' => $order_info['order_id']));
        $order_info['extend_vr_order_code'] = $vr_code_list;

        //显示取消订单
        $order_info['if_cancel'] = $vrorder_model->getVrorderOperateState('buyer_cancel', $order_info);

        //显示订单进行步骤
        $order_info['step_list'] = $vrorder_model->getVrorderStep($order_info);

        //显示系统自动取消订单日期
        if ($order_info['order_state'] == ORDER_STATE_NEW) {
            $order_info['order_cancel_day'] = $order_info['add_time'] + config('order_auto_cancel_day') * 24 * 3600;
        }

        $this->assign('order_info', $order_info);
        $this->setSellerCurMenu('sellervrorder');
        $this->setSellerCurItem('store_order');

        return $this->fetch($this->template_dir.'show_order');
    }

    /**
     * 卖家订单状态操作
     *
     */
    public function change_state() {
        $vrorder_model = model('vrorder');
        $condition = array();
        $condition['order_id'] = intval(input('param.order_id'));
        $condition['store_id'] = session('store_id');
        $order_info = $vrorder_model->getVrorderInfo($condition);
        $state_type = input('param.state_type');
        if ($state_type == 'order_cancel') {
            $result = $this->_order_cancel($order_info, input('post.'));
        }
        if (!isset($result['code'])) {
            ds_json_encode(10001,lang('error'));
        } else {
            ds_json_encode(10000,$result['msg']);
        }
    }

    /**
     * 取消订单
     * @param arrty $order_info
     * @param arrty $post
     * @throws Exception
     */
    private function _order_cancel($order_info, $post) {
        if (!request()->isPost()) {
            $this->assign('order_id', $order_info['order_id']);
            $this->assign('order_info', $order_info);
            echo $this->fetch($this->template_dir.'cancel');
            exit();
        } else {
            $vrorder_model = model('vrorder');
            $logic_vrorder = model('vrorder','logic');
            $if_allow = $vrorder_model->getVrorderOperateState('store_cancel', $order_info);
            if (!$if_allow) {
                return ds_callback(false,lang('have_right_operate'));
            }
            $msg = $post['state_info1'] != '' ? $post['state_info1'] : $post['state_info'];
            return $logic_vrorder->changeOrderStateCancel($order_info, 'seller', $msg);
        }
    }

    public function exchange() {
        $data = $this->_exchange();
        exit(json_encode($data));
    }

    /**
     * 兑换码消费
     */
    private function _exchange() {
        if (input('param.submit_exchange')=='ok') {
            if (!preg_match('/^[a-zA-Z0-9]{15,18}$/', input('get.vr_code'))) {
                return array('error' => lang('exchange_code_format_error'));
            }
            $vrorder_model = model('vrorder');
            $vr_code_info = $vrorder_model->getVrordercodeInfo(array('vr_code' => input('get.vr_code')));
            if (empty($vr_code_info) || $vr_code_info['store_id'] != session('store_id')) {
                return array('error' => lang('exchange_code_not_exist'));
            }
            if ($vr_code_info['vr_state'] == '1') {
                return array('error' => lang('exchange_code_been_used'));
            }
            if ($vr_code_info['vr_indate'] < TIMESTAMP) {
                return array('error' => lang('exchange_code_expired') . date('Y-m-d H:i:s', $vr_code_info['vr_indate']));
            }
            if ($vr_code_info['refund_lock'] > 0) {//退款锁定状态:0为正常,1为锁定(待审核),2为同意
                return array('error' => lang('exchange_code_been_applied_refund'));
            }

            //更新兑换码状态
            $update = array();
            $update['vr_state'] = 1;
            $update['vr_usetime'] = TIMESTAMP;
            $update = $vrorder_model->editVrorderCode($update, array('vr_code' => input('get.vr_code')));

            //如果全部兑换完成，更新订单状态
            model('vrorder','logic')->changeOrderStateSuccess($vr_code_info['order_id']);

            if ($update) {
                //取得返回信息
                $order_info = $vrorder_model->getVrorderInfo(array('order_id' => $vr_code_info['order_id']));
                if ($order_info['use_state'] == '0') {
                    $vrorder_model->editVrorder(array('use_state' => 1), array('order_id' => $vr_code_info['order_id']));
                }
                $order_info['img_240'] = goods_thumb($order_info, 240);
                $order_info['goods_url'] = url('Goods/index',['goods_id'=>$order_info['goods_id']]);
                $order_info['order_url'] = url('Sellervrorder/show_order',['order_id'=>$order_info['order_id']]);
                return array('error' => '', 'data' => $order_info);
            }
        } else {
            $state_type = input('state_type');;
            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('sellervrorder');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem($state_type);
            echo $this->fetch($this->template_dir.'exchange');
            exit;
        }
    }

    /**
     *    栏目菜单
     */
    function getSellerItemList() {
        $menu_array = array(
            array(
                'name' => 'store_order',
                'text' => lang('ds_member_path_all_order'),
                'url' => url('Sellervrorder/index'),
            ),
            array(
                'name' => 'state_new',
                'text' => lang('ds_member_path_wait_pay'),
                'url' => url('Sellervrorder/index', ['state_type' => 'state_new']),
            ),
            array(
                'name' => 'state_pay',
                'text' => lang('payment_been'),
                'url' => url('Sellervrorder/index', ['state_type' => 'state_pay']),
            ),
            array(
                'name' => 'state_success',
                'text' => lang('ds_member_path_finished'),
                'url' => url('Sellervrorder/index', ['state_type' => 'state_success']),
            ),
            array(
                'name' => 'state_cancel',
                'text' => lang('ds_member_path_canceled'),
                'url' => url('Sellervrorder/index', ['state_type' => 'state_cancel']),
            ),
        );
        if (request()->action() === 'exchange') {
            $menu_array[] = array(
                'name' => 'exchange',
                'text' => lang('exchange_code'),
                'url' => url('Sellervrorder/exchange'),
            );
        }
        return $menu_array;
    }


}
