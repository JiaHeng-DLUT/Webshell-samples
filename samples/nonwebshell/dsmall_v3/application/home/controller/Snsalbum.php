<?php

/**
 * 买家相册
 */

namespace app\home\controller;

use think\Lang;

class Snsalbum extends BaseMember {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/snsalbum.lang.php');
    }

    /**
     * 图片删除
     */
    public function album_pic_del() {
        $ids = input('param.id');
        if (empty($ids)) {
            ds_json_encode(10001,lang('album_parameter_error'));
        };
        if (!empty($ids) && is_array($ids)) {
            $id = $ids;
        } else {
            $id[] = intval($ids);
        }

        foreach ($id as $v) {
            $v = intval($v);
            if ($v <= 0)
                continue;
            $ap_info = db('snsalbumpic')->where(array('ap_id' => $v, 'member_id' => session('member_id')))->find();
            if (empty($ap_info))
                continue;
            @unlink(BASE_UPLOAD_PATH . DS . ATTACH_MALBUM . DS . session('member_id') . DS . $ap_info['ap_cover']);
            $res = db('snsalbumpic')->delete($ap_info['ap_id']);
        }
        if ($res){
            ds_json_encode(10000,lang('album_class_pic_del_succeed'));
        }
    }


    /**
     * 上传图片
     *
     * @param
     * @return
     */
    public function swfupload() {
        $member_id = session('member_id');
        $class_id = intval(input('param.category_id'));
        if ($member_id <= 0 && $class_id <= 0) {
            echo json_encode(array('state' => 'false', 'message' => lang('sns_upload_pic_fail'), 'origin_file_name' => $_FILES["file"]["name"]));
            exit;
        }

        /**
         * 上传图片
         */
        //上传文件保存路径
        $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_MALBUM . DS . $member_id;
        if (!empty($_FILES['file']['name'])) {
            $file = request()->file('file');
            //设置特殊图片名称
            $file_name = $member_id . '_' . date('YmdHis') . rand(10000, 99999);
            $info = $file->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file, $file_name);
            if ($info) {
                $img_path = $info->getFilename();
            } else {
                // 目前并不出该提示
                $error = $file->getError();
                $data['state'] = 'false';
                $data['message'] = $error;
                $data['origin_file_name'] = $_FILES['file']['name'];
                echo json_encode($data);
                exit;
            }
        } else {
            //未上传图片不做后面处理
            exit;
        }

        list($width, $height, $type, $attr) = getimagesize($upload_file . DS . $img_path);

        $insert = array();
        $insert['ap_name'] = $img_path;
        $insert['ac_id'] = $class_id;
        $insert['ap_cover'] = $img_path;
        $insert['ap_size'] = intval($_FILES['file']['size']);
        $insert['ap_spec'] = $width . 'x' . $height;
        $insert['ap_uploadtime'] = time();
        $insert['member_id'] = $member_id;
        $result = db('snsalbumpic')->insertGetId($insert);
        $data = array();
        $data['file_id'] = $result;
        $data['file_name'] = $img_path;
        $data['origin_file_name'] = $_FILES["file"]["name"];
        $data['file_path'] = $img_path;
        $data['file_url'] = sns_thumb($img_path, 240);
        $data['state'] = 'true';
        /**
         * 整理为json格式
         */
        $output = json_encode($data);
        echo $output;
    }
}

?>
