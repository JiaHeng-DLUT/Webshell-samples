<?php

namespace app\home\controller;

use think\Image;
use think\Lang;

class Sellersetting extends BaseSeller {

    const MAX_MB_SLIDERS = 5;

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellersetting.lang.php');
    }

    /*
     * 店铺设置
     */

    public function setting() {
        /**
         * 实例化模型
         */
        $store_model = model('store');

        $store_id = session('store_id'); //当前店铺ID
        /**
         * 获取店铺信息
         */
        $store_info = $store_model->getStoreInfoByID($store_id);

        $if_miniprocode=$this->getMiniProCode(1);
        $this->assign('miniprogram_code',$if_miniprocode?(UPLOAD_SITE_URL . DS . ATTACH_STORE . DS . session('store_id').'/miniprogram_code.png'):'');
        /**
         * 保存店铺设置
         */
        if (request()->isPost()) {
            /**
             * 更新入库
             */
            $param = array(
                'store_qq' => input('post.store_qq'),
                'store_ww' => input('post.store_ww'),
                'store_phone' => input('post.store_phone'),
                'store_mainbusiness' => input('post.store_mainbusiness'),
                'store_keywords' => input('post.seo_keywords'),
                'store_description' => input('post.seo_description')
            );

            $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . $store_id;
            $file_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999);

            if (!empty(input('post.store_name'))) {
                $store = $store_model->getStoreInfo(array('store_name' => input('param.store_name')));
                //店铺名存在,则提示错误
                if (!empty($store) && ($store_id != $store['store_id'])) {
                    $this->error(lang('please_change_another_name'));
                }
                $param['store_name'] = input('post.store_name');
            }
            //店铺名称修改处理
            if (input('param.store_name') != $store_info['store_name'] && !empty(input('post.store_name'))) {
                $where = array();
                $where['store_id'] = $store_id;
                $update = array();
                $update['store_name'] = input('param.store_name');
                db('goodscommon')->where($where)->update($update);
                db('goods')->where($where)->update($update);
            }

            $this->getMiniProCode(1);
            $store_model->editStore($param, array('store_id' => $store_id));
            $this->success(lang('ds_common_save_succ'), url('Sellersetting/setting'));
        }
        /**
         * 实例化店铺等级模型
         */
        // 从基类中读取店铺等级信息
        $store_grade = $this->store_grade;

        //编辑器多媒体功能
        $editor_multimedia = false;
        $sg_fun = @explode('|', $store_grade['storegrade_function']);
        if (!empty($sg_fun) && is_array($sg_fun)) {
            foreach ($sg_fun as $fun) {
                if ($fun == 'editor_multimedia') {
                    $editor_multimedia = true;
                }
            }
        }
        $this->assign('editor_multimedia', $editor_multimedia);

        /**
         * 输出店铺信息
         */
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('seller_setting');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('store_setting');
        $this->assign('store_info', $store_info);
        $this->assign('store_grade', $store_grade);
        /**
         * 页面输出
         */
        return $this->fetch($this->template_dir . 'setting');
    }

    public function getMiniProCode($force=0){
        if($force || !file_exists(BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . session('store_id').'/miniprogram_code.png')){
            model('wechat')->getOneWxconfig();
            $a=model('wechat')->getMiniProCode(session('store_id'));
            if(@imagecreatefromstring($a)==false){
                $a= json_decode($a);
                //$this->assign('errmsg',$a->errmsg);
            }else{
                if (is_dir(BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . session('store_id')) || (!is_dir(BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . session('store_id')) && mkdir(BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . session('store_id'), 0755, true))) {
                    file_put_contents(BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . session('store_id').'/miniprogram_code.png', $a);
                    return true;
                } else {
                    //$this->assign('errmsg','没有权限生成目录');
                }
                
            }
            
        }else{
            return true;
        }
        return false;
    }
    public function store_image_upload() {
        $store_id = session('store_id');
        $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . $store_id;
        $file_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999);
        $store_image_name = input('param.id');

        if (!in_array($store_image_name, array('store_logo', 'store_banner', 'store_avatar'))) {
            exit;
        }

        if (!empty($_FILES[$store_image_name]['name'])) {
            $file_object = request()->file($store_image_name);
            $info = $file_object->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, $file_name);
            if ($info) {
                $file_name = $info->getFilename();

                /* 处理图片 */
                $image = Image::open($upload_file . DS . $file_name);
                switch ($store_image_name) {
                    case 'store_logo':
                        $image->thumb(200, 60, \think\Image::THUMB_CENTER)->save($upload_file . DS . $file_name);
                        break;
                    case 'store_banner':
                        $image->thumb(1000, 250, \think\Image::THUMB_CENTER)->save($upload_file . DS . $file_name);
                        break;
                    case 'store_avatar':
                        $image->thumb(100, 100, \think\Image::THUMB_CENTER)->save($upload_file . DS . $file_name);
                        break;
                    default:
                        break;
                }
            } else {
                json_encode(array('error' => $file_object->getError()));
                exit;
            }
        }
        $store_model = model('store');
        //删除原图
        $store_info = $store_model->getStoreInfoByID($store_id);
        @unlink($upload_file . DS . $store_info[$store_image_name]);
        $result = $store_model->editStore(array($store_image_name => $file_name), array('store_id' => $store_id));
        if ($result) {
            $data = array();
            $data['file_name'] = $file_name;
            $data['file_path'] = UPLOAD_SITE_URL . '/' . ATTACH_STORE . '/' . $store_id . '/' . $file_name;
            /**
             * 整理为json格式
             */
            $output = json_encode($data);
            echo $output;
            exit;
        }
    }

    /**
     * 店铺幻灯片
     */
    public function store_slide() {
        /**
         * 模型实例化
         */
        $store_model = model('store');
        $upload_model = model('upload');
        /**
         * 保存店铺信息
         */
        if (request()->isPost()) {
            // 更新店铺信息
            $update = array();
            $update['store_slide'] = implode(',', input('post.image_path/a'));
            $update['store_slide_url'] = implode(',', input('post.image_url/a'));
            $store_model->editStore($update, array('store_id' => session('store_id')));

            // 删除upload表中数据
            $upload_model->delUpload(array('upload_type' => 3, 'item_id' => session('store_id')));
            ds_json_encode(10000,lang('ds_common_save_succ'));
        } else {
            // 删除upload中的无用数据
            $upload_info = $upload_model->getUploadList(array('upload_type' => 3, 'item_id' => session('store_id')), 'file_name');
            if (is_array($upload_info) && !empty($upload_info)) {
                foreach ($upload_info as $val) {
                    @unlink(BASE_UPLOAD_PATH . DS . ATTACH_SLIDE . DS . $val['file_name']);
                }
            }
            $upload_model->delUpload(array('upload_type' => 3, 'item_id' => session('store_id')));

            $store_info = $store_model->getStoreInfoByID(session('store_id'));
            if ($store_info['store_slide'] != '' && $store_info['store_slide'] != ',,,,') {
                $this->assign('store_slide', explode(',', $store_info['store_slide']));
                $this->assign('store_slide_url', explode(',', $store_info['store_slide_url']));
            }
            $this->setSellerCurMenu('seller_setting');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('store_slide');
            return $this->fetch($this->template_dir . 'slide');
        }
    }

    /**
     * 店铺幻灯片ajax上传
     */
    public function silde_image_upload() {
        $file_id = intval(input('param.file_id'));
        $id = input('param.id');
        if($file_id<0 || empty($id)){
            return;
        }
        
        $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_SLIDE;
        $file_name = session('store_id') . '_' . $file_id;
        $file = request()->file($id);
        $result = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, $file_name);
        if ($result) {
            $img_path = $result->getFilename();
        } else {
            echo json_encode($file->getError());
            die;
        }

        $output = array();
        if ($result) {
            $output['file_id'] = $file_id;
            $output['id'] = $id;
            $output['file_name'] = $img_path;
            echo json_encode($output);exit;
        } else {
            $output['error'] = $file->getError();
            echo json_encode($output);
            die;
        }
    }

    /**
     * ajax删除幻灯片图片
     */
    public function dorp_img() {
        $file_id = intval(input('param.file_id'));
        $img_src = input('param.img_src');
        if($file_id<0 || empty($img_src)){
            return;
        }
        $ext =  strrchr($img_src, '.');
        $file_name = session('store_id') . '_' . $file_id .$ext;
        @unlink(BASE_UPLOAD_PATH . DS . ATTACH_SLIDE . DS . $file_name);
        echo json_encode(array('succeed' => lang('ds_common_save_succ')));
        die;
    }

    /**
     * 卖家店铺主题设置
     *
     * @param string
     * @param string
     * @return
     */
    public function theme() {
        /**
         * 店铺信息
         */
        $store_class = model('store');
        $store_info = $store_class->getStoreInfoByID(session('store_id'));
        /**
         * 主题配置信息
         */
        $style_data = array();
        $style_configurl = PUBLIC_PATH . '/static/home/default/store/styles/' . "styleconfig.php";

        if (file_exists($style_configurl)) {
            include_once($style_configurl);
        }
        /**
         * 当前店铺主题
         */
        $curr_store_theme = !empty($store_info['store_theme']) ? $store_info['store_theme'] : 'default';
        /**
         * 当前店铺预览图片
         */
        $curr_image = BASE_SITE_ROOT . '/static/home/default/store/styles/' . $curr_store_theme . '/images/preview.jpg';

        $curr_theme = array(
            'curr_name' => $curr_store_theme,
            'curr_truename' => $style_data[$curr_store_theme]['truename'],
            'curr_image' => $curr_image
        );

        // 自营店全部可用
        if (check_platform_store()) {
            $themes = array_keys($style_data);
        } else {
            /**
             * 店铺等级
             */
            $grade_class = model('storegrade');
            $grade = $grade_class->getOneStoregrade($store_info['grade_id']);

            /**
             * 可用主题
             */
            $themes = explode('|', $grade['storegrade_template']);
        }
        $theme_list = array();
        /**
         * 可用主题预览图片
         */
        foreach ($style_data as $key => $val) {
            if (in_array($key, $themes)) {
                $theme_list[$key] = array(
                    'name' => $key, 'truename' => $val['truename'],
                    'image' => BASE_SITE_ROOT . '/static/home/default/store/styles/' . $key . '/images/preview.jpg'
                );
            }
        }
        /**
         * 页面输出
         */
        $this->setSellerCurMenu('seller_setting');
        $this->setSellerCurItem('store_theme');

        $this->assign('store_info', $store_info);
        $this->assign('curr_theme', $curr_theme);
        $this->assign('theme_list', $theme_list);
        return $this->fetch($this->template_dir . 'theme');
    }

    /**
     * 卖家店铺主题设置
     *
     * @param string
     * @param string
     * @return
     */
    public function set_theme() {
        //读取语言包
        $style = input('param.style_name');
        $style = isset($style) ? trim($style) : null;
        if (!empty($style) && file_exists(PUBLIC_PATH . '/static/home/default/store/styles/theme/' . $style . '/images/preview.jpg')) {
            $store_class = model('store');
            $rs = $store_class->editStore(array('store_theme' => $style), array('store_id' => session('store_id')));
            ds_json_encode(10000,lang('store_theme_congfig_success'));
        } else {
            ds_json_encode(10001,lang('store_theme_congfig_fail'));
        }
    }

    protected function getStoreMbSliders() {
        $store_info = model('store')->getStoreInfoByID(session('store_id'));

        $mbSliders = @unserialize($store_info['mb_sliders']);
        if (!$mbSliders) {
            $mbSliders = array_fill(1, self::MAX_MB_SLIDERS, array(
                'img' => '', 'type' => 1, 'link' => '',
            ));
        }

        return $mbSliders;
    }

    protected function setStoreMbSliders(array $mbSliders) {
        return model('store')->editStore(array(
                    'mb_sliders' => serialize($mbSliders),
                        ), array(
                    'store_id' => session('store_id'),
        ));
    }

    public function store_mb_sliders() {
        try {
            //上传文件名称
            $fileName = input('param.id');
            //文件ID
            $file_id = intval(input('param.file_id'));
            if (!preg_match('/^file_(\d+)$/', $fileName, $fileIndex) || empty($_FILES[$fileName]['name'])) {
                exception(lang('param_error'));
            }

            $fileIndex = (int) $fileIndex[1];
            if ($fileIndex < 1 || $fileIndex > self::MAX_MB_SLIDERS) {
                exception(lang('param_error'));
            }

            $mbSliders = $this->getStoreMbSliders();
            $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . 'mobileslide';
            $file_name = session('store_id') . '_' . $file_id;
            $file_object = request()->file($fileName);
            $info = $file_object->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, $file_name);
            if ($info) {
                $newImg = $info->getFilename();
            } else {
                exception($file_object->getError());
            }
            $oldImg = $mbSliders[$fileIndex]['img'];
            $mbSliders[$fileIndex]['img'] = $newImg;
            //即时更新
            $this->setStoreMbSliders($mbSliders);
            if ($oldImg && file_exists($oldImg)) {
                unlink($oldImg);
            }
            echo json_encode(array(
                'uploadedUrl' => UPLOAD_SITE_URL . DS . ATTACH_STORE . DS . 'mobileslide' . DS . $newImg,
            ));
            die;
        } catch (\Exception $ex) {
            echo json_encode(array(
                'error' => $ex->getMessage(),
            ));
            die;
        }
    }

    public function store_mb_sliders_drop() {
        try {
            $id = (int) $_REQUEST['id'];
            if ($id < 1 || $id > self::MAX_MB_SLIDERS) {
                exception(lang('param_error'));
            }
            $mbSliders = $this->getStoreMbSliders();
            $mbSliders[$id]['img'] = '';
            if (!$this->setStoreMbSliders($mbSliders)) {
                exception(lang('update_failed'));
            }
            echo json_encode(array(
                'success' => true,
            ));
        } catch (\Exception $ex) {
            echo json_encode(array(
                'success' => false, 'error' => $ex->getMessage(),
            ));
        }
    }

    public function store_mobile() {
        $this->assign('max_mb_sliders', self::MAX_MB_SLIDERS);

        $store_info = model('store')->getStoreInfoByID(session('store_id'));

        // 页头背景图
        $mb_title_img = $store_info['mb_title_img'] ? UPLOAD_SITE_URL . '/' . ATTACH_STORE . '/' . $store_info['mb_title_img'] : '';

        // 轮播
        $mbSliders = $this->getStoreMbSliders();

        if (request()->isPost()) {
            $update_array = array();

            if ($mb_title_img_del = !empty(input('post.mb_title_img_del'))) {
                $update_array['mb_title_img'] = '';
            }
            if (!empty($_FILES['mb_title_img']['name'])) {
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_STORE;
                $file_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999);
                $file_object = request()->file('mb_title_img');
                $result = $file_object->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, $file_name);
                if ($result) {
                    $mb_title_img_del = true;
                    $update_array['mb_title_img'] = $result->getFilename();
                } else {
                    $this->error($file_object->getError());
                }
            }
            if ($mb_title_img_del && $mb_title_img && file_exists($mb_title_img)) {
                unlink($mb_title_img);
            }

            // mb_sliders
            $skuToValid = array();
            $mb_sliders_links_array = input('post.mb_sliders_links/a');#获取数组
            $mb_sliders_type_array = input('post.mb_sliders_type/a');#获取数组
            $mb_sliders_sort_array = input('post.mb_sliders_sort/a');#获取数组
            
            foreach ($mb_sliders_links_array as $k => $v) {
                if ($k < 1 || $k > self::MAX_MB_SLIDERS) {
                    $this->error(lang('param_error'));
                }

                $type = intval($mb_sliders_type_array[$k]);
                switch ($type) {
                    case 1:
                        // 链接URL
                        $v = (string) $v;
                        if (!preg_match('#^https?://#', $v)) {
                            $v = '';
                        }
                        break;

                    case 2:
                        // 商品ID
                        $v = (int) $v;
                        if ($v < 1) {
                            $v = '';
                        } else {
                            $skuToValid[$k] = $v;
                        }
                        break;

                    default:
                        $type = 1;
                        $v = '';
                        break;
                }

                $mbSliders[$k]['type'] = $type;
                $mbSliders[$k]['link'] = $v;
            }

            if ($skuToValid) {
                $validSkus = db('goods')->field('goods_id')->where(array('goods_id' => array('in', $skuToValid), 'store_id' => session('store_id'),))->select();
                if (!empty($validSkus)) {
                    $validSkus = ds_change_arraykey($validSkus, 'goods_id');
                }
                foreach ($skuToValid as $k => $v) {
                    if (!isset($validSkus[$v])) {
                        $mbSliders[$k]['link'] = '';
                    }
                }
            }

            // sort
            for ($i = 0; $i < self::MAX_MB_SLIDERS; $i++) {
                $sortedMbSliders[$i + 1] = @$mbSliders[$mb_sliders_sort_array[$i]];
            }

            $update_array['mb_sliders'] = serialize($sortedMbSliders);

            model('store')->editStore($update_array, array(
                'store_id' => session('store_id'),
            ));
            $this->success(lang('save_success'), url('Sellersetting/store_mobile'));
        }

        $mbSliderUrls = array();
        foreach ($mbSliders as $v) {
            if ($v['img']) {
                $mbSliderUrls[] = UPLOAD_SITE_URL . DS . ATTACH_STORE . DS . 'mobileslide' . DS . $v['img'];
            }
        }

        $this->assign('mb_title_img', $mb_title_img);
        $this->assign('mbSliders', $mbSliders);
        $this->assign('mbSliderUrls', $mbSliderUrls);
        $this->setSellerCurMenu('seller_setting');
        $this->setSellerCurItem('store_mobile');
        return $this->fetch($this->template_dir . 'store_mobile');
    }

    public function map() {
        $this->setSellerCurMenu('seller_setting');
        $this->setSellerCurItem('store_map');
        /**
         * 实例化模型
         */
        $store_model = model('store');

        $store_id = session('store_id'); //当前店铺ID
        /**
         * 获取店铺信息
         */
        $store_info = $store_model->getStoreInfoByID($store_id);

        /**
         * 保存店铺设置
         */
        if (request()->isPost()) {
            model('store')->editStore(array(
                'store_address' => input('post.company_address_detail'),
                'region_id' => input('post.district_id') ? input('post.district_id') : (input('post.city_id') ? input('post.city_id') : (input('post.province_id') ? input('post.province_id') : 0)),
                'area_info' => input('post.company_address'),
                'store_longitude' => input('post.longitude'),
                'store_latitude' => input('post.latitude')
                    ), array(
                'store_id' => session('store_id'),
            ));
            ds_json_encode(10000,lang('save_success'));
        }
        $this->assign('store_info', $store_info);
        $this->assign('baidu_ak', config('baidu_ak'));
        return $this->fetch($this->template_dir . 'map');
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $name 当前导航的name
     * @return
     */
    protected function getSellerItemList() {
        $menu_array = array(
            1 => array(
                'name' => 'store_setting', 'text' => lang('ds_member_path_store_config'),
                'url' => url('Sellersetting/setting')
            ),
            2 => array(
                'name' => 'store_map', 'text' => lang('ds_member_path_store_map'),
                'url' => url('Sellersetting/map')
            ),
            4 => array(
                'name' => 'store_slide', 'text' => lang('ds_member_path_store_slide'),
                'url' => url('Sellersetting/store_slide')
            ), 5 => array(
                'name' => 'store_theme', 'text' => lang('store_theme'), 'url' => url('Sellersetting/theme')
            ),
            7 => array(
                'name' => 'store_mobile', 'text' => lang('mobile_phone_store_settings'), 'url' => url('Sellersetting/store_mobile'),
            ),
        );
        return $menu_array;
    }

}

?>
