<?php

namespace app\admin\controller;

use think\Lang;
use app\common\model\Storedepositlog;
class Store extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/store.lang.php');
    }

    /**
     * 店铺
     */
    public function store() {
        $store_model = model('store');

        $owner_and_name = input('get.owner_and_name');
        if (trim($owner_and_name) != '') {
            $condition['member_name'] = array('like', '%' . $owner_and_name . '%');
        }
        $store_name = input('get.store_name');
        if (trim($store_name) != '') {
            $condition['store_name'] = array('like', '%' . trim($store_name) . '%');
        }
        $grade_id = input('get.grade_id');
        if (intval($grade_id) > 0) {
            $condition['grade_id'] = intval($grade_id);
        }
        $store_type = input('get.store_type');
        switch ($store_type) {
            case 'close':
                $condition['store_state'] = 0;
                break;
            case 'open':
                $condition['store_state'] = 1;
                break;
            case 'expired':
                $condition['store_endtime'] = array('between', array(1, TIMESTAMP));
                $condition['store_state'] = 1;
                break;
            case 'expire':
                $condition['store_endtime'] = array('between', array(TIMESTAMP, TIMESTAMP + 864000));
                $condition['store_state'] = 1;
                break;
        }

        // 默认店铺管理不包含自营店铺
        $condition['is_platform_store'] = 0;

        //店铺列表
        $store_list = $store_model->getStoreList($condition, 10, 'store_id desc');
        //店铺等级
        $storegrade_model = model('storegrade');
        $grade_list = $storegrade_model->getStoregradeList();
        $search_grade_list = array();
        if (!empty($grade_list)) {
            $search_grade_list[0] = '未选择等级';
            foreach ($grade_list as $k => $v) {
                $search_grade_list[$v['storegrade_id']] = $v['storegrade_name'];
            }
        }
        $this->assign('search_grade_list', $search_grade_list);

        $this->assign('grade_list', $grade_list);
        $this->assign('store_list', $store_list);
        $this->assign('store_type', $this->_get_store_type_array());
        $this->assign('show_page', $store_model->page_info->render());
        $this->setAdminCurItem('store');
        return $this->fetch('store');
    }

    private function _get_store_type_array() {
        return array(
            'open' => '开启',
            'close' => '关闭',
            'expire' => '即将到期',
            'expired' => '已到期'
        );
    }

    /**
     * 店铺编辑
     */
    public function store_edit() {
        $store_id = input('param.store_id');
        $store_model = model('store');
        //保存
        if (!request()->isPost()) {
            //取店铺信息
            $store_array = $store_model->getStoreInfoByID($store_id);
            if (empty($store_array)) {
                $this->error(lang('store_no_exist'));
            }
            //整理店铺内容
            $store_array['store_endtime'] = $store_array['store_endtime'] ? date('Y-m-d', $store_array['store_endtime']) : '';
            //店铺分类
            $storeclass_model = model('storeclass');
            $parent_list = $storeclass_model->getStoreclassList(array(), '', false);

            //店铺等级
            $storegrade_model = model('storegrade');
            $grade_list = $storegrade_model->getStoregradeList();
            $this->assign('grade_list', $grade_list);
            $this->assign('class_list', $parent_list);
            $this->assign('store_array', $store_array);

            $joinin_detail = model('storejoinin')->getOneStorejoinin(array('member_id' => $store_array['member_id']));
            $this->assign('joinin_detail', $joinin_detail);
            $this->setAdminCurItem('store_edit');
            return $this->fetch('store_edit');
        } else {
            //取店铺等级的审核
            $storegrade_model = model('storegrade');
            $grade_array = $storegrade_model->getOneStoregrade(intval(input('post.grade_id')));
            if (empty($grade_array)) {
                $this->error(lang('please_input_store_level'));
            }
            //结束时间
            $time = '';
            if (trim(input('post.end_time')) != '') {
                $time = strtotime(input('post.end_time'));
            }
            $update_array = array();
            $update_array['store_name'] = trim(input('post.store_name'));
            $update_array['storeclass_id'] = intval(input('post.storeclass_id'));
            $update_array['grade_id'] = intval(input('post.grade_id'));
            $update_array['store_endtime'] = $time;
            $update_array['store_state'] = intval(input('post.store_state'));
            $update_array['store_baozh'] = trim(input('post.store_baozh')); //保障服务开关
            $update_array['store_qtian'] = trim(input('post.store_qtian')); //保障服务-七天退换
            $update_array['store_zhping'] = trim(input('post.store_zhping')); //保障服务-正品保证
            $update_array['store_erxiaoshi'] = trim(input('post.store_erxiaoshi')); //保障服务-两小时发货
            $update_array['store_tuihuo'] = trim(input('post.store_tuihuo')); //保障服务-退货承诺
            $update_array['store_shiyong'] = trim(input('post.store_shiyong')); //保障服务-试用
            $update_array['store_xiaoxie'] = trim(input('post.store_xiaoxie')); //保障服务-消协
            $update_array['store_huodaofk'] = trim(input('post.store_huodaofk')); //保障服务-货到付款
            $update_array['store_shiti'] = trim(input('post.store_shiti')); //保障服务-实体店铺
            $data['store_type'] = input('post.store_type')==1?1:0;
            $condition['member_id'] = intval(input('post.member_id'));
            if ($update_array['store_state'] == 0) {
                //根据店铺状态修改该店铺所有商品状态
                $goods_model = model('goods');
                $goods_model->editProducesOffline(array('store_id' => $store_id));
                $update_array['store_close_info'] = trim(input('post.store_close_info'));
                $update_array['store_recommend'] = 0;
            } else {
                //店铺开启后商品不在自动上架，需要手动操作
                $update_array['store_close_info'] = '';
            }
            $result = $store_model->editStore($update_array, array('store_id' => $store_id));
            $store_type = model('Storejoinin')->editStorejoinin($data,$condition);
            if ($result || $store_type) {
                //店铺名称修改处理 
                $store_name = trim(input('post.store_name'));
                $store_info = $store_model->getStoreInfoByID($store_id);
                if (!empty($store_name)) {
                    $where = array();
                    $where['store_id'] = $store_id;
                    $update = array();
                    $update['store_name'] = $store_name;
                    $bllGoods = $store_model->editGoodscommon($where,$update);
                    $bllGoods = $store_model->editGoods($where,$update);
                }

                $this->log(lang('ds_edit').lang('store') . '[' . input('post.store_name') . ']', 1);
                $this->success(lang('ds_common_save_succ'), url('Store/store'));
            } else {
                $this->log(lang('ds_edit').lang('store') . '[' . input('post.store_name') . ']', 1);
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 编辑保存注册信息
     */
    public function edit_save_joinin() {
        if (request()->isPost()) {
            $member_id = input('post.member_id');
            if ($member_id <= 0) {
                $this->error(lang('param_error'));
            }
            $param = array();
            $param['company_name'] = input('post.company_name');
            $param['company_province_id'] = intval(input('post.province_id'));
            $param['company_address'] = input('post.company_address');
            $param['company_address_detail'] = input('post.company_address_detail');
            $param['company_registered_capital'] = intval(input('post.company_registered_capital'));
            $param['contacts_name'] = input('post.contacts_name');
            $param['contacts_phone'] = input('post.contacts_phone');
            $param['contacts_email'] = input('post.contacts_email');
            $param['business_licence_number'] = input('post.business_licence_number');
            $param['business_licence_address'] = input('post.business_licence_address');
            $param['business_licence_start'] = input('post.business_licence_start');
            $param['business_licence_end'] = input('post.business_licence_end');
            $param['business_sphere'] = input('post.business_sphere');
            if (!empty($_FILES['business_licence_number_electronic']['name'])) {
                $param['business_licence_number_electronic'] = $this->upload_image('business_licence_number_electronic');
            }


            $param['bank_account_name'] = input('post.bank_account_name');
            $param['bank_account_number'] = input('post.bank_account_number');
            $param['bank_name'] = input('post.bank_name');
            $param['bank_address'] = input('post.bank_address');

            $param['settlement_bank_account_name'] = input('post.settlement_bank_account_name');
            $param['settlement_bank_account_number'] = input('post.settlement_bank_account_number');
            $param['settlement_bank_name'] = input('post.settlement_bank_name');
            $param['settlement_bank_address'] = input('post.settlement_bank_address');

            $result = model('storejoinin')->editStorejoinin($param,array('member_id' => $member_id));
            if ($result>=0) {
                //更新店铺信息
                $store_update = array();
                $store_update['store_company_name'] = $param['company_name'];
                $store_update['area_info'] = $param['company_address'];
                $store_update['store_address'] = $param['company_address_detail'];
                $store_model = model('store');
                $store_info = $store_model->getStoreInfo(array('member_id' => $member_id));
                if (!empty($store_info)) {
                    $r = $store_model->editStore($store_update, array('member_id' => $member_id));
                    $this->log('编辑店铺信息' . '[ID:' . $r . ']', 1);
                }
                $this->success(lang('ds_common_op_succ'), url('Store/store'));
            } else {
                $this->error(lang('ds_common_op_fail'));
            }
        }
    }

    private function upload_image($file) {
        
        //上传文件保存路径
        $pic_name = '';
        
        $upload_file = BASE_UPLOAD_PATH .DS. 'home'.DS.'store_joinin'.DS;
        if (!empty($_FILES[$file]['name'])) {
            $file_object = request()->file($file);
            //设置特殊图片名称
            $member_id = input('post.member_id');
            $file_name = $member_id . '_' . date('YmdHis') . rand(10000, 99999);
            $info = $file_object->rule('uniqid')->validate(['ext' =>ALLOW_IMG_EXT])->move($upload_file, $file_name);
            if ($info) {
                $pic_name = $info->getFilename();
            } else {
                // 上传失败获取错误信息
                $this->error($file_object->getError());
            }
        }
        return $pic_name;
        
    }

    /**
     * 店铺经营类目管理
     */

    public function store_bind_class() {
        
        $store_id = intval(input('param.store_id'));

        $store_model = model('store');
        $storebindclass_model = model('storebindclass');
        $goodsclass_model = model('goodsclass');

        $gc_list = $goodsclass_model->getGoodsclassListByParentId(0);
        $this->assign('gc_list', $gc_list);

        $store_info = $store_model->getStoreInfoByID($store_id);
        if (empty($store_info)) {
            $this->error(lang('param_error'));
        }
        $this->assign('store_info', $store_info);

        $store_bind_class_list = $storebindclass_model->getStorebindclassList(array('store_id' => $store_id, 'storebindclass_state' => array('in', array(1, 2))), null);
        $goods_class = model('goodsclass')->getGoodsclassIndexedListAll();
        for ($i = 0, $j = count($store_bind_class_list); $i < $j; $i++) {
            $store_bind_class_list[$i]['class_1_name'] = @$goods_class[$store_bind_class_list[$i]['class_1']]['gc_name'];
            $store_bind_class_list[$i]['class_2_name'] = @$goods_class[$store_bind_class_list[$i]['class_2']]['gc_name'];
            $store_bind_class_list[$i]['class_3_name'] = @$goods_class[$store_bind_class_list[$i]['class_3']]['gc_name'];
        }
        $this->assign('store_bind_class_list', $store_bind_class_list);
        $this->setAdminCurItem('store_bind_class');
        return $this->fetch('store_bind_class');
    }

    /**
     * 添加经营类目
     */
    public function store_bind_class_add() {
        $store_id = intval(input('post.store_id'));
        $commis_rate = intval(input('post.commis_rate'));
        if ($commis_rate < 0 || $commis_rate > 100) {
            $this->error(lang('param_error'));
        }
        @list($class_1, $class_2, $class_3) = explode(',', input('post.goods_class'));

        $storebindclass_model = model('storebindclass');

        $param = array();
        $param['store_id'] = $store_id;
        $param['class_1'] = $class_1;
        $param['storebindclass_state'] = 1;
        if (!empty($class_2)) {
            $param['class_2'] = $class_2;
        }
        if (!empty($class_3)) {
            $param['class_3'] = $class_3;
        }

        // 检查类目是否已经存在
        $store_bind_class_info = $storebindclass_model->getStorebindclassInfo($param);
        if (!empty($store_bind_class_info)) {
            $this->error('该类目已经存在');
        }

        $param['commis_rate'] = $commis_rate;
        $result = $storebindclass_model->addStorebindclass($param);

        if ($result) {
            $this->log('新增店铺经营类目，类目编号:' . $result . ',店铺编号:' . $store_id);
            $this->success(lang('ds_common_save_succ'));
        } else {
            $this->error(lang('ds_common_save_fail'));
        }
    }

    /**
     * 删除经营类目
     */
    public function store_bind_class_del() {
        $bid = intval(input('param.bid'));


        $storebindclass_model = model('storebindclass');
        $goods_model = model('goods');

        $store_bind_class_info = $storebindclass_model->getStorebindclassInfo(array('storebindclass_id' => $bid));
        if (empty($store_bind_class_info)) {
            ds_json_encode('10001', '经营类目删除失败');
        }

        // 商品下架
        $condition = array();
        $condition['store_id'] = $store_bind_class_info['store_id'];
        $gc_id = $store_bind_class_info['class_1'] . ',' . $store_bind_class_info['class_2'] . ',' . $store_bind_class_info['class_3'];
        $update = array();
        $update['goods_stateremark'] = '管理员删除经营类目';
        $condition['gc_id'] = array('in', rtrim($gc_id, ','));
        $goods_model->editProducesLockUp($update, $condition);

        $result = $storebindclass_model->delStorebindclass(array('storebindclass_id' => $bid));

        if (!$result) {
            ds_json_encode('10001', '经营类目删除失败');
        }else{
            $this->log('删除店铺经营类目，类目编号:' . $bid . ',店铺编号:' . $store_bind_class_info['store_id']);
            ds_json_encode('10000', '经营类目删除失败');
        }
    }

    public function store_bind_class_update() {
        $bid = intval(input('param.id'));
        if ($bid <= 0) {
            echo json_encode(array('result' => FALSE, 'message' => lang('param_error')));
            die;
        }
        $new_commis_rate = intval(input('param.value'));
        if ($new_commis_rate < 0 || $new_commis_rate >= 100) {
            echo json_encode(array('result' => FALSE, 'message' => lang('param_error')));
            die;
        } else {
            $update = array('commis_rate' => $new_commis_rate);
            $condition = array('storebindclass_id' => $bid);
            $storebindclass_model = model('storebindclass');
            $result = $storebindclass_model->editStorebindclass($update, $condition);
            if ($result) {
                $this->log('更新店铺经营类目，类目编号:' . $bid);
                echo json_encode(array('result' => TRUE));
                die;
            } else {
                echo json_encode(array('result' => FALSE, 'message' => lang('ds_common_op_fail')));
                die;
            }
        }
    }

    /**
     * 店铺 待审核列表
     */
    public function store_joinin() {
        $condition = array();
        //店铺列表
        if (input('param.owner_and_name')) {
            $condition['member_name'] = array('like', '%' . input('param.owner_and_name') . '%');
        }
        if (input('param.store_name')) {
            $condition['store_name'] = array('like', '%' . input('param.store_name') . '%');
        }
        if (input('param.grade_id') && intval(input('param.grade_id')) > 0) {
            $condition['storegrade_id'] = input('param.grade_id');
        }
        if (input('param.joinin_state') && intval(input('param.joinin_state')) > 0) {
            $condition['joinin_state'] = input('param.joinin_state');
        } else {
            $condition['joinin_state'] = array('gt', 0);
        }
        $storejoinin_model = model('storejoinin');
        $store_list = $storejoinin_model->getStorejoininList($condition, 10, 'joinin_state asc');
        $this->assign('store_list', $store_list);
        $this->assign('joinin_state_array', $this->get_store_joinin_state());

        //店铺等级
        $storegrade_model = model('storegrade');
        $grade_list = $storegrade_model->getStoregradeList();
        $this->assign('grade_list', $grade_list);

        $this->assign('show_page', $storejoinin_model->page_info->render());
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        
        $this->setAdminCurItem('store_joinin');
        return $this->fetch('store_joinin');
    }

    /**
     * 经营类目申请列表
     */

    public function store_bind_class_applay_list() {
        $condition = array();
        // 不显示自营店铺绑定的类目
        $state = input('state');
        if ($state != '') {
            $condition['storebindclass_state'] = intval($state);
            if (!in_array($condition['storebindclass_state'], array('0', '1',)))
                unset($condition['storebindclass_state']);
        } else {
            $condition['storebindclass_state'] = array('in', array('0', '1',));
        }

        $store_id = input('store_id');
        if (intval($store_id)) {
            $condition['store_id'] = intval($store_id);
        }

        $storebindclass_model = model('storebindclass');
        $store_bind_class_list = $storebindclass_model->getStorebindclassList($condition, 15, 'storebindclass_state asc,storebindclass_id desc');
        $goods_class = model('goodsclass')->getGoodsclassIndexedListAll();
        $store_ids = array();

        for ($i = 0; $i < count($store_bind_class_list); $i++) {
            $store_bind_class_list[$i]['class_1_name'] = @$goods_class[$store_bind_class_list[$i]['class_1']]['gc_name'];
            $store_bind_class_list[$i]['class_2_name'] = @$goods_class[$store_bind_class_list[$i]['class_2']]['gc_name'];
            $store_bind_class_list[$i]['class_3_name'] = @$goods_class[$store_bind_class_list[$i]['class_3']]['gc_name'];
            $store_ids[] = $store_bind_class_list[$i]['store_id'];
        }

        //取店铺信息
        $store_model = model('store');
        $store_list = $store_model->getStoreList(array('store_id' => array('in', $store_ids)), null);
        $bind_store_list = array();
        if (!empty($store_list) && is_array($store_list)) {
            foreach ($store_list as $k => $v) {
                $bind_store_list[$v['store_id']]['store_name'] = $v['store_name'];
                $bind_store_list[$v['store_id']]['seller_name'] = $v['seller_name'];
            }
        }
        $this->assign('bind_list', $store_bind_class_list);
        $this->assign('bind_store_list', $bind_store_list);

        $this->assign('show_page', $storebindclass_model->page_info->render());
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        
        $this->setAdminCurItem('store_bind_class_applay_list');
        return $this->fetch('bind_class_applay_list');
    }

    /**
     * 审核经营类目申请
     */
    public function store_bind_class_applay_check() {
        $storebindclass_model = model('storebindclass');
        $condition = array();
        $condition['storebindclass_id'] = intval(input('param.bid'));
        $condition['storebindclass_state'] = 0;
        $update = $storebindclass_model->editStorebindclass(array('storebindclass_state' => 1), $condition);
        if ($update) {
            $this->log('审核新经营类目申请，店铺ID：' . input('param.store_id'), 1);
            ds_json_encode(10000, '审核成功');
        } else {
            $this->error('审核失败', get_referer());
        }
    }

    /**
     * 删除经营类目申请
     */
    public function store_bind_class_applay_del() {
        $storebindclass_model = model('storebindclass');
        $condition = array();
        $condition['storebindclass_id'] = intval(input('param.bid'));
        $del = $storebindclass_model->delStorebindclass($condition);
        if ($del) {
            $this->log('删除经营类目，店铺ID：' . input('param.store_id'), 1);
            ds_json_encode(10000, '删除经营类目成功');
        } else {
            $this->error(lang('ds_common_del_fail'), get_referer());
        }
    }

    private function get_store_joinin_state() {
        $joinin_state_array = array(
            STORE_JOIN_STATE_NEW => '新申请',
            STORE_JOIN_STATE_PAY => '已付款',
            STORE_JOIN_STATE_VERIFY_SUCCESS => '待付款',
            STORE_JOIN_STATE_VERIFY_FAIL => '审核失败',
            STORE_JOIN_STATE_PAY_FAIL => '付款审核失败',
            STORE_JOIN_STATE_FINAL => '开店成功',
        );
        return $joinin_state_array;
    }

    /**
     * 店铺续签申请列表
     */
    public function reopen_list() {
        $condition = array();
        $store_id = input('get.store_id');
        if (intval($store_id)) {
            $condition['storereopen_store_id'] = intval($store_id);
        }
        $store_name = input('get.store_name');
        if (!empty($store_name)) {
            $condition['storereopen_store_name'] = $store_name;
        }
        $storereopen_state = input('get.storereopen_state');
        if ($storereopen_state != '') {
            $condition['storereopen_state'] = intval($storereopen_state);
        }
        $storereopen_model = model('storereopen');
        $reopen_list = $storereopen_model->getStorereopenList($condition, 15);

        $this->assign('reopen_list', $reopen_list);
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件

        $this->assign('show_page', $storereopen_model->page_info->render());
        $this->setAdminCurItem('reopen_list');
        return $this->fetch('store_reopen_list');
    }

    /**
     * 审核店铺续签申请
     */
    public function reopen_check() {
        if (intval(input('param.storereopen_id')) <= 0)
            exit();
        $storereopen_model = model('storereopen');
        $condition = array();
        $condition['storereopen_id'] = intval(input('param.storereopen_id'));
        $condition['storereopen_state'] = 1;
        //取当前申请信息
        $reopen_info = $storereopen_model->getStorereopenInfo($condition);
        
        $data = array();
        $data['storereopen_state'] = 2;
        $update = $storereopen_model->editStorereopen($data, $condition);
        //取目前店铺有效截止日期
        $store_info = model('store')->getStoreInfoByID($reopen_info['storereopen_store_id']);
        $start_time = strtotime(date('Y-m-d 0:0:0',$store_info['store_endtime']))+24*3600;
        $new_store_endtime = strtotime(date('Y-m-d 23:59:59', $start_time)." +".intval($reopen_info['storereopen_year'])." year");
        if ($update) {
            //更新店铺有效期
            model('store')->editStore(array('store_endtime' => $new_store_endtime), array('store_id' => $reopen_info['storereopen_store_id']));
            $msg = '审核通过店铺续签申请，店铺ID：' . $reopen_info['storereopen_store_id'] ;
            $this->log($msg, 1);
            ds_json_encode('10000', '续签成功');
        } else {
            ds_json_encode('10001', '审核失败');
        }
    }

    /**
     * 删除店铺续签申请
     */
    public function reopen_del() {
        $storereopen_model = model('storereopen');
        $condition = array();
        $condition['storereopen_id'] = intval(input('param.storereopen_id'));
        $condition['storereopen_state'] = array('in', array(0, 1));

        //取当前申请信息
        $reopen_info = $storereopen_model->getStorereopenInfo($condition);
        $cert_file = BASE_UPLOAD_PATH . DS . ATTACH_STORE_JOININ . DS . $reopen_info['storereopen_pay_cert'];
        $del = $storereopen_model->delStorereopen($condition);
        if ($del) {
            if (is_file($cert_file)) {
                unlink($cert_file);
            }
            $this->log('删除店铺续签目申请，店铺ID：' . input('param.storereopen_store_id'), 1);
            ds_json_encode('10000', lang('ds_common_del_succ'));
        } else {
            ds_json_encode('10001', lang('ds_common_del_fail'));
        }
    }

    /**
     * 审核详细页
     */
    public function store_joinin_detail() {
        $storejoinin_model = model('storejoinin');
        $member_id = input('param.member_id');
        $joinin_detail = $storejoinin_model->getOneStorejoinin(array('member_id' => $member_id));
        $joinin_detail_title = '查看';
        if (in_array(intval($joinin_detail['joinin_state']), array(STORE_JOIN_STATE_NEW, STORE_JOIN_STATE_PAY))) {
            $joinin_detail_title = '审核';
        }
        if (!empty($joinin_detail['sg_info'])) {
            $store_grade_info = model('storegrade')->getOneStoregrade($joinin_detail['storegrade_id']);
            $joinin_detail['storegrade_price'] = $store_grade_info['storegrade_price'];
        } else {
            $joinin_detail['sg_info'] = @unserialize($joinin_detail['sg_info']);
            if (is_array($joinin_detail['sg_info'])) {
                $joinin_detail['storegrade_price'] = $joinin_detail['sg_info']['storegrade_price'];
            }
        }

        $this->assign('joinin_detail_title', $joinin_detail_title);
        $this->assign('joinin_detail', $joinin_detail);
        return $this->fetch('store_joinin_detail');
    }

    /**
     * 审核
     */
    public function store_joinin_verify() {
        $storejoinin_model = model('storejoinin');
        $joinin_detail = $storejoinin_model->getOneStorejoinin(array('member_id' => input('param.member_id')));

        switch (intval($joinin_detail['joinin_state'])) {
            case STORE_JOIN_STATE_NEW:
                $this->store_joinin_verify_pass($joinin_detail);
                break;
            case STORE_JOIN_STATE_PAY:
                $this->store_joinin_verify_open($joinin_detail);
                break;
            default:
                $this->error(lang('param_error'));
                break;
        }
    }

    private function store_joinin_verify_pass($joinin_detail) {
        $param = array();
        $param['joinin_state'] =input('post.verify_type') === 'pass' ? STORE_JOIN_STATE_VERIFY_SUCCESS : STORE_JOIN_STATE_VERIFY_FAIL;
        $param['joinin_message'] =input('post.joinin_message');
        $param['paying_amount'] = abs(floatval(input('post.paying_amount')));
        $commis_rate_array = input('post.commis_rate/a');#获取数组
        $param['store_class_commis_rates'] = is_array($commis_rate_array)?implode(',', $commis_rate_array):'';
        $storejoinin_model = model('storejoinin');
        $storejoinin_model->editStorejoinin($param, array('member_id' =>input('post.member_id')));
        if ($param['paying_amount'] > 0) {
            dsLayerOpenSuccess('店铺入驻申请审核完成');
        } else {
            //如果开店支付费用为零，则审核通过后直接开通，无需再上传付款凭证
            $this->store_joinin_verify_open($joinin_detail);
        }
    }

    private function store_joinin_verify_open($joinin_detail) {
        $storejoinin_model = model('storejoinin');
        $store_model = model('store');
        $seller_model = model('seller');

        //验证卖家用户名是否已经存在
        if ($seller_model->isSellerExist(array('seller_name' => $joinin_detail['seller_name']))) {
            $this->error('卖家用户名已存在');
        }

        $param = array();
        $param['joinin_state'] = input('post.verify_type') === 'pass' ? STORE_JOIN_STATE_FINAL : STORE_JOIN_STATE_PAY_FAIL;
        $param['joinin_message'] = input('post.joinin_message');

        if (input('post.verify_type') === 'pass') {
            //开店
            $shop_array = array();
            $shop_array['member_id'] = $joinin_detail['member_id'];
            $shop_array['member_name'] = $joinin_detail['member_name'];
            $shop_array['seller_name'] = $joinin_detail['seller_name'];
            $shop_array['grade_id'] = $joinin_detail['storegrade_id'];
            $shop_array['store_name'] = $joinin_detail['store_name'];
            $shop_array['storeclass_id'] = $joinin_detail['storeclass_id'];
            $shop_array['store_company_name'] = $joinin_detail['company_name'];
            $shop_array['region_id'] = $joinin_detail['company_province_id'];
            $shop_array['store_longitude'] = $joinin_detail['store_longitude'];
            $shop_array['store_latitude'] = $joinin_detail['store_latitude'];
            $shop_array['area_info'] = $joinin_detail['company_address'];

            $shop_array['store_address'] = $joinin_detail['company_address_detail'];
            $shop_array['store_zip'] = '';
            $shop_array['store_mainbusiness'] = '';
            $shop_array['store_state'] = 1;
            $shop_array['store_addtime'] = time();
            $shop_array['store_endtime'] = strtotime(date('Y-m-d 23:59:59', strtotime('+1 day')) . " +" . intval($joinin_detail['joinin_year']) . " year");
            //$shop_array['store_avaliable_deposit']=$joinin_detail['storeclass_bail'];
            $store_id = $store_model->addStore($shop_array);

            if ($store_id) {
                //记录保证金
                if($joinin_detail['storeclass_bail']>0){
                    $storedepositlog_model = model('storedepositlog');
                    try {
                        $storedepositlog_model->startTrans();
                        $storedepositlog_model->changeStoredeposit(array(
                            'seller_id'=>$store_id,
                            'storedepositlog_type'=>Storedepositlog::TYPE_PAY,
                            'storedepositlog_state'=>Storedepositlog::STATE_VALID,
                            'storedepositlog_add_time'=>TIMESTAMP,
                            'store_avaliable_deposit'=>$joinin_detail['storeclass_bail'],
                            'storedepositlog_desc'=>lang('store_open_add_deposit'),
                        ));
                        $storedepositlog_model->commit();
                    } catch (\Exception $e) {
                        $storedepositlog_model->rollback();
                        $this->error($e->getMessage());
                    }
                }
                //写入卖家账号
                $seller_array = array();
                $seller_array['seller_name'] = $joinin_detail['seller_name'];
                $seller_array['member_id'] = $joinin_detail['member_id'];
                $seller_array['sellergroup_id'] = 0;
                $seller_array['store_id'] = $store_id;
                $seller_array['is_admin'] = 1;
                $state = $seller_model->addSeller($seller_array);
                //改变店铺状态
                $storejoinin_model->editStorejoinin($param, array('member_id' => input('param.member_id')));
            }

            if ($state) {
                // 添加相册默认
                $album_model = model('album');
                $album_arr = array();
                $album_arr['aclass_name'] = lang('store_save_defaultalbumclass_name');
                $album_arr['store_id'] = $store_id;
                $album_arr['aclass_des'] = '';
                $album_arr['aclass_sort'] = '255';
                $album_arr['aclass_cover'] = '';
                $album_arr['aclass_uploadtime'] = time();
                $album_arr['aclass_isdefault'] = '1';
                $album_model->addAlbumclass($album_arr);

                //插入店铺扩展表
                $store_model->addStoreextend(array('store_id' => $store_id));
                $msg = lang('store_save_create_success');

                //插入店铺绑定分类表
                $store_bind_class_array = array();
                $store_bind_class = unserialize($joinin_detail['store_class_ids']);
                $store_bind_commis_rates = explode(',', $joinin_detail['store_class_commis_rates']);
                for ($i = 0, $length = count($store_bind_class); $i < $length; $i++) {
                    @list($class1, $class2, $class3) = explode(',', $store_bind_class[$i]);
                    $store_bind_class_array[] = array(
                        'store_id' => $store_id,
                        'commis_rate' => $store_bind_commis_rates[$i],
                        'class_1' => $class1,
                        'class_2' => $class2,
                        'class_3' => $class3,
                        'storebindclass_state' => 1
                    );
                }
                $storebindclass_model = model('storebindclass');
                $storebindclass_model->addStorebindclassAll($store_bind_class_array);
                dsLayerOpenSuccess('店铺开店成功');
            } else {
                $this->error('店铺开店失败');
            }
        } else {
            $this->error('店铺开店拒绝');
        }
    }

    /**
     * 提醒续费
     */
    public function remind_renewal() {
        $store_id = intval(input('param.store_id'));
        $store_info = model('store')->getStoreInfoByID($store_id);
        if (!empty($store_info) && $store_info['store_endtime'] < (TIMESTAMP + 864000) && cookie('remindRenewal' . $store_id) == null) {
            // 发送商家消息
            $param = array();
            $param['code'] = 'store_expire';
            $param['store_id'] = intval(input('param.store_id'));
            $param['param'] = array();
            \mall\queue\QueueClient::push('sendStoremsg', $param);

            cookie('remindRenewal' . $store_id, 1, 86400 * 10);  // 十天
            $this->success('消息发送成功');
        }
        $this->error('消息发送失败');
    }

    /*
    //删除店铺操作，暂时屏蔽
    public function del() {
        $store_id = intval(input('param.id'));
        $store_model = model('store');
        $storeArray = $store_model->field('is_platform_store,store_name')->find($store_id);
        if (empty($storeArray)) {
            ds_json_encode('10001', lang('外驻店铺不存在'));
        }
        if ($storeArray['is_platform_store']) {
            ds_json_encode('10001', lang('不能在此删除自营店铺'));
        }
        $condition = array(
            'store_id' => $store_id,
        );
        if (model('goods')->getGoodsCount($condition) > 0){
            ds_json_encode('10001', lang('已经发布商品的外驻店铺不能被删除'));
        }
        // 完全删除店铺
        $store_model->delStoreEntirely($condition);
        //删除入驻相关 
        $member_id = intval(input('param.member_id'));
        $store_joinin = model('storejoinin');
        $condition = array(
            'member_id' => $member_id,
        );
        $store_joinin->delStorejoinin($condition);
        $this->log("删除外驻店铺: {$storeArray['store_name']}");
        ds_json_encode('10000', lang('ds_common_del_succ'));
    }
     * 
     */

    //删除店铺操作 
    public function del_join() {
        $member_id = (int) input('param.member_id');
        $store_joinin = model('storejoinin');
        $condition = array(
            'member_id' => $member_id,
        );
        $mm = $store_joinin->getOneStorejoinin($condition);
        if (empty($mm)) {
            $this->error(lang('ds_common_op_fail'), get_referer());
        }
        if ($mm['joinin_state'] == '20') {
            
        }
        $store_name = $mm['store_name'];
        $store_model = model('store');
        $scount = $store_model->getStoreCount($condition);
        if ($scount > 0) {
            $this->error('操作失败已有店铺在运营', get_referer());
        }
        // 完全删除店铺入驻
        $store_joinin->delStorejoinin($condition);
        $this->log("删除店铺入驻:" . $store_name);
        ds_json_encode('10000', lang('ds_common_del_succ'));
    }

    public function newshop_add() {
        if (!request()->isPost()) {
            return $this->fetch('store_newshop_add');
        } else {

            $memberName = input('post.member_name');
            $memberPasswd = (string)input('post.member_password');
            $seller_name = input('post.seller_name');
            $store_name = input('post.store_name');

            if (strlen($memberName) < 3 || strlen($memberName) > 15 || strlen($seller_name) < 3 || strlen($seller_name) > 15)
                $this->error('账号名称必须是3~15位');

            if (strlen($memberPasswd) < 6)
                $this->error('登录密码不能短于6位');

            if (!$this->checkMemberName($memberName))
                $this->error('店主账号已被占用');

            if (!$this->checkSellerName($seller_name))
                $this->error('店主卖家账号名称已被其它店铺占用');

            try {
                $memberId = model('member')->addMember(array(
                    'member_name' => $memberName,
                    'member_password' => $memberPasswd,
                    'member_email' => '',
                ));
            } catch (Exception $ex) {
                $this->error('店主账号新增失败');
            }

            $store_model = model('store');

            $saveArray = array();
            $saveArray['store_name'] = $store_name;
            $saveArray['member_id'] = $memberId;
            $saveArray['member_name'] = $memberName;
            $saveArray['seller_name'] = $seller_name;
            $saveArray['bind_all_gc'] = 1;
            $saveArray['store_state'] = 1;
            $saveArray['store_addtime'] = time();
            $saveArray['is_platform_store'] = 0;
            $saveArray['grade_id'] = 1;

            $storeId = $store_model->addStore($saveArray);

            model('seller')->addSeller(array(
                'seller_name' => $seller_name,
                'member_id' => $memberId,
                'store_id' => $storeId,
                'sellergroup_id' => 0,
                'is_admin' => 1,
            ));
            model('storejoinin')->addStorejoinin(array(
                'seller_name' => $seller_name,
                'store_name' => $store_name,
                'member_name' => $memberName,
                'member_id' => $memberId,
                'joinin_state' => 40,
                'company_province_id' => 0,
                'storeclass_bail' => 0,
                'joinin_year' => 1,
            ));

            // 添加相册默认
            $album_model = model('album');
            $album_arr = array();
            $album_arr['aclass_name'] = '默认相册';
            $album_arr['store_id'] = $storeId;
            $album_arr['aclass_des'] = '';
            $album_arr['aclass_sort'] = '255';
            $album_arr['aclass_cover'] = '';
            $album_arr['aclass_uploadtime'] = time();
            $album_arr['aclass_isdefault'] = '1';
            $album_model->addAlbumclass($album_arr);

            //插入店铺扩展表
            $store_model->addStoreextend(array('store_id' => $storeId));
            // 删除自营店id缓存
            model('store')->dropCachedOwnShopIds();

            $this->log("新增外驻店铺: {$saveArray['store_name']}");
            dsLayerOpenSuccess(lang('ds_common_op_succ'), url('Store/store'));
        }
    }

    public function check_seller_name() {
        echo json_encode($this->checkSellerName(input('param.seller_name')));
        exit;
    }

    private function checkSellerName($sellerName) {
        // 判断store_joinin是否存在记录
        $count = (int) model('storejoinin')->getStorejoininCount(array(
                    'seller_name' => $sellerName,
        ));
        if ($count > 0)
            return false;

        $seller = model('seller')->getSellerInfo(array(
            'seller_name' => $sellerName,
        ));
        if (!empty($seller)){
            return false;
        }
        return TRUE;
    }

    public function check_member_name() {
        echo json_encode($this->checkMemberName(input('param.member_name')));
        exit;
    }

    private function checkMemberName($memberName) {
        // 判断store_joinin是否存在记录
        $count = (int) model('storejoinin')->getStorejoininCount(array(
                    'member_name' => $memberName,
        ));
        if ($count > 0)
            return false;

        return !model('member')->getMemberCount(array(
                    'member_name' => $memberName,
        ));
    }

    /**
     * 验证店铺名称是否存在
     */
    public function ckeck_store_name() {
        /**
         * 实例化卖家模型
         */
        $where = array();
        $where['store_name'] = input('param.store_name');
        $where['store_id'] = array('neq', input('param.store_id'));
        $store_info = model('store')->getStoreInfo($where);
        if (!empty($store_info['store_name'])) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    /**
     * 验证店铺名称是否存在
     */
    private function ckeckStoreName($store_name) {
        /**
         * 实例化卖家模型
         */
        $where = array();
        $where['store_name'] = $store_name;
        $store_info = model('store')->getStoreInfo($where);
        if (!empty($store_info['store_name'])) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'store',
                'text' => '管理',
                'url' => url('Store/store')
            ), array(
                'name' => 'store_joinin',
                'text' => '开店申请',
                'url' => url('Store/store_joinin')
            ), array(
                'name' => 'reopen_list',
                'text' => '续签申请',
                'url' => url('Store/reopen_list')
            ), array(
                'name' => 'store_bind_class_applay_list',
                'text' => '经营类目申请',
                'url' => url('Store/store_bind_class_applay_list')
            ), array(
                'name' => 'newshop_add',
                'text' => '新增店铺',
                'url' => "javascript:dsLayerOpen('".url('Store/newshop_add')."','新增用户')"
            )
        );
        if(request()->action()=='store_bind_class'){
            $menu_array[]=[
                'name'=>'store_bind_class','text'=>'编辑经营类目','url'=>'#'
            ];
        }
        return $menu_array;
    }

}

?>
