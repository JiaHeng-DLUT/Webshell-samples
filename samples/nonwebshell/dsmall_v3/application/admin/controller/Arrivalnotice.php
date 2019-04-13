<?php

namespace app\admin\controller;


use think\Lang;

class Arrivalnotice extends AdminControl
{
    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/arrivalnotice.lang.php');
    }

    /**
     * 到货通知列表
     * @return mixed
     */
    public function index() {
        $arrivalnotice_model = model('arrivalnotice');
        $condition = array();
        if (!empty(input('param.search_goods'))) {
            $condition['goods_name'] = array('like', '%' . input('param.search_goods') . '%');
        }
        if (!empty(input('param.search_state'))) {
            $condition['arrivalnotice_state'] = input('param.search_state');
        }
        $arrivalnotice_list = $arrivalnotice_model->getArrivalNoticeList($condition,'','','',5);
        foreach ($arrivalnotice_list as $key => $value){
            $arrivalnotice_list[$key]['member_name'] = model('member')->getMemberInfo(['member_id'=>$value['member_id']],'member_name')['member_name'];
        }

        $this->assign('arrivalnotice_list', $arrivalnotice_list);
        $this->assign('show_page', $arrivalnotice_model->page_info->render());
        $this->setAdminCurItem('index');
        $this->assign('filtered', $condition ? 1 : 0); //是否有查询条件
        return $this->fetch();
    }

    /**
     * 到货通知删除
     */
    public function arrivalnotice_del(){
        $arrivalnotice_id = input('param.arrivalnotice_id');
        $arrivalnotice_id_array = ds_delete_param($arrivalnotice_id);
        if ($arrivalnotice_id_array == FALSE) {
            ds_json_encode('10001', lang('param_error'));
        }
        $condition = array();
        $condition['arrivalnotice_id'] = array('in', $arrivalnotice_id_array);
        $arrivalnotice_model = model('arrivalnotice');
        //批量删除
        $result = $arrivalnotice_model->delArrivalNotice($condition);
        if ($result){
            ds_json_encode(10000, lang('ds_common_del_succ'));
        }else{
            ds_json_encode(10001, lang('ds_common_del_fail'));
        }
    }
}