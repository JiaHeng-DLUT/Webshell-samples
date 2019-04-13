<?php

/*
 * 手机验证码
 */

namespace app\home\controller;

use think\Lang;

class Connectsms extends BaseMall {
    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/login.lang.php');
    }
    /**
     * 短信动态码
     */
    public function get_captcha() {
        header("Content-Type: text/html;charset=utf-8");
        $sms_mobile = input('param.sms_mobile');
        if (strlen($sms_mobile) == 11) {
            $log_type = input('param.type'); //短信类型:1为注册,2为登录,3为找回密码
            
            $member_model = model('member');
            $member = $member_model->getMemberInfo(array('member_mobile' => $sms_mobile));
            $sms_captcha = rand(100000, 999999);
            $log_msg = '【' . config('site_name') . '】'.lang('ds_you_in').'' . date("Y-m-d");
            switch ($log_type) {
                case '1':
                    if (config('sms_register') != 1) {
                        echo lang('system_obile_registration_function');
                        exit;
                    }
                    if (!empty($member)) {
                        //检查手机号是否已被注册
                        echo lang('change_another_number');;
                        exit;
                    }
                    $log_msg .= lang('register_member_dynamic_code') . $sms_captcha . '。';
                    break;
                case '2':
                    if (config('sms_login') != 1) {
                        echo lang('enable_mobile_phone_login');
                        exit;
                    }
                    if (empty($member)) {
                        //检查手机号是否已绑定会员
                        echo lang('check_correct_number');
                        exit;
                    }
                    $log_msg .= lang('application_login_dynamic_code'). $sms_captcha . '。';
                    break;
                case '3':
                    if (config('sms_password') != 1) {
                        echo lang('mobile_back_password');
                        exit;
                    }
                    if (empty($member)) {
                        //检查手机号是否已绑定会员
                        echo lang('check_correct_number');
                        exit;
                    }
                    $log_msg .= lang('reset_password_dynamic_code') . $sms_captcha . '。';
                    break;
                default:
                    echo lang('wrong_argument');
                    exit;
                    break;
            }
            
            $smslog_model = model('smslog');
            $result = $smslog_model->sendSms($sms_mobile,$log_msg,$log_type,$sms_captcha,$member['member_id'],$member['member_name']);
            if($result['state']){
                session('sms_mobile', $sms_mobile);
                session('sms_captcha', $sms_captcha);
                echo 'true';
                exit;
            }else{
                echo $result['message'];
                exit;
            }
        } else {
            echo lang('phone_length_incorrect');
            exit;
        }
    }

    /**
     * 验证注册动态码
     */
    public function check_captcha() {
        $state = lang('validation_fails');
        $phone = input('get.phone');
        $captcha = input('get.sms_captcha');
        if (strlen($phone) == 11 && strlen($captcha) == 6) {
            $state = 'true';
            $condition = array();
            $condition['smslog_phone'] = $phone;
            $condition['smslog_captcha'] = $captcha;
            $condition['smslog_type'] = 1;
            $smslog_model = model('smslog');
            $sms_log = $smslog_model->getSmsInfo($condition);
            if (empty($sms_log) || ($sms_log['smslog_smstime'] < TIMESTAMP - 1800)) {//半小时内进行验证为有效
                $state = lang('dynamic_code_expired');
            }
        }
        exit($state);
    }

    /**
     * 登录
     */
    public function login() {
        if(config('captcha_status_login')==1 && !captcha_check(input('post.captcha_mobile'))){
            ds_json_encode(10001,lang('image_verification_code_error'));

        }
        
        if (request()->isPost()) {
            if (config('sms_login') != 1) {
                ds_json_encode(10001,lang('enable_mobile_phone_login'));
            }
            $phone = input('post.sms_mobile');
            $captcha = input('post.sms_captcha');
            $condition = array();
            $condition['smslog_phone'] = $phone;
            $condition['smslog_captcha'] = $captcha;
            $condition['smslog_type'] = 2;
            $smslog_model = model('smslog');
            $sms_log = $smslog_model->getSmsInfo($condition);
            if (empty($sms_log) || ($sms_log['smslog_smstime'] < TIMESTAMP - 1800)) {//半小时内进行验证为有效
                ds_json_encode(10001,lang('dynamic_code_expired'));
            }
            $member_model = model('member');
            $member = $member_model->getMemberInfo(array('member_mobile' => $phone)); //检查手机号是否已被注册
            if (!empty($member)) {
                if (!$member['member_state']) {//1为启用 0 为禁用
                    ds_json_encode(10001,lang('login_index_account_stop'));
                }
                $member_model->createSession($member); //自动登录
                $reload = input('param.ref_url');
                if (empty($reload)) {
                    $reload = url('Member/index');
                }
                ds_json_encode(10000,lang('login_index_login_success'));
            }
        }
    }

    /**
     * 找回密码
     */
    public function find_password() {

        if (config('sms_password') != 1) {
            ds_json_encode(10001,lang('mobile_back_password'));
        }
        $sms_mobile = trim(input('sms_mobile'));
        $sms_captcha = trim(input('sms_captcha'));
        $member_password = trim(input('member_password'));
        //判断验证码是否正确
        if ($sms_captcha != session('sms_captcha')) {
            ds_json_encode(10001,lang('login_index_wrong_checkcode'));
        }
        if ($sms_mobile != session('sms_mobile')) {
            ds_json_encode(10001,lang('receive_number_inconsistent'));
        }
        
        $condition = array();
        $condition['smslog_phone'] = $sms_mobile;
        $condition['smslog_captcha'] = $sms_captcha;
        $condition['smslog_type'] = 3;
        $smslog_model = model('smslog');
        $sms_log = $smslog_model->getSmsInfo($condition);
        if (empty($sms_log) || ($sms_log['smslog_smstime'] < TIMESTAMP - 1800)) {//半小时内进行验证为有效
            ds_json_encode(10001,lang('dynamic_code_expired'));
        }

        $member_model = model('member');
        $member = $member_model->getMemberInfo(array('member_mobile' => $sms_mobile)); //检查手机号是否已被注册
        if (!empty($member)) {
            if (!$member['member_state']) {//1为启用 0 为禁用
                ds_json_encode(10001, lang('login_index_account_stop'));
            }
            $member_model->editMember(array('member_id' => $member['member_id']), array('member_password' => md5($member_password)));
            $member_model->createSession($member); //自动登录
            ds_json_encode(10000,lang('password_changed_successfully'));
        }
    }

}
