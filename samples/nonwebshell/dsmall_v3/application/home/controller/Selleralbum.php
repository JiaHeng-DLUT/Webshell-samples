<?php

namespace app\home\controller;

use think\Lang;

class Selleralbum extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/selleralbum.lang.php');
    }

    public function index() {
        $this->album_cate();
        exit;
    }

    /**
     * 相册分类列表
     *
     */
    public function album_cate() {
        $album_model = model('album');

        /**
         * 验证是否存在默认相册
         */
        $return = $album_model->checkAlbum(array('store_id' => session('store_id'), 'aclass_isdefault' => '1'));
        if (!$return) {
            $album_arr = array();
            $album_arr['aclass_name'] = lang('album_default_album');
            $album_arr['store_id'] = session('store_id');
            $album_arr['aclass_des'] = '';
            $album_arr['aclass_sort'] = '255';
            $album_arr['aclass_cover'] = '';
            $album_arr['aclass_uploadtime'] = time();
            $album_arr['aclass_isdefault'] = '1';
            $album_model->addAlbumclass($album_arr);
        }
        /**
         * 相册分类
         */
        $condition['store_id'] = session('store_id');
        $order = 'aclass_sort desc';
        $sort = input('get.sort');
        if ($sort != '') {
            switch ($sort) {
                case '0':
                    $order = 'aclass_uploadtime desc';
                    break;
                case '1':
                    $order = 'aclass_uploadtime asc';
                    break;
                case '2':
                    $order = 'aclass_name desc';
                    break;
                case '3':
                    $order = 'aclass_name asc';
                    break;
                case '4':
                    $order = 'aclass_sort desc';
                    break;
                case '5':
                    $order = 'aclass_sort asc';
                    break;
            }
        }
        $aclass_info = $album_model->getAlbumclassList($condition, '', $order);
        $this->assign('aclass_info', $aclass_info);
        $this->assign('PHPSESSID', session_id());
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('selleralbum');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('album_cate');
        echo $this->fetch($this->template_dir . 'album_cate');
        exit;
    }

    /**
     * 相册分类添加
     *
     */
    public function album_add() {
        /**
         * 实例化相册模型
         */
        $album_model = model('album');
        $class_count = $album_model->getAlbumclassCount(session('store_id'));
        $this->assign('class_count', $class_count);
        return $this->fetch($this->template_dir . 'album_add');
    }

    /**
     * 相册保存
     *
     */
    public function album_add_save() {
        if (request()->isPost()) {
            /**
             * 实例化相册模型
             */
            $album_model = model('album');
            $class_count = $album_model->getAlbumclassCount(session('store_id'));
            if ($class_count['count'] >= 20) {
                ds_json_encode(10001,lang('album_class_save_max_20'));
            }
            /**
             * 实例化相册模型
             */
            $param = array();
            $param['aclass_name'] = input('post.name');
            $param['store_id'] = session('store_id');
            $param['aclass_des'] = input('post.description');
            $param['aclass_sort'] = input('post.sort');
            $param['aclass_uploadtime'] = time();

            $selleralbum_validate = validate('selleralbum');
            if (!$selleralbum_validate->scene('album_add_save')->check($param)){
                ds_json_encode(10001,$selleralbum_validate->getError());
            }

            $return = $album_model->addAlbumclass($param);
            if ($return) {
                ds_json_encode(10000,lang('album_class_save_succeed'));
            }
        }
        ds_json_encode(10001,lang('album_class_save_lose'));
    }

    /**
     * 相册分类编辑
     */
    public function album_edit() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            echo lang('album_parameter_error');
            exit;
        }
        /**
         * 实例化相册模型
         */
        $album_model = model('album');
        $condtion['aclass_id'] = $id;
        $condtion['store_id'] = session('store_id');
        $class_info = $album_model->getOneAlbumclass($condtion);
        $this->assign('class_info', $class_info);

        return $this->fetch($this->template_dir . 'album_edit');
    }

    /**
     * 相册分类编辑保存
     */
    public function album_edit_save() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            ds_json_encode(10001,lang('album_parameter_error'));
        }
        $param = array();
        $param['aclass_name'] = input('post.name');
        $param['aclass_des'] = input('post.description');
        $param['aclass_sort'] = input('post.sort');

        $selleralbum_validate = validate('selleralbum');
        if (!$selleralbum_validate->scene('album_edit_save')->check($param)){
            ds_json_encode(10001,$selleralbum_validate->getError());
        }

        /**
         * 实例化相册模型
         */
        $album_model = model('album');
        /**
         * 验证
         */
        $return = $album_model->checkAlbum(array('store_id' => session('store_id'), 'aclass_id' => $id));
        if ($return) {
            /**
             * 更新
             */
            $re = $album_model->editAlbumclass($param, $id);
            if ($re) {
                ds_json_encode(10000,lang('album_class_edit_succeed'));
            }
        } else {
            ds_json_encode(10001,lang('album_class_edit_lose'));
        }
    }

    /**
     * 相册删除
     */
    public function album_del() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            ds_json_encode(10001,lang('album_parameter_error'));
        }
        /**
         * 实例化相册模型
         */
        $album_model = model('album');

        /**
         * 验证是否为默认相册，
         */
        $return = $album_model->checkAlbum(array('store_id' => session('store_id'), 'aclass_id' => $id, 'aclass_isdefault' => '0'));
        if (!$return) {
            ds_json_encode(10001,lang('album_class_file_del_lose'));
        }
        /**
         * 删除分类
         */
        $condition = array();
        $condition['aclass_id'] = $id;
        $return = $album_model->delAlbumclass($condition);
        if (!$return) {
            ds_json_encode(10001,lang('album_class_file_del_lose'));
        }
        /**
         * 更新图片分类
         */
        $condition = array();
        $condition['aclass_isdefault'] = 1;
        $condition['store_id'] = session('store_id');
        $class_info = $album_model->getOneAlbumclass($condition);
        $param = array();
        $param['aclass_id'] = $class_info['aclass_id'];
        $album_model->editAlbumpic($param, array('aclass_id' => $id));
        if ($return) {
            ds_json_encode(10000,lang('album_class_file_del_succeed'));
        } else {
            ds_json_encode(10001,lang('album_class_file_del_lose'));
        }
    }

    /**
     * 图片列表
     */
    public function album_pic_list() {
        $id = intval(input('param.id'));
        if ($id <= 0) {
            $this->error(lang('album_parameter_error'));
        }

        /**
         * 实例化相册类
         */
        $album_model = model('album');

        $param = array();
        $param['aclass_id'] = $id;
        $param['store_id'] = session('store_id');
        $order = input('get.sort');
        switch ($order) {
            case '0':
                $order = 'apic_uploadtime desc';
                break;
            case '1':
                $order = 'apic_uploadtime asc';
                break;
            case '2':
                $order = 'apic_size desc';
                break;
            case '3':
                $order = 'apic_size asc';
                break;
            case '4':
                $order = 'apic_name desc';
                break;
            case '5':
                $order = 'apic_name asc';
                break;
            default :
                $order = 'apic_uploadtime desc';
                break;
        }
        $pic_list = $album_model->getAlbumpicList($param, 10, '*', $order);
        $this->assign('pic_list', $pic_list);
        $this->assign('show_page', $album_model->page_info->render());

        /**
         * 相册列表，移动
         */
        $param = array();
        $param['aclass_id'] = array('not in', $id);
        $param['store_id'] = session('store_id');
        $class_list = $album_model->getAlbumclassList($param);
        $this->assign('class_list', $class_list);
        /**
         * 相册信息
         */
        $condition['aclass_id'] = $id;
        $condition['store_id'] = session('store_id');
        $class_info = $album_model->getOneAlbumclass($condition);
        $this->assign('class_info', $class_info);

        $this->assign('PHPSESSID', session_id());

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('selleralbum');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('pic_list');
        return $this->fetch($this->template_dir . 'album_pic_list');
    }

    /**
     * 图片列表，外部调用
     */
    public function pic_list() {
        /**
         * 实例化相册类
         */
        $album_model = model('album');
        /**
         * 图片列表
         */
        $param = array();
        $param['store_id'] = session('store_id');
        $id = intval(input('param.id'));
        if ($id > 0) {
            $param['aclass_id'] = $id;
            /**
             * 分类列表
             */
            $condition = array();
            $condition['aclass_id'] = $id;
            $condition['store_id'] = session('store_id');
            $cinfo = $album_model->getOneAlbumclass($condition);
            $this->assign('class_name', $cinfo['aclass_name']);
        }
        $pic_list = $album_model->getAlbumpicList($param, 12);
        foreach($pic_list as $key => $val){
            $pic_list[$key]['apic_name']=UPLOAD_SITE_URL . '/' . ATTACH_GOODS . '/' . $val['store_id'] . '/' . $val['apic_name'];
        }
        $this->assign('pic_list', $pic_list);
        $this->assign('show_page', $album_model->page_info->render());
        /**
         * 分类列表
         */
        $condition = array();
        $condition['store_id'] = session('store_id');
        $class_info = $album_model->getAlbumclassList($condition);
        $this->assign('class_list', $class_info);

        $item = input('param.item');
        switch ($item) {
            case 'goods':
                return $this->fetch($this->template_dir . 'pic_list_goods');
                break;
            case 'des':
                echo $this->fetch($this->template_dir . 'pic_list_des');
                break;
            case 'groupbuy':
                return $this->fetch($this->template_dir . 'pic_list_groupbuy');
                break;
            case 'store_sns_normal':
                return $this->fetch($this->template_dir . 'pic_list_store_sns_normal');
                break;
            case 'goods_image':
                $this->assign('color_id', input('param.color_id'));
                return $this->fetch($this->template_dir . 'pic_list_goods_image');
                break;
            case 'mobile':
                $this->assign('type', input('param.type'));
                echo $this->fetch($this->template_dir . 'pic_list_mobile');
                break;
        }
    }

    /**
     * 修改相册封面
     */
    public function change_album_cover() {
        $id = intval(input('get.id'));
        if ($id <= 0) {
            ds_json_encode(10001,lang('ds_common_op_fail'));
        }
        /**
         * 实例化相册类
         */
        $album_model = model('album');
        /**
         * 图片信息
         */
        $condition['apic_id'] = $id;
        $condition['store_id'] = session('store_id');

        $pic_info = $album_model->getOneAlbumpicById($condition);
        $return = $album_model->checkAlbum(array('store_id' => session('store_id'), 'aclass_id' => $pic_info['aclass_id']));
        if ($return) {
            $re = $album_model->editAlbumclass(array('aclass_cover' => $pic_info['apic_cover']), $pic_info['aclass_id']);
            ds_json_encode(10000,lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001,lang('ds_common_op_fail'));
        }
    }

    /**
     * ajax修改图名称
     */
    public function change_pic_name() {
        $apic_id = intval(input('post.id'));
        $apic_name = input('post.name');
        
        if ($apic_id<=0 && empty($apic_name)) {
            echo 'false';
        }
        /**
         * 实例化相册类
         */
        $album_model = model('album');

        $return = $album_model->editAlbumpic(array('apic_name' => $apic_name), array('apic_id' => $apic_id));
        if ($return) {
            echo 'true';
        } else {
            echo 'false';
        }
    }


    /**
     * 图片删除
     */
    public function album_pic_del() {

        $ids=input('param.id');
        if (empty($ids)) {
            $this->error(lang('album_parameter_error'));
        }
        if(!is_array($ids)){
            $ids=array(intval($ids));
        }
        $album_model = model('album');

        //删除图片
        $condition = array();
        $condition['apic_id'] = array('in',$ids);
        $condition['store_id'] = session('store_id');
        $return = $album_model->delAlbumpic($condition);
        if ($return) {
            $this->success(lang('album_class_pic_del_succeed'));
        } else {
            $this->error(lang('album_class_pic_del_lose'));
        }
    }

    /**
     * 移动相册
     */
    public function album_pic_move() {
        /**
         * 实例化相册类
         */
        $album_model = model('album');
        if (request()->isPost()) {
            $id = input('post.id/a');
            $cid = input('post.cid');
            if (empty($id)) {
                $this->error(lang('album_parameter_error'));
            }
            if (!empty($id) && is_array($id)) {
                $id = trim(implode(',',$id), ',');
            }

            $update = array();
            $update['aclass_id'] = $cid;
            $condition['apic_id'] = array('in', $id);
            $condition['store_id'] = session('store_id');

            $return = $album_model->editAlbumpic($update, $condition);
            if ($return) {
                $this->success(lang('album_class_pic_move_succeed'));
            } else {
                $this->error(lang('album_class_pic_move_lose'));
            }
        } else {
            $id = input('param.id');
            $cid = input('param.cid');

            $condition['store_id'] = session('store_id');
            $condition['aclass_id'] = array('not in', $cid);
            $class_list = $album_model->getAlbumclassList($condition);

            if (isset($id) && !empty($id)) {
                $this->assign('id', $id);
            }
            $this->assign('class_list', $class_list);
            return $this->fetch($this->template_dir . 'album_pic_move');
        }
    }

    /**
     * 替换图片
     */
    public function replace_image_upload() {
        $file = input('param.id');
        $tpl_array = explode('_', $file);
        $id = intval(end($tpl_array));
        $album_model = model('album');
        $condition['apic_id'] = $id;
        $condition['store_id'] = session('store_id');
        $apic_info = $album_model->getOneAlbumpicById($condition);
        if (substr(strrchr($apic_info['apic_cover'], "."), 1) != substr(strrchr($_FILES[$file]["name"], "."), 1)) {
            // 后缀名必须相同
            $error = lang('album_replace_same_type');
            echo json_encode(array('state' => 'false', 'message' => $error));
            exit();
        }
        $pic_cover = implode(DS, explode(DS, $apic_info['apic_cover'], -1)); // 文件路径
        $tmpvar = explode(DS, $apic_info['apic_cover']);
        $pic_name = end($tmpvar); // 文件名称
        
        /**
         * 上传图片
         */
        //上传文件保存路径
        $store_id = session('store_id');
        $upload_path = ATTACH_GOODS . '/' . $store_id;
        $result=upload_albumpic($upload_path,$file,$pic_name);
        if($result['code'] == '10000'){
            $img_path=$result['result'];
            list($width, $height, $type, $attr) = getimagesize($img_path);
            $img_path=substr(strrchr($img_path, "/"), 1);
        }else{
            $data['state'] = 'false';
            $data['origin_file_name'] = $_FILES[$file]['name'];
            $data['message'] = $result['message'];
            echo json_encode($data);exit;
        }

        $update_array = array();
        $update_array['apic_size'] = intval($_FILES[$file]['size']);
        $update_array['apic_spec'] = $width . 'x' . $height;
        $condition = array();
        $condition['apic_id'] = $id;
        $result = model('album')->editAlbumpic($update_array, $condition);

        echo json_encode(array('state' => 'true', 'id' => $id));
        exit();
    }

    /**
     * 添加水印
     */
    public function album_pic_watermark() {
        $id_array = input('post.id/a');
        if (empty($id_array) && !is_array($id_array)) {
            $this->error(lang('album_parameter_error'));
        }

        $id = trim(implode(',', $id_array), ',');

        /**
         * 实例化图片模型
         */
        $album_model = model('album');
        $param['apic_id'] = array('in',$id);
        $param['store_id'] = session('store_id');
        $wm_list = $album_model->getAlbumpicList($param);
        $storewatermark_model = model('storewatermark');
        $store_wm_info = $storewatermark_model->getOneStorewatermarkByStoreId(session('store_id'));
        if ($store_wm_info['swm_image_name'] == '' && $store_wm_info['swm_text'] == '') {
            $this->error(lang('album_class_setting_wm'));
        }

        //获取店铺生成缩略图规格
        $ifthumb = FALSE;
        if (defined('GOODS_IMAGES_WIDTH') && defined('GOODS_IMAGES_HEIGHT') && defined('GOODS_IMAGES_EXT')) {
            $thumb_width = explode(',', GOODS_IMAGES_WIDTH);
            $thumb_height = explode(',', GOODS_IMAGES_HEIGHT);
            $thumb_ext = explode(',', GOODS_IMAGES_EXT);
            if (count($thumb_width) == count($thumb_height) && count($thumb_width) == count($thumb_ext)) {
                $ifthumb = TRUE;
            }
        }

        //文件路径
        $upload_path = BASE_UPLOAD_PATH . DS . ATTACH_GOODS . DS . session('store_id');
        if ($ifthumb) {
            foreach ($wm_list as $v) {
                //商品的图片路径
                $image_file = $upload_path . DS . $v['apic_cover'];
                //原图不做修改,对缩略图做修改
                if (!file_exists($image_file)) {
                    continue;
                }
                //重新生成缩略图，以及水印
                for ($i = 0; $i < count($thumb_width); $i++) {
                    //打开图片
                    $gd_image = \think\Image::open($image_file);
                    //水印图片名称
                    $thumb_image_file = $upload_path . '/' . str_ireplace('.', $thumb_ext[$i] . '.', $v['apic_cover']);
                    //添加图片水印
                    if (!empty($store_wm_info['swm_image_name'])) {
                        //水印图片的路径
                        $w_image = BASE_UPLOAD_PATH . DS . ATTACH_WATERMARK . DS . $store_wm_info['swm_image_name'];
                        $gd_image->thumb($thumb_width[$i], $thumb_height[$i], \think\Image::THUMB_CENTER)->water($w_image, $store_wm_info['swm_image_pos'], $store_wm_info['swm_image_transition'])->save($thumb_image_file,null,$store_wm_info['swm_quality']);
                    }
                    //添加文字水印
                    if (!empty($store_wm_info['swm_text'])) {
                        //字体文件路径
                        $font = 'font' . DS . $store_wm_info['swm_text_font'] . '.ttf';
                        $gd_image->thumb($thumb_width[$i], $thumb_height[$i], \think\Image::THUMB_CENTER)->text($store_wm_info['swm_text'], $font, $store_wm_info['swm_text_size'], $store_wm_info['swm_text_color'], $store_wm_info['swm_text_pos'], $store_wm_info['swm_text_angle'])->save($thumb_image_file,null,$store_wm_info['swm_quality']);
                    }
                }
            }
        }
        $this->success(lang('album_pic_plus_wm_succeed'));
    }

    /**
     * 水印管理
     */
    public function store_watermark() {
        /**
         * 读取语言包
         */
        $storewatermark_model = model('storewatermark');
        /**
         * 获取会员水印设置
         */
        $store_wm_info = $storewatermark_model->getOneStorewatermarkByStoreId(session('store_id'));
        /**
         * 保存水印配置信息
         */
        if (!request()->isPost()) {
            /**
             * 获取水印字体
             */
            $fontInfo = array();
            include PUBLIC_PATH . DS  . 'font' . DS . 'font.info.php';
            foreach ($fontInfo as $key => $value) {
                if (!file_exists(PUBLIC_PATH  . DS . 'font' . DS . $key . '.ttf')) {
                    unset($fontInfo[$key]);
                }
            }
            $this->assign('file_list', $fontInfo);


            if (empty($store_wm_info)) {
                /**
                 * 新建店铺水印设置信息
                 */
                $storewatermark_model->addStorewatermark(array(
                    'swm_text_font' => 'default',
                    'store_id' => session('store_id')
                ));
                $store_wm_info = $storewatermark_model->getOneStorewatermarkByStoreId(session('store_id'));
            }

            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('selleralbum');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('watermark');
            $this->assign('store_wm_info', $store_wm_info);
            return $this->fetch($this->template_dir . 'store_watermark');
        } else {

            $param = array();
            $param['swm_image_pos'] = input('post.swm_image_pos');
            $param['swm_image_transition'] = intval(input('post.swm_image_transition'));
            $param['swm_text'] = input('post.swm_text');
            $param['swm_text_size'] = input('post.swm_text_size');
            $param['swm_text_angle'] = input('post.swm_text_angle');
            $param['swm_text_font'] = input('post.swm_text_font');
            $param['swm_text_pos'] = input('post.swm_text_pos');
            $param['swm_text_color'] = input('post.swm_text_color');
            $param['swm_quality'] = intval(input('post.swm_quality'));

            $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_WATERMARK;
            if (!empty($_FILES['image']['name'])) {
                if (!empty($_FILES['image']['name'])) {
                    $file = request()->file('image');
                    $info = $file->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                    if ($info) {
                        $param['swm_image_name'] = $info->getFilename();
                        //删除旧水印
                        if (!empty($store_wm_info['swm_image_name'])) {
                            @unlink($upload_file . DS . $store_wm_info['swm_image_name']);
                        }
                    } else {
                        $this->error($file->getError());
                    }
                }
            } elseif (input('post.is_del_image') == 'ok') {
                 //删除水印
                if (!empty($store_wm_info['swm_image_name'])) {
                    $param['swm_image_name'] = '';
                    @unlink($upload_file . DS . $store_wm_info['swm_image_name']);
                }
            }
            $result = $storewatermark_model->editStorewatermark($store_wm_info['swm_id'], $param);
            if ($result) {
                $this->success(lang('store_watermark_congfig_success'));
            } else {
                $this->error(lang('store_watermark_congfig_fail'));
            }
        }
    }

    /**
     * 上传图片
     *
     */
    public function image_upload() {
        $store_id = session('store_id');

        if (input('param.category_id')) {
            $category_id = intval(input('param.category_id'));
        } else {
            $error = '上传 图片失败';
            $data['state'] = 'false';
            $data['message'] = $error;
            $data['origin_file_name'] = $_FILES["file"]["name"];
            echo json_encode($data);
            exit();
        }
        // 判断图片数量是否超限
        $album_limit = $this->store_grade['storegrade_album_limit'];
        if ($album_limit > 0) {
            $album_count = model('album')->getCount(array('store_id' => $store_id));
            if ($album_count >= $album_limit) {
                // 目前并不出该提示，而是提示上传0张图片
                $error = lang('store_goods_album_climit');
                $data['state'] = 'false';
                $data['message'] = $error;
                $data['origin_file_name'] = $_FILES["file"]["name"];
                $data['state'] = 'true';
                echo json_encode($data);
                exit();
            }
        }


        
        /**
         * 上传图片
         */
        //上传文件保存路径
        $upload_path = ATTACH_GOODS . '/' . $store_id;
        $save_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999);
        $name ='file';
        $result=upload_albumpic($upload_path,$name,$save_name);
        if($result['code'] == '10000'){
            $img_path=$result['result'];
            list($width, $height, $type, $attr) = getimagesize($img_path);
            $pic=substr(strrchr($img_path, "/"), 1);
        }else{
            exit($result['message']);
        }
        $insert_array = array();
        $insert_array['apic_name'] = $pic;
        $insert_array['apic_tag'] = '';
        $insert_array['aclass_id'] = $category_id;
        $insert_array['apic_cover'] = $pic;
        $insert_array['apic_size'] = intval($_FILES['file']['size']);
        $insert_array['apic_spec'] = $width . 'x' . $height;
        $insert_array['apic_uploadtime'] = time();
        $insert_array['store_id'] = $store_id;
        $result = model('album')->addAlbumpic($insert_array);

        $data = array();
        $data['file_id'] = $result;
        $data['file_name'] = $pic;
        $data['origin_file_name'] = $_FILES["file"]["name"];
        $data['file_path'] = $pic;
        $data['instance'] = input('get.instance');
        $data['state'] = 'true';
        /**
         * 整理为json格式
         */
        $output = json_encode($data);
        echo $output;
        exit;
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string	$menu_type	导航类型
     * @param string 	$menu_key	当前导航的menu_key
     * @return
     */
    function getSellerItemList() {
        $item_list = array(
            array(
                'name' => 'album',
                'text' => lang('ds_member_path_my_album'),
                'url' => url('Selleralbum/index'),
            ),
            array(
                'name' => 'watermark',
                'text' => lang('ds_member_path_watermark'),
                'url' => url('Selleralbum/store_watermark'),
            ),
        );
        if (request()->action() == 'pic_list') {
            $item_list[] = array(
                'name' => 'pic_list',
                'text' => lang('ds_member_path_album_pic_list'),
                'url' => url('Selleralbum/album_pic_list', ['album_pic_list' => intval(input('param.id'))]),
            );
        }
        if (request()->action() == 'pic_info') {
            $item_list[] = array(
                'name' => 'pic_list',
                'text' => lang('ds_member_path_album_pic_list'),
                'url' => url('Selleralbum/album_pic_list', ['class_id' => intval(input('param.class_id')), 'album_pic_list' => intval(input('param.id'))]),
            );
        }
        return $item_list;
    }


    /**
     * ajax验证名称时候重复
     */
    public function ajax_check_class_name() {
        $ac_name = trim(input('get.ac_name'));
        if ($ac_name == '') {
            echo 'true';
            die;
        }
        $album_model = model('album');
        $condition['store_id'] = session('store_id');
        $condition['aclass_name'] = $ac_name;

        $class_info = $album_model->getOneAlbumclass($condition);
        if (!empty($class_info)) {
            echo 'false';
            die;
        } else {
            echo 'true';
            die;
        }
    }

}

?>
