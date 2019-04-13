<?php
namespace app\admin\controller;

use think\Lang;

class Notice extends AdminControl
{
    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH.'admin/lang/'.config('default_lang').'/notice.lang.php');
    }

    /**
     * 发送通知列表
     */
    public function index()
    {
        $condition = array();
        $condition['message_type'] = 1;
        $message_model = model('message');
        $message_list = $message_model->getMessageList($condition,10);
        $this->assign('message_list', $message_list);
        $this->assign('show_page', $message_model->page_info->render());
        $this->setAdminCurItem('index');
        return $this->fetch();
    }
    /**
     * 会员通知
     */
    public function notice(){
        //提交
        if (request()->isPost()) {
            $notice_validate = validate('notice');
            $content = trim(input('param.content1')); //信息内容
            $send_type = intval(input('param.send_type'));
            //验证
            switch ($send_type) {
                //指定会员
                case 1:
                    $data = [
                        "user_name" => input("param.user_name")
                    ];
                    if (!$notice_validate->scene('notice1')->check($data)) {
                        $this->error($notice_validate->getError());
                    }
                    break;
                //全部会员
                case 2:
                    break;
            }
            $data = [
                "content1" => $content
            ];
            if (!$notice_validate->scene('notice2')->check($data)) {
                $this->error($notice_validate->getError());
            } else {
                //发送会员ID 数组
                $memberid_list = array();
                //整理发送列表
                //指定会员
                if ($send_type == 1) {
                    $member_model = model('member');
                    $tmp = explode("\n", input('param.user_name'));
                    if (!empty($tmp)) {
                        foreach ($tmp as $k => $v) {
                            $tmp[$k] = trim($v);
                        }
                        //查询会员列表
                        $member_list = $member_model->getMemberList(array('member_name' => array('in', $tmp)));
                        unset($membername_str);
                        if (!empty($member_list)) {
                            foreach ($member_list as $k => $v) {
                                $memberid_list[] = $v['member_id'];
                            }
                        }
                        unset($member_list);
                    }
                    unset($tmp);
                }
                if (empty($memberid_list) && $send_type != 2) {
                    $this->error(lang('notice_index_member_error'));
                }
                //接收内容
                $array = array();
                $array['send_mode'] = 1;
                $array['user_name'] = $memberid_list;
                $array['content'] = $content;
                //添加短消息
                $message_model = model('message');
                $insert_arr = array();
                $insert_arr['from_member_id'] = 0;
                if ($send_type == 2) {
                    $insert_arr['member_id'] = 'all';
                } else {
                    $insert_arr['member_id'] = "," . implode(',', $memberid_list) . ",";
                }
                $insert_arr['msg_content'] = $content;
                $insert_arr['message_type'] = 1;
                $insert_arr['message_ismore'] = 1;
                $message_model->addMessage($insert_arr);
                //跳转
                $this->log(lang('notice_index_send'), 1);
                dsLayerOpenSuccess(lang('notice_index_send_succ'));
//                $this->success(lang('notice_index_send_succ'), 'notice/notice');
            }
        } else {
            return $this->fetch('notice_add');
        }
    }
    protected function getAdminItemList()
    {
        $menu_array=array(
            array(
                'name'=>'index','text'=>'会员通知','url'=>url('Notice/index')
            ),
            array(
                'name'=>'notice','text'=>'发送通知','url'=>"javascript:dsLayerOpen('".url('Notice/notice')."','新增用户')"
            )
        );
        return $menu_array;
    }
}