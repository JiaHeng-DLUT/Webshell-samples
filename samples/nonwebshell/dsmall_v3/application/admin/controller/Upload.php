<?php

namespace app\admin\controller;

use think\Lang;

class Upload extends AdminControl
{

    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/upload.lang.php');
    }

    function default_thumb()
    {
        $config_model = model('config');
        $list_config = rkcache('config', true);
        
        if (!request()->isPost()) {
            
            //模板输出
            $this->assign('list_config', $list_config);
            //输出子菜单
            $this->setAdminCurItem('default_thumb');
            return $this->fetch('default_thumb');
        }
        else {
            //上传文件保存路径
            $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_COMMON;
            $update_array = array();
            //默认商品图片
            if (!empty($_FILES['default_goods_image']['name'])) {
                $file = request()->file('default_goods_image');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, 'default_goods_image');
                if ($info) {
                    $upload['default_goods_image'] = $info->getFilename();
                    //生成缩略图 覆盖原有图片
                    ds_create_thumb($upload_file, $info->getFilename(), '240,480,1280', '240,480,1280', '_small,_normal,_big');
                }
                else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            if (!empty($upload['default_goods_image'])) {
                $update_array['default_goods_image'] = $upload['default_goods_image'];
            }

            //默认店铺标志
            if (!empty($_FILES['default_store_logo']['name'])) {
                $file = request()->file('default_store_logo');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, 'default_store_logo');
                if ($info) {
                    $upload['default_store_logo'] = $info->getFilename();
                    //生成缩略图 覆盖原有图片
                    ds_create_thumb($upload_file, $info->getFilename(), '200', '200');
                }
                else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            if (!empty($upload['default_store_logo'])) {
                $update_array['default_store_logo'] = $upload['default_store_logo'];
            }

            //默认店铺头像
            if (!empty($_FILES['default_store_avatar']['name'])) {
                $file = request()->file('default_store_avatar');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, 'default_store_avatar');
                if ($info) {
                    $upload['default_store_avatar'] = $info->getFilename();
                    //生成缩略图 覆盖原有图片
                    ds_create_thumb($upload_file, $info->getFilename(), '100', '100');
                }
                else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            if (!empty($upload['default_store_avatar'])) {
                $update_array['default_store_avatar'] = $upload['default_store_avatar'];
            }

            //默认会员头像
            if (!empty($_FILES['default_user_portrait']['name'])) {
                $file = request()->file('default_user_portrait');
                $info = $file->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, 'default_user_portrait');
                if ($info) {
                    $upload['default_user_portrait'] = $info->getFilename();
                    //生成缩略图 覆盖原有图片
                    ds_create_thumb($upload_file, $info->getFilename(), '128', '128');
                }
                else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }
            if (!empty($upload['default_user_portrait'])) {
                $update_array['default_user_portrait'] = $upload['default_user_portrait'];
            }

            if (!empty($update_array)) {
                $result = $config_model->editConfig($update_array);
            }
            else {
                $result = true;
            }
            if ($result === true) {
                $this->log(lang('ds_edit') . lang('default_thumb'), 1);
                $this->success(lang('ds_common_save_succ'));
            }
            else {
                $this->log(lang('ds_edit') . lang('default_thumb'), 0);
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    public function upload_type()
    {
        if (!request()->isPost()) {
            $list_config = rkcache('config', true);
            $this->assign('list_config',$list_config);
            $this->setAdminCurItem('upload_type');
            return $this->fetch();
        }else{
            $update_array=input('param.');
            $result = model('config')->editConfig($update_array);
            if($result){
                $this->success(lang('ds_common_save_succ'));
            }else{
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'default_thumb', 'text' => lang('default_thumb'), 'url' => url('Upload/default_thumb')
            ), array(
                'name' => 'upload_type', 'text' => '上传设置', 'url' => url('Upload/upload_type')
            )
        );
        return $menu_array;
    }

}

?>
