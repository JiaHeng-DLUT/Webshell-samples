<?php

namespace app\admin\controller;

use think\Lang;
use think\Cache;

class Index extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/index.lang.php');
    }

    public function index() {
        $this->assign('admin_info', $this->getAdminInfo());
        return $this->fetch();
    }

    /**
     * 修改密码
     */
    public function modifypw() {
        if (request()->isPost()) {
            $new_pw = trim(input('post.new_pw'));
            $new_pw2 = trim(input('post.new_pw2'));
            $old_pw = trim(input('post.old_pw'));
            if ($new_pw !== $new_pw2) {
                $this->error(lang('index_modifypw_repeat_error'));
            }
            $admininfo = $this->getAdminInfo();
            //查询管理员信息
            $admin_model = model('admin');
            $admininfo = $admin_model->getOneAdmin(array('admin_id'=>$admininfo['admin_id']));
            if (!is_array($admininfo) || count($admininfo) <= 0) {
                $this->error(lang('index_modifypw_admin_error'));
            }
            //旧密码是否正确
            if ($admininfo['admin_password'] != md5($old_pw)) {
               $this->error(lang('index_modifypw_oldpw_error'));
            }
            $new_pw = md5($new_pw);
            $result = $admin_model->editAdmin(array('admin_password' => $new_pw),$admininfo['admin_id']);
            if ($result) {
                session(null);
                echo "<script>parent.location.href='".url('Login/index')."'</script>";
            } else {
                $this->error(lang('index_modifypw_fail'));
            }
        } else {
            return $this->fetch();
        }
    }
    
    /**
     * 删除缓存
     */
    function clear() {
        $this->delCacheFile('temp');
        $this->delCacheFile('cache');
        Cache::clear();
        ds_json_encode(10000, lang('ds_common_op_succ'));
//        $this->success("操作完成!!!", url('Dashboard/index'));
        exit();
    }
    
    /**
     * 删除缓存目录下的文件或子目录文件
     *
     * @param string $dir 目录名或文件名
     * @return boolean
     */
    function delCacheFile($dir) {
        //防止删除cache以外的文件
        if (strpos($dir, '..') !== false)
            return false;
        $path = RUNTIME_PATH . '/' . $dir;
        if (is_dir($path)) {
            $file_list = array();
            read_file_list($path, $file_list);
            if (!empty($file_list)) {
                foreach ($file_list as $v) {
                    if (basename($v) != 'index.html')
                        @unlink($v);
                }
            }
        }
        else {
            if (basename($path) != 'index.html')
                @unlink($path);
        }
        return true;
    }

}
