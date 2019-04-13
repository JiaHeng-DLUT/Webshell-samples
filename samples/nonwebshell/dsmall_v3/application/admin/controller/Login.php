<?php

namespace app\admin\controller;

use think\Controller;
use think\Lang;

class Login extends Controller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/login.lang.php');
    }

    public function index() {
        if (session('admin_id')) {
            $this->success('已经登录', 'Index/index');
        }
        if (request()->isPost()) {
            $admin_name = input('post.admin_name');
            $admin_password = input('post.admin_password');
            $captcha = input('post.captcha');

            $data = array(
                'admin_name' => $admin_name,
                'admin_password' => $admin_password,
                'captcha' => $captcha,
            );

            $login_validate = validate('admin');
            if (!$login_validate->scene('index')->check($data)) {
                ds_json_encode(10001,$login_validate->getError());
            }

            if (!captcha_check(input('post.captcha'))) {
                //验证失败
                ds_json_encode(10001,'验证码错误');
            }

            $condition['admin_name'] = $admin_name;
            $condition['admin_password'] = md5($admin_password);
            $admin_mod=model('admin');
            $admin_info = $admin_mod->getOneAdmin($condition);

            if (is_array($admin_info) and !empty($admin_info)) {
                //更新 admin 最新信息
                $update_info = array(
                    'admin_login_num' => ($admin_info['admin_login_num'] + 1),
                    'admin_login_time' => TIMESTAMP
                );
                $admin_mod->editAdmin($update_info, $admin_info['admin_id']);

                //设置 session
                session('admin_id', $admin_info['admin_id']);
                session('admin_name', $admin_info['admin_name']);
                session('admin_gid', $admin_info['admin_gid']);
                session('admin_is_super', $admin_info['admin_is_super']);
                ds_json_encode(10000,'登录成功');
            } else {
                ds_json_encode(10001,'帐号密码错误');
            }
        } else {
            return $this->fetch();
        }
    }

    public function logout() {
        //设置 session
        session(null);
        ds_json_encode(10000,'退出成功');
    }

}

?>
