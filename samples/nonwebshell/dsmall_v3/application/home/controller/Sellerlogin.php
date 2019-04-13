<?php

namespace app\home\controller;

use think\Lang;

class Sellerlogin extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerlogin.lang.php');
    }
    
    
    function login() {
        if (!request()->isPost()) {
            return $this->fetch($this->template_dir.'login');
        } else {

            $seller_model = model('seller');
            $seller_info = $seller_model->getSellerInfo(array('seller_name' => input('post.seller_name')));
            if ($seller_info) {
                $member_model = model('member');
                $member_info = $member_model->getMemberInfo(
                        array(
                            'member_id' => $seller_info['member_id'],
                            'member_password' => md5(input('post.member_password'))
                        )
                );
                if ($member_info) {
                    // 更新卖家登陆时间
                    $seller_model->editSeller(array('last_logintime' => TIMESTAMP), array('seller_id' => $seller_info['seller_id']));

                    $sellergroup_model = model('sellergroup');
                    $seller_group_info = $sellergroup_model->getSellergroupInfo(array('sellergroup_id' => $seller_info['sellergroup_id']));

                    $store_model = model('store');
                    $store_info = $store_model->getStoreInfoByID($seller_info['store_id']);

                    $seller_model->createSellerSession($member_info,$store_info,$seller_info, is_array($seller_group_info)?$seller_group_info:array());

                    $this->recordSellerlog('登录成功');
                    $this->redirect('Home/Seller/index');
                } else {
                    $this->error('用户名密码错误','Sellerlogin/login');
                }
            } else {
                $this->error('没有管理店铺权限');
            }
        }
    }

    function logout() {
        $this->recordSellerlog('注销成功');
        session(null);
        $this->redirect('Home/Sellerlogin/login');
    }

}

?>
