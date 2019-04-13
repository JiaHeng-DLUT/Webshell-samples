<?php

/**
 * 系统文章
 */

namespace app\home\controller;

use think\Lang;

class Document extends BaseMall {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/index.lang.php');
    }

    public function index() {
        $code = input('param.code');
        
        if ($code == '') {
            $this->error(lang('param_error'));//'缺少参数:文章标识'
        }
        $document_model = model('document');
        $doc = $document_model->getOneDocumentByCode($code);
        $this->assign('doc', $doc);
        /**
         * 分类导航
         */
        $nav_link = array(
            array(
                'title' => lang('homepage'),
                'link' => HOME_SITE_URL
            ),
            array(
                'title' => $doc['document_title']
            )
        );
        $this->assign('nav_link_list', $nav_link);
        return $this->fetch($this->template_dir . 'index');
    }

}

?>
