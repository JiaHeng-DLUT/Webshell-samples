<?php

/**
 * 地区设置
 */

namespace app\admin\controller;

use think\Lang;

class Region extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/region.lang.php');
        $this->_area_model = model('Area');
        define('MAX_LAYER', 4);
    }

    public function index() {
        $region_list = $this->_area_model->getAreaChild(0);
        /* 先根排序 */
        foreach ($region_list as $key => $val) {
            $region_list[$key]['switchs'] = 0;
            if ($this->_area_model->getAreaChild($val['area_id'])) {
                $region_list[$key]['switchs'] = 1;
            }
        }
        $this->assign('region_list', $region_list);
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    function ajax_cate() {
        $cate_id = input('param.id');
        if (empty($cate_id)) {
            return;
        }

        $cate = $this->_area_model->getAreaChild($cate_id);
        foreach ($cate as $key => $val) {
            $child = $this->_area_model->getAreaChild($val['area_id']);
            if ($val['area_deep'] >= MAX_LAYER) {
                $cate[$key]['add_child'] = 0;
            } else {
                $cate[$key]['add_child'] = 1;
            }
            if (!$child || empty($child)) {
                $cate[$key]['switchs'] = 0;
            } else {
                $cate[$key]['switchs'] = 1;
            }
        }
        echo json_encode(array_values($cate));
        return;
    }

    /**
     * ajax操作
     */
    public function ajax() {
        switch (input('param.branch')) {
            /**
             * 更新地区
             */
            case 'area_name':
                $area_model = model('area');
                $where = array('area_id' => intval(input('get.id')));
                $update_array = array();
                $update_array['area_name'] = trim(input('get.value'));
                $area_model->editArea($update_array, $where);
                echo 'true';
                exit;

                break;
            /**
             * 地区 排序 显示 设置
             */
            case 'area_sort':
                $area_model = model('area');
                $where = array('area_id' => intval(input('get.id')));
                $update_array = array();
                $update_array['area_sort'] = trim(input('get.value'));
                $area_model->editArea($update_array, $where);

                \areacache::deleteCacheFile();
                \areacache::updateAreaPhp();
                \areacache::updateAreaArrayJs();
                echo 'true';
                exit;

            case 'area_region':
                $area_model = model('area');
                $where = array('area_id' => intval(input('get.id')));
                $update_array = array();
                $update_array['area_region'] = trim(input('get.value'));
                $area_model->editArea($update_array, $where);
                
                \areacache::deleteCacheFile();
                \areacache::updateAreaArrayJs();
                \areacache::updateAreaPhp();
                echo 'true';
                exit;

            case 'area_index_show':
                $area_model = model('area');
                $where = array('area_id' => intval(input('get.id')));
                $update_array = array();
                $update_array[input('get.column')] = input('get.value');
                $area_model->editArea($update_array, $where);

                \areacache::deleteCacheFile();
                \areacache::updateAreaArrayJs();
                \areacache::updateAreaPhp();
                echo 'true';
                exit;
                break;
            /**
             * 添加、修改操作中 检测类别名称是否有重复
             */
            case 'check_class_name':
                $area_model = model('area');
                $condition['area_name'] = trim(input('param.area_name'));
                $condition['area_parent_id'] = intval(input('param.area_parent_id'));
                $condition['area_id'] = array('neq', intval(input('param.area_id')));
                $class_list = $area_model->getAreaList($condition);
                if (empty($class_list)) {
                    echo 'true';
                    exit;
                } else {
                    echo 'false';
                    exit;
                }
                break;
        }
    }

    public function add() {
        if (!request()->isPost()) {
            $area = array(
                'area_parent_id' => input('param.area_id'),
            );
            $this->assign('area', $area);
            $this->assign('parents', $this->_get_options());
            return $this->fetch('form');
        } else {
            $area_mod=model('area');
            $area_parent_id = intval(input('param.area_parentid'));
            
            $area = $area_mod->getAreaInfo(array('area_id'=>$area_parent_id));
            $area_deep=intval($area['area_deep'])+1;
            if($area_deep>MAX_LAYER){
                $this->error(sprintf(lang('area_deep_error'), MAX_LAYER));
            }
            $data = array(
                'area_name' => input('post.area_name'),
                'area_region' => input('post.area_region'),
                'area_parent_id' => $area_parent_id,
                'area_deep'=> $area_deep,
                'area_sort' => input('post.area_sort'),
            );
            $region_validate = validate('region');
            if (!$region_validate->scene('add')->check($data)) {
                $this->error($region_validate->getError());
            }

            $result = $area_mod->addArea($data);
            if ($result) {
                \areacache::deleteCacheFile();
                \areacache::updateAreaArrayJs();
                \areacache::updateAreaPhp();
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    public function edit() {
        $area_id = intval(input('param.area_id'));
        if ($area_id<=0) {
            $this->error(lang('param_error'));
        }
        $area_mod=model('area');
        $area = $area_mod->getAreaInfo(array('area_id'=>$area_id));
        if(!$area){
            $this->error(lang('area_empty'));
        }
        if (!request()->isPost()) {
            
            $this->assign('area', $area);
            $this->assign('parents', $this->_get_options());
            return $this->fetch('form');
        } else {
            $area_parent_id = intval(input('param.area_parentid'));
            $data = array(
                'area_name' => input('post.area_name'),
                'area_region' => input('post.area_region'),
                'area_parent_id' => $area_parent_id,
                'area_sort' => input('post.area_sort'),
            );
            $region_validate = validate('region');
            if (!$region_validate->scene('edit')->check($data)) {
                $this->error($region_validate->getError());
            }

            if($data['area_parent_id']==$area_id){
                $this->error(lang('area_parent_error'));
            }
            try {
                $area_mod->startTrans();
            if($data['area_parent_id']!=$area['area_parent_id']){
                //如果不同级
                $now_deep=intval(db('area')->where('area_id='.$data['area_parent_id'])->value('area_deep'))+1;
                $old_deep=intval(db('area')->where('area_id='.$area['area_parent_id'])->value('area_deep'))+1;
                if($now_deep!=$old_deep){
                    if($now_deep>MAX_LAYER){
                        $this->error(sprintf(lang('area_deep_error'), MAX_LAYER));
                    }
                    $data['area_deep']=$now_deep;
                    $j=$old_deep;
                    $subQuery='('.$area_id.')';
                    while($j<=MAX_LAYER){
                        //如果自己的上级是自己的下级则报错
                        if(db('area')->where('area_id='.$data['area_parent_id'].' AND area_parent_id IN '.$subQuery)->value('area_id')){
                            $area_mod->rollback();
                            $this->error(lang('area_parent_error'));
                        }
                        $subQuery=db('area')->field('area_id')->where('area_parent_id IN '.$subQuery)->buildSql();
                        $j++;
                    }
                    //给他的下级修改深度
                    $i=$now_deep+1;
                    $subQuery='('.$area_id.')';
                    while($i<=MAX_LAYER){

                        db('area')->where('area_parent_id IN '.$subQuery)->update(array('area_deep'=>$i));
                        $subQuery='(SELECT area_id FROM '.db('area')->field('area_id')->where('area_parent_id IN '.$subQuery)->buildSql().' a)';
                        $i++;
                    }
                }
            }
            $result = $area_mod->editArea($data,array('area_id'=>$area_id));
        } catch (Exception $e) {
            $area_mod->rollback();
            $this->error($e->getMessage());
        }
        $area_mod->commit();
            if ($result>=0) {
                \areacache::deleteCacheFile();
                \areacache::updateAreaArrayJs();
                \areacache::updateAreaPhp();
                dsLayerOpenSuccess(lang('ds_common_op_succ'));
            } else {
                $this->error(lang('ds_common_op_fail'));
            }
        }
    }

    public function drop() {
        $area_id = input('param.area_id');
        if (empty($area_id)) {
            $this->error(lang('param_error'));
        }
        //判断此分类下是否有子分类
        $area_mod=model('area');
        $result = $area_mod->getAreaInfo(array('area_parent_id'=>$area_id));
        if ($result) {
            ds_json_encode(10001, '请先删除该分类下的子地区');
        }
        $result = $area_mod->delArea(array('area_id'=>$area_id));
        if ($result) {
            ds_json_encode(10000, lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001, lang('error'));
        }
    }

    /* 取得可以作为上级的地区分类数据 */

    function _get_options($except = NULL) {
        $area = $this->_area_model->getAreaChild();
        if (empty($area)) {
            return;
        }
        $tree = new \mall\Tree();
        $tree->setTree($area, 'area_id', 'area_parent_id', 'area_name');
        return $tree->getOptions(MAX_LAYER - 1, 0, $except);
    }

    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => '管理',
                'url' => url('Region/index')
            ),
        );

        if (request()->action() == 'add' || request()->action() == 'index') {
            $menu_array[] = array(
                'name' => 'add',
                'text' => '新增',
                'url' =>"javascript:dsLayerOpen('".url('Region/add')."','".lang('ds_add')."')",
            );
        }
        if (request()->action() == 'edit') {
            $menu_array[] = array(
                'name' => 'edit',
                'text' => '编辑',
                'url' => 'javascript:void(0)'
            );
        }
        return $menu_array;
    }

}
