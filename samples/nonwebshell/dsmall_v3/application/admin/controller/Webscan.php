<?php

/**
 * 系统安全检测相关代码
 */

namespace app\admin\controller;

use think\Lang;
use think\Db;

class Webscan extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        $this->_prefix = config('database.prefix');
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/webscan.lang.php');
    }

    public function index()
    {
        $this->scan_member();
    }

    public function scan_member()
    {
        $output = array();
        //检测Member数据表中是否有重复的 用户名  邮箱  手机号
        $result = Db::query("select member_name,count(*) as count from {$this->_prefix}member group by member_name having count>1;");
    }
}
