<?php
namespace app\admin\controller;

use think\Lang;

class Appadv extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/adv.lang.php');
    }
    
    function index()
    {
        /**
         * 显示广告位管理界面
         */
        $condition = array();
        $search_name = trim(input('get.search_name'));
        if ($search_name != '') {
            $condition['ap_name'] = $search_name;
        }
        $ap_list= model('appadv')->getAppadvpositionList($condition,'10');
        $adv_list = model('appadv')->getAppadvList();
        $this->assign('ap_list',$ap_list);
        $this->assign('adv_list',$adv_list);
        $this->assign('showpage', model('appadv')->page_info->render());
        
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        
        $this->setAdminCurItem('index');
        return $this->fetch();
    }

    /**
     *
     * 新增广告位
     */
    public function ap_add() {
        if (!request()->isPost()) {
            $ap['ap_isuse']=1;
            $this->assign('ap',$ap);
            return $this->fetch('ap_form');
        } else {
            $appadv_model = model('appadv');
            $insert_array['ap_name'] = trim(input('post.ap_name'));
            $insert_array['ap_intro'] = trim(input('post.ap_intro'));
            $insert_array['ap_isuse'] = intval(input('post.ap_isuse'));
            $insert_array['ap_width'] = intval(input('post.ap_width'));
            $insert_array['ap_height'] = intval(input('post.ap_height'));

            $adv_validate = validate('adv');
            if (!$adv_validate->scene('app_ap_add')->check($insert_array)) {
                $this->error($adv_validate->getError());
            }

            $result = $appadv_model->addAppadvposition($insert_array);

            if ($result) {
                $this->log(lang('ap_add_succ') . '[' . input('post.ap_name') . ']', null);
                dsLayerOpenSuccess(lang('ap_add_succ'),url('Appadv/index'));
            } else {
                $this->error(lang('ap_add_fail'));
            }
        }
    }


    /**
     *
     * 删除广告位
     */
    public function ap_del() {
        $appadv_model = model('appadv');
        /**
         * 删除一个广告位
         */
        $ap_id = intval(input('param.ap_id'));
        $result = $appadv_model->delAppadvposition($ap_id);
        if (!$result) {
            ds_json_encode(10001, lang('ap_del_fail'));
        } else {
            $this->log(lang('ap_del_succ') . '[' . $ap_id . ']', null);
            ds_json_encode(10000, lang('ap_del_succ'));
        }
    }

    /**
     *
     * 删除广告
     */
    public function adv_del() {
        $appadv_model = model('appadv');
        /**
         * 删除一个广告
         */
        $adv_id = intval(input('param.adv_id'));
        $result = $appadv_model->delAppadv($adv_id);

        if (!$result) {
            ds_json_encode(10001, lang('adv_del_fail'));
        } else {
            $this->log(lang('adv_del_succ') . '[' . $adv_id . ']', null);
            ds_json_encode(10000, lang('adv_del_succ'));
        }
    }

    /**
     *
     * 修改广告
     */
    public function adv_edit() {
        $adv_id = intval(input('param.adv_id'));
        $appadv_model = model('appadv');
        //获取指定广告
        $condition['adv_id'] = $adv_id;
        $adv = $appadv_model->getOneAppadv($condition);
        if (!request()->isPost()) {
            //获取广告列表
            $ap_list = $appadv_model->getAppadvpositionList();
            $this->assign('ap_list', $ap_list);
            $this->assign('adv', $adv);
            $this->assign('ref_url', get_referer());
            return $this->fetch('adv_form');
        } else {
            $param['adv_id'] = $adv_id;
            $param['ap_id'] = intval(input('post.ap_id'));
            $param['adv_title'] = trim(input('post.adv_name'));
            $param['adv_type'] = input('post.adv_type');
            $param['adv_typedate'] = input('post.adv_typedate');
            $param['adv_sort'] = input('post.adv_sort');
            $param['adv_enabled'] = input('post.adv_enabled');
            $param['adv_startdate'] = $this->getunixtime(trim(input('post.adv_startdate')));
            $param['adv_enddate'] = $this->getunixtime(trim(input('post.adv_enddate')));


            if (!empty($_FILES['adv_code']['name'])) {
                //上传文件保存路径
                $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_APPADV;
                $file = request()->file('adv_code');
                $info = $file->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    //还需删除原来图片
                    if (!empty($adv['adv_code'])) {
                        @unlink($upload_file . DS . $adv['adv_code']);
                    }
                    $param['adv_code'] = $info->getFilename();
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }

            $adv_validate = validate('adv');
            if (!$adv_validate->scene('app_adv_edit')->check($param)) {
                $this->error($adv_validate->getError());
            }

            $result = $appadv_model->editAppadv($param);

            if ($result>=0) {
                $this->log(lang('adv_change_succ') . '[' . input('post.ap_name') . ']', null);
                dsLayerOpenSuccess(lang('adv_change_succ'),input('post.ref_url'));
            } else {
                $this->error(lang('adv_change_fail'));
            }
        }
    }
    
    public function ajax() {
        $appadv_model = model('appadv');
        switch (input('get.branch')) {
            case 'ap_branch':
                $column = input('param.column');
                $value = input('param.value');
                $adv_id = intval(input('param.id'));
                $param['ap_id'] = $adv_id;
                $param[$column] = trim($value);
                $result = $appadv_model->editAppadvposition($param);
                break;
            //ADV数据表更新
            case 'adv_branch':
                $column = input('param.column');
                $value = input('param.value');
                $adv_id = intval(input('param.id'));
                $param[$column] = trim($value);
                $result = $appadv_model->editAdv(array_merge($param, array('adv_id' => $adv_id)));
                break;
        }
        if($result>=0){
            echo 'true';
        }else{
            echo false;
        }
    }
    
    
    /**
     *
     * 广告管理
     */
    public function adv() {
        $appadv_model = model('appadv');
        $ap_id = intval(input('param.ap_id'));
        if (!request()->isPost()) {
            $condition = array();
            if ($ap_id) {
                $condition['ap_id'] = $ap_id;
            }
            $adv_info = $appadv_model->getAppadvList($condition, 20, '', '');
            $this->assign('adv_info', $adv_info);
            $ap_list = $appadv_model->getAppadvpositionList();
            $this->assign('ap_list', $ap_list);
            if ($ap_id) {
                $ap_condition=array();
                $ap_condition['ap_id']=$ap_id;
                $ap = $appadv_model->getOneAppadvposition($ap_condition); 
                $this->assign('ap_name', $ap['ap_name']);
            } else {
                $this->assign('ap_name', '');
            }

            $this->assign('show_page', $appadv_model->page_info->render());
            
            $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
            
            $this->setAdminCurItem('adv');
            return $this->fetch('adv_index');
        }
    }

    /**
     * 管理员添加广告
     */
    public function appadv_add() {
        $appadv_model = model('appadv');
        if (!request()->isPost()) {

            $ap_list = $appadv_model->getAppadvpositionList();
            $this->assign('ap_list', $ap_list);
            $adv = array(
                'ap_id' => 0,
                'adv_enabled' => '1',
                'adv_startdate' => time(),
                'adv_enddate' => time() + 24 * 3600 * 365,
                'adv_type'=>''
            );
            $this->assign('adv', $adv);
            return $this->fetch('adv_form');
        } else {
            $insert_array['ap_id'] = intval(input('post.ap_id'));
            $insert_array['adv_title'] = trim(input('post.adv_name'));
            $insert_array['adv_type'] = input('post.adv_type');
            $insert_array['adv_typedate'] = input('post.adv_typedate');
            $insert_array['adv_sort'] = input('post.adv_sort');
            $insert_array['adv_enabled'] = input('post.adv_enabled');
            $insert_array['adv_startdate'] = $this->getunixtime(input('post.adv_startdate'));
            $insert_array['adv_enddate'] = $this->getunixtime(input('post.adv_enddate'));

            //上传文件保存路径
            $upload_file = BASE_UPLOAD_PATH . DS . ATTACH_APPADV;
            if (!empty($_FILES['adv_code']['name'])) {
                $file = request()->file('adv_code');
                $info = $file->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($upload_file);
                if ($info) {
                    $insert_array['adv_code'] = $info->getFilename();
                } else {
                    // 上传失败获取错误信息
                    $this->error($file->getError());
                }
            }

            $adv_validate = validate('adv');
            if (!$adv_validate->scene('app_adv_add')->check($insert_array)) {
                $this->error($adv_validate->getError());
            }

            //广告信息入库
            $result = $appadv_model->addAppadv($insert_array);
            //更新相应广告位所拥有的广告数量
            $ap_condition=array();
            $ap_condition['ap_id']=intval(input('post.ap_id'));
            $appadv_model->getOneAppadvposition($ap_condition);
            if ($result) {
                $this->log(lang('adv_add_succ') . '[' . input('post.adv_name') . ']', null);
                dsLayerOpenSuccess(lang('adv_add_succ'),url('Appadv/adv', ['ap_id' => input('post.ap_id')]));
            } else {
                $this->error(lang('adv_add_fail'));
            }
        }
    }

    /**
     *
     * 修改广告位
     */
    public function ap_edit() {
        $ap_id = intval(input('param.ap_id'));

        $appadv_model = model('appadv');
        if (!request()->isPost()) {
            
            $condition['ap_id'] = $ap_id;
            $ap = $appadv_model->getOneAppadvposition($condition);
            $this->assign('ref_url', get_referer());
            $this->assign('ap', $ap);
            return $this->fetch('ap_form');
        } else {
            $param['ap_id'] = $ap_id;
            $param['ap_name'] = trim(input('post.ap_name'));
            $param['ap_intro'] = trim(input('post.ap_intro'));
            $param['ap_width'] = intval(trim(input('post.ap_width')));
            $param['ap_height'] = intval(trim(input('post.ap_height')));
            if (input('post.ap_isuse') != '') {
                $param['ap_isuse'] = intval(input('post.ap_isuse'));
            }
            $adv_validate = validate('adv');
            if (!$adv_validate->scene('app_ap_edit')->check($param)) {
                $this->error($adv_validate->getError());
            }

            $result = $appadv_model->editAppadvposition($param);

            if ($result>=0) {
                $this->log(lang('ap_change_succ') . '[' . input('post.ap_name') . ']', null);
                dsLayerOpenSuccess(lang('ap_change_succ'),input('post.ref_url'));
            } else {
                $this->error(lang('ap_change_fail'));
            }
        }
    }
    /**
     *
     * 获取UNIX时间戳
     */
    public function getunixtime($time) {
        $array = explode("-", $time);
        $unix_time = mktime(0, 0, 0, $array[1], $array[2], $array[0]);
        return $unix_time;
    }
    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => lang('ap_manage'),
                'url' => url('Appadv/index')
            ),
        );
        $menu_array[] = array(
            'name' => 'ap_add',
            'text' => lang('ap_add'),
            'url' => "javascript:dsLayerOpen('".url('Appadv/ap_add')."','".lang('ap_add')."')"
        );
        $menu_array[] = array(
            'name' => 'adv',
            'text' => lang('adv_manage'),
            'url' => url('Appadv/adv')
        );
        $menu_array[] = array(
            'name' => 'adv_add',
            'text' => lang('adv_add'),
            'url' => "javascript:dsLayerOpen('".url('Appadv/appadv_add', ['ap_id' => input('param.ap_id')])."','".lang('adv_add')."')"
        );
        return $menu_array;
    }
    
}
