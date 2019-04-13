<?php

namespace app\admin\controller;

use think\Lang;

class Admin extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/' . config('default_lang') . '/admin.lang.php');
    }

    /**
     * 管理员列表
     */
    public function admin() {
        $admin_mod = model('admin');
        $condition = array();
        $admin_list = $admin_mod->getAdminList($condition, 10);
        $this->assign('admin_list', $admin_list);
        $this->assign('show_page', $admin_mod->page_info->render());
        $this->setAdminCurItem('admin');
        return $this->fetch('admin');
    }

    /**
     * 管理员删除
     */
    public function admin_del() {
        $admin_id = intval(input('param.admin_id'));
        if (!empty($admin_id)) {
            if ($admin_id == 1) {
                $this->error(lang('ds_common_save_fail'));
            }
            $admin_mod = model('admin');
            $admin_mod->delAdmin(array('admin_id' => $admin_id));
            $this->log(lang('ds_del') . lang('limit_admin') . '[ID:' . $admin_id . ']', 1);
            ds_json_encode(10000, lang('ds_common_del_succ'));
        } else {
            ds_json_encode(10001, lang('ds_common_del_fail'));
        }
    }

    /**
     * 管理员添加
     */
    public function admin_add() {
        $admin_model = model('admin');
        if (!request()->isPost()) {
            //得到权限组
            $gadmin = $admin_model->getGadminList('gname,gid');
            $this->assign('gadmin', $gadmin);
            return $this->fetch('admin_add');
        } else {
            $data['admin_name'] = input('post.admin_name');
            $data['admin_gid'] = input('post.gid');
            $data['admin_password'] = md5(input('post.admin_password'));

            $admin_validate = validate('admin');
            if (!$admin_validate->scene('admin_add')->check($data)) {
                $this->error($admin_validate->getError());
            }

            $rs = $admin_model->addAdmin($data);
            if ($rs) {
                $this->log(lang('ds_add') . lang('limit_admin') . '[' . input('post.admin_name') . ']', 1);
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * ajax操作
     */
    public function ajax() {
        $admin_model = model('admin');
        switch (input('get.branch')) {
            //管理人员名称验证
            case 'check_admin_name':
                $condition['admin_name'] = input('get.admin_name');
                $admin_info = $admin_model->infoAdmin($condition);
                if (!empty($admin_info)) {
                    exit('false');
                } else {
                    exit('true');
                }
                break;
            //权限组名称验证
            case 'check_gadmin_name':
                $condition = array();
                if (is_numeric(input('param.gid'))) {
                    $condition['gid'] = array('neq', intval(input('param.gid')));
                }
                $condition['gname'] = input('get.gname');
                $info = $admin_model->getOneGadmin($condition);
                if (!empty($info)) {
                    exit('false');
                } else {
                    exit('true');
                }
                break;
        }
    }

    /**
     * 设置管理员权限
     */
    public function admin_edit() {
        $admin_id = intval(input('param.admin_id'));
        if (request()->isPost()) {
            //没有更改密码
            if (input('post.new_pw') != '') {
                $data['admin_password'] = md5(input('post.new_pw'));
            }
            $data['admin_gid'] = intval(input('post.gid'));
            //查询管理员信息
            $admin_model = model('admin');
            $result = $admin_model->editAdmin($data, $admin_id);
            if ($result) {
                $this->log(lang('ds_edit') . lang('limit_admin') . '[ID:' . $admin_id . ']', 1);
                dsLayerOpenSuccess(lang('admin_edit_success'));
            } else {
                $this->error(lang('admin_edit_fail'));
            }
        } else {
            //查询用户信息
            $admin_model = model('admin');
            $admin = $admin_model->getOneAdmin(array('admin_id' => $admin_id));
            if (!is_array($admin) || count($admin) <= 0) {
                $this->error(lang('admin_edit_admin_error'), url('Admin/admin'));
            }
            $this->assign('admin', $admin);

            //得到权限组
            $gadmin = $admin_model->getGadminList('gname,gid');
            $this->assign('gadmin', $gadmin);
            return $this->fetch('admin_edit');
        }
    }

    /**
     * 取得所有权限项
     *
     * @return array
     */
    private function permission() {
        $limit = $this->limitList();
        if (is_array($limit)) {
            foreach ($limit as $k => $v) {
                if (is_array($v['child'])) {
                    $tmp = array();
                    foreach ($v['child'] as $key => $value) {
                        $controller = (!empty($value['controller'])) ? $value['controller'] : $v['controller'];
                        if (strpos($controller, '|') == false) {//controller参数不带|
                            $limit[$k]['child'][$key]['action'] = rtrim($controller . '.' . str_replace('|', '|' . $controller . '.', $value['action']), '.');
                        } else {//controller参数带|
                            $tmp_str = '';
                            if (empty($value['action'])) {
                                $limit[$k]['child'][$key]['action'] = $controller;
                            } elseif (strpos($value['action'], '|') == false) {//action参数不带|
                                foreach (explode('|', $controller) as $v1) {
                                    $tmp_str .= "$v1.{$value['action']}|";
                                }
                                $limit[$k]['child'][$key]['action'] = rtrim($tmp_str, '|');
                            } elseif (strpos($value['action'], '|') != false && strpos($controller, '|') != false) {//action,controller都带|，交差权限
                                foreach (explode('|', $controller) as $v1) {
                                    foreach (explode('|', $value['action']) as $v2) {
                                        $tmp_str .= "$v1.$v2|";
                                    }
                                }
                                $limit[$k]['child'][$key]['action'] = rtrim($tmp_str, '|');
                            }
                        }
                    }
                }
            }
            return $limit;
        } else {
            return array();
        }
    }

    /**
     * 权限组
     */
    public function gadmin() {
        $admin_model = model('admin');
        $gadmin_list = $admin_model->getGadminList();
        $this->assign('gadmin_list', $gadmin_list);
        $this->setAdminCurItem('gadmin');
        return $this->fetch('gadmin');
    }

    /**
     * 添加权限组
     */
    public function gadmin_add() {
        if (!request()->isPost()) {
            $this->assign('limit', $this->permission());
            return $this->fetch('gadmin_add');
        } else {
            $limit_str = '';
            $permission_array = input('post.permission/a');
            if (is_array($permission_array)) {
                $limit_str = implode('|', $permission_array);
            }
            $data['glimits'] = ds_encrypt($limit_str, MD5_KEY . md5(input('post.gname')));
            $data['gname'] = input('post.gname');
            $admin_model = model('admin');
            if ($admin_model->addGadmin($data)) {
                $this->log(lang('ds_add') . lang('limit_gadmin') . '[' . input('post.gname') . ']', 1);
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 设置权限组权限
     */
    public function gadmin_set() {
        $gid = intval(input('param.gid'));
        $admin_model = model('admin');
        $ginfo = $admin_model->getOneGadmin(array('gid' => $gid));
        if (empty($ginfo)) {
            $this->error(lang('admin_set_admin_not_exists'));
        }
        if (!request()->isPost()) {
            //解析已有权限
            $hlimit = ds_decrypt($ginfo['glimits'], MD5_KEY . md5($ginfo['gname']));
            $ginfo['glimits'] = explode('|', $hlimit);
            $this->assign('ginfo', $ginfo);
            $this->assign('limit', $this->permission());
            return $this->fetch('gadmin_set');
        } else {
            $limit_str = '';
            $permission_array = input('post.permission/a');
            if (is_array($permission_array)) {
                $limit_str = implode('|', $permission_array);
            }
            $limit_str = ds_encrypt($limit_str, MD5_KEY . md5(input('post.gname')));
            $data['glimits'] = $limit_str;
            $data['gname'] = input('post.gname');
            $update = $admin_model->editGadmin(array('gid' => $gid), $data);
            if ($update) {
                $this->log(lang('ds_edit') . lang('limit_gadmin') . '[' . input('post.gname') . ']', 1);
                dsLayerOpenSuccess(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_succ'));
            }
        }
    }

    /**
     * 组删除
     */
    public function gadmin_del() {
        if (is_numeric(input('param.gid'))) {
            $admin_model = model('admin');
            $admin_model->delGadmin(array('gid' => intval(input('param.gid'))));
            $this->log(lang('ds_del') . lang('limit_gadmin') . '[ID' . intval(input('param.gid')) . ']', 1);
            ds_json_encode(10000, lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10000, lang('ds_common_op_fail'));
        }
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'admin',
                'text' => lang('limit_admin'),
                'url' => url('Admin/admin')
            ),
            array(
                'name' => 'admin_add',
                'text' => lang('admin_add_limit_admin'),
                'url' => "javascript:dsLayerOpen('" . url('Admin/admin_add') . "','管理员添加')"
            ),
            array(
                'name' => 'gadmin',
                'text' => lang('limit_gadmin'),
                'url' => url('Admin/gadmin')
            ),
            array(
                'name' => 'gadmin_add',
                'text' => lang('admin_add_limit_gadmin'),
                'url' => "javascript:dsLayerOpen('" . url('Admin/gadmin_add') . "','权限组添加')"
            ),
        );
        return $menu_array;
    }

}

?>
