<?php

namespace app\crontab\controller;
use app\common\logic\Queue;
use think\Cache;
class Minutes extends BaseCron {
    

    /**
     * 默认方法
     */
    public function index() {
        $this->_cron_queue();
        $this->_cron_common();
        $this->_cron_mail_send();
        $this->_cron_pintuan();
    }
    
    /**
     * 邮件信息发送队列的处理
     */
    private function _cron_queue(){
        //获取当前存储的数量
        $QueueClientNum = Cache::get('QueueClientNum');
        $QueueLogic = new Queue();
        for($i=1;$i<=$QueueClientNum;$i++){
            $info = Cache::pull('QueueClient_'.$i);#获取缓存
            if(empty($info)){
                continue;
            }
            $info = unserialize($info);
            $key = key($info);
            $value = current($info);
            $QueueLogic->$key($value);
        }
        Cache::set('QueueClientNum',NULL);
    }
    

    /**
     * 拼团相关处理
     */
    private function _cron_pintuan()
    {
        $ppintuan_model = model('ppintuan');
        $ppintuangroup_model = model('ppintuangroup');
        $ppintuanorder_model = model('ppintuanorder');
        //自动关闭时间过期的店铺拼团活动
        $condition = array();
        $condition['pintuan_end_time'] = array('lt',TIMESTAMP);
        $ppintuan_model->endPintuan($condition);
        
        
        //查看正在进行开团的列表.
        $condition = array();
        $condition['pintuangroup_state'] = 1;
        $pintuangroup_list = $ppintuangroup_model->getPpintuangroupList($condition);

        $success_ids = array();#拼团开团成功的拼团开团ID
        $fail_ids = array();#拼团开团失败的拼团开团ID
        foreach ($pintuangroup_list as $key => $pintuangroup) {

            //判断当前参团是否已过期
            if(TIMESTAMP >= $pintuangroup['pintuangroup_starttime'] + $pintuangroup['pintuangroup_limit_hour']*3600){

                //当已参团人数  大于 当前开团的  参团人数   
                if($pintuangroup['pintuangroup_joined']>=$pintuangroup['pintuangroup_limit_number']){

                    //满足开团人数,查看对应的订单是否付款,未付款则拼团失败,订单取消,订单款项退回.
                    $condition = array();
                    $condition['ppintuanorder.pintuangroup_id'] = $pintuangroup['pintuangroup_id'];
                    $condition['order.order_state'] = 20;
                    $count = db('ppintuanorder')->alias('ppintuanorder')->join('__ORDER__ order','order.order_id=ppintuanorder.order_id')->where($condition)->count();
                    if($count == $pintuangroup['pintuangroup_joined']){
                        //表示全部付款,拼团成功
                        $success_ids[] = $pintuangroup['pintuangroup_id'];
                    }else{
                        $fail_ids[] = $pintuangroup['pintuangroup_id'];
                    }
                }else{
                    //未满足开团人数
                    $fail_ids[] = $pintuangroup['pintuangroup_id'];
                }
            }
        }

        $condition = array();
        //在拼团失败的所有订单，已经付款的订单列表，取消订单,并且退款，未付款的订单自动取消订单
        $condition['ppintuanorder.pintuangroup_id'] = array('in', implode(',', $fail_ids));
		$condition['order.order_state'] = 20;
        $ppintuanorder_list = db('ppintuanorder')->field('order.*')->alias('ppintuanorder')->join('__ORDER__ order','order.order_id=ppintuanorder.order_id')->where($condition)->select();
        
        //针对已付款,拼团没成功的订单,进行取消订单以及退款操作
        $order_model = model('order');
        $logic_order = model('order','logic');
        
        foreach ($ppintuanorder_list as $key => $order_info) {
            $logic_order->changeOrderStateCancel($order_info,'system','系统','拼团未成功系统自动关闭订单',true,false,true);
        }
        
        //失败修改拼团相关数据库信息
        $condition = array();
        $condition['pintuangroup_id'] = array('in', implode(',', $fail_ids));
        $ppintuangroup_model->failPpintuangroup($condition);
        
        //成功修改拼团相关数据库信息
        $condition = array();
        $condition['pintuangroup_id'] = array('in', implode(',', $success_ids));
        $ppintuangroup_model->successPpintuangroup($condition);
        
    }
    

    /**
     * 发送邮件消息
     */
    private function _cron_mail_send() {
        //每次发送数量
        $_num = 50;
        $storemsgcron_model = model('mailcron');
        $cron_array = $storemsgcron_model->getMailCronList(array(), $_num);
        if (!empty($cron_array)) {
            $email = new \sendmsg\Email();
            $mail_array = array();
            foreach ($cron_array as $val) {
                $return = $email->send_sys_email($val['mailcron_address'],$val['mailcron_subject'],$val['mailcron_contnet']);
                if ($return) {
                    // 记录需要删除的id
                    $mail_array[] = $val['mailcron_id'];
                }
            }
            // 删除已发送的记录
            $storemsgcron_model->delMailCron(array('mailcron_id' => array('in', $mail_array)));
        }
    }

    /**
     * 执行通用任务
     */
    private function _cron_common(){

        //查找待执行任务
        $cron_model = model('cron');
        $cron = $cron_model->getCronList(array('exetime'=>array('elt',TIMESTAMP)));

        if (!is_array($cron)) return ;
        $cron_array = array(); $cronid = array();
        foreach ($cron as $v) {
            $cron_array[$v['type']][$v['exeid']] = $v;
        }
        foreach ($cron_array as $k=>$v) {
            // 如果方法不存是，直接删除id
            if (!method_exists($this,'_cron_'.$k)) {
                $tmp = current($v);
                $cronid[] = $tmp['id'];continue;
            }
            $result = call_user_func_array(array($this,'_cron_'.$k),array($v));
            if (is_array($result)){
                $cronid = array_merge($cronid,$result);
            }
        }
        //删除执行完成的cron信息
        if (!empty($cronid) && is_array($cronid)){
            $cron_model->delCron(array('id'=>array('in',$cronid)));
        }
    }

    /**
     * 上架
     *
     * @param array $cron
     */
    private function _cron_1($cron = array()){
        $condition = array('goods_commonid' => array('in',array_keys($cron)));
        $update = model('goods')->editProducesOnline($condition);
        if ($update){
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        }else{
            return false;
        }
        return $cronid;
    }

    /**
     * 根据商品id更新商品促销价格
     *
     * @param array $cron
     */
    private function _cron_2($cron = array()){
        $condition = array('goods_id' => array('in',array_keys($cron)));
        $update = model('goods')->editGoodsPromotionPrice($condition);
        if ($update){
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        }else{
            return false;
        }
        return $cronid;
    }

    /**
     * 优惠套装过期
     *
     * @param array $cron
     */
    private function _cron_3($cron = array()) {
        $condition = array('store_id' => array('in', array_keys($cron)));
        $update = model('pbundling')->editBundlingQuotaClose($condition);
        if ($update) {
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        } else {
            return false;
        }
        return $cronid;
    }

    /**
     * 推荐展位过期
     *
     * @param array $cron
     */
    private function _cron_4($cron = array()) {
        $condition = array('store_id' => array('in', array_keys($cron)));
        $update = model('pbooth')->editBoothClose($condition);
        if ($update) {
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        } else {
            return false;
        }
        return $cronid;
    }

    /**
     * 抢购开始更新商品促销价格
     *
     * @param array $cron
     */
    private function _cron_5($cron = array()) {
        $condition = array();
        $condition['goods_commonid'] = array('in', array_keys($cron));
        $condition['groupbuy_starttime'] = array('lt', TIMESTAMP);
        $condition['groupbuy_endtime'] = array('gt', TIMESTAMP);
        $groupbuy = model('groupbuy')->getGroupbuyList($condition);
        foreach ($groupbuy as $val) {
            model('goods')->editGoods(array('goods_promotion_price' => $val['groupbuy_price'], 'goods_promotion_type' => 1), array('goods_commonid' => $val['goods_commonid']));
        }
        //返回执行成功的cronid
        $cronid = array();
        foreach ($cron as $v) {
            $cronid[] = $v['id'];
        }
        return $cronid;
    }

    /**
     * 抢购过期
     *
     * @param array $cron
     */
    private function _cron_6($cron = array()) {
        $condition = array('goods_commonid' => array('in', array_keys($cron)));
        //抢购活动过期
        $update = model('groupbuy')->editExpireGroupbuy($condition);
        if ($update){
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        }else{
            return false;
        }
        return $cronid;
    }

    /**
     * 限时折扣过期
     *
     * @param array $cron
     */
    private function _cron_7($cron = array()) {
        $condition = array('xianshi_id' => array('in', array_keys($cron)));
        //限时折扣过期
        $update = model('pxianshi')->editExpireXianshi($condition);
        if ($update){
            //返回执行成功的cronid
            $cronid = array();
            foreach ($cron as $v) {
                $cronid[] = $v['id'];
            }
        }else{
            return false;
        }
        return $cronid;
    }
    
}
?>
