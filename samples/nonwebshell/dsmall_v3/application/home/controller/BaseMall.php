<?php

/**
 * 公共用户可以访问的类(不需要登录)
 */

namespace app\home\controller;
use think\Lang;

class BaseMall extends BaseHome {

    public function _initialize() {
        parent::_initialize();
        $this->template_dir = 'default/mall/'.  strtolower(request()->controller()).'/';
    }
}

?>
