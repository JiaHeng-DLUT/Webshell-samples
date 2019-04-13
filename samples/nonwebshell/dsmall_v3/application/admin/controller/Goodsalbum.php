<?php

/*
 * 空间管理
 */

namespace app\admin\controller;

use think\Lang;

class Goodsalbum extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/goodsalbum.lang.php');
    }

    /**
     * 相册列表
     */
    public function index() {
        $condition = array();
        $store_name = '';
        if (is_numeric(input('param.keyword'))) {
            $store_id = intval(input('param.keyword'));
            $condition['s.store_id'] = $store_id;
            $store_name = ds_getvalue_byname('store', 'store_id', $store_id, 'store_name');
        } elseif (!empty(input('param.keyword'))) {
            $store_name = input('param.keyword');
            $store_id = ds_getvalue_byname('store', 'store_name', $store_name, 'store_id');
            if (is_numeric($store_id)) {
                $condition['s.store_id'] = $store_id;
            } else {
                $condition['s.store_id'] = 0;
            }
        }
        $goodsalbum_model = model('album');
        $albumclass_list = $goodsalbum_model->getGoodsalbumList($condition,10,'a.*,s.store_name');
        $this->assign('show_page', $goodsalbum_model->page_info->render());

        if (is_array($albumclass_list) && !empty($albumclass_list)) {
            foreach ($albumclass_list as $v) {
                $class[] = $v['aclass_id'];
            }
            $where['aclass_id'] = array('in',$class);
        } else {
            $where = '1=1';
        }
        $count = $goodsalbum_model->getAlbumpicCountlist($where,'aclass_id,count(*) as pcount','aclass_id');

        $pic_count = array();
        if (is_array($count)) {
            foreach ($count as $v) {
                $pic_count[$v['aclass_id']] = $v['pcount'];
            }
        }
        $this->assign('pic_count', $pic_count);
        $this->assign('albumclass_list', $albumclass_list);
        $this->assign('store_name', $store_name);

        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件

        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     * 图片列表
     */
    public function pic_list() {
        $condition = array();
        $store_name = '';
        if (is_numeric(input('param.keyword'))) {
            $store_id = intval(input('param.keyword'));
            $condition['store_id'] = $store_id;
            $store_name = ds_getvalue_byname('store','store_id',$store_id,'store_name');
        } elseif ((input('param.keyword'))) {
            $store_name = input('param.keyword');
            $store_id = ds_getvalue_byname('store','store_name',$store_name,'store_id');
            if (is_numeric($store_id)) {
                $condition['store_id'] = $store_id;
            } else {
                $condition['store_id'] = 0;
            }
        } elseif (is_numeric(input('param.aclass_id'))) {
            $condition['aclass_id'] = input('param.aclass_id');
        }
        $albumpic_model = model('album');
        $albumpic_list = $albumpic_model->getAlbumpicList($condition,34,'','apic_id desc');
        //halt($albumpic_list);
        $show_page = $albumpic_model->page_info->render();
        $this->assign('show_page', $show_page);
        $this->assign('albumpic_list', $albumpic_list);
        $this->assign('store_name', $store_name);
        $this->setAdminCurItem('pic_list');
        return $this->fetch();
    }

    /**
     * 删除相册
     */
    public function aclass_del() {
        $aclass_id = input('param.aclass_id');
        $aclass_id_array = ds_delete_param($aclass_id);
        if ($aclass_id_array == FALSE) {
            ds_json_encode('10001', lang('param_error'));
        }
        $condition=array();
        $condition['aclass_id'] = array('in',$aclass_id_array);
        $albumpic_model = model('album');
        //批量删除相册图片
        $albumpic_model->delAlbumpic($condition);
        $albumpic_model->delAlbumclass($condition);
        $this->log(lang('ds_del') . lang('g_album_one') . '[ID:' . intval(input('param.aclass_id')) . ']', 1);
        ds_json_encode('10000', lang('ds_common_del_succ'));
    }

    /**
     * 删除一张图片及其对应记录
     *
     */
    public function del_album_pic() {
        $apic_id = input('param.apic_id');
        $apic_id_array = ds_delete_param($apic_id);
        if ($apic_id_array === FALSE) {
            ds_json_encode('10001', lang('param_error'));
        }
        $condition=array();
        $condition['apic_id']=array('in',$apic_id_array);
        $albumpic_model = model('album');
        //批量删除相册图片
        $albumpic_model->delAlbumpic($condition);
        $this->log(lang('ds_del') . lang('g_album_pic_one') . '[ID:' . $apic_id . ']', 1);
        ds_json_encode('10000', lang('ds_common_op_succ'));
    }


    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => '相册列表',
                'url' => url('Goodsalbum/index')
            ),
            array(
                'name' => 'pic_list',
                'text' => '图片列表',
                'url' => url('Goodsalbum/pic_list')
            ),
        );
        return $menu_array;
    }

}

?>
