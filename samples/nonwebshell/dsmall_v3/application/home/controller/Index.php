<?php

namespace app\home\controller;

use think\Lang;
use think\Loader;

class Index extends BaseMall {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/index.lang.php');
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellergroupbuy.lang.php');
    }

    public function index() {
        $this->assign('index_sign', 'index');

        $this->getIndexData();
        
        //楼层数据
        $floor_block=array();
	$goodsclass_list = db('goodsclass')->where('gc_parent_id', 0)->where('gc_show', 1)->order('gc_sort asc')->select();
        foreach ($goodsclass_list as $key => $goodsclass) {
            $floor_list = $this->getFloorList($goodsclass['gc_id']);
            $floor_block[$key] = $floor_list;
            $floor_block[$key]['gc_name'] = $goodsclass['gc_name'];
            if(!$floor_block[$key]['goods_list'][0]['gc_list']){
                unset($floor_block[$key]);
            }
        }

        //楼层数据
        $this->assign('floor_block', $floor_block);

        //显示订单信息
        if (session('is_login')) {
            //交易提醒 - 显示数量
            $order_model = model('order');
            $member_order_info['order_nopay_count'] = $order_model->getOrderCountByID('buyer', session('member_id'), 'NewCount');
            $member_order_info['order_noreceipt_count'] = $order_model->getOrderCountByID('buyer', session('member_id'), 'SendCount');
            $member_order_info['order_noeval_count'] = $order_model->getOrderCountByID('buyer', session('member_id'), 'EvalCount');
            $this->assign('member_order_info', $member_order_info);
        }
        //SEO 设置
        $seo = model('seo')->type('index')->show();
        $this->_assign_seo($seo);
        return $this->fetch($this->template_dir . 'index');
    }
    
    private function getIndexData()
    {
        $index_data = rcache("index_data");
        if (empty($index_data)) {
            $index_data = array();
            $index_data['recommend_list'] = model('goods')->getGoodsOnlineList(array('goods_commend' => 1), 'goods_id,goods_name,goods_advword,goods_image,store_id,goods_promotion_price,goods_price', 0, '',5,'goods_commonid');
            //限时折扣
            $index_data['promotion_list'] = model('pxianshigoods')->getXianshigoodsCommendList(5);
            $index_data['new_list'] = model('goods')->getGoodsOnlineList(array(), '', '', 'goods_addtime desc', 5,'goods_commonid');
            $index_data['groupbuy_list'] = model('groupbuy')->getGroupbuyCommendedList(5);
            //友情链接
            $index_data['link_list'] = model('link')->getLinkList();
            //获取第一文章分类的前三篇文章
            $index_data['index_articles'] = db('article')->where('ac.ac_code', 'notice')->where('a.article_show', 1)->alias('a')->field('a.article_id,a.article_url,a.article_title')->order('a.article_sort asc,a.article_time desc')->limit(3)->join('__ARTICLECLASS__ ac', 'a.ac_id=ac.ac_id')->select();
            wcache('index_data',$index_data);
        }
        $this->assign('recommend_list', $index_data['recommend_list']);
        $this->assign('promotion_list', $index_data['promotion_list']);
        $this->assign('new_list', $index_data['new_list']);
        $this->assign('groupbuy_list', $index_data['groupbuy_list']);
        $this->assign('link_list', $index_data['link_list']);
        $this->assign('index_articles', $index_data['index_articles']);
    }
    

    private function getFloorList($cate_id) {
        $prefix = 'home-index-floor-';
        $result = rcache($cate_id,$prefix);
        if (empty($result)) {
            //获取此楼层下的所有分类
            $goods_class_list = db('goodsclass')->where('gc_parent_id=' . $cate_id)->select();
            //获取每个分类下的商品
            $goods_list = array();
            $goods_list[0]['gc_name'] = lang('hot_recommended');
            $goods_list[0]['gc_id'] = $cate_id;
            $goods_list[0]['gc_list'] = model('goods')->getGoodsOnlineList(array('gc_id' => $cate_id),'*', 0, 'goods_commend desc,goods_id desc', 10,'goods_commonid');

            $hot_goods_class_list = db('goodsclass')->where('gc_parent_id=' . $cate_id)->order('gc_sort desc')->limit(5)->select();
            foreach ($hot_goods_class_list as $key => $hot_goods_class) {
                $data = array();
                $data['gc_name'] = $hot_goods_class['gc_name'];
                $data['gc_id'] = $hot_goods_class['gc_id'];
                $data['gc_list'] = model('goods')->getGoodsOnlineList(array('gc_id' => $data['gc_id']),'*', 0, 'goods_commend desc,goods_id desc', 10,'goods_commonid');
                $goods_list[] = $data;
            }
            $result['goods_list'] = $goods_list;
            $result['goods_class_list'] = $goods_class_list;
            wcache($cate_id, $result,$prefix, 3600);
        }
        return $result;
    }

    //json输出商品分类
    public function josn_class() {
        /**
         * 实例化商品分类模型
         */
        $goodsclass_model = model('goodsclass');
        $goods_class = $goodsclass_model->getGoodsclassListByParentId(intval(input('get.gc_id')));
        $array = array();
        if (is_array($goods_class) and count($goods_class) > 0) {
            foreach ($goods_class as $val) {
                $array[$val['gc_id']] = array(
                    'gc_id' => $val['gc_id'], 'gc_name' => htmlspecialchars($val['gc_name']),
                    'gc_parent_id' => $val['gc_parent_id'], 'commis_rate' => $val['commis_rate'],
                    'gc_sort' => $val['gc_sort']
                );
            }
        }

        echo $_GET['callback'] . '(' . json_encode($array) . ')';
    }

    //闲置物品地区json输出
    public function flea_area() {
        if (isset($_GET['check']) && intval($_GET['check']) > 0) {
            $_GET['area_id'] = $_GET['region_id'];
        }
        if (intval($_GET['area_id']) == 0) {
            return;
        }
        $fleaarea_model = model('fleaarea');
        $area_array = $fleaarea_model->getFleaareaList(array('fleaarea_parent_id' => intval($_GET['area_id'])));
        $array = array();
        if (is_array($area_array) and count($area_array) > 0) {
            foreach ($area_array as $val) {
                $array[$val['fleaarea_id']] = array(
                    'fleaarea_id' => $val['fleaarea_id'],
                    'fleaarea_name' => htmlspecialchars($val['fleaarea_name']),
                    'fleaarea_parent_id' => $val['fleaarea_parent_id'], 'fleaarea_sort' => $val['fleaarea_sort']
                );
            }
        }
        if (isset($_GET['check']) && intval($_GET['check']) > 0) {//判断当前地区是否为最后一级
            if (!empty($array) && is_array($array)) {
                echo 'false';
            } else {
                echo 'true';
            }
        } else {
            echo json_encode($array);
        }
    }

    //json输出闲置物品分类
    public function josn_flea_class() {
        /**
         * 实例化商品分类模型
         */
        $fleaclass_model = model('fleaclass');
        $goods_class = $fleaclass_model->getFleaclassList(array('fleaclass_parent_id' => intval(input('get.gc_id'))));
        $array = array();
        if (is_array($goods_class) and count($goods_class) > 0) {
            foreach ($goods_class as $val) {
                $array[$val['fleaclass_id']] = array(
                    'fleaclass_id' => $val['fleaclass_id'], 'fleaclass_name' => htmlspecialchars($val['fleaclass_name']),
                    'fleaclass_parent_id' => $val['fleaclass_parent_id'], 'fleaclass_sort' => $val['fleaclass_sort']
                );
            }
        }
        /**
         * 转码
         */
        echo json_encode($array);
    }

    /**
     * json输出地址数组 public/static/plugins/area_datas.js
     */
    public function json_area() {
        echo $_GET['callback'] . '(' . json_encode(model('area')->getAreaArrayForJson()) . ')';
    }

    /**
     * json输出地址数组 
     */
    public function json_area_show() {
        $area_info['text'] = model('area')->getTopAreaName(intval(input('get.area_id')));
        echo $_GET['callback'] . '(' . json_encode($area_info) . ')';
    }

    //判断是否登录
    public function login() {
        echo (session('is_login') == '1') ? '1' : '0';
    }

    /**
     * 查询每月的周数组
     */
    public function getweekofmonth() {
        Loader::import('mall.datehelper');
        $year = input('get.y');
        $month = input('get.m');
        $week_arr = getMonthWeekArr($year, $month);
        echo json_encode($week_arr);
        die;
    }

    /**
     * 头部最近浏览的商品
     */
    public function viewed_info() {
        $info = array();
        if (session('is_login') == '1') {
            $member_id = session('member_id');
            $info['m_id'] = $member_id;
            if (config('voucher_allow') == 1) {
                $time_to = time(); //当前日期
                $info['voucher'] = db('voucher')->where(
                                array(
                                    'voucher_owner_id' => $member_id, 'voucher_state' => 1,
                                    'voucher_startdate' => array('elt', $time_to),
                                    'voucher_enddate' => array('egt', $time_to)
                        ))->count();
            }
            $time_to = strtotime(date('Y-m-d')); //当前日期
            $time_from = date('Y-m-d', ($time_to - 60 * 60 * 24 * 7)); //7天前
            $consult_mod=model('consult');
            $info['consult'] = $consult_mod->getConsultCount(array(
                        'member_id' => $member_id, 'consult_replytime' => array(
                            array(
                                'gt', strtotime($time_from)
                            ), array('lt', $time_to + 60 * 60 * 24), 'and'
                        )
                    ));
        }
        $goods_list = model('goodsbrowse')->getViewedGoodsList(session('member_id'), 5);
        if (is_array($goods_list) && !empty($goods_list)) {
            $viewed_goods = array();
            foreach ($goods_list as $key => $val) {
                $goods_id = $val['goods_id'];
                $val['url'] = url('Goods/index', ['goods_id' => $goods_id]);
                $val['goods_image'] = goods_thumb($val, 60);
                $viewed_goods[$goods_id] = $val;
            }
            $info['viewed_goods'] = $viewed_goods;
        }
        echo json_encode($info);
    }

}
