<?php
namespace app\home\controller;

use think\Lang;

class Selleraccount extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/selleraccount.lang.php');
    }
    

    public function account_list() {
        $seller_model = model('seller');
        $condition = array(
            'seller.store_id' => session('store_id'),
            'seller.sellergroup_id' => array('gt', 0)
        );
        
        $seller_list = $seller_model->getSellerList($condition);
        $this->assign('seller_list', $seller_list);

        $sellergroup_model = model('sellergroup');
        $seller_group_list = $sellergroup_model->getSellergroupList(array('store_id' => session('store_id')));
        $seller_group_array = array_under_reset($seller_group_list, 'sellergroup_id');
        $this->assign('seller_group_array', $seller_group_array);

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('selleraccount');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('account_list');
        return $this->fetch($this->template_dir.'account_list');
    }

    public function account_add() {
        if (!request()->isPost()) {
            $sellergroup_model = model('sellergroup');
            $seller_group_list = $sellergroup_model->getSellergroupList(array('store_id' => session('store_id')));
            if (empty($seller_group_list)) {
                $this->error(lang('please_set_account_group_first'), url('Selleraccountgroup/group_add'));
            }
            $this->assign('seller_group_list', $seller_group_list);
            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('selleraccount');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('account_add');
            return $this->fetch($this->template_dir . 'account_add');
        } else {
            $member_name = input('post.member_name');
            $password = input('post.password');
            $member_info = $this->_check_seller_member($member_name, $password);
            if (!$member_info) {
                ds_json_encode(10001,lang('user_authentication_failed'));
            }

            $seller_name = input('post.seller_name');
            if ($this->_is_seller_name_exist($seller_name)) {
                ds_json_encode(10001,lang('seller_account_already_exists'));
            }

            $group_id = intval(input('post.group_id'));

            $seller_info = array(
                'seller_name' => $seller_name,
                'member_id' => $member_info['member_id'],
                'sellergroup_id' => $group_id,
                'store_id' => session('store_id'),
                'is_admin' => 0
            );
            $seller_model = model('seller');
            $result = $seller_model->addSeller($seller_info);

            if ($result) {
                $this->recordSellerlog(lang('add_account_successfully') . $result);
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } else {
                $this->recordSellerlog(lang('failed_add_account'));
                ds_json_encode(10001,lang('ds_common_save_fail'));
            }
        }
    }

    public function account_edit() {
        if (!request()->isPost()) {
            $seller_id = intval(input('param.seller_id'));
            if ($seller_id <= 0) {
                $this->error(lang('param_error'));
            }
            $seller_model = model('seller');
            $seller_info = $seller_model->getSellerInfo(array('seller_id' => $seller_id));
            if (empty($seller_info) || intval($seller_info['store_id']) !== intval(session('store_id'))) {
                $this->error(lang('account_not_exist'));
            }
            $this->assign('seller_info', $seller_info);

            $sellergroup_model = model('sellergroup');
            $seller_group_list = $sellergroup_model->getSellergroupList(array('store_id' => session('store_id')));
            if (empty($seller_group_list)) {
                $this->error(lang('please_set_account_group_first'), url('Selleraccountgroup/group_add'));
            }
            $this->assign('seller_group_list', $seller_group_list);

            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('selleraccount');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('account_edit');
            return $this->fetch($this->template_dir . 'account_edit');
        } else {
            $param = array('sellergroup_id' => intval(input('post.group_id')));
            $condition = array(
                'seller_id' => intval(input('post.seller_id')),
                'store_id' => session('store_id')
            );
            $seller_model = model('seller');
            $result = $seller_model->editSeller($param, $condition);
            if ($result) {
                $this->recordSellerlog(lang('edit_account_successfully') . input('post.seller_id'));
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } else {
                $this->recordSellerlog(lang('edit_account_failed') . input('post.seller_id'), 0);
                ds_json_encode(10001,lang('ds_common_save_fail'));
            }
        }
    }


    public function account_del() {
        $seller_id = intval(input('post.seller_id'));
        if($seller_id > 0) {
            $condition = array();
            $condition['seller_id'] = $seller_id;
            $condition['store_id'] = session('store_id');
            $seller_model = model('seller');
            $result = $seller_model->delSeller($condition);
            if($result) {
                $this->recordSellerlog(lang('delete_account_successfully').$seller_id);
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } else {
                $this->recordSellerlog(lang('deletion_account_failed').$seller_id);
                ds_json_encode(10001,lang('ds_common_save_fail'));
            }
        } else {
            ds_json_encode(10001,lang('wrong_argument'));
        }
    }

    public function check_seller_name_exist() {
        $seller_name = input('get.seller_name');
        $result = $this->_is_seller_name_exist($seller_name);
        if($result) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    private function _is_seller_name_exist($seller_name) {
        $condition = array();
        $condition['seller_name'] = $seller_name;
        $seller_model = model('seller');
        return $seller_model->isSellerExist($condition);
    }

    public function check_seller_member() {
        $member_name = input('get.member_name');
        $password = input('get.password');
        $result = $this->_check_seller_member($member_name, $password);
        if($result) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    private function _check_seller_member($member_name, $password) {
        $member_info = $this->_check_member_password($member_name, $password);
        if($member_info && !$this->_is_seller_member_exist($member_info['member_id'])) {
            return $member_info;
        } else {
            return false;
        }
    }

    private function _check_member_password($member_name, $password) {
        $condition = array();
        $condition['member_name']	= $member_name;
        $condition['member_password']	= md5($password);
        $member_model = model('member');
        $member_info = $member_model->getMemberInfo($condition);
        return $member_info;
    }

    private function _is_seller_member_exist($member_id) {
        $condition = array();
        $condition['member_id'] = $member_id;
        $seller_model = model('seller');
        return $seller_model->isSellerExist($condition);
    }

    
    /**
     *    栏目菜单
     */
    function getSellerItemList() {
        $menu_array[] = array(
            'name' => 'account_list',
            'text' => lang('account_list'),
            'url' => url('Selleraccount/account_list'),
        );

        if (request()->action() === 'account_add') {
            $menu_array[] = array(
                'name' => 'account_add',
                'text' => lang('add_account'),
                'url' => url('Selleraccount/account_add'),
            );
        }
        if (request()->action() === 'group_edit') {
            $menu_array[] = array(
                'name' => 'account_edit',
                'text' => lang('edit_account'),
                'url' => url('Selleraccount/account_edit'),
            );
        }
        
        return $menu_array;
    }
    
    
}
