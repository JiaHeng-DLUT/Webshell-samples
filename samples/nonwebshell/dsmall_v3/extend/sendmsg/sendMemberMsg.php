<?php
namespace  sendmsg;
class sendMemberMsg
{
    private $code = '';
    private $member_id = 0;
    private $member_info = array();
    private $mobile = '';
    private $email = '';

    /**
     * 设置
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->$key = $value;
    }

    public function send($param = array())
    {
        $msg_tpl = rkcache('membermsgtpl', true);
        if (!isset($msg_tpl[$this->code]) || $this->member_id <= 0) {
            return false;
        }

        $tpl_info = $msg_tpl[$this->code];

        $setting_info = model('membermsgsetting')->getMembermsgsettingInfo(array('membermt_code' => $this->code,'member_id' => $this->member_id), 'membermt_isreceive');
        if (empty($setting_info) || $setting_info['membermt_isreceive']) {
            // 发送站内信
            if ($tpl_info['membermt_message_switch']) {
                $message = ds_replace_text($tpl_info['membermt_message_content'], $param);
                $this->sendMessage($message);
            }
            // 发送短消息
            if ($tpl_info['membermt_short_switch']) {
                $this->getMemberInfo();
                if (!empty($this->mobile))
                    $this->member_info['member_mobile'] = $this->mobile;
                if ($this->member_info['member_mobilebind'] && !empty($this->member_info['member_mobile'])) {
                    $param['site_name'] = config('site_name');
                    $message = ds_replace_text($tpl_info['membermt_short_content'], $param);
                    if(session('member_msg_short')==md5($message.'@'.$this->code.'@'.$this->member_id)){//如果发送过相同的消息则停止再发送
                        return false;
                    }else{
                        session('member_msg_short',md5($message.'@'.$this->code.'@'.$this->member_id));
                    }
                    $this->sendShort($this->member_info['member_mobile'], $message);
                }
            }
            // 发送邮件
            if ($tpl_info['membermt_mail_switch']) {
                $this->getMemberInfo();
                if (!empty($this->email))
                    $this->member_info['member_email'] = $this->email;
                if ($this->member_info['member_emailbind'] && !empty($this->member_info['member_email'])) {
                    $param['site_name'] = config('site_name');
                    $param['mail_send_time'] = date('Y-m-d H:i:s');
                    $subject = ds_replace_text($tpl_info['membermt_mail_subject'], $param);
                    $message = ds_replace_text($tpl_info['membermt_mail_content'], $param);
                    $this->sendMail($this->member_info['member_email'], $subject, $message);
                }
            }
        }
    }

    /**
     * 会员详细信息
     */
    private function getMemberInfo()
    {
        if (empty($this->member_info)) {
            $this->member_info = model('member')->getMemberInfoByID($this->member_id);
        }
    }

    /**
     * 发送站内信
     * @param unknown $message
     */
    private function sendMessage($message)
    {
        //添加短消息
        $message_model = model('message');
        $insert_arr = array();
        $insert_arr['from_member_id'] = 0;
        $insert_arr['member_id'] = $this->member_id;
        $insert_arr['msg_content'] = $message;
        $insert_arr['message_type'] = 1;
        $message_model->addMessage($insert_arr);
    }

    /**
     * 发送短消息
     * @param unknown $number
     * @param unknown $message
     */
    private function sendShort($number, $message)
    {
        $sms = new \sendmsg\Sms();
        $sms->send($number, $message);
    }

    /**
     * 发送邮件
     * @param unknown $number
     * @param unknown $subject
     * @param unknown $message
     */
    private function sendMail($number, $subject, $message)
    {
        //即时发送邮箱
        $email = new Email();
        $email->send_sys_email($number, $subject, $message);
        // 计划任务代码
        $insert = array();
        $insert['mailcron_address'] = $number;
        $insert['mailcron_subject'] = $subject;
        $insert['mailcron_contnet'] = $message;
        model('mailcron')->addMailCron($insert);
    }
}