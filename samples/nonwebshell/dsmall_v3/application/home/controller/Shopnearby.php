<?php

namespace app\home\controller;
use think\Lang;

class Shopnearby extends BaseMall {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/shopnearby.lang.php');
    }

    /*
     * 首页显示
     */

    public function index() {
        $storeclass_list = model('storeclass')->getStoreclassList();
        $this->assign('storeclass_list', $storeclass_list);
        $area_mod=model('area');
        $city_list = $area_mod->getAreaList(array('area_parent_id'=>'0'));
        $sort_city_list = array();
        foreach ($city_list as $k => $v) {
            if (!isset($sort_city_list[$v['area_region']])) {
                $sort_city_list[$v['area_region']] = array(
                    'region' => $v['area_region'],
                    'child' => array()
                );
            }
            $sort_city_list[$v['area_region']]['child'][] = $v;
        }
        $this->assign('city_list', $sort_city_list);
        $this->assign('baidu_ak', config('baidu_ak'));
        return $this->fetch($this->template_dir . 'index');
    }

    public function get_Own_Store_List() {
        $store_list = array();
        //查询条件
        $condition = array();
        if (!empty(input('get.keyword'))) {
            $condition['store_name'] = array('like', '%' . input('get.keyword') . '%');
        }
        $storeclass_id = intval(input('get.storeclass_id'));
        if ($storeclass_id) {
            $condition['storeclass_id'] = array('=', $storeclass_id);
        }
        $lat = input('get.latitude');
        $lng = input('get.longitude');
        if ($lat && $lng) {
            $page = intval(input('get.page'));
            $store_list = db('store')->where($condition)->where('(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*(' . $lat . '-store_latitude)/360),2)+COS(PI()*' . $lat . '/180)* COS(store_latitude * PI()/180)*POW(SIN(PI()*(' . $lng . '-store_longitude)/360),2)))) < 100000')->field('store_phone,store_latitude,store_longitude,store_id,is_platform_store,store_name,area_info,store_address,store_logo,store_banner,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*(' . $lat . '-store_latitude)/360),2)+COS(PI()*' . $lat . '/180)* COS(store_latitude * PI()/180)*POW(SIN(PI()*(' . $lng . '-store_longitude)/360),2)))) as distance')->order('distance asc')->page($page, 30)->select();

            $goods_conditions = array(
                'goods_verify' => array('eq', 1),
                'goods_state' => array('eq', 1),
                'goods_state' => array('eq', 1),
            );
            foreach ($store_list as $key => $value) {
                $store_list[$key]['store_banner'] && $store_list[$key]['store_banner'] = UPLOAD_SITE_URL . '/' . ATTACH_STORE . '/' . $value['store_id'] . '/' . $value['store_banner'];
                $store_list[$key]['distance'] = round($value['distance'], 2);
                $store_list[$key]['store_logo'] = get_store_logo($value['store_logo'], 'store_logo');
                $goods_conditions['store_id'] = array('EQ', $value['store_id']);
                $store_list[$key]['goods_list'] = db('goods')->where($goods_conditions)->field('goods_name,goods_id,goods_image,goods_price')->order('goods_addtime desc')->page($page, 4)->select();
                if(empty($value['area_info'])){
                    $store_list[$key]['area_info'] = lang('store_doesn_fill_area');
                }
                if(empty($value['store_address'])){
                    $store_list[$key]['store_address'] = lang('store_not_filled_detailed_address');
                }
                
                foreach ($store_list[$key]['goods_list'] as $key2 => $goods) {
                    $store_list[$key]['goods_list'][$key2]['goods_image'] = goods_cthumb($goods['goods_image']);
                }
            }
        }
        if ($store_list) {
            echo json_encode($store_list);
            exit;
        } else {
            echo json_encode(false);
            exit;
        }
    }

}
