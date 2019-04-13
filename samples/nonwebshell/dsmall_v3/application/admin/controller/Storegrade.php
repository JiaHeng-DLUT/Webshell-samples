<?php

namespace app\admin\controller;

use think\Lang;

class Storegrade extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/storegrade.lang.php');
    }

    public function index() {
        $like_storegrade_name = trim(input('param.like_storegrade_name'));
        $condition['storegrade_name'] = array('like', "%" . $like_storegrade_name . "%");
        $storegrade_list = model('storegrade')->getStoregradeList($condition);
        // 获取分页显示
        $this->assign('storegrade_list', $storegrade_list);
        $this->assign('like_storegrade_name', $like_storegrade_name);
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    public function add() {
        if (!request()->isPost()) {
            $storegrade = array(
                'storegrade_name' => '',
                'storegrade_goods_limit' => 0,
                'storegrade_album_limit' => 0,
                'storegrade_space_limit' => 0,
                'storegrade_price' => '',
                'storegrade_description' => '',
                'storegrade_sort' => 100,
            );
            $this->assign('storegrade', $storegrade);
            return $this->fetch('form');
        } else {
            $data = array(
                'storegrade_name' => input('post.storegrade_name'),
                'storegrade_goods_limit' => input('post.storegrade_goods_limit'),
                'storegrade_album_limit' => input('post.storegrade_album_limit'),
                'storegrade_space_limit' => input('post.storegrade_space_limit'),
                //默认附加超文本编辑
                'storegrade_function' => implode('|', array('editor_multimedia')),
                'storegrade_price' => intval(input('post.storegrade_price')),
                'storegrade_description' => input('post.storegrade_description'),
                'storegrade_sort' => input('post.storegrade_sort'),
            );

            $storegrade_validate = validate('storegrade');
            if (!$storegrade_validate->scene('add')->check($data)){
                $this->error($storegrade_validate->getError());
            }

            //验证等级名称
            if (!$this->checkGradeName(array('storegrade_name' => trim(input('post.storegrade_name'))))) {
                $this->error(lang('now_store_grade_name_is_there'));
            }
            //验证级别是否存在
            if (!$this->checkGradeSort(array('storegrade_sort' => trim(input('post.storegrade_sort'))))) {
                $this->error(lang('add_gradesortexist'));
            }
            $result = model('storegrade')->addStoregrade($data);
            if ($result) {
                dsLayerOpenSuccess(lang('ds_common_op_succ'),url('Storegrade/index'));
            } else {
                $this->error(lang('ds_common_op_fail'));
            }
        }
    }

    public function edit() {
        //注：pathinfo地址参数不能通过get方法获取，查看“获取PARAM变量”
        $storegrade_id = input('param.storegrade_id');
        if (empty($storegrade_id)) {
            $this->error(lang('param_error'));
        }
        if (!request()->isPost()) {
            $storegrade = model('storegrade')->getOneStoregrade($storegrade_id);
            $this->assign('storegrade', $storegrade);
            return $this->fetch('form');
        } else {

            $data = array(
                'storegrade_name' => input('post.storegrade_name'),
                'storegrade_goods_limit' => input('post.storegrade_goods_limit'),
                'storegrade_album_limit' => input('post.storegrade_album_limit'),
                'storegrade_space_limit' => input('post.storegrade_space_limit'),
                //默认附加超文本编辑
                'storegrade_function' => implode('|', array('editor_multimedia')),
                'storegrade_price' => intval(input('post.storegrade_price')),
                'storegrade_description' => input('post.storegrade_description'),
                'storegrade_sort' => input('post.storegrade_sort'),
            );
            $storegrade_validate = validate('storegrade');
            if (!$storegrade_validate->scene('edit')->check($data)){
                $this->error($storegrade_validate->getError());
            }
            //验证等级名称
            if (!$this->checkGradeName(array('storegrade_name' => trim(input('post.storegrade_name')), 'storegrade_id' => intval(input('param.storegrade_id'))))) {
                $this->error(lang('now_store_grade_name_is_there'));
            }
            //验证级别是否存在
            if (!$this->checkGradeSort(array('storegrade_sort' => trim(input('post.storegrade_sort')), 'storegrade_id' => intval(input('param.storegrade_id'))))) {
                $this->error(lang('add_gradesortexist'));
            }
            $result = model('storegrade')->editStoregrade($storegrade_id,$data);
            if ($result>=0) {
                dsLayerOpenSuccess(lang('ds_common_op_succ'),url('Storegrade/index'));
            } else {
                $this->error(lang('ds_common_op_fail'));
            }
        }
    }

    public function drop() {
        //注：pathinfo地址参数不能通过get方法获取，查看“获取PARAM变量”
        $storegrade_id = intval(input('param.storegrade_id'));
        if ($storegrade_id<=0) {
            ds_json_encode(10001, lang('param_error'));
        }
        if ($storegrade_id == '1') {
            ds_json_encode(10001, lang('default_store_grade_no_del'));
        }
        //判断该等级下是否存在店铺，存在的话不能删除
        if (!$this->isable_delStoregrade($storegrade_id)) {
            $this->error(lang('del_gradehavestore'), url('Storegrade/index'));
        }
        $result = model('storegrade')->delStoregrade($storegrade_id);
        if ($result) {
            ds_json_encode(10000, lang('ds_common_del_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_del_fail'));
        }
    }

    /**
     * 查询店铺等级名称是否存在
     */
    private function checkGradeName($param) {
        $storegrade_model = model('storegrade');
        $condition['storegrade_name'] = $param['storegrade_name'];

        if (isset($param['storegrade_id'])) {
            $storegrade_id = intval($param['storegrade_id']);
            $condition['storegrade_id'] = array('neq', $storegrade_id);
        }
        $list = $storegrade_model->getStoregradeList($condition);
        if (empty($list)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 查询店铺等级是否存在
     */
    private function checkGradeSort($param) {
        $storegrade_model = model('storegrade');
        $condition = array();
        $condition['storegrade_sort'] = $param['storegrade_sort'];
        if (isset($param['storegrade_id'])) {
            $storegrade_id = intval($param['storegrade_id']);
            $condition['storegrade_id'] = array('neq', $storegrade_id);
        }
        $list = array();
        $list = $storegrade_model->getStoregradeList($condition);
        if (is_array($list) && count($list) > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 判断店铺等级是否能删除
     */
    public function isable_delStoregrade($storegrade_id) {
        //判断该等级下是否存在店铺，存在的话不能删除
        $store_model = model('store');
        $store_list = $store_model->getStoreList(array('grade_id' => $storegrade_id));
        if (count($store_list) > 0) {
            return false;
        }
        return true;
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => '管理',
                'url' => url('Storegrade/index')
            ),
        );

        if (request()->action() == 'add' || request()->action() == 'index') {
            $menu_array[] = array(
                'name' => 'add',
                'text' => '新增',
                'url' => "javascript:dsLayerOpen('".url('Storegrade/add')."','新增用户')"
            );
        }
        return $menu_array;
    }

}

?>
