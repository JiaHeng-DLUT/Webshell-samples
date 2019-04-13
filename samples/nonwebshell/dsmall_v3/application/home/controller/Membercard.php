<?php
namespace app\home\controller;
use think\Lang;
class Membercard extends BaseMall {

    /**
     * AJAX for membership information
     */
    public function index() {
        $ownid = session('member_id');
        $uid = intval(input('get.uid'));

        $member_info = db('member')->field('member_id, member_name, member_truename, member_sex, member_email, member_qq, member_ww, member_areainfo, member_birthday, member_privacy, member_exppoints')->find($uid);
        if (empty($member_info)) {
            echo 'false';
            exit;
        }
        if ($member_info['member_privacy'] != '') {
            $member_info['member_privacy'] = unserialize($member_info['member_privacy']);
        }

        //会员详情及会员级别处理
        if ($member_info) {
            $member_gradeinfo = model('member')->getOneMemberGrade(intval($member_info['member_exppoints']));
            $member_info = array_merge($member_info, $member_gradeinfo);
        }

        if ($ownid == $uid) {
            $followed = 2;
        } else {
            // Whether to pay attention to yourself(own)
            $followed = 0; // 0 stranger, 1 friend, 2 own
            $where = array();
            $where['friend_frommid'] = $uid;
            $where['friend_tomid'] = $ownid;
            $friend_info = db('snsfriend')->where($where)->find();
            if (!empty($friend_info)) {
                $followed = 1;
            }
        }
        $data = array();
        $data['id'] = $member_info['member_id'];
        $data['name'] = $member_info['member_name'];
        $data['avatar'] = get_member_avatar_for_id($member_info['member_id']);
        $data['truename'] = ($followed >= intval($member_info['member_privacy']['truename']) && !empty($member_info['member_truename'])) ? $member_info['member_truename'] : '';
        $data['sex'] = ($followed >= intval($member_info['member_privacy']['sex']) && !empty($member_info['member_sex'])) ? $member_info['member_sex'] : 3;
        $data['email'] = ($followed >= intval($member_info['member_privacy']['email']) && !empty($member_info['member_email'])) ? $member_info['member_email'] : lang('home_member_privary');
        $data['qq'] = ($followed >= intval($member_info['member_privacy']['qq']) && !empty($member_info['member_qq'])) ? $member_info['member_qq'] : '';
        $data['ww'] = ($followed >= intval($member_info['member_privacy']['ww']) && !empty($member_info['member_ww'])) ? $member_info['member_ww'] : '';
        $data['areainfo'] = ($followed >= intval($member_info['member_privacy']['area']) && !empty($member_info['member_areainfo'])) ? $member_info['member_areainfo'] : lang('home_member_privary');
        $data['birthday'] = ($followed >= intval($member_info['member_privacy']['birthday']) && !empty($member_info['member_birthday'])) ? $member_info['member_birthday'] : lang('home_member_privary');
        $data['level_name'] = $member_info['level_name'];

        switch (input('get.from')) {
            case 'shop':
                $data['url'] = HOME_SITE_URL;
                break;
            default:
                $data['url'] = '';
                break;
        }
        if ($ownid == $uid) {
            $data['follow'] = 2; // 0 stranger, 1 friend, 2 own
        } else {
            // Whether to pay attention to me
            $where = array();
            $where['friend_frommid'] = $ownid;
            $where['friend_tomid'] = $uid;
            $friend_info = db('snsfriend')->where($where)->find();
            $data['follow'] = (!empty($friend_info)) ? 1 : 0;
        }
        // Pay attention to the number of
        $data['attention_count'] = db('snsfriend')->where(array('friend_frommid' => $uid))->count();

        // Number of fans
        $data['fans_count'] = db('snsfriend')->where(array('friend_tomid' => $uid))->count();
        echo $_GET['callback'] . '(' . json_encode($data) . ')';
    }

    public function mcard_info() {
        echo 'false';
        exit;
    }

}
