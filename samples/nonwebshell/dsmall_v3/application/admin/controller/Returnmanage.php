<?php

namespace app\admin\controller;

use think\Lang;

class Returnmanage extends AdminControl {

    const EXPORT_SIZE = 1000;
    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/returnmanage.lang.php');
        //向模板页面输出退款退货状态
        $this->getRefundStateArray();
    }

    function getRefundStateArray($type = 'all') {
        $state_array = array(
            '1' => lang('refund_state_confirm'),
            '2' => lang('refund_state_yes'),
            '3' => lang('refund_state_no')
        ); //卖家处理状态:1为待审核,2为同意,3为不同意
        $this->assign('state_array', $state_array);

        $admin_array = array(
            '1' => '处理中',
            '2' => '待处理',
            '3' => '已完成'
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
     * 待处理列表
     */
    public function return_manage() {
        $refundreturn_model = model('refundreturn');
        $condition = array();
        $condition['refund_state'] = '2'; //状态:1为处理中,2为待管理员处理,3为已完成
        $keyword_type = array('order_sn', 'refund_sn', 'store_name', 'buyer_name', 'goods_name');

        $key = input('get.key');
        $type = input('get.type');
        if (trim($key) != '' && in_array($type, $keyword_type)) {
            $condition[$type] = array('like', '%' . $key . '%');
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
        $return_list = $refundreturn_model->getReturnList($condition, 10);

        $this->assign('return_list', $return_list);
        $this->assign('show_page', $refundreturn_model->page_info->render());
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        
        $this->setAdminCurItem('return_manage');
        return $this->fetch('return_manage');
    }

    /**
     * 所有记录
     */
    public function return_all() {
        $refundreturn_model = model('refundreturn');
        $condition = array();

        $keyword_type = array('order_sn', 'refund_sn', 'store_name', 'buyer_name', 'goods_name');
        $key = input('get.key');
        $type = input('get.type');
        if (trim($key) != '' && in_array($type, $keyword_type)) {
            $condition[$type] = array('like', '%' . $key . '%');
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
        $return_list = $refundreturn_model->getReturnList($condition, 10);
        $this->assign('return_list', $return_list);
        $this->assign('show_page', $refundreturn_model->page_info->render());
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        $this->setAdminCurItem('return_all');
        return $this->fetch('return_all');
    }

    /**
     * 退货处理页
     *
     */
    public function edit() {
        $refundreturn_model = model('refundreturn');
        $condition = array();
        $condition['refund_id'] = intval(input('param.refund_id'));
        $return_list = $refundreturn_model->getReturnList($condition);
        $return = $return_list[0];
        if (request()->isPost()) {
            if ($return['refund_state'] != '2') {//检查状态,防止页面刷新不及时造成数据错误
                $this->error(lang('ds_common_save_fail'));
            }
            $order_id = $return['order_id'];
            $refund_array = array();
            $refund_array['admin_time'] = time();
            $refund_array['refund_state'] = '3'; //状态:1为处理中,2为待管理员处理,3为已完成
            $refund_array['admin_message'] = input('post.admin_message');
            $state = $refundreturn_model->editOrderRefund($return);
            if ($state) {
                $refundreturn_model->editRefundreturn($condition, $refund_array);
                $this->log('退货确认，退货编号' . $return['refund_sn']);

                // 发送买家消息
                $param = array();
                $param['code'] = 'refund_return_notice';
                $param['member_id'] = $return['buyer_id'];
                $param['param'] = array(
                    'refund_url' => url('Home/memberreturn/view', array('return_id' => $return['refund_id'])),
                    'refund_sn' => $return['refund_sn']
                );
                \mall\queue\QueueClient::push('sendMemberMsg', $param);

                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
        $this->assign('return', $return);
        $info['buyer'] = array();
        if (!empty($return['pic_info'])) {
            $info[] = unserialize($return['pic_info']);
        }
        $this->assign('pic_list', $info['buyer']);
        return $this->fetch('edit');
    }

    /**
     * 退货记录查看页
     *
     */
    public function view() {
        $refundreturn_model = model('refundreturn');
        $condition = array();
        $condition['refund_id'] = intval(input('param.refund_id'));
        $return_list = $refundreturn_model->getReturnList($condition);
        $return = $return_list[0];
        $this->assign('return', $return);
        $info['buyer'] = array();
        if (!empty($return['pic_info'])) {
            $info = unserialize($return['pic_info']);
        }
        $info['buyer'] ='';
        $this->assign('pic_list', $info['buyer']);
        return $this->fetch('view');
    }


    /**
     * 导出
     *
     */
    public function export_step1() {

        $refundreturn_model = model('refundreturn');
        $condition = array();

        $keyword_type = array('order_sn', 'refund_sn', 'store_name', 'buyer_name', 'goods_name');
        $key = input('get.key');
        $type = input('get.type');
        if (trim($key) != '' && in_array($type, $keyword_type)) {
            $condition[$type] = array('like', '%' . $key . '%');
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
        if (!is_numeric(input('param.curpage'))) {
            $count = $refundreturn_model->getReturnCount($condition);
            $export_list = array();
            if ($count > self::EXPORT_SIZE) { //显示下载链接
                $page = ceil($count / self::EXPORT_SIZE);
                for ($i = 1; $i <= $page; $i++) {
                    $limit1 = ($i - 1) * self::EXPORT_SIZE + 1;
                    $limit2 = $i * self::EXPORT_SIZE > $count ? $count : $i * self::EXPORT_SIZE;
                    $export_list[$i] = $limit1 . ' ~ ' . $limit2;
                }
                $this->assign('export_list', $export_list);
                return $this->fetch('/public/excel');
            } else { //如果数量小，直接下载
                $data = $refundreturn_model->getReturnList($condition, '', '*', 'refund_id desc', self::EXPORT_SIZE);
                $this->createExcel($data);
            }
        } else { //下载
            $limit1 = (input('param.curpage') - 1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $refundreturn_model->getReturnList($condition, '', '*', 'refund_id desc', "{$limit1},{$limit2}");
            $this->createExcel($data);
        }
    }

    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel($data = array()) {
        Lang::load(APP_PATH .'admin/lang/'.config('default_lang').'/export.lang.php');
        $excel_obj = new \excel\Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id' => 's_title', 'Font' => array('FontName' => '宋体', 'Size' => '12', 'Bold' => '1')));
        //header
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_th_order_ordersn'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_th_order_returnsn'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_th_store_name'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_th_goods_name'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_th_buyer_name'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_th_add_time'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_th_refund_amount'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_th_goods_num'));
        //data
        foreach ((array) $data as $k => $v) {
            $tmp = array();
            $tmp[] = array('data' => 'DS' . $v['order_sn']);
            $tmp[] = array('data' => $v['refund_sn']);
            $tmp[] = array('data' => $v['store_name']);
            $tmp[] = array('data' => $v['goods_name']);
            $tmp[] = array('data' => $v['buyer_name']);
            $tmp[] = array('data' => date('Y-m-d H:i:s', $v['add_time']));
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['refund_amount']));
            $tmp[] = array('data' => $v['goods_num']);
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data, CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(lang('exp_th_return'), CHARSET));
        $excel_obj->generateXML($excel_obj->charset(lang('exp_th_return'), CHARSET) . input('param.curpage') . '-' . date('Y-m-d-H', time()));
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'return_manage',
                'text' => '待审核',
                'url' => url('Returnmanage/return_manage')
            ),
            array(
                'name' => 'return_all',
                'text' => '所有记录',
                'url' => url('Returnmanage/return_all')
            ),
        );
        if(request()->action() == 'edit') {
            $menu_array[] = array(
                'name' => 'edit', 'text' => '审核', 'url' => 'javascript:void(0)',
            );
        }
        return $menu_array;
    }

}

?>
