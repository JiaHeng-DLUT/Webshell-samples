<?php

namespace app\common\model;

use think\Model;

class Smslog extends Model {

    public $page_info;

    /**
     * 发送验证码
     * @author csdeshang
     * @param type $smslog_phone 手机号
     * @param type $smslog_msg 短信
     * @param type $smslog_type 类型
     * @param type $smslog_captcha 验证码
     * @param type $member_id 会员ID
     * @param type $member_name 会员名
     * @return type
     */
    function sendSms($smslog_phone,$smslog_msg,$smslog_type='',$smslog_captcha='',$member_id='0',$member_name='')
    {
        
        //通过手机号判断是否允许发送短信
        $begin_add_time = strtotime(date('Y-m-d', TIMESTAMP));
        $end_add_time = strtotime(date('Y-m-d', TIMESTAMP)) + 24 * 3600;
        
        //同一IP 每天只能发送20条短信
        $condition = array();
        $condition['smslog_ip'] = request()->ip();
        $condition['smslog_smstime'] = array('between', array($begin_add_time, $end_add_time));
        if ($this->getSmsCount($condition) > 20) {
            return array('state'=>FALSE,'code'=>10001,'message'=>'同一IP地址一天内只能发送20条短信，请勿多次获取动态码！');
        }
        
        //同一手机号,60秒才能提交发送一次
        $condition = array();
        $condition['smslog_phone'] = $smslog_phone;
        $condition['smslog_smstime'] = array('between', array(TIMESTAMP-30, TIMESTAMP));
        if ($this->getSmsCount($condition) > 0) {
            return array('state'=>FALSE,'code'=>10001,'message'=>'同一手机30秒后才能再次发送短信，请勿多次获取动态码！');
        }
        
        //同一手机号,每天只能发送5条短信
        $condition = array();
        $condition['smslog_phone'] = $smslog_phone;
        $condition['smslog_smstime'] = array('between', array($begin_add_time, $end_add_time));
        if ($this->getSmsCount($condition) > 5) {
            return array('state'=>FALSE,'code'=>10001,'message'=>'同一手机一天内只能发送5条短信，请勿多次获取动态码！');
        }

        //通过手机号获取现绑定的客户信息
        if(empty($member_id)||empty($member_name)){
            //通过手机号查询用户名
            $member = model('member')->getMemberInfo(array('member_mobile' => $smslog_phone));
            $member_id = isset($member['member_id'])?$member['member_id']:'0';
            $member_name = isset($member['member_name'])?$member['member_name']:'';
        }
        $sms = new \sendmsg\Sms();
        $result = $sms->send($smslog_phone, $smslog_msg);
        
        if ($result) {
            $log['smslog_phone'] = $smslog_phone;
            $log['smslog_captcha'] = $smslog_captcha;
            $log['smslog_ip'] = request()->ip();
            $log['smslog_msg'] = $smslog_msg;
            $log['smslog_type'] = $smslog_type;
            $log['smslog_smstime'] = TIMESTAMP;
            $log['member_id'] = $member_id;
            $log['member_name'] = $member_name;
            $result = $this->addSms($log);
            if($result>=0){
                return array('state'=>TRUE,'code'=>10000,'message'=>'');
            }else{
                return array('state'=>FALSE,'code'=>10001,'message'=>'手机短信发送失败');
            }
        }else{
            return array('state'=>FALSE,'code'=>10001,'message'=>'手机短信发送失败');
        }
    }
    
 
    /**
     * 增加短信记录
     * @access public
     * @author csdeshang
     * @param type $log_array 日志数组
     * @return type
     */
    public function addSms($log_array) {
        $log_id = db('smslog')->insertGetId($log_array);
        return $log_id;
    }

    /**
     * 查询单条记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return boolean
     */
    public function getSmsInfo($condition) {
        if (empty($condition)) {
            return false;
        }
        $result = db('smslog')->where($condition)->order('smslog_id desc')->find();
        return $result;
    }

    /**
     * 查询记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $limit 限制
     * @param type $order 排序
     * @return type
     */
    public function getSmsList($condition = array(), $page = '', $limit = '', $order = 'smslog_id desc') {
        if ($page) {
            $result = db('smslog')->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $result;
            $result = $result->items();
        } else {
            $result = db('smslog')->where($condition)->limit($limit)->order($order)->select();
        }

        return $result;
    }

    /**
     * 获取数据条数
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getSmsCount($condition) {
        return db('smslog')->where($condition)->count();
    }

    /**
     * 删除短信记录
     */
    public function delSmsLog($condition)
    {
        return db('smslog')->where($condition)->delete();
    }
}

?>
