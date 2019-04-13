<?php

namespace app\home\controller;

use think\Lang;

class Sellerjoininc2c extends BaseMember {

    private $joinin_detail = NULL;

    public function __construct() {
        parent::__construct();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerjoinin.lang.php');
        $this->checkLogin();

        $seller_model = model('seller');
        $seller_info = $seller_model->getSellerInfo(array('member_id' => session('member_id')));
        if (!empty($seller_info)) {
            $this->success('您已经是店铺的子账户,请直接登录店铺',url('Sellerlogin/login'));
            exit;
        }
        
        if (request()->action() != 'check_seller_name_exist' && request()->action() != 'checkname') {
            $this->check_joinin_state();
        }
        
        $phone_array = explode(',', config('site_phone'));
        $this->assign('phone_array', $phone_array);
        $help_model = model('help');
        $condition = array();
        $condition['helptype_id'] = '99'; //默认显示入驻流程;
        $help_list = $help_model->getShowStoreHelpList($condition);
        $this->assign('help_list', $help_list); //左侧帮助类型及帮助
        $this->assign('show_sign', 'joinin');
        $this->assign('html_title', config('site_name') . ' - ' . '商家入驻');
        $this->assign('article_list', ''); //底部不显示文章分类
        
    }

    private function check_joinin_state() {
        $storejoinin_model = model('storejoinin');
        $joinin_detail = $storejoinin_model->getOneStorejoinin(array('member_id' => session('member_id')));
        if (!empty($joinin_detail)) {
            $this->joinin_detail = $joinin_detail;
            switch (intval($joinin_detail['joinin_state'])) {
                case STORE_JOIN_STATE_NEW:
                    $this->dostep4();
                    $this->show_join_message('入驻申请已经提交，请等待管理员审核', FALSE, '3');
                    break;
                case STORE_JOIN_STATE_PAY:
                    $this->show_join_message('已经提交，请等待管理员核对后为您开通店铺', FALSE, '4');
                    break;
                case STORE_JOIN_STATE_VERIFY_SUCCESS:
                    if (!in_array(request()->action(), array('pay', 'pay_save'))) {
                        $this->pay();
                    }
                    break;
                case STORE_JOIN_STATE_VERIFY_FAIL:
                    if (!in_array(request()->action(), array('step1', 'step2', 'step3', 'step4'))) {
                        $this->show_join_message('审核失败:' . $joinin_detail['joinin_message'], HOME_SITE_URL . DS . '/sellerjoininc2c/step0');
                    }
                    break;
                case STORE_JOIN_STATE_PAY_FAIL:
                    if (!in_array(request()->action(), array('pay', 'pay_save'))) {
                        $this->show_join_message('付款审核失败:' . $joinin_detail['joinin_message'], HOME_SITE_URL . DS . '/sellerjoininc2c/pay');
                    }
                    break;
                case STORE_JOIN_STATE_FINAL:
                    $this->success('您已经开通了店铺,请直接登录店铺',url('Sellerlogin/login'));
                    break;
            }
        }
    }

    public function index() {
        $this->step0();
    }

    public function step0() {
        $document_model = model('document');
        $document_info = $document_model->getOneDocumentByCode('open_store');
        $this->assign('agreement', htmlspecialchars_decode($document_info['document_content']));
        $this->assign('step', 'step1');
        $this->assign('sub_step', 'step0');
        echo $this->fetch($this->template_dir . 'step0');exit;
    }

    public function step1() {
        $this->assign('step', 'step2');
        $this->assign('sub_step', 'step1');
        return $this->fetch($this->template_dir . 'step1');
    }

    public function step2() {
        if (request()->isPost()) {
            $param = array();
            $param['member_name'] = session('member_name');
            $param['company_name'] = input('post.company_name');
            $param['company_address'] = input('post.company_address');
            $param['store_longitude']=input('post.longitude');
            $param['store_latitude']=input('post.latitude');
            $param['company_address_detail'] = input('post.company_address_detail');
            $param['company_province_id'] = input('post.district_id') ?input('post.district_id'):(input('post.city_id')?input('post.city_id'):(input('post.province_id')?input('post.province_id'):0));
            $param['contacts_name'] = input('post.contacts_name');
            $param['contacts_phone'] = input('post.contacts_phone');
            $param['contacts_email'] = input('post.contacts_email');
            $param['business_licence_number'] = input('post.business_licence_number');
            $param['business_sphere'] = input('post.business_sphere');
            $param['business_licence_number_electronic'] = $this->upload_image('business_licence_number_electronic');

            $this->step2_save_valid($param);

            $storejoinin_model = model('storejoinin');
            $joinin_info = $storejoinin_model->getOneStorejoinin(array('member_id' => session('member_id')));
            if (empty($joinin_info)) {
                $param['member_id'] = session('member_id');
                $storejoinin_model->addStorejoinin($param);
            } else {
                $storejoinin_model->editStorejoinin($param, array('member_id' => session('member_id')));
            }
        }
        $this->assign('step', 'step2');
        $this->assign('sub_step', 'step2');
        echo $this->fetch($this->template_dir . 'step2');
        exit;
    }

    private function step2_save_valid($param) {
        $sellerjoinin_validate = validate('sellerjoinin');
        if (!$sellerjoinin_validate->scene('step2_save_valid2')->check($param)) {
            $this->error($sellerjoinin_validate->getError());
        }
    }

    public function step3() {
        if (request()->isPost()) {
            $param = array();

            $param['settlement_bank_account_name'] = input('post.settlement_bank_account_name');
            $param['settlement_bank_account_number'] = input('post.settlement_bank_account_number');

            $this->step3_save_valid($param);

            $storejoinin_model = model('storejoinin');
            $storejoinin_model->editStorejoinin($param, array('member_id' => session('member_id')));
        }

        //商品分类
        $gc = model('goodsclass');
        $gc_list = $gc->getGoodsclassListByParentId(0);
        $this->assign('gc_list', $gc_list);

        //店铺等级
        $grade_list = rkcache('storegrade', true);
        //附加功能
        if (!empty($grade_list) && is_array($grade_list)) {
            foreach ($grade_list as $key => $grade) {
                $storegrade_function = explode('|', $grade['storegrade_function']);
                if (!empty($storegrade_function[0]) && is_array($storegrade_function)) {
                    $grade_list[$key]['function_str'] = '';
                    foreach ($storegrade_function as $key1 => $value) {
                        if ($value == 'editor_multimedia') {
                            $grade_list[$key]['function_str'] .= '富文本编辑器';
                        }
                    }
                } else {
                    $grade_list[$key]['function_str'] = '无';
                }
            }
        }
        $this->assign('grade_list', $grade_list);

        //店铺分类
        $storeclass_model = model('storeclass');
        $store_class = $storeclass_model->getStoreclassList(array(), '', false);
        $this->assign('store_class', $store_class);

        $this->assign('step', '3');
        $this->assign('sub_step', 'step3');
        echo $this->fetch($this->template_dir . 'step3');
        exit;
    }

    private function step3_save_valid($param) {
        $sellerjoinin_validate = validate('sellerjoinin');
        if (!$sellerjoinin_validate->scene('step3_save_valid3')->check($param)) {
            $this->error($sellerjoinin_validate->getError());
        }
    }

    public function check_seller_name_exist() {
        $condition = array();
        $condition['seller_name'] = input('get.seller_name');

        $seller_model = model('seller');
        $result = $seller_model->isSellerExist($condition);

        if ($result) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function step4() {
        $store_class_ids = array();
        $store_class_names = array();
        $store_class_ids_array = input('post.store_class_ids/a');#获取数组
        if (!empty($store_class_ids_array)) {
            foreach ($store_class_ids_array as $value) {
                $store_class_ids[] = $value;
            }
        }
        
        $store_class_names_array = input('post.store_class_names/a');#获取数组
        if (!empty($store_class_names_array)) {
            foreach ($store_class_names_array as $value) {
                $store_class_names[] = $value;
            }
        }
        //取最小级分类最新分佣比例
        $sc_ids = array();
        foreach ($store_class_ids as $v) {
            $v = explode(',', trim($v, ','));
            if (!empty($v) && is_array($v)) {
                $sc_ids[] = end($v);
            }
        }
        $store_class_commis_rates = array();
        if (!empty($sc_ids)) {
            $goods_class_list = model('goodsclass')->getGoodsclassListByIds($sc_ids);
            if (!empty($goods_class_list) && is_array($goods_class_list)) {
                $sc_ids = array();
                foreach ($goods_class_list as $v) {
                    $store_class_commis_rates[] = $v['commis_rate'];
                }
            }
        }
        $param = array();
        $param['seller_name'] = input('post.seller_name');
        $param['store_name'] = input('post.store_name');
        $param['store_type'] = 1;
        $param['store_class_ids'] = serialize($store_class_ids);
        $param['store_class_names'] = serialize($store_class_names);
        $param['joinin_year'] = intval(input('post.joinin_year'));
        $param['joinin_state'] = STORE_JOIN_STATE_NEW;
        $param['store_class_commis_rates'] = implode(',', $store_class_commis_rates);

        //取店铺等级信息
        $grade_list = rkcache('storegrade', true);
        
        $storegrade_id = intval(input('post.storegrade_id'));
        if($storegrade_id<=0){
            $this->error(lang('param_error'));
        }
        
        if (!empty($grade_list[$storegrade_id])) {
            $param['storegrade_id'] = $storegrade_id;
            $param['storegrade_name'] = $grade_list[$storegrade_id]['storegrade_name'];
            $param['sg_info'] = serialize(array('storegrade_price' => $grade_list[$storegrade_id]['storegrade_price']));
        }

        //取最新店铺分类信息
        $store_class_info = model('storeclass')->getStoreclassInfo(array('storeclass_id' => intval(input('post.storeclass_id'))));
        if ($store_class_info) {
            $param['storeclass_id'] = $store_class_info['storeclass_id'];
            $param['storeclass_name'] = $store_class_info['storeclass_name'];
            $param['storeclass_bail'] = $store_class_info['storeclass_bail'];
        }

        //店铺应付款
        $param['paying_amount'] = floatval($grade_list[$storegrade_id]['storegrade_price']) * $param['joinin_year'] + floatval($param['storeclass_bail']);
        $this->step4_save_valid($param);
        
        $storejoinin_model = model('storejoinin');
        $storejoinin_model->editStorejoinin($param, array('member_id' => session('member_id')));
        
        header('location:'.url('Sellerjoininc2c/index'));
        exit;
    }

    private function step4_save_valid($param) {
        $sellerjoinin_validate = validate('sellerjoinin');
        if (!$sellerjoinin_validate->scene('step4_save_valid4')->check($param)) {
            $this->error($sellerjoinin_validate->getError());
        }
    }

    public function pay() {
        if (!empty($this->joinin_detail['sg_info'])) {
            $store_grade_info = model('storegrade')->getOneStoregrade($this->joinin_detail['storegrade_id']);
            $this->joinin_detail['storegrade_price'] = $store_grade_info['storegrade_price'];
        } else {
            $this->joinin_detail['sg_info'] = @unserialize($this->joinin_detail['sg_info']);
            if (is_array($this->joinin_detail['sg_info'])) {
                $this->joinin_detail['storegrade_price'] = $this->joinin_detail['sg_info']['storegrade_price'];
            }
        }
        $this->assign('joinin_detail', $this->joinin_detail);
        $this->assign('step', '4');
        $this->assign('sub_step', 'pay');
        echo $this->fetch($this->template_dir . 'pay');
        exit;
    }

    public function pay_save() {
        $param = array();
        $param['paying_money_certificate'] = $this->upload_image('paying_money_certificate');
        $param['paying_money_certificate_explain'] = input('post.paying_money_certificate_explain');
        $param['joinin_state'] = STORE_JOIN_STATE_PAY;

        if (empty($param['paying_money_certificate'])) {
            $this->error('请上传付款凭证');
        }

        $storejoinin_model = model('storejoinin');
        $storejoinin_model->editStorejoinin($param, array('member_id' => session('member_id')));

        header('location:'.url('Sellerjoininc2c/index'));
        exit;
    }

    private function dostep4() {
        if (!empty($this->joinin_detail['sg_info'])) {
            $store_grade_info = model('storegrade')->getOneStoregrade($this->joinin_detail['storegrade_id']);
            $this->joinin_detail['storegrade_price'] = $store_grade_info['storegrade_price'];
        } else {
            $this->joinin_detail['sg_info'] = @unserialize($this->joinin_detail['sg_info']);
            if (is_array($this->joinin_detail['sg_info'])) {
                $this->joinin_detail['storegrade_price'] = $this->joinin_detail['sg_info']['storegrade_price'];
            }
        }
        $this->assign('joinin_detail', $this->joinin_detail);
    }

    private function show_join_message($message, $btn_next = FALSE, $step = 'step2') {
        $this->assign('joinin_detail', $this->joinin_detail);
        $this->assign('joinin_message', $message);
        $this->assign('btn_next', $btn_next);
        $this->assign('step', $step);
        $this->assign('sub_step', 'step4');
        echo $this->fetch($this->template_dir . 'step4');
        exit;
    }

    private function upload_image($file) {
        
        $pic_name= '';
        $upload_file = BASE_UPLOAD_PATH .DS .'home' .DS . 'store_joinin' . DS;
        if (!empty($_FILES[$file]['name'])) {
            $file_object = request()->file($file);
            //设置特殊图片名称
            $file_name = session('member_id') . '_' . date('YmdHis') . rand(10000, 99999);
            $info = $file_object->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, $file_name);
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
     * 检查店铺名称是否存在
     *
     * @param 
     * @return 
     */
    public function checkname() {
        /**
         * 实例化卖家模型
         */
        $store_model = model('store');
        $store_name = input('get.store_name');
        $store_info = $store_model->getStoreInfo(array('store_name' => $store_name));
        if (!empty($store_info['store_name']) && $store_info['member_id'] != session('member_id')) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

}

?>
