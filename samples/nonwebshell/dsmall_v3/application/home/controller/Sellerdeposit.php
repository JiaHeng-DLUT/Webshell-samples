<?php

/**
 * 预存款管理
 */

namespace app\home\controller;

use think\Lang;
use app\common\model\Storedepositlog;
use app\common\model\Storemoneylog;
class Sellerdeposit extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/' . config('default_lang') . '/sellerdeposit.lang.php');
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
            $condition['storedepositlog_add_time'] = array('between', array($start_unixtime, $end_unixtime));
        }

        $storedepositlog_desc = input('param.storedepositlog_desc');
        if ($storedepositlog_desc) {
            $condition['storedepositlog_desc'] = array('like', '%' . $storedepositlog_desc . '%');
        }
        $storedepositlog_model = model('storedepositlog');
        $list_log = $storedepositlog_model->getStoredepositlogList($condition, 10, '*', 'storedepositlog_id desc');
        $this->assign('show_page', $storedepositlog_model->page_info->render());
        $this->assign('list_log', $list_log);
        /* 设置买家当前菜单 */
        $this->setSellerCurMenu('seller_deposit');
        /* 设置买家当前栏目 */
        $this->setSellerCurItem('index');
        $store_info = db('store')->where(array('store_id' => session('store_id')))->field('store_avaliable_deposit,store_freeze_deposit,store_payable_deposit')->find();
        $this->assign('store_info', $store_info);
        return $this->fetch($this->template_dir . 'index');
    }
    
    public function recharge_add() {
        $storedepositlog_model = model('storedepositlog');
        if (request()->isPost()) {
            $money = abs(floatval(input('post.pdc_amount')));
            if (!$money) {
                ds_json_encode(10001,lang('param_error'));
            }
            try {
                $storedepositlog_model->startTrans();

                $data = array(
                    'seller_id' => $this->store_info['store_id'],
                    'seller_name' => $this->store_info['seller_name'],
                    'storedepositlog_type' => Storedepositlog::TYPE_PAY,
                    'storedepositlog_state' => Storedepositlog::STATE_VALID,
                    'storedepositlog_add_time' => TIMESTAMP,
                );
                $data['store_avaliable_deposit'] = $money;


                $data['storedepositlog_desc'] = lang('sellerdeposit_recharge_deposit');


                $storedepositlog_model->changeStoredeposit($data);
                //从店铺资金中扣除
                $storemoneylog_model = model('storemoneylog');
                $data2 = array(
                    'seller_id' => $this->store_info['store_id'],
                    'seller_name' => $this->store_info['seller_name'],
                    'storemoneylog_type' => Storemoneylog::TYPE_DEPOSIT_IN,
                    'storemoneylog_state' => Storemoneylog::STATE_VALID,
                    'storemoneylog_add_time' => TIMESTAMP,
                    'store_avaliable_money' => -$money,
                    'storemoneylog_desc' => $data['storedepositlog_desc'],
                );
                $storemoneylog_model->changeStoremoney($data2);

                $storedepositlog_model->commit();
            } catch (\Exception $e) {
                $storedepositlog_model->rollback();
                ds_json_encode(10001,$e->getMessage());
            }
            $this->recordSellerlog(lang('sellerdeposit_recharge_deposit'));
            ds_json_encode(10000,lang('ds_common_op_succ'));
        } else {
            return $this->fetch($this->template_dir . 'recharge_add');
        }
    }

    /**
     * 申请提现
     */
    public function withdraw_add() {
        $store_info = db('store')->where(array('store_id' => session('store_id')))->field('store_avaliable_deposit,store_freeze_deposit,store_payable_deposit')->find();
        if (request()->isPost()) {
            $data=[
                'pdc_amount'=>floatval(input('post.pdc_amount')),
            ];
            $sellerdeposit_validate = validate('sellerdeposit');
            if (!$sellerdeposit_validate->scene('withdraw_add')->check($data)) {
                ds_json_encode(10001,$sellerdeposit_validate->getError());
            }
            
            $pdc_amount = $data['pdc_amount'];
            $storedepositlog_model = model('storedepositlog');

            $data = array(
                'seller_id' => $this->store_info['store_id'],
                'seller_name' => $this->store_info['seller_name'],
                'storedepositlog_type' => Storedepositlog::TYPE_WITHDRAW,
                'storedepositlog_state' => Storedepositlog::STATE_WAIT,
                'storedepositlog_add_time' => TIMESTAMP,
            );
            $data['store_avaliable_deposit'] = -$pdc_amount;
            $data['store_freeze_deposit'] = $pdc_amount;


            $data['storedepositlog_desc'] = lang('sellerdeposit_apply_withdraw').lang('sellerdeposit_avaliable_money');
            try {
                $storedepositlog_model->startTrans();
                $storedepositlog_model->changeStoredeposit($data);
                $storedepositlog_model->commit();
                $this->recordSellerlog(lang('sellerdeposit_apply_withdraw'));
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } catch (\Exception $e) {
                $storedepositlog_model->rollback();
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
            'storedepositlog_type' => array('in',[Storedepositlog::TYPE_WITHDRAW,Storedepositlog::TYPE_RECHARGE]),
        );


        $paystate_search = input('param.paystate_search');
        if (isset($paystate_search) && $paystate_search !== '') {
            $condition['storedepositlog_state'] = intval($paystate_search);
        }

        $storedepositlog_model = model('storedepositlog');
        $withdraw_list = $storedepositlog_model->getStoredepositlogList($condition, 10, '*', 'storedepositlog_id desc');
        $this->assign('show_page', $storedepositlog_model->page_info->render());
        $this->assign('withdraw_list', $withdraw_list);

        /* 设置买家当前菜单 */
        $this->setSellerCurMenu('seller_deposit');
        ;
        /* 设置买家当前栏目 */
        $this->setSellerCurItem('withdraw_list');
        $store_info = db('store')->where(array('store_id' => session('store_id')))->field('store_avaliable_deposit,store_freeze_deposit,store_payable_deposit')->find();
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
                'text' => lang('sellerdeposit_log_list'),
                'url' => url('Sellerdeposit/index'),
            ),
            array(
                'name' => 'withdraw_list',
                'text' => lang('sellerdeposit_withdraw_list'),
                'url' => url('Sellerdeposit/withdraw_list'),
            ),
        );

        return $item_list;
    }

}
