<?php

namespace app\home\controller;

use think\Lang;

class Sellerplate extends BaseSeller {

     public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerplate.lang.php');
    }
    public function index() {
        $this->plate_list();
    }

    /**
     * 关联版式列表
     */
    public function plate_list() {
        // 版式列表
        $where = array();
        $where['store_id'] = session('store_id');
        $p_name = trim(input('get.p_name'));
        if ($p_name != '') {
            $where['storeplate_name'] = array('like', '%' . $p_name . '%');
        }
        $p_position = trim(input('get.p_position'));
        if (in_array($p_position, array('0', '1'))) {
            $where['storeplate_position'] = $p_position;
        }
        $store_plate = model('storeplate');
        $plate_list = $store_plate->getStoreplateList($where, '*', 10);
        $this->assign('show_page', $store_plate->page_info->render());
        $this->assign('plate_list', $plate_list);
        $this->assign('position', array(0 => '底部', 1 => '顶部'));

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellerplate');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('plate_list');
        echo $this->fetch($this->template_dir . 'plate_list');
        exit;
    }

    /**
     * 关联版式添加
     */
    public function plate_add() {
        if (!request()->isPost()) {
            $plate_info = array(
                'storeplate_name' => '',
                'storeplate_position' => '',
                'storeplate_content' => '',
            );
            $this->assign('plate_info', $plate_info);
            // 是否能使用编辑器
            if (check_platform_store()) { // 平台店铺可以使用编辑器
                $editor_multimedia = true;
            } else {    // 三方店铺需要
                $editor_multimedia = false;
                if ($this->store_grade['storegrade_function'] == 'editor_multimedia') {
                    $editor_multimedia = true;
                }
            }
            $this->assign('editor_multimedia', $editor_multimedia);
            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('sellerplate');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('plate_add');
            return $this->fetch($this->template_dir . 'plate_add');
        } else {
            
            $insert = array();
            $insert['storeplate_name'] = input('post.p_name');
            $insert['storeplate_position'] = input('post.p_position');
            $insert['storeplate_content'] = input('post.p_content');
            $insert['store_id'] = session('store_id');

            $sellerplate_validate = validate('sellerplate');
            if (!$sellerplate_validate->scene('plate_add')->check($insert)) {
                ds_json_encode(10001,lang('error') . $sellerplate_validate->getError());
            }

            $result = model('storeplate')->addStoreplate($insert);
            if ($result) {
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } else {
                ds_json_encode(10001,lang('ds_common_op_fail'));
            }
        }
    }

    /**
     * 关联版式编辑
     */
    public function plate_edit() {
        
        $storeplate_id = intval(input('param.p_id'));
        if ($storeplate_id <= 0) {
            $this->error(lang('wrong_argument'));
        }
        if (!request()->isPost()) {

            
            $plate_info = model('storeplate')->getStoreplateInfo(array('storeplate_id' => $storeplate_id, 'store_id' => session('store_id')));
            $this->assign('plate_info', $plate_info);

            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('sellerplate');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('plate_edit');
            return $this->fetch($this->template_dir .'plate_add');
        } else {

            $update = array();
            $update['storeplate_name'] = input('post.p_name');
            $update['storeplate_position'] = input('post.p_position');
            $update['storeplate_content'] = input('post.p_content');

            //验证数据  BEGIN
            $sellerplate_validate = validate('sellerplate');
            if (!$sellerplate_validate->scene('plate_edit')->check($update)) {
                ds_json_encode(10001,lang('error') . $sellerplate_validate->getError());
            }
            //验证数据  END
            
            $where = array();
            $where['storeplate_id'] = $storeplate_id;
            $where['store_id'] = session('store_id');
            $result = model('storeplate')->editStoreplate($update, $where);
            if ($result) {
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } else {
                ds_json_encode(10001,lang('ds_common_op_fail'));
            }
        }
    }

    /**
     * 删除关联版式
     */
    public function drop_plate() {
        $storeplate_id = input('param.p_id');
        if (!preg_match('/^[\d,]+$/i', $storeplate_id)) {
            ds_json_encode(10001,lang('wrong_argument'));
        }
        $plateid_array = explode(',', $storeplate_id);
        $return = model('storeplate')->delStoreplate(array('storeplate_id' => array('in', $plateid_array), 'store_id' => session('store_id')));
        if ($return) {
            ds_json_encode(10000,lang('ds_common_del_succ'));
        } else {
            ds_json_encode(10001,lang('ds_common_del_fail'));
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    function getSellerItemList() {
        $item_list = array(
            array(
                'name' => 'plate_list',
                'text' => '版式列表',
                'url' => url('Sellerplate/plate_list'),
            ),
        );
        if (request()->action() == 'plate_add') {
            $item_list[] = array(
                'name' => 'plate_add',
                'text' => '添加版式',
                'url' => url('Sellerplate/plate_add'),
            );
        }

        if (request()->action() == 'plate_edit') {
            $item_list[] = array(
                'name' => 'plate_add',
                'text' => '添加版式',
                'url' => url('Sellerplate/plate_add'),
            );
            $item_list[] = array(
                'name' => 'plate_edit',
                'text' => '编辑版式',
                'url' => url('Sellerplate/plate_edit'),
            );
        }
        return $item_list;
    }

}

?>
