<?php

namespace app\admin\controller;

use think\Lang;

class Navigation extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/navigation.lang.php');
    }

    public function index() {
        $navigation_model= model('navigation');
        if (!(request()->isPost())) {
            $condition=array();
            $nav_list = $navigation_model->getNavigationList($condition,10);
        } else {
            $search_nav = input('post.search_nav');
            $condition['nav_title|nav_url'] = ['like', "%$search_nav%"];
            $nav_list = $navigation_model->getNavigationList($condition,10);
        }
        $this->assign('nav_list', $nav_list);
        $this->assign('show_page', $navigation_model->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    public function add() {
        if (!(request()->isPost())) {
            $nav = [
                'nav_location' => 'header',
                'nav_new_open' => 0,
            ];
            $this->assign('nav', $nav);
            return $this->fetch('form');
        } else {
            $data['nav_title'] = input('post.nav_title');
            $data['nav_location'] = input('post.nav_location');
            $data['nav_url'] = input('post.nav_url');
            $data['nav_new_open'] = intval(input('post.nav_new_open'));
            $data['nav_sort'] = intval(input('post.nav_sort'));
            $navigation_validate = validate('navigation');
            if (!$navigation_validate->scene('add')->check($data)) {
                $this->error($navigation_validate->getError());
            }

            $navigation_model= model('navigation');
            $result=$navigation_model->addNavigation($data);
            if ($result) {
                dsLayerOpenSuccess(lang('ds_common_op_succ'));
            } else {
                $this->error(lang('error'));
            }
        }
    }

    public function edit() {
        $navigation_model= model('navigation');
        $nav_id = input('param.nav_id');
        if (empty($nav_id)) {
            $this->error(lang('param_error'));
        }
        if (!request()->isPost()) {
            $condition = array();
            $condition['nav_id'] = $nav_id;
            $nav=$navigation_model->getOneNavigation($condition);
            $this->assign('nav', $nav);
            return $this->fetch('form');
        } else {
            $data['nav_title'] = input('post.nav_title');
            $data['nav_location'] = input('post.nav_location');
            $data['nav_url'] = input('post.nav_url');
            $data['nav_new_open'] = intval(input('post.nav_new_open'));
            $data['nav_sort'] = intval(input('post.nav_sort'));
            $navigation_validate = validate('navigation');
            if (!$navigation_validate->scene('edit')->check($data)) {
                $this->error($navigation_validate->getError());
            }
            $condition = array();
            $condition['nav_id'] = $nav_id;
            $result = $navigation_model->eidtNavigation($data,$condition);
            if ($result>=0) {
                dsLayerOpenSuccess(lang('ds_common_op_succ'));
            } else {
                $this->error(lang('error'));
            }
        }
    }

    public function drop() {
        $navigation_model= model('navigation');
        $nav_id = input('param.nav_id');
        $nav_id_array = ds_delete_param($nav_id);
        if($nav_id_array === FALSE){
            ds_json_encode('10001', lang('param_error'));
        }
        $condition = array('nav_id' => array('in', $nav_id_array));
        $result =$navigation_model->delNavigation($condition);
        if ($result) {
            ds_json_encode('10000', lang('ds_common_del_succ'));
        } else {
            ds_json_encode('10001', lang('ds_common_del_fail'));
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => '管理',
                'url' => url('Navigation/index')
            ),
            array(
                'name' => 'add',
                'text' => '新增',
                'url' => "javascript:dsLayerOpen('".url('Navigation/add')."','新增导航')"
            ),
        );
        return $menu_array;
    }

}