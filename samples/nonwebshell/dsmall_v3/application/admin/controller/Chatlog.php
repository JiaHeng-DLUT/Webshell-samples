<?php

namespace app\admin\controller;
use think\Lang;

class Chatlog extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize(); 
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/chatlog.lang.php');

        $add_time_to = date("Y-m-d",strtotime("+1 day"));
        $time_from = array();
        $time_from['7'] = strtotime($add_time_to) - 60 * 60 * 24 * 7;
        $time_from['90'] = strtotime($add_time_to) - 60 * 60 * 24 * 90;
        $add_time_from = date("Y-m-d", $time_from['90']);
        $this->assign('minDate', $add_time_from);//只能查看3个月内数据
        $this->assign('maxDate', $add_time_to);
        $time_add_from = input('param.add_time_from');
        $time_add_to = input('param.add_time_to');
        if (empty($time_add_from ) || $time_add_from  < $add_time_from) {//默认显示7天内数据
            $this->final_time_from = date("Y-m-d", $time_from['7']);
        }else{
            $this->final_time_from = $time_add_from;
        }
        if (empty($time_add_to) || $time_add_to > $add_time_to) {
            $this->final_time_to = $add_time_to;
        }else{
            $this->final_time_to = $time_add_to;
        }
        $this->assign('final_time_from', $this->final_time_from);//只能查看3个月内数据
        $this->assign('final_time_to', $this->final_time_to);
    }

    /**
     * 聊天记录查询
     */
    public function chatlog()
    {
        $webchat_model = model('webchat');
        $f_member = array();//发消息人
        $t_member = array();//收消息人
        $f_name = trim(input('param.f_name'));
        if (!empty($f_name)) {
            $condition = array();
            $condition['member_name'] = $f_name;
            $f_member = $webchat_model->getMemberInfo($condition);
            $this->assign('f_member', $f_member);
        }
        $t_name = trim(input('param.t_name'));
        if (!empty($t_name)) {
            $condition = array();
            $condition['member_name'] = $t_name;
            $t_member = $webchat_model->getMemberInfo($condition);
            $this->assign('t_member', $t_member);
        }
        if (isset($f_member['member_id']) && isset($t_member['member_id'])) {
            if ($f_member['member_id'] > 0 && $t_member['member_id'] > 0) {//验证账号
                $condition = array();
                $condition['add_time_from'] = trim($this->final_time_from);
                $condition['add_time_to'] = trim($this->final_time_to);
                $condition['f_id'] = intval($f_member['member_id']);
                $condition['t_id'] = intval($t_member['member_id']);
                $log_list = $webchat_model->getChatlogFromList($condition, 15);
                $log_list = array_reverse($log_list);
                $this->assign('log_list', $log_list);
                $this->assign('show_page', $webchat_model->page_info->render());
            }
        }
        $this->setAdminCurItem('chatlog');
        return $this->fetch('index');
    }

    /**
     * 聊天内容查询
     */
    public function msglog() {
        $webchat_model = model('webchat');
        $condition = array();
        $add_time_from = strtotime($this->final_time_from);
        $add_time_to = strtotime($this->final_time_to);
        $condition['chatlog_addtime'] = array('between', array($add_time_from, $add_time_to));
        //搜索关键词
        $t_msg = input('param.msg');
        if (!empty($t_msg)) {
            $condition['t_msg'] = array('like', '%' . $t_msg . '%');
        }
        $log_list = $webchat_model->getChatlogList($condition, 15);
        $log_list = array_reverse($log_list);
        $this->assign('log_list', $log_list);
        $this->assign('show_page', $webchat_model->page_info->render());
        $this->setAdminCurItem('msglog');
        return $this->fetch();
    }

    protected function getAdminItemList()
    {
        $menu_array = array(
            array(
                'name' => 'chatlog', 'text' => lang('ds_chatlog'), 'url' => url('Chatlog/chatlog')
            ),
            array(
                'name' => 'msglog', 'text' => lang('chatlog_content'), 'url' => url('Chatlog/msglog')
            ),
        );
        return $menu_array;
    }
}