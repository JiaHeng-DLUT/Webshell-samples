<?php

namespace app\admin\controller;

use think\Lang;

class Message extends AdminControl {

    public function _initialize() {
        parent::_initialize();

        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/message.lang.php');
    }

    /**
     * 邮件设置
     */
    public function email() {
        $config_model = model('config');
        if (!(request()->isPost())) {
            $list_config = rkcache('config', true);
            $this->assign('list_config', $list_config);

            $this->setAdminCurItem('email');
            return $this->fetch('email');
        } else {
            $update_array = array();
            $update_array['email_host'] = input('post.email_host');
            $update_array['email_secure'] = input('post.email_secure');
            $update_array['email_port'] = input('post.email_port');
            $update_array['email_addr'] = input('post.email_addr');
            $update_array['email_id'] = input('post.email_id');
            $update_array['email_pass'] = input('post.email_pass');

            $result = $config_model->editConfig($update_array);
            if ($result === true) {
                $this->log(lang('ds_edit') . lang('email_set'), 1);
                $this->success(lang('ds_common_save_succ'));
            } else {
                $this->log(lang('ds_edit') . lang('email_set'), 0);
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 短信平台设置
     */
    public function mobile() {
        $config_model = model('config');
        if (!(request()->isPost())) {
            $list_config = rkcache('config', true);
            
            $smscf_wj_num = '';
            if(!empty($list_config['smscf_wj_username'])&&!empty($list_config['smscf_wj_key'])){
                //如果配置了信息,可以查看具体可用短信条数
                $smscf_wj_num = http_request('http://www.smschinese.cn/web_api/SMS/?Action=SMS_Num&Uid='.$list_config['smscf_wj_username'].'&Key='.$list_config['smscf_wj_key'],'get');
            }
            $this->assign('smscf_wj_num', $smscf_wj_num);
            $this->assign('list_config', $list_config);
            
            $this->setAdminCurItem('mobile');
            return $this->fetch('mobile');
        } else {
            $update_array = array();
            $update_array['smscf_wj_username'] = input('post.smscf_wj_username');
            $update_array['smscf_wj_key'] = input('post.smscf_wj_key');
            $update_array['sms_register'] = input('post.sms_register');
            $update_array['sms_login'] = input('post.sms_login');
            $update_array['sms_password'] = input('post.sms_password');
            $result = $config_model->editConfig($update_array);
            if ($result === true) {
                $this->log(lang('ds_edit') . lang('mobile_set'), 1);
                $this->success(lang('ds_common_save_succ'));
            } else {
                $this->log(lang('ds_edit') . lang('mobile_set'), 0);
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }
    
    /**
     * 短信发送日志
     */
    public function smslog()
    {
        $condition = array();
        
        $add_time_from = input('get.add_time_from');
        $add_time_to = input('get.add_time_to');
        if (trim($add_time_from) != '' || trim($add_time_to) != '') {
            $add_time_from = strtotime(trim($add_time_from));
            $add_time_to = strtotime(trim($add_time_to));
            if ($add_time_from !== false || $add_time_to !== false) {
                $condition['smslog_smstime'] = array('between', array($add_time_from, $add_time_to));
            }
        }
        $member_name = input('get.member_name');
        if(!empty($member_name)){
            $condition['member_name'] = array('like',"%" . $member_name . "%");
        }
        $smslog_phone = input('get.smslog_phone');
        if(!empty($smslog_phone)){
            $condition['smslog_phone'] = array('like',"%" . $smslog_phone . "%");
        }
        $smslog_model = model('smslog');
        $smslog_list = $smslog_model->getSmsList($condition,10);
        $this->assign('smslog_list', $smslog_list);
        $this->assign('show_page', $smslog_model->page_info->render());
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        
        $this->setAdminCurItem('smslog');
        return $this->fetch();
    }

    /**
     * 短信日志删除
     */
    public function smslog_del(){
        $smslog_id = input('param.smslog_id');
        $smslog_id_array = ds_delete_param($smslog_id);
        if ($smslog_id_array === FALSE) {
            ds_json_encode(10001, lang('param_error'));
        }
        $condition = array();
        $smslog_model = model('smslog');
        $condition['smslog_id'] = array('in', $smslog_id_array);
        $smslog_list = $smslog_model->delSmsLog($condition);
        if ($smslog_list){
            ds_json_encode(10000, lang('ds_common_del_succ'));
        }else{
            ds_json_encode(10001, lang('ds_common_del_fail'));
        }
    }

    /**
     * 邮件模板列表
     */
    public function email_tpl() {
        $mailtemplates_model = model('mailtemplates');
        $templates_list = $mailtemplates_model->getTplList();
        $this->assign('templates_list', $templates_list);
        $this->setAdminCurItem('email_tpl');
        return $this->fetch('email_tpl');
    }

    /**
     * 编辑邮件模板
     */
    public function email_tpl_edit() {
        $mailtemplates_model = model('mailtemplates');
        if (!request()->isPost()) {
            if (!(input('param.code'))) {
                $this->error(lang('mailtemplates_edit_code_null'));
            }
            $templates_array = $mailtemplates_model->getTplInfo(array('mailmt_code' => input('param.code')));
            $this->assign('templates_array', $templates_array);
            $this->setAdminCurItem('email_tpl_edit');
            return $this->fetch('email_tpl_edit');
        } else {
            $data = array(
                'code' => input('post.code'),
                'title' => input('post.title'),
                'content' => input('post.content'),
            );
            $mailtemplatese_validate = validate('mailtemplates');
            if (!$mailtemplatese_validate->scene('email_tpl_edit')->check($data)) {
                $this->error($mailtemplatese_validate->getError());
            } else {
                $update_array = array();
                $update_array['mailmt_code'] = input('post.code');
                $update_array['mailmt_title'] = input('post.title');
                $update_array['mailmt_content'] = input('post.content');
                $result = $mailtemplates_model->editTpl($update_array, array('mailmt_code' => input('post.code')));
                if ($result>=0) {
                    $this->log(lang('ds_edit') . lang('email_tpl'), 1);
                    $this->success(lang('mailtemplates_edit_succ'), 'Admin/Message/email_tpl');
                } else {
                    $this->log(lang('ds_edit') . lang('email_tpl'), 0);
                    $this->error(lang('mailtemplates_edit_fail'));
                }
            }
        }
    }

    /**
     * 测试邮件发送
     *
     * @param
     * @return
     */
    public function email_testing() {
        /**
         * 读取语言包
         */
        $email_host = trim(input('post.email_host'));
        $email_secure = trim(input('post.email_secure'));
        $email_port = trim(input('post.email_port'));
        $email_addr = trim(input('post.email_addr'));
        $email_id = trim(input('post.email_id'));
        $email_pass = trim(input('post.email_pass'));
        $email_test = trim(input('post.email_test'));
        $subject = lang('test_email');
        $site_url = HOME_SITE_URL;
        
        /**
        //邮件发送测试
        $email_host = 'smtp.126.com';
        $email_secure = 'tls';//tls ssl
        $email_port = '25';//465 25
        $email_addr = '';
        $email_id = '';
        $email_pass = '';
        $email_test = '181814630@qq.com';
        */
        

        $site_name = config('site_name');
        $message = '<p>' . lang('this_is_to') . "<a href='" . $site_url . "' target='_blank'>" . $site_name . '</a>' . lang('test_email_set_ok') . '</p>';

        $obj_email = new \sendmsg\Email();
        $obj_email->set('email_server', $email_host);
        $obj_email->set('email_secure', $email_secure);
        $obj_email->set('email_port', $email_port);
        $obj_email->set('email_user', $email_id);
        $obj_email->set('email_password', $email_pass);
        $obj_email->set('email_from', $email_addr);
        $obj_email->set('site_name', $site_name);
        $result = $obj_email->send($email_test, $subject, $message);
        if ($result === false) {
            $data['msg'] = lang('test_email_send_fail');
            echo json_encode($data);exit;
        } else {
            $data['msg'] = lang('test_email_send_ok');
            echo json_encode($data);exit;
        }
    }

    /**
     * 商家消息模板
     */
    public function seller_tpl() {
        $mstpl_list = model('storemsgtpl')->getStoremsgtplList(array());
        $this->assign('mstpl_list', $mstpl_list);
        $this->setAdminCurItem('seller_tpl');
        return $this->fetch('seller_tpl');
    }

    /**
     * 商家消息模板编辑
     */
    public function seller_tpl_edit() {
        if (!request()->isPost()) {
            $code = trim(input('param.code'));
            if (empty($code)) {
                $this->error(lang('param_error'));
            }
            $where = array();
            $where['storemt_code'] = $code;
            $smtpl_info = model('storemsgtpl')->getStoremsgtplInfo($where);
            $this->assign('smtpl_info', $smtpl_info);
            $this->setAdminCurItem('seller_tpl_edit');
            return $this->fetch('seller_tpl_edit');
        } else {
            $code = trim(input('post.code'));
            $type = trim(input('post.type'));
            if (empty($code) || empty($type)) {
                $this->error(lang('param_error'));
            }
            switch ($type) {
                case 'message':
                    $this->seller_tpl_update_message();
                    break;
                case 'short':
                    $this->seller_tpl_update_short();
                    break;
                case 'mail':
                    $this->seller_tpl_update_mail();
                    break;
            }
        }
    }

    /**
     * 商家消息模板更新站内信
     */
    private function seller_tpl_update_message() {
        $message_content = trim(input('post.message_content'));
        if (empty($message_content)) {
            $this->error('请填写站内信模板内容。');
        }
        // 条件
        $where = array();
        $where['storemt_code'] = trim(input('post.code'));
        // 数据
        $update = array();
        $update['storemt_message_switch'] = intval(input('post.message_switch'));
        $update['storemt_message_content'] = $message_content;
        $update['storemt_message_forced'] = intval(input('post.message_forced'));
        $result = model('storemsgtpl')->editStoremsgtpl($where, $update);
        $this->seller_tpl_update_showmessage($result);
    }

    /**
     * 商家消息模板更新短消息
     */
    private function seller_tpl_update_short() {
        $short_content = trim(input('post.short_content'));
        if (empty($short_content)) {
            $this->error('请填写短消息模板内容。');
        }
        // 条件
        $where = array();
        $where['storemt_code'] = trim(input('post.code'));
        // 数据
        $update = array();
        $update['storemt_short_switch'] = intval(input('post.short_switch'));
        $update['storemt_short_content'] = $short_content;
        $update['smt_short_forced'] = intval(input('post.short_forced'));
        $result = model('storemsgtpl')->editStoremsgtpl($where, $update);
        $this->seller_tpl_update_showmessage($result);
    }

    /**
     * 商家消息模板更新邮件
     */
    private function seller_tpl_update_mail() {
        $mail_subject = trim(input('post.mail_subject'));
        $mail_content = trim(input('post.mail_content'));
        if ((empty($mail_subject) || empty($mail_content))) {
            $this->error('请填写邮件模板内容。');
        }
        // 条件
        $where = array();
        $where['storemt_code'] = trim(input('post.code'));
        // 数据
        $update = array();
        $update['storemt_mail_switch'] = intval(input('post.mail_switch'));
        $update['storemt_mail_subject'] = $mail_subject;
        $update['storemt_mail_content'] = $mail_content;
        $update['storemt_mail_forced'] = intval(input('post.mail_forced'));
        $result = model('storemsgtpl')->editStoremsgtpl($where, $update);
        $this->seller_tpl_update_showmessage($result);
    }

    private function seller_tpl_update_showmessage($result) {
        if ($result>=0) {
            $this->success(lang('ds_common_op_succ'), url('Message/seller_tpl'));
        } else {
            $this->error(lang('ds_common_op_fail'));
        }
    }

    /**
     * 用户消息模板
     */
    public function member_tpl() {
        $mmtpl_list = model('membermsgtpl')->getMembermsgtplList(array());
        $this->assign('mmtpl_list', $mmtpl_list);
        $this->setAdminCurItem('member_tpl');
        return $this->fetch('member_tpl');
    }

    /**
     * 用户消息模板编辑
     */
    public function member_tpl_edit() {
        if (!request()->isPost()) {
            $code = trim(input('param.code'));
            if (empty($code)) {
                $this->error(lang('param_error'));
            }
            $where = array();
            $where['membermt_code'] = $code;
            $mmtpl_info = model('membermsgtpl')->getMembermsgtplInfo($where);
            $this->assign('mmtpl_info', $mmtpl_info);
            $this->setAdminCurItem('member_tpl_edit');
            return $this->fetch('member_tpl_edit');
        } else {
            $code = trim(input('post.code'));
            $type = trim(input('post.type'));
            if (empty($code) || empty($type)) {
                $this->error(lang('param_error'));
            }
            switch ($type) {
                case 'message':
                    $this->member_tpl_update_message();
                    break;
                case 'short':
                    $this->member_tpl_update_short();
                    break;
                case 'mail':
                    $this->member_tpl_update_mail();
                    break;
            }
        }
    }

    /**
     * 商家消息模板更新站内信
     */
    private function member_tpl_update_message() {
        $message_content = trim(input('post.message_content'));
        if (empty($message_content)) {
            $this->error('请填写站内信模板内容。');
        }
        // 条件
        $where = array();
        $where['membermt_code'] = trim(input('post.code'));
        // 数据
        $update = array();
        $update['membermt_message_switch'] = intval(input('post.message_switch'));
        $update['membermt_message_content'] = $message_content;
        $result = model('membermsgtpl')->editMembermsgtpl($where, $update);
        $this->member_tpl_update_showmessage($result);
    }

    /**
     * 商家消息模板更新短消息
     */
    private function member_tpl_update_short() {
        $short_content = trim(input('post.short_content'));
        if (empty($short_content)) {
            $this->error('请填写短消息模板内容。');
        }
        // 条件
        $where = array();
        $where['membermt_code'] = trim(input('post.code'));
        // 数据
        $update = array();
        $update['membermt_short_switch'] = intval(input('post.short_switch'));
        $update['membermt_short_content'] = $short_content;
        $result = model('membermsgtpl')->editMembermsgtpl($where, $update);
        $this->member_tpl_update_showmessage($result);
    }

    /**
     * 商家消息模板更新邮件
     */
    private function member_tpl_update_mail() {
        $mail_subject = trim(input('post.mail_subject'));
        $mail_content = trim(input('post.mail_content'));
        if ((empty($mail_subject) || empty($mail_content))) {
            $this->error('请填写邮件模板内容。');
        }
        // 条件
        $where = array();
        $where['membermt_code'] = trim(input('post.code'));
        // 数据
        $update = array();
        $update['membermt_mail_switch'] = intval(input('post.mail_switch'));
        $update['membermt_mail_subject'] = $mail_subject;
        $update['membermt_mail_content'] = $mail_content;
        $result = model('membermsgtpl')->editMembermsgtpl($where, $update);
        $this->member_tpl_update_showmessage($result);
    }

    private function member_tpl_update_showmessage($result) {
        if ($result>=0) {
            $this->success(lang('ds_common_op_succ'), url('Message/member_tpl'));
        } else {
            $this->error(lang('ds_common_op_fail'));
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'email',
                'text' => '邮件设置',
                'url' => url('Message/email')
            ),
            array(
                'name' => 'mobile',
                'text' => '短信平台设置',
                'url' => url('Message/mobile')
            ),
            array(
                'name' => 'smslog',
                'text' => '短信记录',
                'url' => url('Message/smslog')
            ),
            array(
                'name' => 'seller_tpl',
                'text' => '商家消息模板',
                'url' => url('Message/seller_tpl')
            ),
            array(
                'name' => 'member_tpl',
                'text' => '用户消息模板',
                'url' => url('Message/member_tpl')
            ),
            array(
                'name' => 'email_tpl',
                'text' => '其他模板',
                'url' => url('Message/email_tpl')
            ),
        );
        if (request()->action() == 'seller_tpl_edit') {
            $menu_array[] = array(
                'name' => 'seller_tpl_edit',
                'text' => '编辑商家消息模板',
                'url' => "javascript:void(0)"
            );
        }
        if (request()->action() == 'member_tpl_edit') {
            $menu_array[] = array(
                'name' => 'member_tpl_edit',
                'text' => '编辑用户消息模板',
                'url' => "javascript:void(0)"
            );
        }
        if (request()->action() == 'email_tpl_edit') {
            $menu_array[] = array(
                'name' => 'email_tpl_edit',
                'text' => '编辑其他消息模板',
                'url' => "javascript:void(0)"
            );
        }


        return $menu_array;
    }

}

?>
