<?php

namespace app\common\model;

use think\Model;
use think\Db;
class Predeposit extends Model {

    public $page_info;


    /**
     * 增加充值卡
     * @access public
     * @author csdeshang
     * @param type $sn
     * @param type $member_info
     * @return type
     * @throws \app\common\model\Exception
     */        
    public function addRechargecard($sn, $member_info) {
        $member_id = $member_info['member_id'];
        $member_name = $member_info['member_name'];

        if ($member_id < 1 || !$member_name) {
            return array('message' => '当前登录状态为未登录，不能使用充值卡');
        }

        $rechargecard_model = model('rechargecard');

        $card = $rechargecard_model->getRechargecardBySN($sn);

        if (empty($card) || $card['rc_state'] != 0 || $card['member_id'] != 0) {
            return array('message' => '充值卡不存在或已被使用');
        }

        $card['member_id'] = $member_id;
        $card['member_name'] = $member_name;

        try {
            $this->startTrans();

            $rechargecard_model->setRechargecardUsedById($card['rc_id'], $member_id, $member_name);

            $card['amount'] = $card['rc_denomination'];
            $this->changeRcb('recharge', $card);

            $this->commit();
        } catch (Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    /**
     * 取得充值列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $pagesize 页面大小
     * @param type $fields 字段
     * @param type $order 排序
     * @return type
     */
    public function getPdRechargeList($condition = array(), $pagesize = '', $fields = '*', $order = '') {
        if ($pagesize) {
            $result = db('pdrecharge')->where($condition)->field($fields)->order($order)->paginate($pagesize, false, ['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('pdrecharge')->where($condition)->field($fields)->order($order)->select();
        }
    }

    /**
     * 添加充值记录
     * @access public
     * @author csdeshang
     * @param type $data 参数内容
     * @return bool
     */
    public function addPdRecharge($data) {
        return db('pdrecharge')->insertGetId($data);
    }

    /**
     * 编辑
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @param type $condition 条件
     * @return bool
     */
    public function editPdRecharge($data, $condition = array()) {
        return db('pdrecharge')->where($condition)->update($data);
    }

    /**
     * 取得单条充值信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $fields 字段
     * @return type
     */
    public function getPdRechargeInfo($condition = array(), $fields = '*') {
        return db('pdrecharge')->where($condition)->field($fields)->find();
    }

    /**
     * 取充值信息总数
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getPdRechargeCount($condition = array()) {
        return db('pdrecharge')->where($condition)->count();
    }

    /**
     * 取提现单信息总数
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return int
     */
    public function getPdcashCount($condition = array()) {
        return db('pdcash')->where($condition)->count();
    }

    /**
     * 取日志总数
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return int
     */
    public function getPdLogCount($condition = array()) {
        return db('pdlog')->where($condition)->count();
    }

    /**
     * 取得预存款变更日志列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $pagesize 页面信息
     * @param type $fields 字段
     * @param type $order 排序
     * @param type $limit 限制
     * @return array
     */
    public function getPdLogList($condition = array(), $pagesize = '', $fields = '*', $order = '', $limit = '') {
        if ($pagesize) {
            $pdlog_list_paginate = db('pdlog')->where($condition)->field($fields)->order($order)->paginate($pagesize, false, ['query' => request()->param()]);
            $this->page_info = $pdlog_list_paginate;
            return $pdlog_list_paginate->items();
        } else {
            $pdlog_list_paginate = db('pdlog')->where($condition)->field($fields)->order($order)->limit($limit)->select();
            return $pdlog_list_paginate;
        }
    }

    /**
     * 变更充值卡余额
     * @access public
     * @author csdeshang
     * @param type $type 类型
     * @param type $data 数据
     * @return type
     */
    public function changeRcb($type, $data = array()) {
        $amount = (float) $data['amount'];
        if ($amount < .01) {
            exception('参数错误');
        }

        $available = $freeze = 0;
        $desc = null;

        switch ($type) {
            case 'order_pay':
                $available = -$amount;
                $desc = '下单，使用充值卡余额，订单号: ' . $data['order_sn'];
                break;

            case 'order_freeze':
                $available = -$amount;
                $freeze = $amount;
                $desc = '下单，冻结充值卡余额，订单号: ' . $data['order_sn'];
                break;

            case 'order_cancel':
                $available = $amount;
                $freeze = -$amount;
                $desc = '取消订单，解冻充值卡余额，订单号: ' . $data['order_sn'];
                break;

            case 'order_comb_pay':
                $freeze = -$amount;
                $desc = '下单，扣除被冻结的充值卡余额，订单号: ' . $data['order_sn'];
                break;

            case 'recharge':
                $available = $amount;
                $desc = '平台充值卡充值，充值卡号: ' . $data['rc_sn'];
                break;

            case 'refund':
                $available = $amount;
                $desc = '确认退款，订单号: ' . $data['order_sn'];
                break;

            case 'vr_refund':
                $available = $amount;
                $desc = '虚拟兑码退款成功，订单号: ' . $data['order_sn'];
                break;

            default:
                exception('参数错误');
        }

        $update = array();
        if ($available) {
            $update['available_rc_balance'] = Db::raw('available_rc_balance+'.$available);
        }
        if ($freeze) {
            $update['freeze_rc_balance'] = Db::raw('freeze_rc_balance+'.$freeze);
        }

        if (!$update) {
            exception('参数错误');
        }

        // 更新会员
        $updateSuccess = model('member')->editMember(array(
            'member_id' => $data['member_id'],
                ), $update);

        if (!$updateSuccess) {
            exception('操作失败');
        }

        // 添加日志
        $rcblog = array(
            'member_id' => $data['member_id'],
            'member_name' => $data['member_name'],
            'rcblog_type' => $type,
            'rcblog_addtime' => TIMESTAMP,
            'available_amount' => $available,
            'freeze_amount' => $freeze,
            'rcblog_description' => $desc,
        );

        $insertSuccess = db('rcblog')->insertGetId($rcblog);
        if (!$insertSuccess) {
            exception('操作失败');
        }

        $msg = array(
            'code' => 'recharge_card_balance_change',
            'member_id' => $data['member_id'],
            'param' => array(
                'time' => date('Y-m-d H:i:s', TIMESTAMP),
                'url' => url('Home/Predeposit/rcb_log_list'),
                'available_amount' => ds_price_format($available),
                'freeze_amount' => ds_price_format($freeze),
                'description' => $desc,
            ),
        );

        // 发送买家消息
        \mall\queue\QueueClient::push('sendMemberMsg', $msg);
        return $insertSuccess;
    }

    /**
     * 变更预存款
     * @access public
     * @author csdeshang
     * @param type $change_type
     * @param type $data
     * @return type
     */
    public function changePd($change_type, $data = array()) {
        $data_log = array();
        $data_pd = array();
        $data_msg = array();

        $data_log['lg_member_id'] = $data['member_id'];
        $data_log['lg_member_name'] = $data['member_name'];
        $data_log['lg_addtime'] = TIMESTAMP;
        $data_log['lg_type'] = $change_type;

        $data_msg['time'] = date('Y-m-d H:i:s');
        $data_msg['pd_url'] = url('home/Predeposit/pd_log_list');
        switch ($change_type) {
            case 'order_pay':
                $data_log['lg_av_amount'] = -$data['amount'];
                $data_log['lg_desc'] = '下单，支付预存款，订单号: ' . $data['order_sn'];
                $data_pd['available_predeposit'] = Db::raw('available_predeposit-'.$data['amount']);

                $data_msg['av_amount'] = -$data['amount'];
                $data_msg['freeze_amount'] = 0;
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'order_freeze':
                $data_log['lg_av_amount'] = -$data['amount'];
                $data_log['lg_freeze_amount'] = $data['amount'];
                $data_log['lg_desc'] = '下单，冻结预存款，订单号: ' . $data['order_sn'];
                $data_pd['freeze_predeposit'] = Db::raw('freeze_predeposit+'.$data['amount']);
                $data_pd['available_predeposit'] = Db::raw('available_predeposit-'.$data['amount']);

                $data_msg['av_amount'] = -$data['amount'];
                $data_msg['freeze_amount'] = $data['amount'];
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'order_cancel':
                $data_log['lg_av_amount'] = $data['amount'];
                $data_log['lg_freeze_amount'] = -$data['amount'];
                $data_log['lg_desc'] = '取消订单，解冻预存款，订单号: ' . $data['order_sn'];
                $data_pd['freeze_predeposit'] = Db::raw('freeze_predeposit-'.$data['amount']);
                $data_pd['available_predeposit'] = Db::raw('available_predeposit+'.$data['amount']);

                $data_msg['av_amount'] = $data['amount'];
                $data_msg['freeze_amount'] = -$data['amount'];
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'order_comb_pay':
                $data_log['lg_freeze_amount'] = -$data['amount'];
                $data_log['lg_desc'] = '下单，支付被冻结的预存款，订单号: ' . $data['order_sn'];
                $data_pd['freeze_predeposit'] = Db::raw('freeze_predeposit-'.$data['amount']);

                $data_msg['av_amount'] = 0;
                $data_msg['freeze_amount'] = $data['amount'];
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'recharge':
                $data_log['lg_av_amount'] = $data['amount'];
                $data_log['lg_desc'] = '充值，充值单号: ' . $data['pdr_sn'];
                $data_log['lg_admin_name'] = isset($data['admin_name']) ? $data['admin_name'] : '会员' . $data['member_name'] . '在线充值';
                $data_pd['available_predeposit'] = Db::raw('available_predeposit+'.$data['amount']);

                $data_msg['av_amount'] = $data['amount'];
                $data_msg['freeze_amount'] = 0;
                $data_msg['desc'] = $data_log['lg_desc'];
                break;

            case 'refund':
                $data_log['lg_av_amount'] = $data['amount'];
                $data_log['lg_desc'] = '确认退款，订单号: ' . $data['order_sn'];
                $data_pd['available_predeposit'] = Db::raw('available_predeposit+'.$data['amount']);

                $data_msg['av_amount'] = $data['amount'];
                $data_msg['freeze_amount'] = 0;
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'vr_refund':
                $data_log['lg_av_amount'] = $data['amount'];
                $data_log['lg_desc'] = '虚拟兑码退款成功，订单号: ' . $data['order_sn'];
                $data_pd['available_predeposit'] = Db::raw('available_predeposit+'.$data['amount']);

                $data_msg['av_amount'] = $data['amount'];
                $data_msg['freeze_amount'] = 0;
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'cash_apply':
                $data_log['lg_av_amount'] = -$data['amount'];
                $data_log['lg_freeze_amount'] = $data['amount'];
                $data_log['lg_desc'] = '申请提现，冻结预存款，提现单号: ' . $data['order_sn'];
                $data_pd['available_predeposit'] = Db::raw('available_predeposit-'.$data['amount']);
                $data_pd['freeze_predeposit'] = Db::raw('freeze_predeposit+'.$data['amount']);

                $data_msg['av_amount'] = -$data['amount'];
                $data_msg['freeze_amount'] = $data['amount'];
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'cash_pay':
                $data_log['lg_freeze_amount'] = -$data['amount'];
                $data_log['lg_desc'] = '提现成功，提现单号: ' . $data['order_sn'];
                $data_log['lg_admin_name'] = $data['admin_name'];
                $data_pd['freeze_predeposit'] = Db::raw('freeze_predeposit-'.$data['amount']);

                $data_msg['av_amount'] = 0;
                $data_msg['freeze_amount'] = -$data['amount'];
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'cash_del':
                $data_log['lg_av_amount'] = $data['amount'];
                $data_log['lg_freeze_amount'] = -$data['amount'];
                $data_log['lg_desc'] = '取消提现申请，解冻预存款，提现单号: ' . $data['order_sn'];
                $data_log['lg_admin_name'] = $data['admin_name'];
                $data_pd['available_predeposit'] = Db::raw('available_predeposit+'.$data['amount']);
                $data_pd['freeze_predeposit'] = Db::raw('freeze_predeposit-'.$data['amount']);

                $data_msg['av_amount'] = $data['amount'];
                $data_msg['freeze_amount'] = -$data['amount'];
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'sys_add_money':
                $data_log['lg_av_amount'] = $data['amount'];
                $data_log['lg_desc'] = '管理员调节预存款【增加】，充值单号: ' . $data['pdr_sn'].',备注：'.$data['lg_desc'];
                $data_log['lg_admin_name'] = $data['admin_name'];
                $data_pd['available_predeposit'] = Db::raw('available_predeposit+'.$data['amount']);

                $data_msg['av_amount'] = $data['amount'];
                $data_msg['freeze_amount'] = 0;
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'sys_del_money':
                $data_log['lg_av_amount'] = -$data['amount'];
                $data_log['lg_desc'] = '管理员调节预存款【减少】，充值单号: ' . $data['pdr_sn'].',备注：'.$data['lg_desc'];
                $data_log['lg_admin_name'] = $data['admin_name'];
                $data_pd['available_predeposit'] = Db::raw('available_predeposit-'.$data['amount']);

                $data_msg['av_amount'] = -$data['amount'];
                $data_msg['freeze_amount'] = 0;
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'sys_freeze_money':
                $data_log['lg_av_amount'] = -$data['amount'];
                $data_log['lg_freeze_amount'] = $data['amount'];
                $data_log['lg_desc'] = '管理员调节预存款【冻结】，充值单号: ' . $data['pdr_sn'].',备注：'.$data['lg_desc'];
                $data_log['lg_admin_name'] = $data['admin_name'];
                $data_pd['available_predeposit'] = Db::raw('available_predeposit-'.$data['amount']);
                $data_pd['freeze_predeposit'] = Db::raw('freeze_predeposit+'.$data['amount']);

                $data_msg['av_amount'] = -$data['amount'];
                $data_msg['freeze_amount'] = $data['amount'];
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'sys_unfreeze_money':
                $data_log['lg_av_amount'] = $data['amount'];
                $data_log['lg_freeze_amount'] = -$data['amount'];
                $data_log['lg_desc'] = '管理员调节预存款【解冻】，充值单号: ' . $data['pdr_sn'].',备注：'.$data['lg_desc'];
                $data_log['lg_admin_name'] = $data['admin_name'];
                $data_pd['available_predeposit'] = Db::raw('available_predeposit+'.$data['amount']);
                $data_pd['freeze_predeposit'] = Db::raw('freeze_predeposit-'.$data['amount']);

                $data_msg['av_amount'] = $data['amount'];
                $data_msg['freeze_amount'] = -$data['amount'];
                $data_msg['desc'] = $data_log['lg_desc'];
                break;
            case 'order_inviter':
                $data_log['lg_av_amount'] = $data['amount'];
                $data_log['lg_desc'] = $data['lg_desc'];
                $data_pd['available_predeposit'] = Db::raw('available_predeposit+'.$data['amount']);

                $data_msg['av_amount'] = $data['amount'];
                $data_msg['freeze_amount'] = 0;
                $data_msg['desc'] = $data_log['lg_desc'];
                break;

            //end

            default:
                exception('参数错误');
                break;
        }

        $update = model('member')->editMember(array('member_id' => $data['member_id']), $data_pd);

        if (!$update) {
            exception('操作失败');
        }
        $insert = db('pdlog')->insertGetId($data_log);
        if (!$insert) {
            exception('操作失败');
        }

        // 支付成功发送买家消息
        $message = array();
        $message['code'] = 'predeposit_change';
        $message['member_id'] = $data['member_id'];
        $data_msg['av_amount'] = ds_price_format($data_msg['av_amount']);
        $data_msg['freeze_amount'] = ds_price_format($data_msg['freeze_amount']);
        $message['param'] = $data_msg;
        \mall\queue\QueueClient::push('sendMemberMsg', $message);
        return $insert;
    }

    /**
     * 删除充值记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function delPdRecharge($condition) {
        return db('pdrecharge')->where($condition)->delete();
    }

    /**
     * 取得提现列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $pagesize 页面
     * @param type $fields 字段
     * @param type $order 排序
     * @param type $limit 限制
     * @return type
     */
    public function getPdcashList($condition = array(), $pagesize = '', $fields = '*', $order = '', $limit = '') {
        if ($pagesize) {
            $pdcash_list_paginate = db('pdcash')->where($condition)->field($fields)->order($order)->paginate($pagesize, false, ['query' => request()->param()]);
            $this->page_info = $pdcash_list_paginate;
            return $pdcash_list_paginate->items();
        } else {
            return db('pdcash')->where($condition)->field($fields)->order($order)->limit($limit)->select();
        }
    }

    /**
     * 添加提现记录
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @return bool
     */
    public function addPdcash($data) {
        return db('pdcash')->insertGetId($data);
    }

    /**
     * 编辑提现记录
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @param type $condition 条件
     * @return bool
     */
    public function editPdcash($data, $condition = array()) {
        return db('pdcash')->where($condition)->update($data);
    }

    /**
     * 取得单条提现信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $fields 字段
     * @return type
     */
    public function getPdcashInfo($condition = array(), $fields = '*') {
        return db('pdcash')->where($condition)->field($fields)->find();
    }

    /**
     * 删除提现记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function delPdcash($condition) {
        return db('pdcash')->where($condition)->delete();
    }

}
