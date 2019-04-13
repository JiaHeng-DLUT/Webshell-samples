<?php

namespace app\common\model;

use think\Model;

class Vrorder extends Model {
    public $page_info;

    /**
     * 取单条订单信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $fields 字段
     * @param type $master 主服务器
     * @return type
     */
    public function getVrorderInfo($condition = array(), $fields = '*', $master = false) {
        $order_info = db('vrorder')->field($fields)->where($condition)->master($master)->find();
        if (empty($order_info)) {
            return array();
        }
        if (isset($order_info['order_state'])) {
            $order_info['state_desc'] = $this->_vrorderState($order_info['order_state']);
            $order_info['state_desc'] = $order_info['state_desc'][0];
        }
        if (isset($order_info['payment_code'])) {
            $order_info['payment_name'] = get_order_payment_name($order_info['payment_code']);
        }
        return $order_info;
    }

    /**
     * 新增订单
     * @access public
     * @author csdeshang
     * @param type $data 参数内容
     * @return type
     */
    public function addVrorder($data) {
        return db('vrorder')->insertGetId($data);
    }

    /**
     * 新增订单
     * @access public
     * @author csdeshang
     * @param type $order_info 订单信息
     * @return boolean
     */
    public function addVrorderCode($order_info) {
        $vrc_num = db('vrordercode')->where(array('order_id' => $order_info['order_id']))->count();
        if (!empty($vrc_num) && intval($vrc_num) >= intval($order_info['goods_num']))
            return false;

        if (empty($order_info))
            return false;

        //均摊后每个兑换码支付金额
        $each_pay_price = number_format($order_info['order_amount'] / $order_info['goods_num'], 2);

        //取得店铺兑换码前缀
        $store_info = model('store')->getStoreInfoByID($order_info['store_id']);
        $virtual_code_perfix = $store_info['store_vrcode_prefix'] ? $store_info['store_vrcode_prefix'] : rand(100, 999);

        //生成兑换码
        $code_list = $this->_makeVrordercode($virtual_code_perfix, $order_info['store_id'], $order_info['buyer_id'], $order_info['goods_num']);

        for ($i = 0; $i < $order_info['goods_num']; $i++) {
            $order_code[$i]['order_id'] = $order_info['order_id'];
            $order_code[$i]['store_id'] = $order_info['store_id'];
            $order_code[$i]['buyer_id'] = $order_info['buyer_id'];
            $order_code[$i]['vr_code'] = $code_list[$i];
            $order_code[$i]['pay_price'] = $each_pay_price;
            $order_code[$i]['vr_indate'] = $order_info['vr_indate'];
            $order_code[$i]['vr_invalid_refund'] = $order_info['vr_invalid_refund'];
        }

        //将因舍出小数部分出现的差值补到最后一个商品的实际成交价中
//         $diff_amount = $order_info['order_amount'] - $each_pay_price * $order_info['goods_num'];
//         $order_code[$i-1]['pay_price'] += $diff_amount;

        return db('vrordercode')->insertAll($order_code);
    }

    /**
     * 更改订单信息
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @param type $condition 条件
     * @param type $limit 限制
     * @return type
     */
    public function editVrorder($data, $condition, $limit = '') {
        return db('vrorder')->where($condition)->limit($limit)->update($data);
    }

    /**
     * 更新兑换码
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @param type $condition 条件
     * @return type
     */
    public function editVrorderCode($data, $condition) {
        return db('vrordercode')->where($condition)->update($data);
    }

    /**
     * 兑换码列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $fields 字段
     * @param type $pagesize 分页
     * @param type $order 排序
     * @return type
     */
    public function getVrordercodeList($condition = array(), $fields = '*', $pagesize = '', $order = 'rec_id desc') {
        if($pagesize){
            $res = db('vrordercode')->field($fields)->where($condition)->order($order)->paginate($pagesize,false,['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        }else{
            return db('vrordercode')->field($fields)->where($condition)->order($order)->select();
        }

    }

    /**
     * 兑换码列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $fields 字段
     * @return type
     */
    public function getCodeUnusedList($condition = array(), $fields = '*') {
        $condition['vr_state'] = 0;
        $condition['refund_lock'] = 0;
        return $this->getVrordercodeList($condition, $fields);
    }

    /**
     * 根据虚拟订单取没有使用的兑换码列表
     * @access public
     * @author csdeshang
     * @param type $order_list 订单列表
     * @return type
     */
    public function getCodeRefundList($order_list = array()) {
        if (!empty($order_list) && is_array($order_list)) {
            $order_ids = array(); //订单编号数组
            foreach ($order_list as $key => $value) {
                $order_id = $value['order_id'];
                $order_ids[$order_id] = $key;
            }
            $condition = array();
            $condition['order_id'] = array('in', array_keys($order_ids));
            $condition['refund_lock'] = '0'; //退款锁定状态:0为正常(能退款),1为锁定(待审核),2为同意
            $code_list = $this->getVrordercodeList($condition);
            if (!empty($code_list) && is_array($code_list)) {
                foreach ($code_list as $key => $value) {
                    $order_id = $value['order_id']; //虚拟订单编号
                    $rec_id = $value['rec_id']; //兑换码表编号
                    if ($value['vr_state'] != '1') {//使用状态 0:未使用1:已使用2:已过期
                        $order_key = $order_ids[$order_id];
                        $order_list[$order_key]['code_list'][$rec_id] = $value;
                    }
                }
            }
        }
        return $order_list;
    }

    /**
     * 取得兑换码列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $fields 字段
     * @return array
     */
    public function getShowVrordercodeList($condition = array(), $fields = '*') {
        $code_list = $this->getVrordercodeList($condition);
        //进一步处理
        if (!empty($code_list)) {
            $i = 0;
            foreach ($code_list as $k => $v) {
                if ($v['vr_state'] == '1') {
                    $content = '已使用，使用时间 ' . date('Y-m-d', $v['vr_usetime']);
                } else if ($v['vr_state'] == '0') {
                    if ($v['vr_indate'] < TIMESTAMP) {
                        $content = '已过期，过期时间 ' . date('Y-m-d', $v['vr_indate']);
                    } else {
                        $content = '未使用，有效期至 ' . date('Y-m-d', $v['vr_indate']);
                    }
                }
                if ($v['refund_lock'] == '1') {
                    $content = '退款审核中';
                } else if ($v['refund_lock'] == '2') {
                    $content = '退款已完成';
                }
                $code_list[$k]['vr_code_desc'] = $content;
                if ($v['vr_state'] == '0')
                    $i++;
            }
            $code_list[0]['vr_code_valid_count'] = $i;
        }
        return $code_list;
    }

    /**
     * 取得兑换码信息
     * @param type $condition 条件
     * @param type $fields 字段
     * @param type $master 主服务器
     * @return type
     */
    public function getVrordercodeInfo($condition = array(), $fields = '*', $master = false) {
        return db('vrordercode')->field($fields)->where($condition)->master($master)->find();
    }

    /**
     * 取得兑换码数量
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getVrordercodeCount($condition) {
        return db('vrordercode')->where($condition)->count();
    }

    /**
     * 生成兑换码 长度 =3位 + 4位 + 2位 + 3位  + 1位 + 5位随机  = 18位
     * @access public
     * @author csdeshang
     * @param string $perfix 前缀
     * @param type $store_id 店铺id
     * @param type $member_id 会员id
     * @param type $num 数字
     * @return string
     */
    private function _makeVrordercode($perfix, $store_id, $member_id, $num) {
        $perfix .= sprintf('%04d', (int) $store_id * $member_id % 10000)
                . sprintf('%02d', (int) $member_id % 100)
                . sprintf('%03d', (float) microtime() * 1000);

        $code_list = array();
        for ($i = 0; $i < $num; $i++) {
            $code_list[$i] = $perfix . sprintf('%01d', (int) $i % 10) . random(5, 1);
        }
        return $code_list;
    }

    /**
     * 取得订单列表(所有)
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $pagesize 分页
     * @param type $field 字段
     * @param type $order 排序
     * @param type $limit 限制
     * @return type
     */
    public function getVrorderList($condition, $pagesize = '', $field = '*', $order = 'order_id desc', $limit = '') {
        if($pagesize){
            $list = db('vrorder')->field($field)->where($condition)->order($order)->limit($limit)->paginate($pagesize,false,['query' => request()->param()]);
            $this->page_info = $list;
            $list = $list->items();
        }else{
            $list = db('vrorder')->field($field)->where($condition)->order($order)->limit($limit)->select();
        }



        if (empty($list))
            return array();
        foreach ($list as $key => $order) {
            if (isset($order['order_state'])) {
                list($list[$key]['state_desc'], $list[$key]['order_state_text']) = $this->_vrorderState($order['order_state']);
            }
            if (isset($order['payment_code'])) {
                $list[$key]['payment_name'] = get_order_payment_name($order['payment_code']);
            }
        }

        return $list;
    }

    /**
     * 取得订单状态文字输出形式
     * @access public
     * @author csdeshang
     * @param type $order_state 订单状态
     * @return type
     */
    private function _vrorderState($order_state) {
        switch ($order_state) {
            case ORDER_STATE_CANCEL:
                $order_state = '<span style="color:#999">已取消</span>';
                $order_state_text = '已取消';
                break;
            case ORDER_STATE_NEW:
                $order_state = '<span style="color:#36C">待付款</span>';
                $order_state_text = '待付款';
                break;
            case ORDER_STATE_PAY:
                $order_state = '<span style="color:#999">已支付</span>';
                $order_state_text = '已支付';
                break;
            case ORDER_STATE_SUCCESS:
                $order_state = '<span style="color:#999">已完成</span>';
                $order_state_text = '已完成';
                break;
        }
        return array($order_state, $order_state_text);
        ;
    }

    /**
     * 返回是否允许某些操作
     * @access public
     * @author csdeshang
     * @param type $operate 操作
     * @param type $order_info 订单信息
     * @return boolean
     */
    public function getVrorderOperateState($operate, $order_info) {
        $state = false;
        if (!is_array($order_info) || empty($order_info))
            return false;

        switch ($operate) {

            //买家取消订单
            case 'buyer_cancel':
                $state = $order_info['order_state'] == ORDER_STATE_NEW;
                break;

            //商家取消订单
            case 'store_cancel':
                $state = $order_info['order_state'] == ORDER_STATE_NEW;
                break;

            //平台取消订单
            case 'system_cancel':
                $state = $order_info['order_state'] == ORDER_STATE_NEW;
                break;

            //平台收款
            case 'system_receive_pay':
                $state = $order_info['order_state'] == ORDER_STATE_NEW;
                break;

            //支付
            case 'payment':
                $state = $order_info['order_state'] == ORDER_STATE_NEW;
                break;

            //评价
            case 'evaluation':
                $state = !isset($order_info['lock_state']) && $order_info['evaluation_state'] == '0' && $order_info['use_state'];
                break;

            //买家退款
            case 'refund':
                $state = false;
                $code_list = isset($order_info['code_list'])?$order_info['code_list']:''; //没有使用的兑换码列表
                if (!empty($code_list) && is_array($code_list)) {//没结算可以退款
                    if ($order_info['vr_indate'] > TIMESTAMP) {//有效期内的能退款
                        $state = true;
                    }
                    if ($order_info['vr_invalid_refund'] == 1 && ($order_info['vr_indate'] + 60 * 60 * 24 * config('code_invalid_refund')) > TIMESTAMP) {//兑换码过期后可退款
                        $state = true;
                    }
                }
                break;
        }
        return $state;
    }

    /**
     * 订单详情页显示进行步骤
     * @access public
     * @author csdeshang
     * @param array $order_info 订单信息
     * @return array
     */
    public function getVrorderStep($order_info) {
        if (!is_array($order_info) || empty($order_info))
            return array();
        $step_list = array();
        // 第一步 下单完成
        $step_list['step1'] = true;
        //第二步 付款完成
        $step_list['step2'] = !empty($order_info['payment_time']);
        //第三步 兑换码使用中
        $step_list['step3'] = !empty($order_info['payment_time']);
        //第四步 使用完成或到期结束
        $step_list['step4'] = $order_info['order_state'] == ORDER_STATE_SUCCESS;
        return $step_list;
    }

    /**
     * 取得订单数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getVrorderCount($condition) {
        return db('vrorder')->where($condition)->count();
    }

    /**
     * 订单销售记录 订单状态为20、30、40时
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $page 分页
     * @param type $order 排序
     * @return type
     */
    public function getVrorderAndOrderGoodsSalesRecordList($condition, $field = "*", $page = 0, $order = 'order_id desc') {
        $condition['order_state'] = array('in', array(ORDER_STATE_PAY, ORDER_STATE_SUCCESS));
        return $this->getVrorderList($condition, $page,$field , $order);
    }

}
