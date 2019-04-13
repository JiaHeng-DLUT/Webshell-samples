<?php

/*
 * 卖家相关控制中心
 */

namespace app\home\controller;
use think\Lang;

class BaseSeller extends BaseMall
{

    //店铺信息
    protected $store_info = array();

    public function _initialize()
    {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/' . config('default_lang') . '/basemember.lang.php');
        Lang::load(APP_PATH . 'home/lang/' . config('default_lang') . '/baseseller.lang.php');
        //卖家中心模板路径
        $this->template_dir = 'default/seller/' . strtolower(request()->controller()) . '/';
        if (request()->controller() != 'Sellerlogin') {
            if (!session('member_id')) {
                $this->redirect('Home/Sellerlogin/login');
            }
            if (!session('seller_id')) {
                $this->redirect('Home/Sellerlogin/login');
            }

            // 验证店铺是否存在
            $store_model = model('store');
            $this->store_info = $store_model->getStoreInfoByID(session('store_id'));
            if (empty($this->store_info)) {
                $this->redirect('Home/Sellerlogin/login');
            }

            // 店铺关闭标志
            if (intval($this->store_info['store_state']) === 0) {
                $this->assign('store_closed', true);
                $this->assign('store_close_info', $this->store_info['store_close_info']);
            }

            // 店铺等级
            if (session('is_platform_store')) {
                $this->store_grade = array(
                    'storegrade_id' => '0',
                    'storegrade_name' => lang('exclusive_grade_stores'),
                    'storegrade_goods_limit' => '0',
                    'storegrade_album_limit' => '0',
                    'storegrade_space_limit' => '999999999',
                    'storegrade_template_number' => '6',
                    // 'storegrade_template' => 'default|style1|style2|style3|style4|style5',
                    'storegrade_price' => '0.00',
                    'storegrade_description' => '',
                    'storegrade_function' => 'editor_multimedia',
                    'storegrade_sort' => '0',
                );
            } else {
                $store_grade = rkcache('storegrade', true);
                $this->store_grade = @$store_grade[$this->store_info['grade_id']];
            }
            if (session('seller_is_admin') !== 1 && request()->controller() !== 'Seller' && request()->controller() !== 'Sellerlogin') {
                if (!in_array(request()->controller(), session('seller_limits'))) {
                    $this->error(lang('have_no_legalpower'), 'Seller/index');
                }
            }
        }
    }

    /**
     * 记录卖家日志
     *
     * @param $content 日志内容
     * @param $state 1成功 0失败
     */
    protected function recordSellerlog($content = '', $state = 1)
    {
        $seller_info = array();
        $seller_info['sellerlog_content'] = $content;
        $seller_info['sellerlog_time'] = TIMESTAMP;
        $seller_info['sellerlog_seller_id'] = session('seller_id');
        $seller_info['sellerlog_seller_name'] = session('seller_name');
        $seller_info['sellerlog_store_id'] = session('store_id');
        $seller_info['sellerlog_seller_ip'] = request()->ip();
        $seller_info['sellerlog_url'] = request()->module() . '/' . request()->controller() . '/' . request()->action();
        $seller_info['sellerlog_state'] = $state;
        $sellerlog_model = model('sellerlog');
        $sellerlog_model->addSellerlog($seller_info);
    }

    /**
     * 记录店铺费用
     *
     * @param $storecost_price 费用金额
     * @param $storecost_remark 费用备注
     */
    protected function recordStorecost($storecost_price, $storecost_remark)
    {
        // 平台店铺不记录店铺费用
        if (check_platform_store()) {
            return false;
        }
        $storecost_model = model('storecost');
        $param = array();
        $param['storecost_store_id'] = session('store_id');
        $param['storecost_seller_id'] = session('seller_id');
        $param['storecost_price'] = $storecost_price;
        $param['storecost_remark'] = $storecost_remark;
        $param['storecost_state'] = 0;
        $param['storecost_time'] = TIMESTAMP;
        $storecost_model->addStorecost($param);

        // 发送店铺消息
        $param = array();
        $param['code'] = 'store_cost';
        $param['store_id'] = session('store_id');
        $param['param'] = array(
            'price' => $storecost_price,
            'seller_name' => session('seller_name'),
            'remark' => $storecost_remark
        );

        \mall\queue\QueueClient::push('sendStoremsg', $param);
    }

    /**
     * 添加到任务队列
     *
     * @param array $goods_array
     * @param boolean $ifdel 是否删除以原记录
     */
    protected function addcron($data = array(), $ifdel = false)
    {
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
     *    当前选中的栏目
     */
    protected function setSellerCurItem($curitem = '')
    {
        $this->assign('seller_item', $this->getSellerItemList());
        $this->assign('curitem', $curitem);
    }

    /**
     *    当前选中的子菜单
     */
    protected function setSellerCurMenu($cursubmenu = '')
    {
        $seller_menu = $this->getSellerMenuList();
        $this->assign('seller_menu', $seller_menu);
        $curmenu = '';
        foreach ($seller_menu as $key => $menu) {
            foreach ($menu['submenu'] as $subkey => $submenu) {
                if ($submenu['name'] == $cursubmenu) {
                    $curmenu = $menu['name'];
                }
            }
        }
        //当前一级菜单
        $this->assign('curmenu', $curmenu);
        //当前二级菜单
        $this->assign('cursubmenu', $cursubmenu);
    }

    /*
     * 获取卖家栏目列表,针对控制器下的栏目
     */

    protected function getSellerItemList()
    {
        return array();
    }

    /*
     * 获取卖家菜单列表
     */

    private function getSellerMenuList()
    {
        //controller  注意第一个字母要大写
        $menu_list = array(
            'sellergoods' =>
                array(
                    'name' => 'sellergoods',
                    'text' => lang('site_search_goods'),
                    'url' => url('Sellergoodsonline/index'),
                    'submenu' => array(
                        array('name' => 'sellergoodsadd', 'text' => lang('goods_released'), 'controller' => 'Sellergoodsadd', 'url' => url('Sellergoodsadd/index'),),
                        array('name' => 'sellergoodsonline', 'text' => lang('goods_on_sale'), 'controller' => 'Sellergoodsonline', 'url' => url('Sellergoodsonline/index'),),
                        array('name' => 'sellergoodsoffline', 'text' => lang('warehouse_goods'), 'controller' => 'Sellergoodsoffline', 'url' => url('Sellergoodsoffline/index'),),
                        array('name' => 'sellerplate', 'text' => lang('associated_format'), 'controller' => 'Sellerplate', 'url' => url('Sellerplate/index'),),
                        array('name' => 'sellerspec', 'text' => lang('product_specifications'), 'controller' => 'Sellerspec', 'url' => url('Sellerspec/index'),),
                        array('name' => 'selleralbum', 'text' => lang('image_space'), 'controller' => 'Selleralbum', 'url' => url('Selleralbum/index'),),
                    )
                ),
            'sellerorder' =>
                array(
                    'name' => 'sellerorder',
                    'text' => lang('pointsorderdesc_1'),
                    'url' => url('Sellerorder/index'),
                    'submenu' => array(
                        array('name' => 'sellerorder', 'text' => lang('order_physical_transaction'), 'controller' => 'Sellerorder', 'url' => url('Sellerorder/index'),),
                        array('name' => 'sellervrorder', 'text' => lang('code_order'), 'controller' => 'Sellervrorder', 'url' => url('Sellervrorder/index'),),
                        array('name' => 'sellerdeliver', 'text' => lang('delivery_management'), 'controller' => 'Sellerdeliver', 'url' => url('Sellerdeliver/index'),),
                        array('name' => 'sellerdeliverset', 'text' => lang('delivery_settings'), 'controller' => 'Sellerdeliverset', 'url' => url('Sellerdeliverset/index'),),
                        array('name' => 'sellerwaybill', 'text' => lang('waybill_template'), 'controller' => 'Sellerwaybill', 'url' => url('Sellerwaybill/index')),
                        array('name' => 'sellerevaluate', 'text' => lang('evaluation_management'), 'controller' => 'Sellerevaluate', 'url' => url('Sellerevaluate/index'),),
                        array('name' => 'sellertransport', 'text' => lang('sales_area'), 'controller' => 'Sellertransport', 'url' => url('Sellertransport/index'),),
                        array('name' => 'Sellerbill', 'text' => lang('physical_settlement'), 'controller' => 'Sellerbill', 'url' => url('Sellerbill/index'),),
                    )
                ),
            'sellergroupbuy' =>
                array(
                    'name' => 'sellergroupbuy',
                    'text' => lang('sales_promotion'),
                    'url' => url('Sellergroupbuy/index'),
                    'submenu' => array(
                        array('name' => 'Sellergroupbuy', 'text' => lang('snap_up_management'), 'controller' => 'Sellergroupbuy', 'url' => url('Sellergroupbuy/index'),),
                        array('name' => 'Sellerpromotionxianshi', 'text' => lang('time_discount'), 'controller' => 'Sellerpromotionxianshi', 'url' => url('Sellerpromotionxianshi/index'),),
                        array('name' => 'Sellermgdiscount', 'text' => lang('membership_level_discount'), 'controller' => 'Sellerpromotionmgdiscount', 'url' => url('Sellerpromotionmgdiscount/mgdiscount_store'),),
                        array('name' => 'Sellerpromotionpintuan', 'text' => lang('syndication'), 'controller' => 'Sellerpromotionpintuan', 'url' => url('Sellerpromotionpintuan/index'),),
                        array('name' => 'Sellerpromotionmansong', 'text' => lang('free_on_delivery'), 'controller' => 'Sellerpromotionmansong', 'url' => url('Sellerpromotionmansong/index'),),
                        array('name' => 'Sellerpromotionbundling', 'text' => lang('discount_package'), 'controller' => 'Sellerpromotionbundling', 'url' => url('Sellerpromotionbundling/index'),),
                        array('name' => 'Sellerpromotionbooth', 'text' => lang('recommended_stand'), 'controller' => 'Sellerpromotionbooth', 'url' => url('Sellerpromotionbooth/index'),),
                        array('name' => 'Sellervoucher', 'text' => lang('voucher_management'), 'controller' => 'Sellervoucher', 'url' => url('Sellervoucher/templatelist'),),
                        array('name' => 'Selleractivity', 'text' => lang('activity_management'), 'controller' => 'Selleractivity', 'url' => url('Selleractivity/index'),),
                    )
                ),
            'seller' =>
                array(
                    'name' => 'seller',
                    'text' => lang('site_search_store'),
                    'url' => url('Seller/index'),
                    'submenu' => array(
                        array('name' => 'seller_index', 'text' => lang('store_overview'), 'controller' => 'Seller', 'url' => url('Seller/index'),),
                        array('name' => 'seller_setting', 'text' => lang('store_setup'), 'controller' => 'Sellersetting', 'url' => url('Sellersetting/setting'),),
                        array('name' => 'seller_navigation', 'text' => lang('store_navigation'), 'controller' => 'Sellernavigation', 'url' => url('Sellernavigation/index'),),
                        array('name' => 'sellersns', 'text' => lang('store_dynamics'), 'controller' => 'Sellersns', 'url' => url('Sellersns/index'),),
                        array('name' => 'sellerinfo', 'text' => lang('store_information'), 'controller' => 'Sellerinfo', 'url' => url('Sellerinfo/index'),),
                        array('name' => 'sellergoodsclass', 'text' => lang('store_classification'), 'controller' => 'Sellergoodsclass', 'url' => url('Sellergoodsclass/index'),),
                        array('name' => 'sellerlive', 'text' => lang('offline_store'), 'controller' => 'Sellerlive', 'url' => url('Sellerlive/index'),),
                        array('name' => 'seller_brand', 'text' => lang('brand_application'), 'controller' => 'Sellerbrand', 'url' => url('Sellerbrand/index'),),
                    )
                ),
            'sellerconsult' =>
                array(
                    'name' => 'sellerconsult',
                    'text' => lang('after_sales_service'),
                    'url' => url('Sellerconsult/index'),
                    'submenu' => array(
                        array('name' => 'seller_consult', 'text' => lang('consulting_management'), 'controller' => 'Sellerconsult', 'url' => url('Sellerconsult/index'),),
                        array('name' => 'seller_complain', 'text' => lang('complaint_record'), 'controller' => 'Sellercomplain', 'url' => url('Sellercomplain/index'),),
                        array('name' => 'seller_refund', 'text' => lang('refund_paragraph'), 'controller' => 'Sellerrefund', 'url' => url('Sellerrefund/index'),),
                        array('name' => 'seller_return', 'text' => lang('refund_cargo'), 'controller' => 'Sellerreturn', 'url' => url('Sellerreturn/index'),),
                    )
                ),
            'sellerstatistics' =>
                array(
                    'name' => 'sellerstatistics',
                    'text' => lang('statistics'),
                    'url' => url('Statisticsgeneral/index'),
                    'submenu' => array(
                        array('name' => 'Statisticsgeneral', 'text' => lang('store_overview'), 'controller' => 'Statisticsgeneral', 'url' => url('Statisticsgeneral/index'),),
                        array('name' => 'Statisticsgoods', 'text' => lang('commodity_analysis'), 'controller' => 'Statisticsgoods', 'url' => url('Statisticsgoods/index'),),
                        array('name' => 'Statisticssale', 'text' => lang('operational_report'), 'controller' => 'Statisticssale', 'url' => url('Statisticssale/index'),),
                        array('name' => 'Statisticsindustry', 'text' => lang('industry_analysis'), 'controller' => 'Statisticsindustry', 'url' => url('Statisticsindustry/index'),),
                        array('name' => 'Statisticsflow', 'text' => lang('traffic_statistics'), 'controller' => 'Statisticsflow', 'url' => url('Statisticsflow/index'),),
                        
                    )
                ),
            'sellercallcenter' =>
                array(
                    'name' => 'sellercallcenter',
                    'text' => lang('news_service'),
                    'url' => url('Sellercallcenter/index'),
                    'submenu' => array(
                        array('name' => 'Sellercallcenter', 'text' => lang('setting_service'), 'controller' => 'Sellercallcenter', 'url' => url('Sellercallcenter/index'),),
                        array('name' => 'Sellermsg', 'text' => lang('system_message'), 'controller' => 'Sellermsg', 'url' => url('Sellermsg/index'),),
                        array('name' => 'Sellerim', 'text' => lang('chat_query'), 'controller' => 'Sellerim', 'url' => url('Sellerim/index'),),
                    )
                ),
            'selleraccount' =>
                array(
                    'name' => 'selleraccount',
                    'text' => lang('account'),
                    'url' => url('Selleraccount/account_list'),
                    'submenu' => array(
                        array('name' => 'selleraccount', 'text' => lang('account_list'), 'controller' => 'Selleraccount', 'url' => url('Selleraccount/account_list'),),
                        array('name' => 'selleraccountgroup', 'text' => lang('account_group'), 'controller' => 'Selleraccountgroup', 'url' => url('Selleraccountgroup/group_list'),),
                        array('name' => 'sellerlog', 'text' => lang('account_log'), 'controller' => 'Sellerlog', 'url' => url('Sellerlog/log_list'),),
                        array('name' => 'sellercost', 'text' => lang('store_consumption'), 'controller' => 'Sellercost', 'url' => url('Sellercost/cost_list'),),
                    )
                ),
        );
        if(!$this->store_info['is_platform_store']){
            $menu_list['seller']['submenu']=array_merge(array(array('name' => 'seller_money', 'text' => lang('store_money'), 'controller' => 'Sellermoney', 'url' => url('Sellermoney/index'),),array('name' => 'seller_deposit', 'text' => lang('store_deposit'), 'controller' => 'Sellerdeposit', 'url' => url('Sellerdeposit/index'),)),$menu_list['seller']['submenu']);
        }
        if (config('inviter_open')) {
            $menu_list['sellerinviter'] = array(
                'name' => 'sellerinviter',
                'text' => lang('distribution'),
                'url' => url('Sellerinviter/goods_list'),
                'submenu' => array(
                    array('name' => 'sellerinviter_goods', 'text' => lang('distribution_management'), 'controller' => 'Sellerinviter', 'url' => url('Sellerinviter/goods_list'),),
                    array('name' => 'sellerinviter_order', 'text' => lang('distribution_earnings'), 'controller' => 'Sellerinviter', 'url' => url('Sellerinviter/order_list'),),
                )
            );
        }
        return $menu_list;
    }

    /**
     * 自动发布店铺动态
     *
     * @param array $data 相关数据
     * @param string $type 类型 'new','coupon','xianshi','mansong','bundling','groupbuy'
     *            所需字段
     *            new       goods表'             goods_id,store_id,goods_name,goods_image,goods_price,goods_transfee_charge,goods_freight
     *            xianshi   pxianshigoods表'   goods_id,store_id,goods_name,goods_image,goods_price,goods_freight,xianshi_price
     *            mansong   pmansong表'         mansong_name,start_time,end_time,store_id
     *            bundling  pbundling表'        bl_id,bl_name,bl_img,bl_discount_price,bl_freight_choose,bl_freight,store_id
     *            groupbuy  goodsgroup表'       group_id,group_name,goods_id,goods_price,groupbuy_price,group_pic,rebate,start_time,end_time
     *            coupon在后台发布
     */
    public function storeAutoShare($data, $type)
    {
        $param = array(
            3 => 'new',
            4 => 'coupon',
            5 => 'xianshi',
            6 => 'mansong',
            7 => 'bundling',
            8 => 'groupbuy'
        );
        $param_flip = array_flip($param);
        if (!in_array($type, $param) || empty($data)) {
            return false;
        }

        $auto_setting = model('storesnssetting')->getStoresnssettingInfo(array('storesnsset_storeid' => session('store_id')));
        $auto_sign = false; // 自动发布开启标志

        if ($auto_setting['storesnsset_' . $type] == 1) {
            $auto_sign = true;

            $goodsdata = addslashes(json_encode($data));
            if ($auto_setting['storesnsset_' . $type . 'title'] != '') {
                $title = $auto_setting['storesnsset_' . $type . 'title'];
            } else {
                $auto_title = 'ds_store_auto_share_' . $type . rand(1, 5);
                $title = lang($auto_title);
            }
        }
        if ($auto_sign) {
            // 插入数据
            $stracelog_array = array();
            $stracelog_array['stracelog_storeid'] = $this->store_info['store_id'];
            $stracelog_array['stracelog_storename'] = $this->store_info['store_name'];
            $stracelog_array['stracelog_storelogo'] = empty($this->store_info['store_avatar']) ? '' : $this->store_info['store_avatar'];
            $stracelog_array['stracelog_title'] = $title;
            $stracelog_array['stracelog_content'] = '';
            $stracelog_array['stracelog_time'] = TIMESTAMP;
            $stracelog_array['stracelog_type'] = $param_flip[$type];
            $stracelog_array['stracelog_goodsdata'] = $goodsdata;
            model('storesnstracelog')->addStoresnstracelog($stracelog_array);
            return true;
        } else {
            return false;
        }
    }
}

?>
