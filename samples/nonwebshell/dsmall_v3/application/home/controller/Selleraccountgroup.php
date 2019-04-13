<?php

namespace app\home\controller;

use think\Lang;

class Selleraccountgroup extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/selleraccount.lang.php');
    }

    public function group_list() {
        $sellergroup_model = model('sellergroup');
        $seller_group_list = $sellergroup_model->getSellergroupList(array('store_id' => session('store_id')));
        $this->assign('seller_group_list', $seller_group_list);
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('selleraccountgroup');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('group_list');
        return $this->fetch($this->template_dir.'group_list');
    }

    public function group_add() {
        $seller_group_info = array(
            'sellergroup_id' => 0,
            'sellergroup_name' => '',
            'sellergroup_limits' => '',
            'smt_limits' => ''
        );
        $this->assign('group_info', $seller_group_info);
        $this->assign('group_limits', explode(',', $seller_group_info['sellergroup_limits']));
        $this->assign('smt_limits', explode(',', $seller_group_info['smt_limits']));

        // 店铺消息模板列表
        $smt_list = model('storemsgtpl')->getStoremsgtplList(array(), 'storemt_code,storemt_name');
        $this->assign('smt_list', $smt_list);

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('selleraccountgroup');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('group_add');
        return $this->fetch($this->template_dir.'group_add');
    }

    public function group_edit() {
        $group_id = intval(input('param.group_id'));
        if ($group_id <= 0) {
            $this->error(lang('param_error'));
        }
        $sellergroup_model = model('sellergroup');
        $seller_group_info = $sellergroup_model->getSellergroupInfo(array('sellergroup_id' => $group_id, 'store_id' => session('store_id')));
        if (empty($seller_group_info)) {
            $this->error(lang('there_no_group'));
        }
        $this->assign('group_info', $seller_group_info);
        $this->assign('group_limits', explode(',', $seller_group_info['sellergroup_limits']));
        $this->assign('smt_limits', explode(',', $seller_group_info['smt_limits']));

        // 店铺消息模板列表
        $smt_list = model('storemsgtpl')->getStoremsgtplList(array(), 'storemt_code,storemt_name');
        $this->assign('smt_list', $smt_list);


        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('selleraccountgroup');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('group_edit');
        return $this->fetch($this->template_dir.'group_add');
    }

    public function group_save() {
        $seller_info = array();
        $group_id = intval(input('param.group_id'));

        $seller_info['sellergroup_name'] = input('post.seller_group_name');
        $seller_info['sellergroup_limits'] = implode(',', input('post.limits/a'));
        $seller_info['smt_limits'] = empty(input('post.smt_limits/a')) ? '' : implode(',', input('post.smt_limits/a'));
        $seller_info['store_id'] = session('store_id');
        
        
        $sellergroup_model = model('sellergroup');

        if (empty($group_id)) {
            $result = $sellergroup_model->addSellergroup($seller_info);
            $this->recordSellerlog(lang('add_group_successfully') . $result);
            if($result){
                ds_json_encode(10001,lang('add_success'));
            }else{
                ds_json_encode(10001,lang('add_failure'));
            }
            
        } else {
            $condition = array();
            $condition['sellergroup_id'] = $group_id;
            $condition['store_id'] = session('store_id');
            $result = $sellergroup_model->editSellergroup($seller_info, $condition);
            $this->recordSellerlog(lang('editorial_team_succeeds') . $group_id);
            if($result){
                ds_json_encode(10000,lang('edit_success'));
            }else{
                ds_json_encode(10001,lang('edit_failure'));
            }
            
        }
    }

    public function group_del() {
        $group_id = intval(input('param.group_id'));
        if ($group_id > 0) {
            //判断当前用户组下是否有用户
            $condition = array(
                'seller.store_id' => session('store_id'),
                'seller.sellergroup_id' => $group_id
            );
            $seller_list = model('seller')->getSellerList($condition);
            if(!empty($seller_list)){
                ds_json_encode(10001,'此帐号组下有设置的会员,请先设置会员为其他账户组再删除');
            }

            $condition = array();
            $condition['sellergroup_id'] = $group_id;
            $condition['store_id'] = session('store_id');
            $sellergroup_model = model('sellergroup');
            $result = $sellergroup_model->delSellergroup($condition);
            if ($result) {
                $this->recordSellerlog(lang('group_deleted_successfully') . $group_id);
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } else {
                $this->recordSellerlog(lang('deletion_group_failed') . $group_id);
                ds_json_encode(10001,lang('ds_common_save_fail'));
            }
        } else {
            ds_json_encode(10001,lang('wrong_argument'));
        }
    }

    /**
     *    栏目菜单
     */
    function getSellerItemList() {
        $menu_array[] = array(
            'name' => 'group_list',
            'text' => lang('group_list'),
            'url' => url('Selleraccountgroup/group_list'),
        );

        if (request()->action() === 'group_add') {
            $menu_array[] = array(
                'name' => 'group_add',
                'text' => lang('add_group'),
                'url' => url('Selleraccountgroup/group_add'),
            );
        }
        if (request()->action() === 'group_edit') {
            $menu_array[] = array(
                'name' => 'group_edit',
                'text' => lang('editorial_team'),
                'url' => url('Selleraccountgroup/group_edit'),
            );
        }
        
        return $menu_array;
    }


}
