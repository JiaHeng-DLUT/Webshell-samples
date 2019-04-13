<?php

/*
 * 规格管理
 */

namespace app\admin\controller;

use think\Lang;

class Spec extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/spec.lang.php');
    }

    public function index() {
        $spec_model = model('spec');
        $spec_list	= $spec_model->getSpecList(array(), 10);
        $this->assign('spec_list', $spec_list);
        $this->assign('show_page', $spec_model->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    public function spec_add() {
        if (!(request()->isPost())) {
            $spec = [
                'gc_id' => 0,
            ];
            $this->assign('spec', $spec);
            $gc_list = model('goodsclass')->getGoodsclassListByParentId(0);
            $this->assign('gc_list', $gc_list);
            return $this->fetch('spec_form');
        } else {
            $data = array(
                'sp_name' => input('post.sp_name'),
                'sp_sort' => input('post.sp_sort'),
                'gc_id' => input('post.gc_id'),
                'gc_name' => input('post.gc_name'),
            );
            $spec_validate = validate('spec');
            if (!$spec_validate->scene('spec_add')->check($data)) {
                $this->error($spec_validate->getError());
            }

            $spec_model= model('spec');
            $result=$spec_model->addSpec($data);
            if ($result) {
                dsLayerOpenSuccess(lang('ds_common_op_succ'));
            } else {
                $this->error(lang('error'));
            }
        }
    }

    public function spec_edit() {
        //注：pathinfo地址参数不能通过get方法获取，查看“获取PARAM变量”
        $sp_id = input('param.sp_id');
        if (empty($sp_id)) {
            $this->error(lang('param_error'));
        }
        if (!request()->isPost()) {
            $spec_model= model('spec');
            $spec=$spec_model->getSpecInfo($sp_id);
            $this->assign('spec', $spec);
            $gc_list = model('goodsclass')->getGoodsclassListByParentId(0);
            $this->assign('gc_list', $gc_list);
            return $this->fetch('spec_form');
        } else {
            $data = array(
                'sp_name' => input('post.sp_name'),
                'sp_sort' => input('post.sp_sort'),
                'gc_id' => input('post.gc_id'),
                'gc_name' => input('post.gc_name'),
            );
            $spec_validate = validate('spec');
            if (!$spec_validate->scene('spec_edit')->check($data)) {
                $this->error($spec_validate->getError());
            }

            $spec_model= model('spec');
            $condition=array();
            $condition['sp_id']=$sp_id;
            $result=$spec_model->editSpec($data, $condition);
            if ($result>=0) {
                dsLayerOpenSuccess(lang('ds_common_op_succ'));
            } else {
                $this->error(lang('ds_common_op_fail'));
            }
        }
    }

    public function spec_drop() {
        //注：pathinfo地址参数不能通过get方法获取，查看“获取PARAM变量”
        $sp_id = intval(input('param.sp_id'));
        // sp_id 值为1 不能删除，用于处理前台显示图片的规格
        if ($sp_id<=1) {
            $this->error(lang('param_error'));
        }
        $spec_model = model('spec');
        $result=$spec_model->delSpec(array('sp_id' => $sp_id));
        if ($result) {
            ds_json_encode(10000, lang('ds_common_del_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_del_fail'));
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
                'url' => url('Spec/index')
            ),
            array(
                'name' => 'spec_add',
                'text' => '新增规格',
                'url' => "javascript:dsLayerOpen('".url('Spec/spec_add')."','新增规格')"
            ),
        );
        return $menu_array;
    }
}

?>
