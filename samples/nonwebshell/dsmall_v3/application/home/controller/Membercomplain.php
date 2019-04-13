<?php

/*
 * 交易投诉
 */

namespace app\home\controller;

use think\Lang;

class Membercomplain extends BaseMember {
    //定义投诉状态常量

    const STATE_NEW = 10;
    const STATE_APPEAL = 20;
    const STATE_TALK = 30;
    const STATE_HANDLE = 40;
    const STATE_FINISH = 99;
    const STATE_UNACTIVE = 1;
    const STATE_ACTIVE = 2;

    public function _initialize() {
        parent::_initialize(); 
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/membercomplain.lang.php');
        $complain_model = model('complain');
        $condition['accuser_id'] = session('member_id');
        $list = $complain_model->getComplainList($condition);
        $goods_list = $complain_model->getComplainGoodsList($list);
        $this->assign('goods_list', $goods_list);
    }

    /*
     * 我的投诉页面
     */

    public function index() {
        /*
         * 得到当前用户的投诉列表
         */
        $complain_model = model('complain');
        $condition = array();
        $condition['accuser_id'] = session('member_id');
        switch (intval(input('param.select_complain_state'))) {
            case 1:
                $condition['complain_state'] = array('lt',90);
                break;
            case 2:
                $condition['complain_state'] = 99;
                break;
        }
        $complain_list = $complain_model->getComplainList($condition);
        /* 设置买家当前菜单 */
        $this->setMemberCurMenu('member_complain');
        /* 设置买家当前栏目 */
        $this->setMemberCurItem('complain_list');
        $this->assign('complain_list', $complain_list);
        $this->assign('show_page', '');
        $goods_list = $complain_model->getComplainGoodsList($complain_list);
        $this->assign('goods_list', $goods_list);
        return $this->fetch($this->template_dir . 'index');
    }

    /*
     * 新投诉
     */

    public function complain_new() {
        $order_id = intval(input('order_id'));
        $goods_id = intval(input('goods_id')); //订单商品表编号
        if ($order_id < 1 || $goods_id < 1) {//参数验证
            $this->error(lang('wrong_argument'), 'Memberorder/index');
        }
        $condition = array();
        $condition['buyer_id'] = session('member_id');
        $condition['order_id'] = $order_id;
        $refundreturn_model = model('refundreturn');
        $order_info = $refundreturn_model->getRightOrderList($condition, $goods_id);
        //halt($order_info);
        $this->assign('return_info', $order_info);
        //检查订单是否可以投诉
        $order_model = model('order');
        $if_complain = $order_model->getOrderOperateState('complain', $order_info);
        if ($if_complain < 1) {
            $this->error(lang('param_error'));
        }
        //检查是不是正在进行投诉
        if ($this->check_complain_exist($goods_id)) {
            $this->error(lang('complain_repeat')); //'您已经投诉了该订单请等待处理'
        }

        //获取投诉类型
        $complainsubject_model = model('complainsubject');
        $param = array();
        $complain_subject_list = $complainsubject_model->getActiveComplainsubject($param);
        if (empty($complain_subject_list)) {
            $this->error(lang('complain_subject_error'));
        }
        $refundreturn_model = model('refundreturn');
        $order_info['extend_order_goods'] = $order_info['goods_list'];
        $order_list[$order_id] = $order_info;
        $order_list = $refundreturn_model->getGoodsRefundList($order_list);

        if (isset($order_list[$order_id]['extend_complain'][$goods_id]) && intval($order_list[$order_id]['extend_complain'][$goods_id]) == 1) {//退款投诉
            $complainsubject_model = model('complainsubject');
            $complain_subject = $complainsubject_model->getComplainsubject(array('complainsubject_id' => 1)); //投诉主题
            $complain_subject_list = array_merge($complain_subject, $complain_subject_list);
        }
        $this->assign('subject_list', $complain_subject_list);
        $this->assign('goods_id', $goods_id);
        /* 设置买家当前菜单 */
        $this->setMemberCurMenu('member_complain');
        /* 设置买家当前栏目 */
        $this->setMemberCurItem('complain_list');
        return $this->fetch($this->template_dir . 'complain_new');
    }

    /*
     * 处理投诉请求
     */

    public function complain_show() {
        $complain_id = intval(input('complain_id'));
        //获取投诉详细信息
        $complain_info = $this->get_complain_info($complain_id);
        $this->assign('complain_info', $complain_info);
        $complain_pic = array();
        $appeal_pic = array();
        for ($i = 1; $i <= 3; $i++) {
            if (!empty($complain_info['complain_pic' . $i])) {
                $complain_pic[$i] = $complain_info['complain_pic' . $i];
            }
            if (!empty($complain_info['appeal_pic' . $i])) {
                $appeal_pic[$i] = $complain_info['appeal_pic' . $i];
            }
        }
        $this->assign('complain_pic', $complain_pic);
        $this->assign('appeal_pic', $appeal_pic);
        $condition = array();
        $condition['buyer_id'] = session('member_id');
        $condition['order_id'] = $complain_info['order_id'];
        $refundreturn_model = model('refundreturn');
        $return_info = $refundreturn_model->getRightOrderList($condition, $complain_info['order_goods_id']);
        $this->assign('return_info', $return_info);
        /* 设置买家当前菜单 */
        $this->setMemberCurMenu('member_complain');
        /* 设置买家当前栏目 */
        $this->setMemberCurItem('complain_list');
        return $this->fetch($this->template_dir . 'complain_show');
    }

    /*
     * 保存用户提交的投诉
     */

    public function complain_save() {
        //获取输入的投诉信息
        $input = array();
        $input['order_id'] = intval(input('post.input_order_id'));
        $input['order_goods_id'] = intval(input('post.input_goods_id'));
        $condition = array();
        $condition['buyer_id'] = session('member_id');
        $condition['order_id'] = $input['order_id'];
        $order_model = model('order');
        $order_info = $order_model->getOrderInfo($condition);
        $if_complain = $order_model->getOrderOperateState('complain', $order_info); //检查订单是否可以投诉
        if ($if_complain < 1) {
            $this->error(lang('param_error'),url('Memberorder/index'));
        }
        //检查是不是正在进行投诉
        if ($this->check_complain_exist($input['order_goods_id'])) {
            $this->error(lang('complain_repeat'));
        }
        list($input['complain_subject_id'], $input['complain_subject_content']) = explode(',', trim(input('post.input_complain_subject')));
        $input['complain_content'] = trim(input('post.input_complain_content'));
        $input['accuser_id'] = $order_info['buyer_id'];
        $input['accuser_name'] = $order_info['buyer_name'];
        $input['accused_id'] = $order_info['store_id'];
        $input['accused_name'] = $order_info['store_name'];
        $input['complain_datetime'] = time();
        $input['complain_state'] = self::STATE_NEW;
        $input['complain_active'] = self::STATE_UNACTIVE;
        $pic_name = $this->upload_pic(); //上传图片
        $input['complain_pic1'] = isset($pic_name[1]) ? $pic_name[1] : '';
        $input['complain_pic2'] = isset($pic_name[2]) ? $pic_name[2] : '';
        $input['complain_pic3'] = isset($pic_name[3]) ? $pic_name[3] : '';
        $complain_model = model('complain');
        $state = $complain_model->addComplain($input); //保存投诉信息
        if ($state) {
            $this->success(lang('complain_submit_success'), url('Membercomplain/index'));
        } else {
            $this->error(lang('ds_common_save_fail'));
        }
    }

    /*
     * 保存用户提交的补充证据
     */

    public function complain_add_pic() {
        $complain_id = input('param.complain_id');
        //获取投诉详细信息
        $complain_info = $this->get_complain_info($complain_id);
        if (request()->isPost()) {
            $where_array = array();
            $where_array['complain_id'] = $complain_id;
            //获取输入的投诉信息
            $input = array();
            $pic_name = $this->upload_pic();
            $input['complain_pic1'] = isset($pic_name[1]) ? $pic_name[1] : '';
            $input['complain_pic2'] = isset($pic_name[2]) ? $pic_name[2] : '';
            $input['complain_pic3'] = isset($pic_name[3]) ? $pic_name[3] : '';

            //保存投诉信息
            $complain_model = model('complain');
            $complain_model->editComplain($input, $where_array);
            $this->success(lang('ds_common_save_succ'));
        }
    }

    /*
     * 取消用户提交的投诉
     */

    public function complain_cancel() {
        $complain_id = intval(input('param.complain_id'));
        $complain_info = $this->get_complain_info($complain_id);
        if (intval($complain_info['complain_state']) === 10) {
            $pics = array();
            if (!empty($complain_info['complain_pic1']))
                $pics[] = $complain_info['complain_pic1'];
            if (!empty($complain_info['complain_pic2']))
                $pics[] = $complain_info['complain_pic2'];
            if (!empty($complain_info['complain_pic3']))
                $pics[] = $complain_info['complain_pic3'];
            if (!empty($pics)) {//删除图片
                foreach ($pics as $pic) {
                    $pic = BASE_UPLOAD_PATH . DS . ATTACH_PATH . DS . 'complain' . DS . $pic;
                    if (file_exists($pic)) {
                        @unlink($pic);
                    }
                }
            }
            $complain_model = model('complain');
            $complain_model->delComplain(array('complain_id' => $complain_id));
            ds_json_encode(10000,lang('complain_cancel_success'));
        } else {
            ds_json_encode(10001,lang('complain_cancel_fail'));
        }
    }

    /*
     * 处理用户申请仲裁
     */

    public function apply_handle() {
        $complain_id = intval(input('post.input_complain_id'));
        //获取投诉详细信息
        $complain_info = $this->get_complain_info($complain_id);
        $complain_state = intval($complain_info['complain_state']);
        //检查当前是不是投诉状态
        if ($complain_state < self::STATE_TALK || $complain_state === 99) {
            ds_json_encode(10001,lang('param_error'));
        }
        $update_array = array();
        $update_array['complain_state'] = self::STATE_HANDLE;
        $where_array = array();
        $where_array['complain_id'] = $complain_id;
        //保存投诉信息
        $complain_model = model('complain');
        $complain_model->editComplain($update_array, $where_array);
        ds_json_encode(10000,lang('handle_submit_success'));
    }

    /*
     * 根据投诉id获取投诉对话
     */

    public function get_complain_talk() {
        $complain_id = intval(input('post.complain_id'));
        $complain_info = $this->get_complain_info($complain_id);
        $complaintalk_model = model('complaintalk');
        $param = array();
        $param['complain_id'] = $complain_id;
        $complain_talk_list = $complaintalk_model->getComplaintalkList($param);
        $talk_list = array();
        $i = 0;
        foreach ($complain_talk_list as $talk) {
            $talk_list[$i]['css'] = $talk['talk_member_type'];
            $talk_list[$i]['talk'] = date("Y-m-d H:i:s", $talk['talk_datetime']);
            switch ($talk['talk_member_type']) {
                case 'accuser':
                    $talk_list[$i]['talk'] .= lang('complain_accuser');
                    break;
                case 'accused':
                    $talk_list[$i]['talk'] .= lang('complain_accused');
                    break;
                case 'admin':
                    $talk_list[$i]['talk'] .= lang('complain_admin');
                    break;
                default:
                    $talk_list[$i]['talk'] .= lang('complain_unknow');
            }
            if (intval($talk['talk_state']) === 2) {
                $talk['talk_content'] = lang('talk_forbit_message');
            }
            $talk_list[$i]['talk'] .= '(' . $talk['talk_member_name'] . ')' . lang('complain_text_say') . ':' . $talk['talk_content'];
            $i++;
        }

        echo json_encode($talk_list);
    }

    /*
     * 根据发布投诉对话
     */

    public function publish_complain_talk() {
        $complain_id = intval(input('post.complain_id'));
        $complain_talk = trim(input('post.complain_talk'));
        $talk_len = strlen($complain_talk);
        if ($talk_len > 0 && $talk_len < 255) {
            $complain_info = $this->get_complain_info($complain_id);
            $complain_state = intval($complain_info['complain_state']);
            //检查投诉是否是可发布对话状态
            if ($complain_state > self::STATE_APPEAL && $complain_state < self::STATE_FINISH) {
                $complaintalk_model = model('complaintalk');
                $param = array();
                $param['complain_id'] = $complain_id;
                $param['talk_member_id'] = $complain_info['accuser_id'];
                $param['talk_member_name'] = $complain_info['accuser_name'];
                $param['talk_member_type'] = $complain_info['member_status'];

                $param['talk_content'] = $complain_talk;
                $param['talk_state'] = 1;
                $param['talk_admin'] = 0;
                $param['talk_datetime'] = time();
                if ($complaintalk_model->addComplaintalk($param)) {
                    echo json_encode('success');
                } else {
                    echo json_encode('error2');
                }
            } else {
                echo json_encode('error');
            }
        } else {
            echo json_encode('error1');
        }
    }

    /*
     * 获取投诉信息
     */

    private function get_complain_info($complain_id) {
        $complain_model = model('complain');
        $complain_info = $complain_model->getOneComplain($complain_id);
        if ($complain_info['accuser_id'] != session('member_id')) {
            $this->error(lang('param_error'));
        }
        $complain_info['member_status'] = 'accuser';
        $complain_info['complain_state_text'] = $this->get_complain_state_text($complain_info['complain_state']);
        return $complain_info;
    }

    /*
     * 检查投诉是否已经存在
     */

    private function check_complain_exist($goods_id) {
        $complain_model = model('complain');
        $param = array();
        $param['order_goods_id'] = $goods_id;
        $param['accuser_id'] = session('member_id');
        $param['complain_state'] = array('lt',90);
        return $complain_model->isComplainExist($param);
    }

    /*
     * 获得投诉状态文本
     */

    private function get_complain_state_text($complain_state) {
        switch (intval($complain_state)) {
            case self::STATE_NEW:
                return lang('complain_state_new');
                break;
            case self::STATE_APPEAL:
                return lang('complain_state_appeal');
                break;
            case self::STATE_TALK:
                return lang('complain_state_talk');
                break;
            case self::STATE_HANDLE:
                return lang('complain_state_handle');
                break;
            case self::STATE_FINISH:
                return lang('complain_state_finish');
                break;
            default:
                $this->error(lang('param_error'));
        }
    }

    private function upload_pic() {
        $complain_pic = array();
        $complain_pic[1] = 'input_complain_pic1';
        $complain_pic[2] = 'input_complain_pic2';
        $complain_pic[3] = 'input_complain_pic3';
        $pic_name = array();
        $count = 1;
        foreach ($complain_pic as $pic) {
            if (!empty($_FILES[$pic]['name'])) {
                $upload = request()->file($pic);
                $uploaddir = BASE_UPLOAD_PATH . DS . ATTACH_PATH . DS . 'complain' . DS;
                $result = $upload->rule('uniqid')->validate(['ext' => ALLOW_IMG_EXT])->move($uploaddir);
                if ($result) {
                    $pic_name[$count] = $result->getFilename();
                } else {
                    $pic_name[$count] = '';
                }
            }
            $count++;
        }
        return $pic_name;
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param array $array 附加菜单
     * @return
     */
    public function getMemberItemList() {
        $menu_array = array(
            array(
                'name' => 'complain_list',
                'text' => lang('complain_manage_title'),
                'url' => url('Membercomplain/index')
            )
        );
        return $menu_array;
    }

}

?>
