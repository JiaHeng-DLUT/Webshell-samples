<?php

namespace app\admin\controller;

use think\Controller;

class AdminControl extends Controller {

    /**
     * 管理员资料 name id group
     */
    protected $admin_info;

    protected $permission;
    public function _initialize() {
        $this->admin_info = $this->systemLogin();
        $config_list = rkcache('config', true);
        config($config_list);
        
        if ($this->admin_info['admin_id'] != 1) {
            // 验证权限
            $this->checkPermission();
        }
        $this->setMenuList();
    }

    /**
     * 取得当前管理员信息
     *
     * @param
     * @return 数组类型的返回结果
     */
    protected final function getAdminInfo() {
        return $this->admin_info;
    }

    /**
     * 系统后台登录验证
     *
     * @param
     * @return array 数组类型的返回结果
     */
    protected final function systemLogin() {
        $admin_info = array(
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'admin_gid' => session('admin_gid'),
            'admin_is_super' => session('admin_is_super'),
        );
        if (empty($admin_info['admin_id']) || empty($admin_info['admin_name']) || !isset($admin_info['admin_gid']) || !isset($admin_info['admin_is_super'])) {
            session(null);
            $this->redirect('Admin/Login/index');
        }

        return $admin_info;
    }

    public function setMenuList() {
        $menu_list = $this->menuList();

        $menu_list=$this->parseMenu($menu_list);
        $this->assign('menu_list', $menu_list);
    }

    /**
     * 验证当前管理员权限是否可以进行操作
     *
     * @param string $link_nav
     * @return
     */
    protected final function checkPermission($link_nav = null){
        if ($this->admin_info['admin_is_super'] == 1) return true;

        $controller = request()->controller();
        $action = request()->action();
        if (empty($this->permission)){
            
            $admin_model=model('admin');
            $gadmin = $admin_model->getOneGadmin(array('gid'=>$this->admin_info['admin_gid']));
            
            $permission = ds_decrypt($gadmin['glimits'],MD5_KEY.md5($gadmin['gname']));
            $this->permission = $permission = explode('|',$permission);
        }else{
            $permission = $this->permission;
        }
        //显示隐藏小导航，成功与否都直接返回
        if (is_array($link_nav)){
            if (!in_array("{$link_nav['controller']}.{$link_nav['action']}",$permission) && !in_array($link_nav['controller'],$permission)){
                return false;
            }else{
                return true;
            }
        }
        //以下几项不需要验证
        $tmp = array('Index','Dashboard','Login');
        if (in_array($controller,$tmp)){
            return true;
        }
        if (in_array($controller,$permission) || in_array("$controller.$action",$permission)){
            return true;
        }else{
            $extlimit = array('ajax','export_step1');
            if (in_array($action,$extlimit) && (in_array($controller,$permission) || strpos(serialize($permission),'"'.$controller.'.'))){
                return true;
            }
            //带前缀的都通过
            foreach ($permission as $v) {
                if (!empty($v) && strpos("$controller.$action",$v.'_') !== false) {
                    return true;break;
                }
            }
        }
        $this->error(lang('ds_assign_right'),'Dashboard/welcome');
    }

    /**
     * 过滤掉无权查看的菜单
     *
     * @param array $menu
     * @return array
     */
    private final function parseMenu($menu = array()) {
        if ($this->admin_info['admin_is_super'] == 1) {
            return $menu;
        }
        foreach ($menu as $k => $v) {
            foreach ($v['children'] as $ck => $cv) {
                $tmp = explode(',', $cv['args']);
                //以下几项不需要验证
                $except = array('Index', 'Dashboard', 'Login');
                if (in_array($tmp[1], $except))
                    continue;
                if (!in_array($tmp[1], array_values($this->permission))) {
                    unset($menu[$k]['children'][$ck]);
                }
            }
            if (empty($menu[$k]['children'])) {
                unset($menu[$k]);
                unset($menu[$k]['children']);
            }
        }
        return $menu;
    }

    /**
     * 记录系统日志
     *
     * @param $lang 日志语言包
     * @param $state 1成功0失败null不出现成功失败提示
     * @param $admin_name
     * @param $admin_id
     */
    protected final function log($lang = '', $state = 1, $admin_name = '', $admin_id = 0) {
        if ($admin_name == '') {
            $admin_name = session('admin_name');
            $admin_id = session('admin_id');
        }
        $data = array();
        if (is_null($state)) {
            $state = null;
        } else {
            $state = $state ? '' : lang('ds_fail');
        }
        $data['adminlog_content'] = $lang . $state;
        $data['adminlog_time'] = TIMESTAMP;
        $data['admin_name'] = $admin_name;
        $data['admin_id'] = $admin_id;
        $data['adminlog_ip'] = request()->ip();
        $data['adminlog_url'] = request()->controller() . '&' . request()->action();
        
        $adminlog_model=model('adminlog');
        return $adminlog_model->addAdminlog($data);
    }

    /**
     * 添加到任务队列
     *
     * @param array $goods_array
     * @param boolean $ifdel 是否删除以原记录
     */
    protected function addcron($data = array(), $ifdel = false) {
        $cron_model = model('cron');
        if (isset($data[0])) { // 批量插入
            $where = array();
            foreach ($data as $k => $v) {
                if (isset($v['content'])) {
                    $data[$k]['content'] = serialize($v['content']);
                }
                // 删除原纪录条件
                if ($ifdel) {
                    $where[] = '(type = ' . $data['type'] . ' and exeid = ' . $data['exeid'] . ')';
                }
            }
            // 删除原纪录
            if ($ifdel) {
                $cron_model->delCron(implode(',', $where));
            }
            $cron_model->addCronAll($data);
        } else { // 单条插入
            if (isset($data['content'])) {
                $data['content'] = serialize($data['content']);
            }
            // 删除原纪录
            if ($ifdel) {
                $cron_model->delCron(array('type' => $data['type'], 'exeid' => $data['exeid']));
            }
            $cron_model->addCron($data);
        }
    }

    /**
     * 当前选中的栏目
     */
    protected function setAdminCurItem($curitem = '') {
        $this->assign('admin_item', $this->getAdminItemList());
        $this->assign('curitem', $curitem);
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        return array();
    }

    /*
     * 侧边栏列表
     */

    function menuList() {
        return array(
            'dashboard' => array(
                'name' => 'dashboard',
                'text' => lang('ds_dashboard'),
                'children' => array(
                    'welcome' => array(
                        'ico'=>"&#xe649;",
                        'text' => lang('ds_welcome'),
                        'args' => 'welcome,Dashboard,dashboard',
                    ),
                    /*
                    'aboutus' => array(
                        'text' => lang('ds_aboutus'),
                        'args' => 'aboutus,dashboard,dashboard',
                    ),
                     */
                    'config' => array(
                        'ico'=>'&#xe632;',
                        'text' => lang('ds_base'),
                        'args' => 'base,Config,dashboard',
                    ),
                    'member' => array(
                        'ico'=>'&#xe609;',
                        'text' => lang('ds_member_manage'),
                        'args' => 'member,Member,dashboard',
                    ),
                ),
            ),
            'setting' => array(
                'name' => 'setting',
                'text' => lang('ds_setting'),
                'children' => array(
                    'config' => array(
                        'ico'=>'&#xe632;',
                        'text' => lang('ds_base'),
                        'args' => 'base,Config,setting',
                    ),
                    'account' => array(
                        'ico'=>'&#xe613;',
                        'text' => lang('ds_account'),
                        'args' => 'qq,Account,setting',
                    ),
                    'upload_set' => array(
                        'ico'=>'&#xe65b;',
                        'text' => lang('ds_upload_set'),
                        'args' => 'default_thumb,Upload,setting',
                    ),
                    'seo' => array(
                        'ico'=>'&#xe632;',
                        'text' => lang('ds_seo_set'),
                        'args' => 'index,Seo,setting',
                    ),
                    'message' => array(
                        'ico'=>'&#xe652;',
                        'text' => lang('ds_message'),
                        'args' => 'email,Message,setting',
                    ),
                    'payment' => array(
                        'ico'=>'&#xe674;',
                        'text' => lang('ds_payment'),
                        'args' => 'index,Payment,setting',
                    ),
                    'admin' => array(
                        'ico'=>'&#xe615;',
                        'text' => lang('ds_admin'),
                        'args' => 'admin,Admin,setting',
                    ),
                    'express' => array(
                        'ico'=>'&#xe640;',
                        'text' => lang('ds_express'),
                        'args' => 'index,Express,setting',
                    ),
                    'waybill' => array(
                        'ico'=>'&#xe654;',
                        'text' => lang('ds_waybill'),
                        'args' => 'index,Waybill,setting',
                    ),
//                    'Delivery' => array(
//                        'ico'=>'&#xe640;',
//                        'text' => lang('ds_delivery'),
//                        'args' => 'index,Delivery,setting',
//                    ),
                    'Region' => array(
                        'ico'=>'&#xe655;',
                        'text' => lang('ds_region'),
                        'args' => 'index,Region,setting',
                    ),
                    'offpayarea' => array(
                        'ico'=>'&#xe655;',
                        'text' => lang('ds_offpayarea'),
                        'args' => 'index,Offpayarea,setting',
                    ),
                    'db' => array(
                        'ico'=>'&#xe644;',
                        'text' => lang('ds_db'),
                        'args' => 'db,Db,setting',
                    ),
                    'admin_log' => array(
                        'ico'=>'&#xe654;',
                        'text' => lang('ds_adminlog'),
                        'args' => 'loglist,Adminlog,setting',
                    ),
                ),
            ),
            'member' => array(
                'name' => 'member',
                'text' => lang('ds_member'),
                'children' => array(
                    'member' => array(
                        'ico'=>'&#xe609;',
                        'text' => lang('ds_member_manage'),
                        'args' => 'member,Member,member',
                    ),
                    'membergrade' => array(
                        'ico'=>'&#xe61d;',
                        'text' => lang('ds_membergrade'),
                        'args' => 'index,Membergrade,member',
                    ),
                    'exppoints' => array(
                        'ico'=>'&#xe645;',
                        'text' => lang('ds_exppoints'),
                        'args' => 'index,Exppoints,member',
                    ),
                    'notice' => array(
                        'ico'=>'&#xe652;',
                        'text' => lang('ds_notice'),
                        'args' => 'index,Notice,member',
                    ),
                    'points' => array(
                        'ico'=>'&#xe644;',
                        'text' => lang('ds_points'),
                        'args' => 'index,Points,member',
                    ),
                    'predeposit' => array(
                        'ico'=>'&#xe671;',
                        'text' => lang('ds_predeposit'),
                        'args' => 'pdrecharge_list,Predeposit,member',
                    ),
                    'snsmalbum' => array(
                        'ico'=>'&#xe65b;',
                        'text' => lang('ds_snsmalbum'),
                        'args' => 'index,Snsmalbum,member',
                    ),
                    'snsmember' => array(
                        'text' => lang('ds_snsmember'),
                        'args' => 'index,Snsmember,member',
                    ),
                    'chatlog' => array(
                        'ico'=>'&#xe654;',
                        'text' => lang('ds_chatlog'),
                        'args' => 'chatlog,Chatlog,member',
                    ),
                ),
            ),
            'goods' => array(
                'name' => 'goods',
                'text' => lang('ds_goods'),
                'children' => array(
                    'goodsclass' => array(
                        'ico'=>'&#xe661;',
                        'text' => lang('ds_goodsclass'),
                        'args' => 'goods_class,Goodsclass,goods',
                    ),
                    'Brand' => array(
                        'ico'=>'&#xe66c;',
                        'text' => lang('ds_brand'),
                        'args' => 'index,Brand,goods',
                    ),
                    'Goods' => array(
                        'ico'=>'&#xe661;',
                        'text' => lang('ds_goods_manage'),
                        'args' => 'index,Goods,goods',
                    ),
                    'Type' => array(
                        'ico'=>'&#xe659;',
                        'text' => lang('ds_type'),
                        'args' => 'index,Type,goods',
                    ),
                    'Spec' => array(
                        'ico'=>'&#xe653;',
                        'text' => lang('ds_spec'),
                        'args' => 'index,Spec,goods',
                    ),
                    'album' => array(
                        'ico'=>'&#xe65b;',
                        'text' => lang('ds_album'),
                        'args' => 'index,GoodsAlbum,goods',
                    ),
                    'Arrivalnotice' => array(
                        'ico'=>'&#xe661;',
                        'text' => lang('ds_arrivalnotice'),
                        'args' => 'index,Arrivalnotice,goods',
                    ),
                ),
            ),
            'store' => array(
                'name' => 'store',
                'text' => lang('ds_store'),
                'children' => array(
                    'Store' => array(
                        'ico'=>'&#xe607;',
                        'text' => lang('ds_store_manage'),
                        'args' => 'store,Store,store',
                    ),
                    'Storemoney' => array(
                        'ico'=>'&#xe671;',
                        'text' => lang('ds_store_money'),
                        'args' => 'index,Storemoney,store',
                    ),
                    'Storedeposit' => array(
                        'ico'=>'&#xe65c;',
                        'text' => lang('ds_store_deposit'),
                        'args' => 'index,Storedeposit,store',
                    ),
                    'Storegrade' => array(
                        'ico'=>'&#xe61d;',
                        'text' => lang('ds_storegrade'),
                        'args' => 'index,Storegrade,store',
                    ),
                    'Storeclass' => array(
                        'ico'=>'&#xe604;',
                        'text' => lang('ds_storeclass'),
                        'args' => 'store_class,Storeclass,store',
                    ),
                    'Storesnstrace' => array(
                        'ico'=>'&#xe646;',
                        'text' => lang('ds_storesnstrace'),
                        'args' => 'index,Storesnstrace,store',
                    ),
                    'Storehelp' => array(
                        'ico'=>'&#xe621;',
                        'text' => lang('ds_Storehelp'),
                        'args' => 'index,Storehelp,store',
                    ),
                    'Storejoin' => array(
                        'ico'=>'&#xe675;',
                        'text' => lang('ds_storejoin'),
                        'args' => 'index,Storejoin,store',
                    ),
                    'Ownshop' => array(
                        'ico'=>'&#xe63b;',
                        'text' => lang('ds_ownshop'),
                        'args' => 'index,Ownshop,store',
                    ),
                ),
            ),
            'trade' => array(
                'name' => 'trade',
                'text' => lang('ds_trade'),
                'children' => array(
                    'order' => array(
                        'ico'=>'&#xe631;',
                        'text' => lang('ds_order'),
                        'args' => 'index,Order,trade',
                    ),
                    'vrorder' => array(
                        'ico'=>'&#xe654;',
                        'text' => lang('ds_vrorder'),
                        'args' => 'index,Vrorder,trade',
                    ),
                    'refund' => array(
                        'ico'=>'&#xe624;',
                        'text' => lang('ds_refund'),
                        'args' => 'refund_manage,Refund,trade',
                    ),
                    'return' => array(
                        'ico'=>'&#xe642;',
                        'text' => lang('ds_return'),
                        'args' => 'return_manage,Returnmanage,trade',
                    ),
                    'vrrefund' => array(
                        'ico'=>'&#xe624;',
                        'text' => lang('ds_vrrefund'),
                        'args' => 'refund_manage,Vrrefund,trade',
                    ),
                    'Bill' => array(
                        'ico'=>'&#xe631;',
                        'text' => lang('ds_bill_manage'),
                        'args' => 'show_statis,Bill,trade',
                    ),
                    'consulting' => array(
                        'ico'=>'&#xe670;',
                        'text' => lang('ds_consulting'),
                        'args' => 'Consulting,Consulting,trade',
                    ),
                    'inform' => array(
                        'ico'=>'&#xe66f;',
                        'text' => lang('ds_inform'),
                        'args' => 'inform_list,Inform,trade',
                    ),
                    'evaluate' => array(
                        'ico'=>'&#xe641;',
                        'text' => lang('ds_evaluate'),
                        'args' => 'evalgoods_list,Evaluate,trade',
                    ),
                    'complain' => array(
                        'ico'=>'&#xe676;',
                        'text' => lang('ds_complain'),
                        'args' => 'complain_new_list,Complain,trade',
                    ),
                ),
            ),
            'website' => array(
                'name' => 'website',
                'text' => lang('ds_website'),
                'children' => array(
                    'Articleclass' => array(
                        'ico'=>'&#xe604;',
                        'text' => lang('ds_articleclass'),
                        'args' => 'index,Articleclass,website',
                    ),
                    'Article' => array(
                        'ico'=>'&#xe65b;',
                        'text' => lang('ds_article'),
                        'args' => 'index,Article,website',
                    ),
                    'Document' => array(
                        'text' => lang('ds_document'),
                        'args' => 'index,Document,website',
                    ),
                    'Navigation' => array(
                        'text' => lang('ds_navigation'),
                        'args' => 'index,Navigation,website',
                    ),
                    'Adv' => array(
                        'text' => lang('ds_adv'),
                        'args' => 'ap_manage,Adv,website',
                    ),
                    'Link' => array(
                        'ico'=>'&#xe617;',
                        'text' => lang('ds_link'),
                        'args' => 'index,Link,website',
                    ),
                    'Mallconsult' => array(
                        'ico'=>'&#xe66d;',
                        'text' => lang('ds_mall_consult'),
                        'args' => 'index,Mallconsult,website',
                    ),
                ),
            ),
            'operation' => array(
                'name' => 'operation',
                'text' => lang('ds_operation'),
                'children' => array(
                    'Operation' => array(
                        'ico'=>'&#xe662;',
                        'text' => lang('ds_operation_set'),
                        'args' => 'setting,Operation,operation',
                    ),
                    'Inviter' => array(
                        'ico'=>'&#xe662;',
                        'text' => lang('ds_inviter_set'),
                        'args' => 'setting,Inviter,operation',
                    ),
                    'Groupbuy' => array(
                        'ico'=>'&#xe668;',
                        'text' => lang('ds_groupbuy'),
                        'args' => 'index,Groupbuy,operation',
                    ),
                    'Vrgroupbuy' => array(
                        'ico'=>'&#xe668;',
                        'text' => lang('ds_groupbuy_vr'),
                        'args' => 'index,Vrgroupbuy,operation',
                    ),
                    'Pintuan' => array(
                        'text' => lang('ds_promotion_pintuan'),
                        'args' => 'index,Promotionpintuan,operation',
                    ),
                    'Xianshi' => array(
                        'text' => lang('ds_promotion_xianshi'),
                        'args' => 'index,Promotionxianshi,operation',
                    ),
                    'Mansong' => array(
                        'text' => lang('ds_promotion_mansong'),
                        'args' => 'index,Promotionmansong,operation',
                    ),
                    'Bundling' => array(
                        'text' => lang('ds_promotion_bundling'),
                        'args' => 'index,Promotionbundling,operation',
                    ),
                    'Booth' => array(
                        'text' => lang('ds_promotion_booth'),
                        'args' => 'index,Promotionbooth,operation',
                    ),
                    'Mgdiscount' => array(
                        'ico'=>'&#xe61d;',
                        'text' => lang('ds_promotion_mgdiscount'),
                        'args' => 'mgdiscount_store,Promotionmgdiscount,operation',
                    ),
                    'Voucher' => array(
                        'ico'=>'&#xe658;',
                        'text' => lang('ds_voucher_price_manage'),
                        'args' => 'index,Voucher,operation',
                    ),
                    'Activity' => array(
                        'text' => lang('ds_activity_manage'),
                        'args' => 'index,Activity,operation',
                    ),
                    'Pointprod' => array(
                        'ico'=>'&#xe646;',
                        'text' => lang('ds_pointprod'),
                        'args' => 'index,Pointprod,operation',
                    ),
                    'rechargecard' => array(
                        'ico'=>'&#xe643;',
                        'text' => lang('ds_rechargecard'),
                        'args' => 'index,Rechargecard,operation',
                    ),
                ),
            ),
            'stat' => array(
                'name' => 'stat',
                'text' => lang('ds_stat'),
                'children' => array(
                    'stat_general' => array(
                        'ico'=>'&#xe662;',
                        'text' => lang('ds_statgeneral'),
                        'args' => 'general,Statgeneral,stat',
                    ),
                    'stat_industry' => array(
                        'text' => lang('ds_statindustry'),
                        'args' => 'scale,Statindustry,stat',
                    ),
                    'stat_member' => array(
                        'ico'=>'&#xe665;',
                        'text' => lang('ds_statmember'),
                        'args' => 'newmember,Statmember,stat',
                    ),
                    'stat_store' => array(
                        'ico'=>'&#xe607;',
                        'text' => lang('ds_statstore'),
                        'args' => 'newstore,Statstore,stat',
                    ),
                    'stat_trade' => array(
                        'text' => lang('ds_stattrade'),
                        'args' => 'income,Stattrade,stat',
                    ),
                    'stat_goods' => array(
                        'ico'=>'&#xe661;',
                        'text' => lang('ds_statgoods'),
                        'args' => 'pricerange,Statgoods,stat',
                    ),
                    'stat_marketing' => array(
                        'text' => lang('ds_statmarketing'),
                        'args' => 'promotion,Statmarketing,stat',
                    ),
                    'stat_stataftersale' => array(
                        'text' => lang('ds_stataftersale'),
                        'args' => 'refund,Stataftersale,stat',
                    ),
                ),
            ),
            'mobile' => array(
                'name' => 'mobile',
                'text' => lang('mobile'),
                'children' => array(
                    'mb_category_list' => array(
                        'text' => lang('mb_category_list'),
                        'args' => 'mb_category_list,mbcategorypic,mobile',
                    ),
                    'mb_feedback' => array(
                        'ico'=>'&#xe60f;',
                        'text' => lang('mb_feedback'),
                        'args' => 'flist,mbfeedback,mobile',
                    ),
                    'app_appadv' => array(
                        'text' => lang('appadv'),
                        'args' => 'index,Appadv,mobile',
                    ),
                ),
            ),
            'wechat' => array(
                'name' => 'wechat',
                'text' => lang('wechat'),
                'children' => array(
                    'wechat_setting' => array(
                        'ico'=>'&#xe632;',
                        'text' => lang('wechat'),
                        'args' => 'setting,Wechat,wechat',
                    ),
                    'wechat_menu' => array(
                        'ico'=>'&#xe614;',
                        'text' => lang('wechat_menu'),
                        'args' => 'menu,Wechat,wechat',
                    ),
                    'wechat_keywords' => array(
                        'ico'=>'&#xe610;',
                        'text' => lang('wechat_keywords'),
                        'args' => 'k_text,Wechat,wechat',
                    ),
                    'wechat_member' => array(
                        'ico'=>'&#xe65a;',
                        'text' => lang('wechat_member'),
                        'args' => 'member,Wechat,wechat',
                    ),
                    'wechat_push' => array(
                        'ico'=>'&#xe652;',
                        'text' => lang('wechat_push'),
                        'args' => 'SendList,Wechat,wechat',
                    ),
                ),
            ),
            'flea' => array(
                'name' => 'flea',
                'text' => lang('flea'),
                'children' => array(
                    'flea_mes' => array(
                        'text' => lang('flea_mes'),
                        'args' => 'flea,Flea,flea',
                    ),
                    'flea_index' => array(
                        'ico'=>'&#xe632;',
                        'text' => lang('flea_seo'),
                        'args' => 'index,Fleaseo,flea',
                    ),
                     'flea_class' => array(
                         'ico'=>'&#xe601;',
                         'text' => lang('flea_class'),
                         'args' => 'flea_class,Fleaclass,flea',
                     ),
                    'flea_class_index' => array(
                        'ico'=>'&#xe669;',
                        'text' => lang('flea_class_index'),
                        'args' => 'flea_class_index,Fleaclassindex,flea',
                    ),
                    'flea_region' => array(
                        'ico'=>'&#xe655;',
                        'text' => lang('flea_region'),
                        'args' => 'flea_region,Flearegion,flea',
                    ),
                    'adv_manage' => array(
                        'ico'=>'&#xe65b;',
                        'text' => lang('adv_manage'),
                        'args' => 'adv_manage,Fleaseo,flea',
                    ),
                ),
            ),

        );
    }

    /*
     * 权限选择列表
     */

    function limitList() {
        $_limit = array(
            array('name' => lang('ds_setting'), 'child' => array(
                    array('name' => lang('ds_base'), 'action' => null, 'controller' => 'Config'),
                    array('name' => lang('ds_account'), 'action' => null, 'controller' => 'Account'),
                    array('name' => lang('ds_upload_set'), 'action' => null, 'controller' => 'Upload'),
                    array('name' => lang('ds_seo_set'), 'action' => null, 'controller' => 'Seo'),
                    array('name' => lang('ds_payment'), 'action' => null, 'controller' => 'Payment'),
                    array('name' => lang('ds_message'), 'action' => null, 'controller' => 'Message'),
                    array('name' => lang('ds_express'), 'action' => null, 'controller' => 'Express'),
                    array('name' => lang('ds_waybill'), 'action' => null, 'controller' => 'Waybill'),
                    array('name' => lang('ds_region'), 'action' => null, 'controller' => 'Region'),
                    array('name' => lang('ds_offpayarea'), 'action' => null, 'controller' => 'Offpayarea'),
                    array('name' => lang('ds_adminlog'), 'action' => null, 'controller' => 'Adminlog'),
                )),
            array('name' => lang('ds_goods'), 'child' => array(
                    array('name' => lang('ds_goods_manage'), 'action' => null, 'controller' => 'Goods'),
                    array('name' => lang('ds_goodsclass'), 'action' => null, 'controller' => 'Goodsclass'),
                    array('name' => lang('ds_brand'), 'action' => null, 'controller' => 'Brand'),
                    array('name' => lang('ds_type'), 'action' => null, 'controller' => 'Type'),
                    array('name' => lang('ds_spec'), 'action' => null, 'controller' => 'Spec'),
                    array('name' => lang('ds_album'), 'action' => null, 'controller' => 'GoodsAlbum'),
                )),
            array('name' => lang('ds_store'), 'child' => array(
                    array('name' => lang('ds_store_manage'), 'action' => null, 'controller' => 'Store'),
                    array('name' => lang('ds_storegrade'), 'action' => null, 'controller' => 'Storegrade'),
                    array('name' => lang('ds_storeclass'), 'action' => null, 'controller' => 'Storeclass'),
                    array('name' => lang('ds_Storehelp'), 'action' => null, 'controller' => 'Storehelp'),
                    array('name' => lang('ds_storejoin'), 'action' => null, 'controller' => 'Storejoin'),
                    array('name' => lang('ds_ownshop'), 'action' => null, 'controller' => 'Ownshop'),
                )),
            array('name' => lang('ds_member'), 'child' => array(
                    array('name' => lang('ds_member_manage'), 'action' => null, 'controller' => 'Member'),
                    array('name' => lang('ds_membergrade'), 'action' => null, 'controller' => 'Membergrade'),
                    array('name' => lang('ds_exppoints'), 'action' => null, 'controller' => 'Exppoints'),
                    array('name' => lang('ds_points'), 'action' => null, 'controller' => 'Points'),
                    array('name' => lang('ds_snsmalbum'), 'action' => null, 'controller' => 'Snsmalbum'),
                    array('name' => lang('ds_snsmember'), 'action' => null, 'controller' => 'Snsmember'),
                    array('name' => lang('ds_predeposit'), 'action' => null, 'controller' => 'Predeposit'),
                    array('name' => lang('ds_chatlog'), 'action' => null, 'controller' => 'Chatlog'),
                )),
            array('name' => lang('ds_trade'), 'child' => array(
                    array('name' => lang('ds_order'), 'action' => null, 'controller' => 'Order'),
                    array('name' => lang('ds_vrorder'), 'action' => null, 'controller' => 'Vrorder'),
                    array('name' => lang('ds_refund'), 'action' => null, 'controller' => 'Refund'),
                    array('name' => lang('ds_return'), 'action' => null, 'controller' => 'Returnmanage'),
                    array('name' => lang('ds_vrrefund'), 'action' => null, 'controller' => 'Vrrefund'),
                    array('name' => lang('ds_consulting'), 'action' => null, 'controller' => 'Consulting'),
                    array('name' => lang('ds_inform'), 'action' => null, 'controller' => 'Inform'),
                    array('name' => lang('ds_evaluate'), 'action' => null, 'controller' => 'Evaluate'),
                    array('name' => lang('ds_complain'), 'action' => null, 'controller' => 'Complain'),
                )),
            array('name' => lang('ds_website'), 'child' => array(
                    array('name' => lang('ds_articleclass'), 'action' => null, 'controller' => 'Articleclass'),
                    array('name' => lang('ds_article'), 'action' => null, 'controller' => 'Article'),
                    array('name' => lang('ds_document'), 'action' => null, 'controller' => 'Document'),
                    array('name' => lang('ds_navigation'), 'action' => null, 'controller' => 'Navigation'),
                    array('name' => lang('ds_adv'), 'action' => null, 'controller' => 'Adv'),
                    array('name' => lang('ds_link'), 'action' => null, 'controller' => 'Link'),
                )),
            array('name' => lang('ds_operation'), 'child' => array(
                    array('name' => lang('ds_operation_set'), 'action' => null, 'controller' => 'Operation'),
                    array('name' => lang('ds_groupbuy'), 'action' => null, 'controller' => 'Groupbuy'),
                    array('name' => lang('ds_groupbuy_vr'), 'action' => null, 'controller' => 'Vrgroupbuy'),
                    array('name' => lang('ds_activity_manage'), 'action' => null, 'controller' => 'Activity'),
                    array('name' => lang('ds_promotion_xianshi'), 'action' => null, 'controller' => 'Promotionxianshi'),
                    array('name' => lang('ds_promotion_mansong'), 'action' => null, 'controller' => 'Promotionmansong'),
                    array('name' => lang('ds_promotion_bundling'), 'action' => null, 'controller' => 'Promotionbundling'),
                    array('name' => lang('ds_promotion_booth'), 'action' => null, 'controller' => 'Promotionbooth'),
                    array('name' => lang('ds_pointprod'), 'action' => null, 'controller' => 'Pointprod|Pointorder'),
                    array('name' => lang('ds_voucher_price_manage'), 'action' => null, 'controller' => 'Voucher'),
                    array('name' => lang('ds_bill_manage'), 'action' => null, 'controller' => 'Bill'),
                    array('name' => lang('ds_activity_manage'), 'action' => null, 'controller' => 'Vrbill'),
                    array('name' => lang('ds_mall_consult'), 'action' => null, 'controller' => 'Mallconsult'),
                    array('name' => lang('ds_rechargecard'), 'action' => null, 'controller' => 'Rechargecard'),
                    array('name' => lang('ds_delivery'), 'action' => null, 'controller' => 'Delivery')
                )),
            array('name' => lang('ds_stat'), 'child' => array(
                    array('name' => lang('ds_statgeneral'), 'action' => null, 'controller' => 'Statgeneral'),
                    array('name' => lang('ds_statindustry'), 'action' => null, 'controller' => 'Statindustry'),
                    array('name' => lang('ds_statmember'), 'action' => null, 'controller' => 'Statmember'),
                    array('name' => lang('ds_statstore'), 'action' => null, 'controller' => 'Statstore'),
                    array('name' => lang('ds_stattrade'), 'action' => null, 'controller' => 'Stattrade'),
                    array('name' => lang('ds_statgoods'), 'action' => null, 'controller' => 'Statgoods'),
                    array('name' => lang('ds_statmarketing'), 'action' => null, 'controller' => 'Statmarketing'),
                    array('name' => lang('ds_stataftersale'), 'action' => null, 'controller' => 'Stataftersale'),
                )),
        );

        return $_limit;
    }

}

?>
