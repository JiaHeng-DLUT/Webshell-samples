<?php

namespace app\admin\controller;

use think\Lang;

class Seo extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/seo.lang.php');
    }

    function index() {
        $seo_model = model('seo');
        if (!request()->isPost()) {
            //读取SEO信息
            $list = $seo_model->select();
            $seo = array();
            foreach ((array) $list as $value) {
                $seo[$value['seo_type']] = $value;
            }
            $this->assign('seo', $seo);
//            $category = model('goodsclass')->getGoodsclassForCacheModel();
//            $this->assign('category', $category);
            return $this->fetch('index');
        } else {
            $update = array();
            $seo = input('post.SEO/a');#获取数组
            if (is_array($seo)) {
                foreach ($seo as $key => $value) {
                    $seo_model->where(array('seo_type' => $key))->update($value);
                }
                dkcache('seo');
                ds_json_encode('10000', lang('ds_common_save_succ'));
            }
        }
    }

}

?>
