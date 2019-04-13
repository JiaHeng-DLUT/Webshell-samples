<?php

namespace app\home\controller;

use think\Lang;

class Sellerrefund extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerrefund.lang.php');
        $this->getRefundStateArray();
    }

    /**
     * 退款记录列表页
     *
     */
    public function index() {
        $refundreturn_model = model('refundreturn');
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['refund_type'] = '1'; //类型:1为退款,2为退货
        $keyword_type = array('order_sn', 'refund_sn', 'buyer_name');

        $key = input('key');
        $type = input('type');
        if (trim($key) != '' && in_array($type, $keyword_type)) {
            $condition[$type] = array('like', '%' . $key . '%');
        }
        $add_time_from = input('add_time_from');
        $add_time_to = input('add_time_to');
        if (trim($add_time_from) != '' || trim($add_time_to) != '') {

            if ($add_time_from !== false || $add_time_to !== false) {
                $condition['add_time'] = array('between time', array($add_time_from, $add_time_to));
            }
        }
        $seller_state = intval(input('state'));
        if ($seller_state > 0) {
            $condition['seller_state'] = $seller_state;
        }
        $order_lock = intval(input('lock'));
        if ($order_lock != 1) {
            $order_lock = 2;
        }
        $condition['order_lock'] = $order_lock;
        $refund_list = $refundreturn_model->getRefundList($condition, 10);
        $page=$refundreturn_model->page_info->render();

        $this->assign('refund_list', $refund_list);
        $this->assign('show_page', $page);


        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_refund');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem($order_lock);

        return $this->fetch($this->template_dir.'index');
    }

    /**
     * 退款审核页
     *
     */
    public function edit() {
        $refundreturn_model = model('refundreturn');
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['refund_id'] = intval(input('param.refund_id'));
        $refund_list = $refundreturn_model->getRefundList($condition);

        $refund = $refund_list[0];


        if (!request()->isPost()) {
            $this->assign('refund', $refund);
            $info['buyer'] = array();
            if (!empty($refund['pic_info'])) {
                $info = unserialize($refund['pic_info']);
            }
            $this->assign('pic_list', $info['buyer']);
            $member_model = model('member');
            $member = $member_model->getMemberInfoByID($refund['buyer_id']);
            $this->assign('member', $member);
            $condition = array();
            $condition['order_id'] = $refund['order_id'];
            $order = $refundreturn_model->getRightOrderList($condition, $refund['order_goods_id']);
            $this->assign('order', $order);
            $this->assign('store', $order['extend_store']);
            $this->assign('order_common', $order['extend_order_common']);
            $this->assign('goods_list', $order['goods_list']);


            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('seller_refund');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('');
            return $this->fetch($this->template_dir.'edit');
        } else {
            if ($refund['seller_state'] != '1') {//检查状态,防止页面刷新不及时造成数据错误
                ds_json_encode(10001,lang('wrong_argument'));
            }
            $order_id = $refund['order_id'];
            $refund_array = array();
            $refund_array['seller_time'] = time();
            $refund_array['seller_state'] = input('post.seller_state'); //卖家处理状态:1为待审核,2为同意,3为不同意
            $refund_array['seller_message'] = input('post.seller_message');
            if ($refund_array['seller_state'] == '3') {
                $refund_array['refund_state'] = '3'; //状态:1为处理中,2为待管理员处理,3为已完成
            } else {
                $refund_array['seller_state'] = '2';
                $refund_array['refund_state'] = '2';
            }
            $state = $refundreturn_model->editRefundreturn($condition, $refund_array);

            if ($state) {
                if ($refund_array['seller_state'] == '3' && $refund['order_lock'] == '2') {
                    $refundreturn_model->editOrderUnlock($order_id); //订单解锁
                }
                $this->recordSellerlog(lang('refund_processing') . $refund['refund_sn']);

                // 发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $refund['buyer_id'];
                $param['param'] = array(
                    'refund_url' => url('Memberrefund/view/', ['refund_id' => $refund['refund_id']]),
                    'refund_sn' => $refund['refund_sn']
                );
                \mall\queue\QueueClient::push('sendMemberMsg', $param);
                ds_json_encode(10000,lang('ds_common_save_succ'));
            } else {
                ds_json_encode(10001,lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 退款记录查看页
     *
     */
    public function view() {
        $refundreturn_model = model('refundreturn');
        $condition = array();
        $condition['store_id'] = session('store_id');
        $condition['refund_id'] = intval(input('param.refund_id'));
        $refund_list = $refundreturn_model->getRefundList($condition);

        $refund = $refund_list[0];
        $this->assign('refund', $refund);
        $info['buyer'] = array();
        if (!empty($refund['pic_info'])) {
            $info = unserialize($refund['pic_info']);
        }

        $this->assign('pic_list', $info['buyer']);
        $member_model = model('member');
        $member = $member_model->getMemberInfoByID($refund['buyer_id']);
        $this->assign('member', $member);
        $condition = array();
        $condition['order_id'] = $refund['order_id'];
        $order = $refundreturn_model->getRightOrderList($condition, $refund['order_goods_id']);
        $this->assign('order', $order);
        $this->assign('store', $order['extend_store']);
        $this->assign('order_common', $order['extend_order_common']);
        $this->assign('goods_list', $order['goods_list']);

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_refund');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('');
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
            '3' => lang('has_been_completed')
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
                'url' => url('Sellerrefund/index',['lock'=>2])
            ),
            array(
                'name' => '1',
                'text' => lang('after_refund'),
                'url' => url('Sellerrefund/index',['lock'=>1])
            ),
        );
        return $menu_array;
    }

}
