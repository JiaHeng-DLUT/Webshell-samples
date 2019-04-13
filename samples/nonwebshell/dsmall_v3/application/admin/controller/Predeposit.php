<?php

namespace app\admin\controller;

use think\Lang;

class Predeposit extends AdminControl {
    const EXPORT_SIZE = 1000;
    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/predeposit.lang.php');
    }

    /*
     * 充值明细
     */

    public function pdrecharge_list() {
        $condition = array();
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', input('param.query_start_date'));
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', input('param.query_end_date'));
        $start_unixtime = $if_start_date ? strtotime(input('param.query_start_date')) : null;
        $end_unixtime = $if_end_date ? strtotime(input('param.query_end_date')) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['pdr_addtime'] = array('between', array($start_unixtime, $end_unixtime));
        }
        if (input('param.mname') != '') {
            $condition['pdr_member_name'] = array('like', "%" . input('param.mname') . "%");
        }
        if (input('param.paystate_search') != '') {
            $condition['pdr_payment_state'] = input('param.paystate_search');
        }
        $predeposit_model = model('predeposit');
        $recharge_list = $predeposit_model->getPdRechargeList($condition, 20, '*', 'pdr_id desc');
        $this->assign('recharge_list', $recharge_list);
        $this->assign('show_page', $predeposit_model->page_info->render());
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        
        $this->setAdminCurItem('pdrecharge_list');
        return $this->fetch();
    }

    /**
     * 充值编辑(更改成收到款)
     */
    public function recharge_edit() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            $this->error(lang('admin_predeposit_parameter_error'), 'Predeposit/pdrecharge_list');
        }
        //查询充值信息
        $predeposit_model = model('predeposit');
        $condition = array();
        $condition['pdr_id'] = $id;
        $condition['pdr_payment_state'] = 0;
        $info = $predeposit_model->getPdRechargeInfo($condition);
        if (empty($info)) {
            $this->error(lang('admin_predeposit_record_error'), 'Predeposit/pdrecharge_list');
        }
        if (!request()->isPost()) {
            //显示支付接口列表
            $payment_list = model('payment')->getPaymentOpenList();
            //去掉预存款和货到付款
            foreach ($payment_list as $key => $value) {
                if ($value['payment_code'] == 'predeposit' || $value['payment_code'] == 'offline') {
                    unset($payment_list[$key]);
                }
            }
            $this->assign('payment_list', $payment_list);
            $this->assign('info', $info);
            return $this->fetch('recharge_edit');
        }

        //取支付方式信息
        $payment_model = model('payment');
        $condition = array();
        $condition['payment_code'] = input('post.payment_code');
        $payment_info = $payment_model->getPaymentOpenInfo($condition);
        if (!$payment_info || $payment_info['payment_code'] == 'offline' || $payment_info['payment_code'] == 'offline') {
            $this->error(lang('payment_index_sys_not_support'));
        }

        $condition = array();
        $condition['pdr_sn'] = $info['pdr_sn'];
        $condition['pdr_payment_state'] = 0;
        $update = array();
        $update['pdr_payment_state'] = 1;
        $update['pdr_paymenttime'] = strtotime(input('post.payment_time'));
        $update['pdr_payment_code'] = $payment_info['payment_code'];
        $update['pdr_trade_sn'] = input('post.trade_no');
        $update['pdr_admin'] = $this->admin_info['admin_name'];
        $log_msg = lang('admin_predeposit_recharge_edit_state') . ',' . lang('admin_predeposit_sn') . ':' . $info['pdr_sn'];

        try {
            $predeposit_model->startTrans();
            //更改充值状态
            $state = $predeposit_model->editPdRecharge($update, $condition);
            if (!$state) {
                throw Exception(lang('predeposit_payment_pay_fail'));
            }
            //变更会员预存款
            $data = array();
            $data['member_id'] = $info['pdr_member_id'];
            $data['member_name'] = $info['pdr_member_name'];
            $data['amount'] = $info['pdr_amount'];
            $data['pdr_sn'] = $info['pdr_sn'];
            $data['admin_name'] = $this->admin_info['admin_name'];
            $predeposit_model->changePd('recharge', $data);
            $predeposit_model->commit();
            $this->log($log_msg, 1);
            dsLayerOpenSuccess(lang('admin_predeposit_recharge_edit_success'));
        } catch (Exception $e) {
            $predeposit_model->rollback();
            $this->log($log_msg, 0);
            $this->error($e->getMessage(), 'Predeposit/pdrecharge_list');
        }
    }

    /**
     * 充值查看
     */
    public function recharge_info() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            $this->error(lang('admin_predeposit_parameter_error'), 'Predeposit/pdrecharge_list');
        }
        //查询充值信息
        $predeposit_model = model('predeposit');
        $condition = array();
        $condition['pdr_id'] = $id;
        $info = $predeposit_model->getPdRechargeInfo($condition);
        if (empty($info)) {
            $this->error(lang('admin_predeposit_record_error'), 'Predeposit/pdrecharge_list');
        }
        $this->assign('info', $info);
        return $this->fetch('recharge_info');
    }

    /**
     * 充值删除
     */
    public function recharge_del() {
        $pdr_id = input('param.pdr_id');
        $pdr_id_array = ds_delete_param($pdr_id);
        if($pdr_id_array === FALSE){
            ds_json_encode('10001', lang('param_error'));
        }
        $predeposit_model = model('predeposit');
        $condition = array();
        $condition = array('pdr_id' => array('in', $pdr_id_array));
        $condition['pdr_payment_state'] = 0;
        $result = $predeposit_model->delPdRecharge($condition);
        if ($result) {
            ds_json_encode('10000', lang('ds_common_del_succ'));
        } else {
            ds_json_encode('10001', lang('ds_common_del_fail'));
        }
    }



    /*
     * 预存款明细
     */

    public function pdlog_list() {
        $condition = array();
        $stime = input('get.stime');
        $etime = input('get.etime');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $stime);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $etime);
        $start_unixtime = $if_start_date ? strtotime($stime) : null;
        $end_unixtime = $if_end_date ? strtotime($etime) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['lg_addtime'] = array('between', array($start_unixtime, $end_unixtime));
        }
        $mname = input('get.mname');
        if (!empty($mname)) {
            $condition['lg_member_name'] = $mname;
        }
        $aname = input('get.aname');
        if (!empty($aname)) {
            $condition['lg_admin_name'] = $aname;
        }
        $predeposit_model = model('predeposit');
        $list_log = $predeposit_model->getPdLogList($condition, 10, '*', 'lg_id desc');
        $this->assign('show_page', $predeposit_model->page_info->render());
        $this->assign('list_log', $list_log);
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        
        $this->setAdminCurItem('pdlog_list');
        return $this->fetch();
    }

    /*
     * 提现列表
     */
    public function pdcash_list() {
        $condition = array();
        $stime = input('get.stime');
        $etime = input('get.etime');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $stime);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $etime);
        $start_unixtime = $if_start_date ? strtotime($stime) : null;
        $end_unixtime = $if_end_date ? strtotime($etime) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['pdc_addtime'] = array('between', array($start_unixtime, $end_unixtime));
        }
        $mname = input('get.mname');
        if (!empty($mname)) {
            $condition['pdc_member_name'] = array('like', "%" . $mname . "%");
        }
        $pdc_bank_user = input('get.pdc_bank_user');
        if (!empty($pdc_bank_user)) {
            $condition['pdc_bank_user'] = array('like', "%" . $pdc_bank_user . "%");
        }
        $paystate_search = input('get.paystate_search');
        if ($paystate_search != '') {
            $condition['pdc_payment_state'] = $paystate_search;
        }
        $predeposit_model = model('predeposit');
        $predeposit_list = $predeposit_model->getPdcashList($condition, 20, '*', 'pdc_payment_state asc,pdc_id asc');
        $this->assign('predeposit_list', $predeposit_list);
        $this->assign('show_page', $predeposit_model->page_info->render());
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        
        $this->setAdminCurItem('pdcash_list');
        return $this->fetch('pdcash_list');
    }

    /**
     * 删除提现记录
     */
    public function pdcash_del() {
        $pdc_id = intval(input('param.pdc_id'));
        if ($pdc_id <= 0) {
             ds_json_encode(10001, lang('param_error'));
        }
        $predeposit_model = model('predeposit');
        $condition = array();
        $condition['pdc_id'] = $pdc_id;
        $condition['pdc_payment_state'] = 0;
        $info = $predeposit_model->getPdcashInfo($condition);
        if (!$info) {
            ds_json_encode(10001, lang('admin_predeposit_parameter_error'));
        }
        try {
            $result = $predeposit_model->delPdcash($condition);
            if (!$result) {
                ds_json_encode(10001, lang('admin_predeposit_cash_del_fail'));
            }
            //退还冻结的预存款
            $member_model = model('member');
            $member_info = $member_model->getMemberInfo(array('member_id' => $info['pdc_member_id']));
            //扣除冻结的预存款
            $admininfo = $this->getAdminInfo();
            $data = array();
            $data['member_id'] = $member_info['member_id'];
            $data['member_name'] = $member_info['member_name'];
            $data['amount'] = $info['pdc_amount'];
            $data['order_sn'] = $info['pdc_sn'];
            $data['admin_name'] = $admininfo['admin_name'];
            $predeposit_model->changePd('cash_del', $data);
            $predeposit_model->commit();
            ds_json_encode(10000, lang('admin_predeposit_cash_del_success'));
        } catch (Exception $e) {
            $predeposit_model->commit();
            ds_json_encode(10001, lang($e->getMessage()));
        }
    }

    /**
     * 更改提现为支付状态
     */
    public function pdcash_pay() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            $this->error(lang('admin_predeposit_parameter_error'),'Predeposit/pdcash_list');
        }
        $predeposit_model = model('predeposit');
        $condition = array();
        $condition['pdc_id'] = $id;
        $condition['pdc_payment_state'] = 0;
        $info = $predeposit_model->getPdcashInfo($condition);
        if (!is_array($info) || count($info) < 0) {
            $this->error(lang('admin_predeposit_record_error'), 'Predeposit/pdcash_list');
        }
        //查询用户信息
        $member_model = model('member');
        $member_info = $member_model->getMemberInfo(array('member_id' => $info['pdc_member_id']));

        $update = array();
        $admininfo = $this->getAdminInfo();
        $update['pdc_payment_state'] = 1;
        $update['pdc_payment_admin'] = $admininfo['admin_name'];
        $update['pdc_payment_time'] = TIMESTAMP;
        $log_msg = lang('admin_predeposit_cash_edit_state') . ',' . lang('admin_predeposit_cs_sn') . ':' . $info['pdc_sn'];

        try {
            $predeposit_model->startTrans();
            $result = $predeposit_model->editPdcash($update, $condition);
            if (!$result) {
                $this->error(lang('admin_predeposit_cash_edit_fail'));
            }
            //扣除冻结的预存款
            $data = array();
            $data['member_id'] = $member_info['member_id'];
            $data['member_name'] = $member_info['member_name'];
            $data['amount'] = $info['pdc_amount'];
            $data['order_sn'] = $info['pdc_sn'];
            $data['admin_name'] = $admininfo['admin_name'];
            $predeposit_model->changePd('cash_pay', $data);
            $predeposit_model->commit();
            $this->log($log_msg, 1);
            dsLayerOpenSuccess(lang('admin_predeposit_cash_edit_success'));
        } catch (Exception $e) {
            $predeposit_model->rollback();
            $this->log($log_msg, 0);
            $this->error($e->getMessage(), 'Predeposit/pdcash_list');
        }
    }

    /**
     * 查看提现信息
     */
    public function pdcash_view() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            $this->error(lang('admin_predeposit_parameter_error'), 'Predeposit/pdcash_list');
        }
        $predeposit_model = model('predeposit');
        $condition = array();
        $condition['pdc_id'] = $id;
        $info = $predeposit_model->getPdcashInfo($condition);
        if (!is_array($info) || count($info) < 0) {
            $this->error(lang('admin_predeposit_record_error'), 'Predeposit/pdcash_list');
        }
        $this->assign('info', $info);
        return $this->fetch();
    }

    /*
     * 调节预存款
     */

    public function pd_add() {
        if (!(request()->isPost())) {
            $member_id = intval(input('get.member_id'));
            if($member_id>0){
                $condition['member_id'] = $member_id;
                $member = model('member')->getMemberInfo($condition);
                if(!empty($member)){
                    $this->assign('member_info',$member);
                }
            }
            return $this->fetch();
        } else {
            $data = array(
                'member_id' => input('post.member_id'),
                'amount' => input('post.amount'),
                'operatetype' => input('post.operatetype'),
                'lg_desc' => input('post.lg_desc'),
            );
            $predeposit_validate = validate('predeposit');
            if (!$predeposit_validate->scene('pd_add')->check($data)) {
                $this->error($predeposit_validate->getError());
            }

            $money = abs(floatval(input('post.amount')));
            $memo = trim(input('post.lg_desc'));
            if ($money <= 0) {
                $this->error('输入的金额必需大于0');
            }
            //查询会员信息
            $member_mod = model('member');
            $member_id = intval(input('post.member_id'));
            $operatetype = input('post.operatetype');
            $member_info = $member_mod->getMemberInfo(array('member_id' => $member_id));

            if (!is_array($member_info) || count($member_info) <= 0) {
                $this->error('用户不存在', 'Predeposit/pd_add');
            }
            $available_predeposit = floatval($member_info['available_predeposit']);
            $freeze_predeposit = floatval($member_info['freeze_predeposit']);
            if ($operatetype == 2 && $money > $available_predeposit) {
                $this->error(('预存款不足，会员当前预存款') . $available_predeposit, 'Predeposit/pd_add');
            }
            if ($operatetype == 3 && $money > $available_predeposit) {
                $this->error(('可冻结预存款不足，会员当前预存款') . $available_predeposit, 'Predeposit/pd_add');
            }
            if ($operatetype == 4 && $money > $freeze_predeposit) {
                $this->error(('可恢复冻结预存款不足，会员当前冻结预存款') . $freeze_predeposit, 'Predeposit/pd_add');
            }
            $predeposit_model = model('predeposit');
            #生成对应订单号
            $order_sn = makePaySn($member_id);
            $admininfo = $this->getAdminInfo();
            $log_msg = "管理员【" . $admininfo['admin_name'] . "】操作会员【" . $member_info['member_name'] . "】预存款，金额为" . $money . ",编号为" . $order_sn;
            $admin_act = "sys_add_money";
            switch ($operatetype) {
                case 1:
                    $admin_act = "sys_add_money";
                    $log_msg = "管理员【" . $admininfo['admin_name'] . "】操作会员【" . $member_info['member_name'] . "】预存款【增加】，金额为" . $money . ",编号为" . $order_sn;
                    break;
                case 2:
                    $admin_act = "sys_del_money";
                    $log_msg = "管理员【" . $admininfo['admin_name'] . "】操作会员【" . $member_info['member_name'] . "】预存款【减少】，金额为" . $money . ",编号为" . $order_sn;
                    break;
                case 3:
                    $admin_act = "sys_freeze_money";
                    $log_msg = "管理员【" . $admininfo['admin_name'] . "】操作会员【" . $member_info['member_name'] . "】预存款【冻结】，金额为" . $money . ",编号为" . $order_sn;
                    break;
                case 4:
                    $admin_act = "sys_unfreeze_money";
                    $log_msg = "管理员【" . $admininfo['admin_name'] . "】操作会员【" . $member_info['member_name'] . "】预存款【解冻】，金额为" . $money . ",编号为" . $order_sn;
                    break;
                default:
                    $this->error(lang('ds_common_op_fail'), 'Predeposit/pdlog_list');
                    break;
            }
            try {
                $predeposit_model->startTrans();
                //扣除冻结的预存款
                $data = array();
                $data['member_id'] = $member_info['member_id'];
                $data['member_name'] = $member_info['member_name'];
                $data['amount'] = $money;
                $data['order_sn'] = $order_sn;
                $data['admin_name'] = $admininfo['admin_name'];
                $data['pdr_sn'] = $order_sn;
                $data['lg_desc'] = $memo;
                $predeposit_model->changePd($admin_act, $data);
                $predeposit_model->commit();
                $this->log($log_msg, 1);
                dsLayerOpenSuccess(lang('ds_common_op_succ'));
            } catch (Exception $e) {
                $predeposit_model->rollback();
                $this->log($log_msg, 0);
                $this->error($e->getMessage(), 'Predeposit/pdlog_list');
            }
        }
    }

    //取得会员信息
    public function checkmember() {
        $name = input('post.name');
        if (!$name) {
            exit(json_encode(array('id' => 0)));
            die;
        }
        $obj_member = model('member');
        $member_info = $obj_member->getMemberInfo(array('member_name' => $name));
        if (is_array($member_info) && count($member_info) > 0) {
            exit(json_encode(array('id' => $member_info['member_id'], 'name' => $member_info['member_name'], 'available_predeposit' => $member_info['available_predeposit'], 'freeze_predeposit' => $member_info['freeze_predeposit'])));
        } else {
            exit(json_encode(array('id' => 0)));
        }
    }
    
    
    

    /**
     * 导出预存款充值记录
     *
     */
    public function export_step1() {
        $condition = array();
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', input('param.query_start_date'));
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', input('param.query_end_date'));
        $start_unixtime = $if_start_date ? strtotime(input('param.query_start_date')) : null;
        $end_unixtime = $if_end_date ? strtotime(input('param.query_end_date')) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['pdr_addtime'] = array('between', array($start_unixtime, $end_unixtime));
        }
        if (input('param.mname') != '') {
            $condition['pdr_member_name'] = array('like', "%" . input('param.mname') . "%");
        }
        if (input('param.paystate_search') != '') {
            $condition['pdr_payment_state'] = input('param.paystate_search');
        }
        
        
        $predeposit_model = model('predeposit');
        if (!is_numeric(input('param.curpage'))) {
            $count = $predeposit_model->getPdRechargeCount($condition);
            $array = array();
            if ($count > self::EXPORT_SIZE) { //显示下载链接
                $page = ceil($count / self::EXPORT_SIZE);
                for ($i = 1; $i <= $page; $i++) {
                    $limit1 = ($i - 1) * self::EXPORT_SIZE + 1;
                    $limit2 = $i * self::EXPORT_SIZE > $count ? $count : $i * self::EXPORT_SIZE;
                    $array[$i] = $limit1 . ' ~ ' . $limit2;
                }
                $this->assign('export_list', $array);
                return $this->fetch('/public/excel');
            } else { //如果数量小，直接下载
                $data = $predeposit_model->getPdRechargeList($condition, '', '*', 'pdr_id desc', self::EXPORT_SIZE);
                $rechargepaystate = array(0 => '未支付', 1 => '已支付');
                foreach ($data as $k => $v) {
                    $data[$k]['pdr_payment_state'] = $rechargepaystate[$v['pdr_payment_state']];
                }
                $this->createExcel($data);
            }
        } else { //下载
            $limit1 = (input('param.curpage') - 1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $predeposit_model->getPdRechargeList($condition, '', '*', 'pdr_id desc', "{$limit1},{$limit2}");
            $rechargepaystate = array(0 => '未支付', 1 => '已支付');
            foreach ($data as $k => $v) {
                $data[$k]['pdr_payment_state'] = $rechargepaystate[$v['pdr_payment_state']];
            }
            $this->createExcel($data);
        }
    }

    /**
     * 生成导出预存款充值excel
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
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_no'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_member'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_ctime'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_ptime'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_pay'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_money'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_paystate'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_memberid'));
        foreach ((array) $data as $k => $v) {
            $tmp = array();
            $tmp[] = array('data' => $v['pdr_sn']);
            $tmp[] = array('data' => $v['pdr_member_name']);
            $tmp[] = array('data' => date('Y-m-d H:i:s', $v['pdr_addtime']));
            if (intval($v['pdr_paymenttime'])) {
                if (date('His', $v['pdr_paymenttime']) == 0) {
                    $tmp[] = array('data' => date('Y-m-d', $v['pdr_paymenttime']));
                } else {
                    $tmp[] = array('data' => date('Y-m-d H:i:s', $v['pdr_paymenttime']));
                }
            } else {
                $tmp[] = array('data' => '');
            }
            $tmp[] = array('data' => $v['pdr_payment_code']);
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['pdr_amount']));
            $tmp[] = array('data' => $v['pdr_payment_state']);
            $tmp[] = array('data' => $v['pdr_member_id']);
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data, CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(lang('exp_yc_yckcz'), CHARSET));
        $excel_obj->generateXML($excel_obj->charset(lang('exp_yc_yckcz'), CHARSET) . input('param.curpage') . '-' . date('Y-m-d-H', time()));
    }

    
    /**
     * 导出预存款提现记录
     *
     */
    public function export_cash_step1() {
        $condition = array();
        $stime = input('get.stime');
        $etime = input('get.etime');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $stime);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $etime);
        $start_unixtime = $if_start_date ? strtotime($stime) : null;
        $end_unixtime = $if_end_date ? strtotime($etime) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['pdc_addtime'] = array('between', array($start_unixtime, $end_unixtime));
        }
        $mname = input('get.mname');
        if (!empty($mname)) {
            $condition['pdc_member_name'] = array('like', "%" . $mname . "%");
        }
        $pdc_bank_user = input('get.pdc_bank_user');
        if (!empty($pdc_bank_user)) {
            $condition['pdc_bank_user'] = array('like', "%" . $pdc_bank_user . "%");
        }
        $paystate_search = input('get.paystate_search');
        if ($paystate_search != '') {
            $condition['pdc_payment_state'] = $paystate_search;
        }

        $predeposit_model = Model('predeposit');

        if (!is_numeric(input('param.curpage'))) {
            $count = $predeposit_model->getPdCashCount($condition);
            $array = array();
            if ($count > self::EXPORT_SIZE) { //显示下载链接
                $page = ceil($count / self::EXPORT_SIZE);
                for ($i = 1; $i <= $page; $i++) {
                    $limit1 = ($i - 1) * self::EXPORT_SIZE + 1;
                    $limit2 = $i * self::EXPORT_SIZE > $count ? $count : $i * self::EXPORT_SIZE;
                    $array[$i] = $limit1 . ' ~ ' . $limit2;
                }
                $this->assign('export_list', $array);
                return $this->fetch('/public/excel');
            } else { //如果数量小，直接下载
                $data = $predeposit_model->getPdCashList($condition, '', '*', 'pdc_id desc', self::EXPORT_SIZE);
                $cashpaystate = array(0 => '未支付', 1 => '已支付');
                foreach ($data as $k => $v) {
                    $data[$k]['pdc_payment_state'] = $cashpaystate[$v['pdc_payment_state']];
                }
                $this->createCashExcel($data);
            }
        } else { //下载
            $limit1 = (input('param.curpage') - 1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $predeposit_model->getPdCashList($condition, '', '*', 'pdc_id desc', "{$limit1},{$limit2}");
            $cashpaystate = array(0 => '未支付', 1 => '已支付');
            foreach ($data as $k => $v) {
                $data[$k]['pdc_payment_state'] = $cashpaystate[$v['pdc_payment_state']];
            }
            $this->createCashExcel($data);
        }
    }

    /**
     * 生成导出预存款提现excel
     *
     * @param array $data
     */
    private function createCashExcel($data = array()) {
        Lang::load(APP_PATH .'admin/lang/'.config('default_lang').'/export.lang.php');
        $excel_obj = new \excel\Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id' => 's_title', 'Font' => array('FontName' => '宋体', 'Size' => '12', 'Bold' => '1')));
        //header
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_no'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_member'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_money'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_ctime'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_state'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_memberid'));
        foreach ((array) $data as $k => $v) {
            $tmp = array();
            $tmp[] = array('data' => $v['pdc_sn']);
            $tmp[] = array('data' => $v['pdc_member_name']);
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['pdc_amount']));
            $tmp[] = array('data' => date('Y-m-d H:i:s', $v['pdc_addtime']));
            $tmp[] = array('data' => $v['pdc_payment_state']);
            $tmp[] = array('data' => $v['pdc_member_id']);
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data, CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(lang('exp_tx_title'), CHARSET));
        $excel_obj->generateXML($excel_obj->charset(lang('exp_tx_title'), CHARSET) . input('param.curpage') . '-' . date('Y-m-d-H', time()));
    }

    /**
     * 预存款明细信息导出
     */
    public function export_mx_step1() {
        $condition = array();
        $stime = input('get.stime');
        $etime = input('get.etime');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $stime);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $etime);
        $start_unixtime = $if_start_date ? strtotime($stime) : null;
        $end_unixtime = $if_end_date ? strtotime($etime) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['lg_addtime'] = array('between', array($start_unixtime, $end_unixtime));
        }
        $mname = input('get.mname');
        if (!empty($mname)) {
            $condition['lg_member_name'] = $mname;
        }
        $aname = input('get.aname');
        if (!empty($aname)) {
            $condition['lg_admin_name'] = $aname;
        }
        
        
        $predeposit_model = Model('predeposit');
        if (!is_numeric(input('param.curpage'))) {
            $count = $predeposit_model->getPdLogCount($condition);
            $array = array();
            if ($count > self::EXPORT_SIZE) { //显示下载链接
                $page = ceil($count / self::EXPORT_SIZE);
                for ($i = 1; $i <= $page; $i++) {
                    $limit1 = ($i - 1) * self::EXPORT_SIZE + 1;
                    $limit2 = $i * self::EXPORT_SIZE > $count ? $count : $i * self::EXPORT_SIZE;
                    $array[$i] = $limit1 . ' ~ ' . $limit2;
                }
                $this->assign('export_list', $array);
                return $this->fetch('/public/excel');
            } else { //如果数量小，直接下载
                $data = $predeposit_model->getPdLogList($condition, '', '*', 'lg_id desc', self::EXPORT_SIZE);
                $this->createmxExcel($data);
            }
        } else { //下载
            $limit1 = (input('param.curpage') - 1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $data = $predeposit_model->getPdLogList($condition, '', '*', 'lg_id desc', "{$limit1},{$limit2}");
            $this->createmxExcel($data);
        }
    }

    /**
     * 导出预存款明细excel
     *
     * @param array $data
     */
    private function createmxExcel($data = array()) {
        Lang::load(APP_PATH .'admin/lang/'.config('default_lang').'/export.lang.php');
        $excel_obj = new \excel\Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id' => 's_title', 'Font' => array('FontName' => '宋体', 'Size' => '12', 'Bold' => '1')));
        //header
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_member'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_ctime'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_av_money'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_freeze_money'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_system'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_mshu'));
        foreach ((array) $data as $k => $v) {
            $tmp = array();
            $tmp[] = array('data' => $v['lg_member_name']);
            $tmp[] = array('data' => date('Y-m-d H:i:s', $v['lg_addtime']));
            if (floatval($v['lg_av_amount']) == 0) {
                $tmp[] = array('data' => '');
            } else {
                $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['lg_av_amount']));
            }
            if (floatval($v['lg_freeze_amount']) == 0) {
                $tmp[] = array('data' => '');
            } else {
                $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['lg_freeze_amount']));
            }
            $tmp[] = array('data' => $v['lg_admin_name']);
            $tmp[] = array('data' => $v['lg_desc']);
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data, CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(lang('exp_mx_rz'), CHARSET));
        $excel_obj->generateXML($excel_obj->charset(lang('exp_mx_rz'), CHARSET) . input('param.curpage') . '-' . date('Y-m-d-H', time()));
    }
    
    
    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'pdrecharge_list',
                'text' => '充值明细',
                'url' => url('Predeposit/pdrecharge_list')
            ),
            array(
                'name' => 'pdcash_list',
                'text' => '提现管理',
                'url' => url('Predeposit/pdcash_list')
            ),
            array(
                'name' => 'pdlog_list',
                'text' => '预存款明细',
                'url' => url('Predeposit/pdlog_list')
            ),
            array(
                'name' => 'pd_add',
                'text' => '预存款调节',
                'url' => "javascript:dsLayerOpen('".url('Predeposit/pd_add')."','预存款调节')"
            ),
        );
        return $menu_array;
    }
}

?>
