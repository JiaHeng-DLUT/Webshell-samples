<?php

/**
 * 积分管理
 */

namespace app\admin\controller;

use think\Lang;

class Points extends AdminControl {
    const EXPORT_SIZE = 5000;
    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/points.lang.php');
    }

    public function index() {
        if (!request()->isPost()) {
            $condition_arr = array();
            $mname = input('param.mname');
            if (!empty($mname)) {
                $condition_arr['pl_membername'] = array('like', '%' . $mname . '%');
            }
            $aname = input('param.aname');
            if (!empty($aname)) {
                $condition_arr['pl_adminname'] = array('like', '%' . $aname . '%');
            }
            $stage = input('get.stage');
            if ($stage) {
                $condition_arr['pl_stage'] = trim($stage);
            }
            $stime = input('get.stime');
            $etime = input('get.etime');
            $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $stime);
            $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $etime);
            $start_unixtime = $if_start_time ? strtotime($stime) : null;
            $end_unixtime = $if_end_time ? strtotime($etime) : null;
            if ($start_unixtime || $end_unixtime) {
                $condition_arr['pl_addtime'] = array('between', array($start_unixtime, $end_unixtime));
            }
            
            $search_desc = trim(input('param.description'));
            if (!empty($search_desc)) {
                $condition_arr['pl_desc'] = array('like', "%" . $search_desc . "%");
            }


            $points_model = model('points');
            $list_log = $points_model->getPointslogList($condition_arr, 10, '*', '');

            $this->assign('pointslog', $list_log);
            $this->assign('show_page', $points_model->page_info->render());
            $this->setAdminCurItem('index');
            return $this->fetch();
        }
    }

    //积分明细查询
    function pointslog() {
        if (!request()->isPost()) {
            return $this->fetch();
        } else {
            $data = [
                'member_name' => input('post.member_name'),
                'points_type' => input('post.points_type'),
                'points_num' => intval(input('post.points_num')),
                'points_desc' => input('post.points_desc'),
            ];
            $point_validate = validate('point');
            if (!$point_validate->scene('pointslog')->check($data)) {
                $this->error($point_validate->getError());
            }

            $member_name = $data['member_name'];
            $member_info = model('member')->getMemberInfo(array('member_name' => $member_name));
            if (!is_array($member_info) || count($member_info) <= 0) {
                $this->error(lang('admin_points_userrecord_error'));
            }
            if ($data['points_type'] == 2 && $data['points_num'] > $member_info['member_points']) {
                $this->error(lang('admin_points_points_short_error') . $member_info['member_points']);
            }
            //积分数据记录
            $insert_arr['pl_memberid'] = $member_info['member_id'];
            $insert_arr['pl_membername'] = $member_info['member_name'];
            if ($data['points_type'] == 2) {
                $insert_arr['pl_points'] = -$data['points_num'];
            } else {
                $insert_arr['pl_points'] = $data['points_num'];
            }
            $insert_arr['pl_desc'] = $data['points_desc'];
            $insert_arr['pl_adminname'] = session('admin_name');

            $result = model('points')->savePointslog('system', $insert_arr);
            if ($result) {
                dsLayerOpenSuccess(lang('ds_common_op_succ'));
            } else {
                $this->error(lang('error'), 'Points/index');
            }
        }
    }

    public function checkmember() {
        $name = trim(input('param.name'));
        if (!$name) {
            exit(json_encode(array('id' => 0)));
        }
        $member_info = model('member')->getMemberInfo(array('member_name' => $name));
        if (is_array($member_info) && count($member_info) > 0) {
            echo json_encode(array('id' => $member_info['member_id'], 'name' => $member_info['member_name'], 'points' => $member_info['member_points']));
        } else {
            exit(json_encode(array('id' => 0)));
            die;
        }
    }


	/**
     * 积分日志列表导出
     */
    public function export_step1() {
        $condition_arr = array();
        
        $mname = input('param.mname');
        if (!empty($mname)) {
            $condition_arr['pl_membername'] = array('like', '%' . $mname . '%');
        }
        $aname = input('param.aname');
        if (!empty($aname)) {
            $condition_arr['pl_adminname'] = array('like', '%' . $aname . '%');
        }
        
        $stage = input('get.stage');
        if ($stage) {
            $condition_arr['pl_stage'] = trim($stage);
        }
        $stime = input('get.stime');
        $etime = input('get.etime');
        $if_start_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $stime);
        $if_end_time = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $etime);
        $start_unixtime = $if_start_time ? strtotime($stime) : null;
        $end_unixtime = $if_end_time ? strtotime($etime) : null;
        if ($start_unixtime || $end_unixtime) {
            $condition_arr['pl_addtime'] = array('between', array($start_unixtime, $end_unixtime));
        }
        $search_desc = trim(input('param.description'));
        if (!empty($search_desc)) {
            $condition_arr['pl_desc'] = array('like', "%" . $search_desc . "%");
        }
        
        
        $points_model = model('points');
        
        if (!is_numeric(input('param.curpage'))) {
            $count = $points_model->getPointsCount($condition_arr);
            $array = array();
            if ($count > self::EXPORT_SIZE) { //显示下载链接
                $page = ceil($count / self::EXPORT_SIZE);
                for ($i = 1; $i <= $page; $i++) {
                    $limit1 = ($i - 1) * self::EXPORT_SIZE + 1;
                    $limit2 = $i * self::EXPORT_SIZE > $count ? $count : $i * self::EXPORT_SIZE;
                    $array[$i] = $limit1 . ' ~ ' . $limit2;
                }
                $this->assign('export_list', $array);
                return $this->fetch('/public/excel');
            } else { //如果数量小，直接下载
                $list_log = $points_model->getPointsLogList($condition_arr, '', '*', self::EXPORT_SIZE);
                $this->createExcel($list_log);
            }
        } else { //下载
            $limit1 = (input('param.curpage') - 1) * self::EXPORT_SIZE;
            $limit2 = self::EXPORT_SIZE;
            $list_log = $points_model->getPointsLogList($condition_arr, '', '*', "$limit1,$limit2");
            $this->createExcel($list_log);
        }
    }

    /**
     * 生成excel
     *
     * @param array $data
     */
    private function createExcel($data = array()) {
        Lang::load(APP_PATH .'admin/lang/'.config('default_lang').'/export.lang.php');
        $excel_obj = new \excel\Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id' => 's_title', 'Font' => array('FontName' => '宋体', 'Size' => '12', 'Bold' => '1')));
        //header
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_pi_member'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_pi_system'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_pi_point'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_pi_time'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_pi_jd'));
        $excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_pi_ms'));
        $state_cn = array(lang('admin_points_stage_regist'), lang('admin_points_stage_login'), lang('admin_points_stage_comments'), lang('admin_points_stage_order'), lang('admin_points_stage_system'), lang('admin_points_stage_pointorder'), lang('admin_points_stage_app'));
        foreach ((array) $data as $k => $v) {
            $tmp = array();
            $tmp[] = array('data' => $v['pl_membername']);
            $tmp[] = array('data' => $v['pl_adminname']);
            $tmp[] = array('format' => 'Number', 'data' => ds_price_format($v['pl_points']));
            $tmp[] = array('data' => date('Y-m-d H:i:s', $v['pl_addtime']));
            $tmp[] = array('data' => str_replace(array('regist', 'login', 'comments', 'order', 'system', 'pointorder', 'app'), $state_cn, $v['pl_stage']));
            $tmp[] = array('data' => $v['pl_desc']);

            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data, CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset(lang('exp_pi_jfmx'), CHARSET));
        $excel_obj->generateXML($excel_obj->charset(lang('exp_pi_jfmx'), CHARSET) . input('param.curpage') . '-' . date('Y-m-d-H', time()));
    }

    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'index',
                'text' => '积分明细',
                'url' => url('Points/index')
            ),
            array(
                'name' => 'pointslog',
                'text' => '积分调整',
                'url' => "javascript:dsLayerOpen('".url('Points/pointslog')."','积分调整')"
            )
        );
        return $menu_array;
    }

}
