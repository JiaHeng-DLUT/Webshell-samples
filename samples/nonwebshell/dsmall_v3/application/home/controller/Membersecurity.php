<?php

namespace app\home\controller;

use think\Lang;

class Membersecurity extends BaseMember {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/memberpoints.lang.php');
    }

    public function index() {
        $member_info = $this->member_info;
        $member_info['security_level'] = model('member')->getMemberSecurityLevel($member_info);
        $this->assign('member_info', $member_info);
        /* 设置买家当前菜单 */
        $this->setMemberCurMenu('member_security');
        /* 设置买家当前栏目 */
        $this->setMemberCurItem('index');
        return $this->fetch($this->template_dir . 'index');
    }

    /**
     * 绑定邮箱 - 发送邮件
     */
    public function send_bind_email() {
        $email = input('param.email');

        $membersecurity_validate = validate('membersecurity');
        if (!$membersecurity_validate->scene('send_bind_email')->check(array('email'=>$email))) {
            ds_json_encode(10001,$membersecurity_validate->getError());
        }

        $member_model = model('member');
        $condition = array();
        $condition['member_email'] = $email;
        $condition['member_id'] = array('neq', session('member_id'));
        $member_info = $member_model->getMemberInfo($condition, 'member_id');
        if ($member_info) {
            ds_json_encode(10001,lang('mailbox_has_been_used'));
        }
        $seed = random(6);
        $data = array();
        $data['auth_code'] = $seed;
        $data['send_acode_time'] = TIMESTAMP;
        $update = $member_model->editMemberCommon($data, array('member_id' => session('member_id')));
        if (!$update) {
            ds_json_encode(10001,lang('system_error'));
        }
        $uid = base64_encode(ds_encrypt(session('member_id') . ' ' . $email));
        $verify_url = HOME_SITE_URL . '/Login/bind_email.html?uid=' . $uid . '&hash=' . md5($seed);

        $mailtemplates_model = model('mailtemplates');
        $tpl_info = $mailtemplates_model->getTplInfo(array('mailmt_code' => 'bind_email'));
        $param = array();
        $param['site_name'] = config('site_name');
        $param['user_name'] = session('member_name');
        $param['verify_url'] = $verify_url;
        $subject = ds_replace_text($tpl_info['mailmt_title'], $param);
        $message = ds_replace_text($tpl_info['mailmt_content'], $param);

        $ob_email = new \sendmsg\Email();
        $result = $ob_email->send_sys_email($email, $subject, $message);
        if ($result) {
            $data = array();
            $data['member_email'] = $email;
            $data['member_emailbind'] = 0;
            $member_model->editMember(array('member_id' => session('member_id')), $data);
            ds_json_encode(10000,lang('verify_mail_been_sent_mailbox'));
        } else {
            ds_json_encode(10001,lang('system_error'));
        }
    }

    public function auth() {
        $member_model = model('member');
        $type = input('param.type');
        if (!request()->isPost()) {
            if (!in_array($type, array('modify_pwd', 'modify_mobile', 'modify_email', 'modify_paypwd', 'pd_cash'))) {
                $this->redirect('Membersecurity/index');
            }
            //继承父类的member_info
            $member_info = $this->member_info;
            if (!$member_info) {
                $member_info = $member_model->getMemberInfo(array('member_id' => session('member_id')), 'member_email,member_emailbind,member_mobile,member_mobilebind');
            }
            //第一次绑定邮箱，不用发验证码，直接进下一步
            //第一次绑定手机，不用发验证码，直接进下一步
            if (($type == 'modify_email' && $member_info['member_emailbind'] == '0') || ($type == 'modify_mobile' && $member_info['member_mobilebind'] == '0')) {
                session('auth_' . $type, TIMESTAMP);
                /* 设置买家当前菜单 */
                $this->setMemberCurMenu('member_security');
                /* 设置买家当前栏目 */
                $this->setMemberCurItem($type);
                echo $this->fetch($this->template_dir . $type);
                exit;
            }

            //修改密码、设置支付密码时，必须绑定邮箱或手机
            if (in_array($type, array('modify_pwd', 'modify_paypwd')) && $member_info['member_emailbind'] == '0' && $member_info['member_mobilebind'] == '0') {
                $this->error(lang('please_bind_email_phone_first'), 'membersecurity/index');
            }
            $this->assign('member_info', $member_info);
            /* 设置买家当前菜单 */
            $this->setMemberCurMenu('member_security');
            /* 设置买家当前栏目 */
            $this->setMemberCurItem($type);
            return $this->fetch($this->template_dir . 'auth');
        } else {
            if (!in_array($type, array('modify_pwd', 'modify_mobile', 'modify_email', 'modify_paypwd', 'pd_cash'))) {
                $this->redirect(url('Membersecurity/index'));
            }
            $member_common_info = $member_model->getMemberCommonInfo(array('member_id' => session('member_id')));
            if (empty($member_common_info) || !is_array($member_common_info)) {
                $this->error(lang('validation_fails'));
            }
            if ($member_common_info['auth_code'] != input('post.auth_code') || TIMESTAMP - $member_common_info['send_acode_time'] > 1800) {
                $this->error(lang('please_retrieve_verification_code'), url('Membersecurity/index'));
            }
            $data = array();
            $data['auth_code'] = '';
            $data['send_acode_time'] = 0;
            $update = $member_model->editMemberCommon($data, array('member_id' => session('member_id')));
            if (!$update) {
                $this->error(lang('system_error'), HOME_SITE_URL);
            }
            session('auth_' . $type, TIMESTAMP);

            /* 设置买家当前菜单 */
            $this->setMemberCurMenu('member_security');
            /* 设置买家当前栏目 */
            $this->setMemberCurItem($type);
            return $this->fetch($this->template_dir . $type);
        }
    }

    /**
     * 统一发送身份验证码
     */
    public function send_auth_code() {
        $type = input('param.type');
        if (!in_array($type, array('email', 'mobile')))
            exit();

        $member_model = model('member');
        $member_info = $member_model->getMemberInfoByID(session('member_id'));

        $verify_code = rand(100, 999) . rand(100, 999);
        $data = array();
        $data['auth_code'] = $verify_code;
        $data['send_acode_time'] = time();
        $update = $member_model->editMemberCommon($data, array('member_id' => session('member_id')));


        if (!$update) {
            exit(json_encode(array('state' => 'false', 'msg' => lang('system_error'))));
        }

        $mailtemplates_model = model('mailtemplates');
        $tpl_info = $mailtemplates_model->getTplInfo(array('mailmt_code' => 'authenticate'));

        $param = array();
        $param['send_time'] = date('Y-m-d H:i', TIMESTAMP);
        $param['verify_code'] = $verify_code;
        $param['site_name'] = config('site_name');
        $subject = ds_replace_text($tpl_info['mailmt_title'], $param);
        $message = ds_replace_text($tpl_info['mailmt_content'], $param);
        if ($type == 'email') {
            $email = new \sendmsg\Email();
            $result['state'] = $email->send_sys_email($member_info["member_email"], $subject, $message);
        } elseif ($type == 'mobile') {
            $result = model('smslog')->sendSms($member_info["member_mobile"],$message);
        }
        if ($result['state']) {
            exit(json_encode(array('state' => 'true', 'msg' => lang('verification_code_has_been_sent'))));
        } else {
            exit(json_encode(array('state' => 'false', 'msg' => isset($result['message'])?$result['message']: lang('verification_code_sending_failed'))));
        }
    }

    /**
     * 修改密码
     */
    public function modify_pwd() {
        $member_model = model('member');
        //身份验证后，需要在30分钟内完成修改密码操作
        if (TIMESTAMP - session('auth_modify_pwd') > 1800) {
            ds_json_encode(10001, lang('operation_timed_out'));
        }
        if (!request()->isPost()){
            exit();
        }
        $data = array(
            'password' => input('post.password'), 
            'confirm_password' => input('post.confirm_password'),
        );
        $membersecurity_validate = validate('membersecurity');
        if (!$membersecurity_validate->scene('modify_pwd')->check($data)) {
            ds_json_encode(10001, $membersecurity_validate->getError());
        }
        if ($data['password'] != $data['confirm_password']) {
            ds_json_encode(10001, lang('two_password_inconsistencies'));
        }
        
        //判断当前的密码是否和原密码相同
        $member_info = $member_model->getMemberInfo(array('member_id'=>session('member_id')));
        if($member_info['member_password'] == md5($data['password'])){
            ds_json_encode(10001, '修改密码不能和原密码相同');
        }
        

        $update = $member_model->editMember(array('member_id' => session('member_id')), array('member_password' => md5($data['password'])));
        $message = $update ? lang('password_modify_successfully') : 'operation_timed_out';
        session('auth_modify_pwd', NULL);
        if ($update) {
            ds_json_encode(10000, $message);
        } else {
            ds_json_encode(10001, $message);
        }
    }

    /**
     * 设置支付密码
     */
    public function modify_paypwd() {
        $member_model = model('member');

        //身份验证后，需要在30分钟内完成修改密码操作
        if (TIMESTAMP - session('auth_modify_paypwd') > 1800) {
            $this->error(lang('operation_timed_out'), url('Membersecurity/auth', ['type' => 'modify_paypwd']));
        }
        if (!request()->isPost())
            exit();
        $data = array(
            'password' => input('post.password'),
            'confirm_password' => input('post.confirm_password'),
        );
        $membersecurity_validate = validate('membersecurity');
        if (!$membersecurity_validate->scene('modify_paypwd')->check($data)) {
            ds_json_encode(10001,$membersecurity_validate->getError());
        }

        if ($data['password'] != $data['confirm_password']) {
            ds_json_encode(10001,lang('two_password_inconsistencies'));
        }

        $update = $member_model->editMember(array('member_id' => session('member_id')), array('member_paypwd' => md5($data['password'])));
        $message = $update ? lang('password_set_successfully') : lang('password_setting_failed');
        session('auth_modify_paypwd', NULL);
        if ($update){
            ds_json_encode(10000,$message);
        }else{
            ds_json_encode(10001,$message);
        }
    }

    /**
     * 绑定手机
     */
    public function modify_mobile() {
        $member_model = model('member');
        $member_model->getMemberInfoByID(session('member_id'));
        if (request()->isPost()) {
            $data = array(
                'mobile' => input('post.mobile'),
                'vcode' => input('post.vcode'),
            );

            $membersecurity_validate = validate('membersecurity');
            if (!$membersecurity_validate->scene('modify_mobile')->check($data)) {
                ds_json_encode(10001,$membersecurity_validate->getError());
            }

            $condition = array();
            $condition['member_id'] = session('member_id');
            $condition['auth_code'] = intval($data['vcode']);
            $member_common_info = $member_model->getMemberCommonInfo($condition, 'send_acode_time');
            if (!$member_common_info) {
                ds_json_encode(10001,lang('mobile_verification_code_error'));
            }
            if (TIMESTAMP - $member_common_info['send_acode_time'] > 1800) {
                ds_json_encode(10001,lang('phone_verification_code_expired'));
            }
            $data = array();
            $data['auth_code'] = '';
            $data['send_acode_time'] = 0;
            $update = $member_model->editMemberCommon($data, array('member_id' => session('member_id')));
            if (!$update) {
                ds_json_encode(10001,lang('system_error'));
            }
            $member_model->editMember(array('member_id' => session('member_id')), array('member_mobilebind' => 1));
            ds_json_encode(10000,lang('phone_number_bound_successfully'));
        }
    }

    /**
     * 修改手机号 - 发送验证码
     */
    public function send_modify_mobile() {
        $mobile = input('param.mobile');
        $membersecurity_validate = validate('membersecurity');
        if (!$membersecurity_validate->scene('send_modify_mobile')->check(array('mobile' => $mobile))) {
            exit(json_encode(array('state' => 'false', 'msg' => $membersecurity_validate->getError())));
        }

        $member_model = model('member');
        $condition = array();
        $condition['member_mobile'] = $mobile;
        $condition['member_id'] = array('neq', session('member_id'));
        $member_info = $member_model->getMemberInfo($condition, 'member_id');
        if ($member_info) {
            exit(json_encode(array('state' => 'false', 'msg' => lang('please_change_another_phone_number'))));
        }

        $verify_code = rand(100, 999) . rand(100, 999);

        $data = array();
        $data['auth_code'] = $verify_code;
        $data['send_acode_time'] = TIMESTAMP;

        $update = $member_model->editMemberCommon($data, array('member_id' => session('member_id')));

        if (!$update) {
            exit(json_encode(array('state' => 'false', 'msg' => lang('error_occurred_system_update_information'))));
        }

        $mailtemplates_model = model('mailtemplates');
        $tpl_info = $mailtemplates_model->getTplInfo(array('mailmt_code' => 'modify_mobile'));
        $param = array();
        $param['site_name'] = config('site_name');
        $param['send_time'] = date('Y-m-d H:i', TIMESTAMP);
        $param['verify_code'] = $verify_code;
        $message = ds_replace_text($tpl_info['mailmt_content'], $param);
        
        $result = model('smslog')->sendSms($mobile,$message);

        if (!$result['state']) {
            exit(json_encode(array('state' => 'false', 'msg' => $result['message'])));
        }

        $update = $member_model->editMember(array('member_id' => session('member_id')), array('member_mobile' => $mobile));
        if (!$update) {
            exit(json_encode(array('state' => 'false', 'msg' => lang('modified_phone_same_original_one'))));
        }else{
            exit(json_encode(array('state' => 'true', 'msg' => lang('send_success'))));
        }

    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    protected function getMemberItemList() {
        $menu_name = request()->action();
        switch ($menu_name) {
            case 'index':
                $menu_array = array(
                    array(
                        'name' => 'index', 'text' => lang('account_security'),
                        'url' => url('Membersecurity/index')
                    )
                );
                return $menu_array;
                break;
            case 'modify_pwd':
                $menu_array = array(
                    array(
                        'name' => 'index', 'text' => lang('account_security'),
                        'url' => url('Membersecurity/index')
                    ), array(
                        'name' => 'modify_pwd', 'text' => lang('change_login_password'),
                        'url' => url('Membersecurity/auth', ['type' => 'modify_pwd'])
                    ),
                );
                return $menu_array;
                break;
            case 'modify_email':
                $menu_array = array(
                    array(
                        'name' => 'index', 'text' => lang('account_security'),
                        'url' => url('Membersecurity/index')
                    ), array(
                        'name' => 'modify_email', 'text' => lang('email_address_verification'),
                        'url' => url('Membersecurity/auth', ['type' => 'modify_email'])
                    ),
                );
                return $menu_array;
                break;
            case 'modify_mobile':
                $menu_array = array(
                    array(
                        'name' => 'index', 'text' => lang('account_security'),
                        'url' => url('Membersecurity/index')
                    ), array(
                        'name' => 'modify_mobile', 'text' => lang('phone_verification'),
                        'url' => url('Membersecurity/auth', ['type' => 'modify_mobile'])
                    ),
                );
                return $menu_array;
                break;
            case 'modify_paypwd':
                $menu_array = array(
                    array(
                        'name' => 'index', 'text' => lang('account_security'),
                        'url' => url('Membersecurity/index')
                    ), array(
                        'name' => 'modify_paypwd', 'text' => lang('set_payment_password'),
                        'url' => url('Membersecurity/auth', ['type' => 'modify_paypwd'])
                    ),
                );
                return $menu_array;
                break;
            case 'auth':
                $menu_array = array(
                    array(
                        'name' => 'loglist', 'text' => lang('account_balance'),
                        'url' => url('Predeposit/pd_log_list')
                    ), array(
                        'name' => 'recharge_list', 'text' => lang('top_up_detail'),
                        'url' => url('Predeposit/index')
                    ), array(
                        'name' => 'cashlist', 'text' => lang('balance_withdrawal'),
                        'url' => url('Predeposit/pd_cash_list')
                    ), array(
                        'name' => 'pd_cash', 'text' => lang('withdrawal_application'),
                        'url' => url('Membersecurity/auth', ['type' => 'pd_cash'])
                    ),
                );
                return $menu_array;
                break;
        }
    }

}

?>
