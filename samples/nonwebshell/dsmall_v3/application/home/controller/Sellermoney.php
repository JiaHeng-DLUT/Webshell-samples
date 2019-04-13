<?php

/**
 * 预存款管理
 */

namespace app\home\controller;

use think\Lang;
use app\common\model\Storemoneylog;

class Sellermoney extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/' . config('default_lang') . '/sellermoney.lang.php');
    }

    /**
     * 预存款变更日志
     */
    public function index() {
        $condition = array('seller_id' => session('store_id'));


        $query_start_date = input('param.query_start_date');
        $query_end_date = input('param.query_end_date');
        $if_start_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_start_date);
        $if_end_date = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $query_end_date);
        $start_unixtime = $if_start_date ? strtotime($query_start_date) : null;
        $end_unixtime = $if_end_date ? (strtotime($query_end_date) + 86399) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition['storemoneylog_add_time'] = array('between', array($start_unixtime, $end_unixtime));
        }

        $storemoneylog_desc = input('param.storemoneylog_desc');
        if ($storemoneylog_desc) {
            $condition['storemoneylog_desc'] = array('like', '%' . $storemoneylog_desc . '%');
        }
        $storemoneylog_model = model('storemoneylog');
        $list_log = $storemoneylog_model->getStoremoneylogList($condition, 10, '*', 'storemoneylog_id desc');
        $this->assign('show_page', $storemoneylog_model->page_info->render());
        $this->assign('list_log', $list_log);
        /* 设置买家当前菜单 */
        $this->setSellerCurMenu('seller_money');
        ;
        /* 设置买家当前栏目 */
        $this->setSellerCurItem('index');
        $store_info = db('store')->where(array('store_id' => session('store_id')))->field('store_avaliable_money,store_freeze_money')->find();
        $this->assign('store_info', $store_info);
        return $this->fetch($this->template_dir . 'index');
    }

    /**
     * 申请提现
     */
    public function withdraw_add() {
        $store_info = db('store')->where(array('store_id' => session('store_id')))->field('store_avaliable_money,store_freeze_money')->find();
        if (request()->isPost()) {
            $data=[
                'pdc_amount'=>floatval(input('post.pdc_amount')),
            ];
            $sellermoney_validate = validate('sellermoney');
            if (!$sellermoney_validate->scene('withdraw_add')->check($data)) {
                ds_json_encode(10001,$sellermoney_validate->getError());
            }
            
            $pdc_amount = $data['pdc_amount'];
            $storemoneylog_model = model('storemoneylog');
            //是否超过提现周期
            $last_withdraw=$storemoneylog_model->getStoremoneylogInfo(array('seller_id'=>$this->store_info['store_id'],'storemoneylog_state'=>array('in',[Storemoneylog::STATE_WAIT,Storemoneylog::STATE_AGREE]),'storemoneylog_type'=>Storemoneylog::TYPE_WITHDRAW,'storemoneylog_add_time'=>array('>',TIMESTAMP-intval(config('store_withdraw_cycle'))*86400)),'storemoneylog_add_time');
            if($last_withdraw){
                ds_json_encode(10001,lang('sellermoney_last_withdraw_time_error').date('Y-m-d',$last_withdraw['storemoneylog_add_time']));
            }
            //是否不小于最低提现金额
            if($pdc_amount<floatval(config('store_withdraw_min'))){
                ds_json_encode(10001,lang('sellermoney_withdraw_min').config('store_withdraw_min').lang('currency_zh'));
            }
            //是否不超过最高提现金额
            if($pdc_amount>floatval(config('store_withdraw_max'))){
                ds_json_encode(10001,lang('sellermoney_withdraw_max').config('store_withdraw_max').lang('currency_zh'));
            }
            $data = array(
                'seller_id' => $this->store_info['store_id'],
                'seller_name' => $this->store_info['seller_name'],
                'storemoneylog_type' => Storemoneylog::TYPE_WITHDRAW,
                'storemoneylog_state' => Storemoneylog::STATE_WAIT,
                'storemoneylog_add_time' => TIMESTAMP,
            );
            $data['store_avaliable_money'] = -$pdc_amount;
            $data['store_freeze_money'] = $pdc_amount;

            $storejoinin_info = db('storejoinin')->where(array('member_id' => $this->store_info['member_id']))->field('settlement_bank_account_name,settlement_bank_account_number,settlement_bank_name,settlement_bank_address')->find();

            $joinin_detail = model('storejoinin')->getOneStorejoinin(array('member_id' => $this->store_info['member_id']));
            if ($joinin_detail['business_licence_address'] != '') {
                $sml_desc = lang('sellermoney_bank_user').'：' . $storejoinin_info['settlement_bank_account_name'] . '，'.lang('sellermoney_bank_number').'：' . $storejoinin_info['settlement_bank_account_number'] . '，'.lang('sellermoney_bank_sub_name').'：' . $storejoinin_info['settlement_bank_name'] . '，'.lang('sellermoney_bank_name').'：' . $storejoinin_info['settlement_bank_address'];
            } else {
                $sml_desc = lang('sellermoney_alipay_name').'：' . $storejoinin_info['settlement_bank_account_name'] . '，'.lang('sellermoney_alipay_number').'：' . $storejoinin_info['settlement_bank_account_number'];
            }

            $data['storemoneylog_desc'] = $sml_desc;
            try {
                $storemoneylog_model->startTrans();
                $storemoneylog_model->changeStoremoney($data);
                $storemoneylog_model->commit();
                $this->recordSellerlog(lang('sellermoney_apply_withdraw'));
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } catch (\Exception $e) {
                $storemoneylog_model->rollback();
                ds_json_encode(10001,$e->getMessage());
            }
        } else {
            $this->assign('store_withdraw_cycle', config('store_withdraw_cycle'));
            $this->assign('store_withdraw_min', config('store_withdraw_min'));
            $this->assign('store_withdraw_max', config('store_withdraw_max'));
            $this->assign('store_info', $store_info);
            return $this->fetch($this->template_dir . 'withdraw_add');
        }
    }

    /**
     * 提现列表
     */
    public function withdraw_list() {
        $condition = array(
            'seller_id' => session('store_id'),
            'storemoneylog_type' => Storemoneylog::TYPE_WITHDRAW,
        );


        $paystate_search = input('param.paystate_search');
        if (isset($paystate_search) && $paystate_search !== '') {
            $condition['storemoneylog_state'] = intval($paystate_search);
        }

        $storemoneylog_model = model('storemoneylog');
        $withdraw_list = $storemoneylog_model->getStoremoneylogList($condition, 10, '*', 'storemoneylog_id desc');
        $this->assign('show_page', $storemoneylog_model->page_info->render());
        $this->assign('withdraw_list', $withdraw_list);

        /* 设置买家当前菜单 */
        $this->setSellerCurMenu('seller_money');
        ;
        /* 设置买家当前栏目 */
        $this->setSellerCurItem('withdraw_list');
        $store_info = db('store')->where(array('store_id' => session('store_id')))->field('store_avaliable_money,store_freeze_money')->find();
        $this->assign('store_info', $store_info);
        return $this->fetch($this->template_dir . 'withdraw_list');
    }

    /**
     *    栏目菜单
     */
    function getSellerItemList() {
        $item_list = array(
            array(
                'name' => 'index',
                'text' => lang('sellermoney_log_list'),
                'url' => url('Sellermoney/index'),
            ),
            array(
                'name' => 'withdraw_list',
                'text' => lang('sellermoney_withdraw_list'),
                'url' => url('Sellermoney/withdraw_list'),
            ),
        );

        return $item_list;
    }

}
