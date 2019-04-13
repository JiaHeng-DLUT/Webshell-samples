<?php

namespace app\home\controller;

use think\Lang;

class Sellerreturn extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerreturn.lang.php');
        //向模板页面输出退款退货状态
        $this->getRefundStateArray();
    }

    /**
     * 退货记录列表页
     *
     */
    public function index() {
        $refundreturn_model = model('refundreturn');
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['refund_type'] = '2'; //类型:1为退款,2为退货
        $keyword_type = array('order_sn', 'refund_sn', 'buyer_name');

        $keyword = input('get.keyword');
        $type = input('get.type');
        if (trim($keyword) != '' && in_array($type, $keyword_type)) {
            $condition[$type] = array('like', '%' . $keyword . '%');
        }
        $add_time_from = input('get.add_time_from');
        $add_time_to = input('get.add_time_to');
        if (trim($add_time_from) != '' || trim($add_time_to) != '') {
            $add_time_from = strtotime(trim($add_time_from));
            $add_time_to = strtotime(trim($add_time_to));
            if ($add_time_from !== false || $add_time_to !== false) {
                $condition['add_time'] = array('between', array($add_time_from, $add_time_to));
            }
        }
        $seller_state = intval(input('get.state'));
        if ($seller_state > 0) {
            $condition['seller_state'] = $seller_state;
        }
        $order_lock = intval(input('param.lock'));
        if ($order_lock != 1) {
            $order_lock = 2;
        }
        $condition['order_lock'] = $order_lock;
        $return_list = $refundreturn_model->getReturnList($condition, 10);

        $this->assign('return_list', $return_list);
        //分页
        $show_page = $refundreturn_model->page_info->render();
        $this->assign('show_page', $show_page);

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_return');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem($order_lock);

        return $this->fetch($this->template_dir.'index');
    }

    /**
     * 退货审核页
     */
    public function edit() {
        $refundreturn_model = model('refundreturn');
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['refund_id'] = intval(input('param.return_id'));
        $return_list = $refundreturn_model->getReturnList($condition);
        $return = $return_list[0];
        if (!request()->isPost()) {
            $this->assign('return', $return);
            $info['buyer'] = array();
            if (!empty($return['pic_info'])) {
                $info = unserialize($return['pic_info']);
            }
//            $this->assign('pic_list', $info['buyer']);
            $this->assign('pic_list', '');
            $member_model = model('member');
            $member = $member_model->getMemberInfoByID($return['buyer_id']);
            $this->assign('member', $member);
            $condition = array();
            $condition['order_id'] = $return['order_id'];
            $order = $refundreturn_model->getRightOrderList($condition, $return['order_goods_id']);
            $this->assign('order', $order);
            $this->assign('store', $order['extend_store']);
            $this->assign('order_common', $order['extend_order_common']);
            $this->assign('goods_list', $order['goods_list']);

            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('seller_return');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem();
            return $this->fetch($this->template_dir.'edit');
        } else {
            if ($return['seller_state'] != '1') {
                ds_json_encode(10001,lang('wrong_argument'));
            }
            $order_id = $return['order_id'];
            $refund_array = array();
            $refund_array['seller_time'] = time();
            $refund_array['seller_state'] = input('post.seller_state'); //卖家处理状态:1为待审核,2为同意,3为不同意
            $refund_array['seller_message'] = input('post.seller_message');

            if ($refund_array['seller_state'] == '2' && empty(input('post.return_type'))) {
                $refund_array['return_type'] = '2'; //退货类型:1为不用退货,2为需要退货
            } elseif ($refund_array['seller_state'] == '3') {
                $refund_array['refund_state'] = '3'; //状态:1为处理中,2为待管理员处理,3为已完成
            } else {
                $refund_array['seller_state'] = '2';
                $refund_array['refund_state'] = '2';
                $refund_array['return_type'] = '1'; //选择弃货
            }
            $state = $refundreturn_model->editRefundreturn($condition, $refund_array);
            if ($state) {
                if ($refund_array['seller_state'] == '3' && $return['order_lock'] == '2') {
                    $refundreturn_model->editOrderUnlock($order_id); //订单解锁
                }
                $this->recordSellerlog(lang('any_returns') . $return['refund_sn']);

                // 发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $return['buyer_id'];
                $param['param'] = array(
                    'refund_url' => url('Memberreturn/view', ['return_id' => $return['refund_id']]),
                    'refund_sn' => $return['refund_sn']
                );
                \mall\queue\QueueClient::push('sendMemberMsg', $param);
                ds_json_encode(10000,lang('ds_common_save_succ'));
            } else {
                ds_json_encode(10001,lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 收货
     *
     */
     public function receive() {
        $refundreturn_model = model('refundreturn');
        $trade_model = model('trade');
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['refund_id'] = intval(input('param.return_id'));
        $return_list = $refundreturn_model->getReturnList($condition);
        $return = $return_list[0];
        $this->assign('return', $return);
        $return_delay = $trade_model->getMaxDay('return_delay'); //发货默认5天后才能选择没收到
        $delay_time = time() - $return['delay_time'] - 60 * 60 * 24 * $return_delay;
        $this->assign('return_delay', $return_delay);
        $this->assign('return_confirm', $trade_model->getMaxDay('return_confirm')); //卖家不处理收货时按同意并弃货处理
        $this->assign('delay_time', $delay_time);
        if (!request()->isPost()) {
            $express_list = rkcache('express', true);
            if ($return['express_id'] > 0 && !empty($return['invoice_no'])) {
                $this->assign('express_name', $express_list[$return['express_id']]['express_name']);
                $this->assign('express_code', $express_list[$return['express_id']]['express_code']);
            }
            return $this->fetch($this->template_dir.'receive');
        } else {

            if ($return['seller_state'] != '2' || $return['goods_state'] != '2') {//检查状态,防止页面刷新不及时造成数据错误
                ds_json_encode(10001,lang('wrong_argument'));
            }
            $refund_array = array();
            if (input('post.return_type') == '3' && $delay_time > 0) {
                $refund_array['goods_state'] = '3';
            } else {
                $refund_array['receive_time'] = time();
                $refund_array['receive_message'] = lang('confirm_receipt_goods_completed');
                $refund_array['refund_state'] = '2'; //状态:1为处理中,2为待管理员处理,3为已完成
                $refund_array['goods_state'] = '4';
            }
            $state = $refundreturn_model->editRefundreturn($condition, $refund_array);
            if ($state) {
                $this->recordSellerlog(lang('confirm_receipt_goods_returned') . $return['refund_sn']);
                
                // 发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $return['buyer_id'];
                $param['param'] = array(
                    'refund_url' => url('Memberreturn/view',['return_id'=>$return['refund_id']]),
                    'refund_sn' => $return['refund_sn']
                );
                \mall\queue\QueueClient::push('sendMemberMsg', $param);
                ds_json_encode(10000,lang('ds_common_save_succ'));
            } else {
                ds_json_encode(10001,lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 退货记录查看页
     *
     */
    public function view() {
        $refundreturn_model = model('refundreturn');
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['refund_id'] = intval(input('param.return_id'));
        $return_list = $refundreturn_model->getReturnList($condition);
        $return = $return_list[0];
        $this->assign('return', $return);
        $express_list = rkcache('express', true);
        if ($return['express_id'] > 0 && !empty($return['invoice_no'])) {
            $this->assign('express_name', $express_list[$return['express_id']]['express_name']);
            $this->assign('express_code', $express_list[$return['express_id']]['express_code']);
        }
        $info['buyer'] = array();
        if (!empty($return['pic_info'])) {
            $info = unserialize($return['pic_info']);
        }
//        $this->assign('pic_list', $info['buyer']);
        $this->assign('pic_list', '');
        $member_model = model('member');
        $member = $member_model->getMemberInfoByID($return['buyer_id']);
        $this->assign('member', $member);
        $condition = array();
        $condition['order_id'] = $return['order_id'];
        $order = $refundreturn_model->getRightOrderList($condition, $return['order_goods_id']);
        $this->assign('order', $order);
        $this->assign('store', $order['extend_store']);
        $this->assign('order_common', $order['extend_order_common']);
        $this->assign('goods_list', $order['goods_list']);
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_return');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem();
        return $this->fetch($this->template_dir.'view');
    }

    function getRefundStateArray($type = 'all') {
        $state_array = array(
            '1' => lang('refund_state_confirm'),
            '2' => lang('refund_state_yes'),
            '3' => lang('refund_state_no')
        ); //卖家处理状态:1为待审核,2为同意,3为不同意
        $this->assign('state_array', $state_array);

        $admin_array = array(
            '1' => lang('in_processing'),
            '2' => lang('to_processed'),
            '3' => lang('has_been_completed'),
        ); //确认状态:1为买家或卖家处理中,2为待平台管理员处理,3为退款退货已完成
        $this->assign('admin_array', $admin_array);

        $state_data = array(
            'seller' => $state_array,
            'admin' => $admin_array
        );
        if ($type == 'all') {
            return $state_data; //返回所有
        }
        return $state_data[$type];
    }
    
    
    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    function getSellerItemList() {
        $menu_array = array(
            array(
                'name' => '2',
                'text' => lang('before_refund'),
                'url' => url('Sellerreturn/index',['lock'=>2])
            ),
            array(
                'name' => '1',
                'text' => lang('after_refund'),
                'url' => url('Sellerreturn/index',['lock'=>1])
            ),
        );
        return $menu_array;
    }


}
