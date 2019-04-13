<?php

namespace app\admin\controller;

use think\Lang;

class Express extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/express.lang.php');
    }

    public function index() {
        $express_letter = input('get.express_letter');
        $condition = array();
        if (preg_match('/^[A-Z]$/', $express_letter)) {
            $condition['express_letter'] = $express_letter;
        }
        
        $express_name = input('get.express_name');
        if(!empty($express_name)){
            $condition['express_name'] = array('like', "%" . $express_name . "%");
        }
        
        $express_model = model('express');
        $express_list = $express_model->getAllExpresslist($condition, 10);
        $this->assign('show_page', $express_model->page_info->render());
        $this->assign('express_list', $express_list);
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 添加品牌
     */
    public function add() {
        $express_mod = model('express');
        if (request()->isPost()) {
            $insert_array['express_name'] = trim(input('post.express_name'));
            $insert_array['express_code'] = input('post.express_code');
            $insert_array['express_state'] = intval(input('post.express_state'));
            $insert_array['express_letter'] = strtoupper(input('post.express_letter'));
            $insert_array['express_order'] = intval(input('post.express_order'));
            $insert_array['express_url'] = input('post.express_url');
            $insert_array['express_zt_state'] = intval(input('post.express_zt_state'));

            $result = $express_mod->addExpress($insert_array);
            if ($result) {
                $this->log(lang('ds_add') . lang('express') . '[' . input('post.express_name') . ']', 1);
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        } else {
            $express = [
                'express_zt_state' => 1,
                'express_order' => 1,
                'express_state' => 1,
            ];
            $this->assign('express', $express);
            return $this->fetch('form');
        }
    }

    public function edit() {
        $express_model = model('express');
        $express_id = input('param.express_id');
        if (request()->isPost()) {
            $condition = array();
            $condition['express_id'] = $express_id;

            $data['express_name'] = trim(input('post.express_name'));
            $data['express_code'] = input('post.express_code');
            $data['express_state'] = intval(input('post.express_state'));
            $data['express_letter'] = strtoupper(input('post.express_letter'));
            $data['express_order'] = intval(input('post.express_order'));
            $data['express_url'] = input('post.express_url');
            $data['express_zt_state'] = intval(input('post.express_zt_state'));
            $result = $express_model->editExpress($condition, $data);

            if ($result) {
                $this->log(lang('ds_edit') . lang('express_name') . lang('ds_state') . '[ID:' . $express_id . ']', 1);
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->log(lang('ds_edit') . lang('express_name') . lang('ds_state') . '[ID:' . $express_id . ']', 0);
                $this->error(lang('ds_common_save_fail'));
            }
        } else {
            $condition['express_id'] = $express_id;
            $express = $express_model->getOneExpress($condition);
            if (empty($express)) {
                $this->error(lang('param_error'));
            }
            $this->assign('express', $express);
            return $this->fetch('form');
        }
    }

    /**
     * 删除品牌
     */
    public function del() {
        $express_id = input('param.express_id');
        $express_id_array = ds_delete_param($express_id);
        if ($express_id_array == FALSE) {
            $this->log(lang('ds_del') . lang('express') . '[ID:' . $express_id . ']', 0);
            ds_json_encode(10001, lang('param_error'));
        }
        $express_mod = model('express');
        $express_mod->delExpress(array('express_id' => array('in', implode(',', $express_id_array))));
        $this->log(lang('ds_del') . lang('express') . '[ID:' . $express_id . ']', 1);
        ds_json_encode(10000, lang('ds_common_del_succ'));
    }

    /**
     * ajax操作
     */
    public function ajax() {
        $branch = input('get.branch');
        $column = input('get.column');
        $value = trim(input('get.value'));
        $id = intval(input('get.id'));
        switch ($branch) {
            case 'state':
                $express_model = model('express');
                $update_array = array();
                $condition['express_id'] = $id;
                $update_array[$column] = $value;
                $express_model->editExpress($condition, $update_array);
                $this->log(lang('ds_edit') . lang('express_name') . lang('ds_state') . '[ID:' . $id . ']', 1);
                echo 'true';
                exit;
                break;
            case 'order':
                $express_model = model('express');
                $update_array = array();
                $condition['express_id'] = $id;
                $update_array[$column] = $value;
                $express_model->editExpress($condition, $update_array);
                $this->log(lang('ds_edit') . lang('express_name') . lang('ds_state') . '[ID:' . $id . ']', 1);
                echo 'true';
                exit;
                break;
            case 'express_zt_state':
                $express_model = model('express');
                $update_array = array();
                $condition['express_id'] = $id;
                $update_array[$column] = $value;
                $express_model->editExpress($condition, $update_array);
                $this->log(lang('ds_edit') . lang('express_name') . lang('ds_state') . '[ID:' . $id . ']', 1);
                echo 'true';
                exit;
                break;
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('ds_manage'),
                'url' => url('Express/index'),
            ),
            array(
                'name' => 'express_add',
                'text' => lang('ds_add'),
                'url' => "javascript:dsLayerOpen('" . url('Express/add') . "','添加')"
            ),
        );
        return $menu_array;
    }

}

?>
