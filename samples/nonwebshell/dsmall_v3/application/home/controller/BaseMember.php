<?php

/**
 * 买家
 */

namespace app\home\controller;
use think\Lang;

class BaseMember extends BaseHome {

    protected $member_info = array();   // 会员信息

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/basemember.lang.php');
        /* 不需要登录就能访问的方法 */
        if (!in_array(request()->controller() ,array('cart')) && !in_array(request()->action(), array('ajax_load', 'add', 'del')) && !session('member_id')) {
            $ref_url = request_uri();
            $this->redirect(HOME_SITE_URL.'/Login/login.html?ref_url='.urlencode($ref_url));
        }
        //会员中心模板路径
        $this->template_dir = 'default/member/' . strtolower(request()->controller()) . '/';
        $this->member_info = $this->getMemberAndGradeInfo(true);
        $this->assign('member_info', $this->member_info);
    }

    /**
     *    当前选中的栏目
     */
    protected function setMemberCurItem($curitem = '') {
        $this->assign('member_item', $this->getMemberItemList());
        $this->assign('curitem', $curitem);
    }

    /**
     *    当前选中的子菜单
     */
    protected function setMemberCurMenu($cursubmenu = '') {
        $member_menu = $this->getMemberMenuList();
        $this->assign('member_menu', $member_menu);
        $curmenu = '';
        foreach ($member_menu as $key => $menu) {
            foreach ($menu['submenu'] as $subkey => $submenu) {
                if ($submenu['name'] == $cursubmenu) {
                    $curmenu = $menu['name'];
                    $nav = $submenu['text'];
                }
            }
        }
        
        // 面包屑
        $nav_link = array();
        $nav_link[] = array('title' => lang('homepage'), 'link' => HOME_SITE_URL);
        if ($curmenu == '') {
            $nav_link[] = array('title' => lang('ds_user_center'));
        } else {
            $nav_link[] = array('title' =>  lang('ds_user_center'), 'link' => url('Member/index'));
            $nav_link[] = array('title' => $nav);
        }


        $this->assign('nav_link_list', $nav_link);


        //当前一级菜单
        $this->assign('curmenu', $curmenu);
        //当前二级菜单
        $this->assign('cursubmenu', $cursubmenu);
    }

    /*
     * 获取卖家栏目列表,针对控制器下的栏目
     */

    protected function getMemberItemList() {
        return array();
    }

    /*
     * 获取卖家菜单列表
     */

    private function getMemberMenuList() {
        $menu_list = array(
            'info' =>
            array(
                'name' => 'info',
                'text' => lang('ds_data_management'),
                'url' => url('Memberinformation/index'),
                'submenu' => array(
                    array('name' => 'member_information', 'text' => lang('ds_account_information'), 'url' => url('Memberinformation/index'),),
                    array('name' => 'member_security', 'text' =>lang('ds_account_security'), 'url' => url('Membersecurity/index'),),
                    array('name' => 'member_address', 'text' => lang('ds_member_path_address'), 'url' => url('Memberaddress/index'),),
                    array('name' => 'member_message', 'text' => lang('ds_my_news'), 'url' => url('Membermessage/message'),),
                    array('name' => 'member_snsfriend', 'text' => lang('ds_my_good_friend'), 'url' => url('Membersnsfriend/index'),),
                    array('name' => 'member_goodsbrowse', 'text' => lang('ds_my_footprint'), 'url' => url('Membergoodsbrowse/listinfo'),),
                    array('name' => 'member_connect', 'text' => lang('ds_third_party_account_login'), 'url' => url('Memberconnect/qqbind'),),
                )
            ),
            'trade' =>
            array(
                'name' => 'trade',
                'text' => lang('ds_seller_order_manage'),
                'url' => url('Memberorder/index'),
                'submenu' => array(
                    array('name' => 'member_order', 'text' => lang('ds_real_order'), 'url' => url('Memberorder/index'),),
                    array('name' => 'member_vr_order', 'text' =>lang('ds_virtual_orders'), 'url' => url('Membervrorder/index'),),
                    array('name' => 'member_favorites', 'text' => lang('ds_member_path_favorites'), 'url' => url('Memberfavorites/fglist'),),
                    array('name' => 'member_evaluate', 'text' => lang('ds_trading_evaluation'), 'url' => url('Memberevaluate/index'),),
                    array('name' => 'predeposit', 'text' => lang('ds_account_balance'), 'url' => url('Predeposit/index'),),
                    array('name' => 'member_points', 'text' => lang('ds_member_points_manage'), 'url' => url('Memberpoints/index'),),
                    array('name' => 'member_voucher', 'text' => lang('ds_member_path_myvoucher'), 'url' => url('Membervoucher/index'),),
                )
            ),
            'server' =>
            array(
                'name' => 'server',
                'text' => lang('ds_customer_service'),
                'url' => url('Memberrefund/index'),
                'submenu' => array(
                    array('name' => 'member_refund', 'text' => lang('ds_refund_and_return'), 'url' => url('Memberrefund/index'),),
                    array('name' => 'member_complain', 'text' => lang('ds_trade_complaints'), 'url' => url('Membercomplain/index'),),
                    array('name' => 'member_consult', 'text' => lang('ds_commodity_consulting'), 'url' => url('Memberconsult/index'),),
                    array('name' => 'member_inform', 'text' => lang('ds_violation_to_report'), 'url' => url('Memberinform/index'),),
                    array('name' => 'member_mallconsult', 'text' => lang('ds_platform_for_customer_service'), 'url' => url('Membermallconsult/index'),),
                )
            ),
            array(
                'name' => 'sns',
                'text' => lang('ds_application_management'),
                'url' => url('Memberflea/index'),
                'submenu' => array(
                    array('name' => 'member_flea', 'text' => lang('ds_member_path_flea'), 'url' => url('Memberflea/index'),),
                )
            ),

        );
        if (config('inviter_open')) {
            //查看是否已是分销会员
            $inviter_model = model('inviter');
            $inviter_info = $inviter_model->getInviterInfo('i.inviter_id=' . session('member_id'));
            if ($inviter_info && $inviter_info['inviter_state'] == 1) {
                $menu_list['inviter'] = array(
                    'name' => 'inviter',
                    'text' => lang('ds_member_distribution'),
                    'url' => url('Memberinviter/index'),
                    'submenu' => array(
                        array('name' => 'inviter_poster', 'text' => lang('ds_distribution_information'), 'url' => url('Memberinviter/index'),),
                        array('name' => 'inviter_user', 'text' => lang('ds_distribution_member'), 'url' => url('Memberinviter/user'),),
                        array('name' => 'inviter_order', 'text' => lang('ds_distribution_commission'), 'url' => url('Memberinviter/order'),),
                    )
                );
            } else {
                $menu_list['inviter'] = array(
                    'name' => 'inviter',
                    'text' => lang('ds_member_distribution'),
                    'url' => url('Memberinviter/add'),
                    'submenu' => array(
                        array('name' => 'inviter_add', 'text' => lang('ds_become_member'), 'url' => url('Memberinviter/add'),),
                    )
                );
            }
        }
        return $menu_list;
    }
}

?>
