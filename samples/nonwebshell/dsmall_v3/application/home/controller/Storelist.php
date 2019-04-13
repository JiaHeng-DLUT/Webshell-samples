<?php

/*
 * 店铺列表控制器
 */

namespace app\home\controller;

use think\Lang;

class Storelist extends BaseMall {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/storelist.lang.php');
    }

    /**
     * 店铺列表
     */
    public function index() {

        //店铺类目快速搜索

        $class_list = rkcache('storeclass', true, 'file');

        $cate_id = intval(input('param.cate_id'));


        if (!key_exists($cate_id, $class_list))
            $cate_id = 0;

        $this->assign('class_list', $class_list);

        //店铺搜索
        $condition = array();
        $keyword = trim(input('param.keyword'));
        if (config('fullindexer.open') && !empty($keyword)) {
            //全文搜索
            $condition = $this->full_search($keyword);
        } else {
            if ($keyword != '') {
                $condition['store_name|store_mainbusiness'] = array('like', '%' . $keyword . '%');
            }
            $user_name = trim(input('param.user_name'));
            if ($user_name != '') {
                $condition['member_name'] = $user_name;
            }
        }
        $area_info = trim(input('param.area_info'));
        if (!empty($area_info)) {
            //修复店铺按地区搜索
            $tabs = preg_split("#\s+#", $area_info, -1, PREG_SPLIT_NO_EMPTY);
            $len = count($tabs);
            $area_name = $tabs[$len - 1];
            if ($area_name) {
                $area_name = trim($area_name);
                $condition['area_info'] = array('like', '%' . $area_name . '%');
            }
        }
        if ($cate_id > 0) {
            $condition['storeclass_id'] = $cate_id;
        }

        $condition['store_state'] = 1;

        $order = trim(input('param.order'));
        if (!in_array($order, array('desc', 'asc'))) {
            unset($order);
        }


        $order_sort = 'store_sort asc';

        if (isset($condition['store.store_id'])) {
            $condition['store_id'] = $condition['store.store_id'];
            unset($condition['store.store_id']);
        }

        $store_model = model('store');
        $store_list = $store_model->getStoreList($condition,10,$order_sort);
        //获取店铺商品数，推荐商品列表等信息
        $store_list = $store_model->getStoreSearchList($store_list);
        //信用度排序
        $key = trim(input('param.key'));
        if ($key == 'store_credit') {
            if ($order == 'desc') {
                $store_list = sortClass::sortArrayDesc($store_list, 'store_credit_average');
            } else {
                $store_list = sortClass::sortArrayAsc($store_list, 'store_credit_average');
            }
        } else if ($key == 'store_sales') {//销量排行
            if ($order == 'desc') {
                $store_list = sortClass::sortArrayDesc($store_list, 'num_sales_jq');
            } else {
                $store_list = sortClass::sortArrayAsc($store_list, 'num_sales_jq');
            }
        }
        $this->assign('store_list', $store_list);

        $this->assign('show_page', $store_model->page_info->render());
        // 页面输出
        $this->assign('index_sign', 'store_list');
        //当前位置
        if (intval($cate_id) > 0) {
            $nav_link[1]['link'] = url('Search/index');
            $nav_link[1]['title'] = lang('site_search_store');
            $nav = $class_list[$cate_id];
            //存入当前级
            $nav_link[] = array(
                'title' => $nav['storeclass_name']
            );
        } else {
            $nav_link[1]['link'] = 'index.html';
            $nav_link[1]['title'] = lang('homepage');
            $nav_link[2]['title'] = lang('site_search_store');
        }
        $this->assign('nav_link_list', $nav_link);


        $purl = input('param.');
        unset($purl['page']);
        $this->assign('purl', url(request()->module() . '/' . request()->controller() . '/' . request()->action(), $purl));

        //SEO
        $seo = model('seo')->type('index')->show();
        $this->_assign_seo($seo);
        $this->assign('html_title', (input('param.keyword') ? input('param.keyword') . ' - ':'' ) . config('site_name') . lang('ds_common_search'));

        return $this->fetch($this->template_dir . 'store_list');
    }

    /**
     * 全文搜索
     *
     */
    private function full_search($search_txt) {
        $conf = config('fullindexer');
        import('libraries.sphinx');
        $cl = new SphinxClient();
        $cl->SetServer($conf['host'], $conf['port']);
        $cl->SetConnectTimeout(1);
        $cl->SetArrayResult(true);
        $cl->SetRankingMode($conf['rankingmode'] ? $conf['rankingmode'] : 0);
        $cl->setLimits(0, $conf['querylimit']);

        $matchmode = $conf['matchmode'];
        $cl->setMatchMode($matchmode);

        //可以使用全文搜索进行状态筛选及排序，但需要经常重新生成索引，否则结果不太准，所以暂不使用。使用数据库，速度会慢些
        //		$cl->SetFilter('store_state',array(1),false);
        //		if (input('get.key') == 'store_credit'){
        //			$order = input('get.order') == 'desc' ? SPH_SORT_ATTR_DESC : SPH_SORT_ATTR_ASC;
        //			$cl->SetSortMode($order,'store_sort');
        //		}

        $res = $cl->Query($search_txt, $conf['index_shop']);
        if ($res) {
            if (is_array($res['matches'])) {
                foreach ($res['matches'] as $value) {
                    $matchs_id[] = $value['id'];
                }
            }
        }
        if ($search_txt != '') {
            $condition['store.store_id'] = array('in', $matchs_id);
        }
        return $condition;
    }


    //获取店铺列表要显示的信息
    public function storelistinfo_bak($storeinfo) {
        foreach ($storeinfo as $value) {
            $map['store_id'] = $value['store_id'];
            $goods_count['count'] = db('goods')->where($map)->count();
            $goods_count['info'] = db('goods')->where('goods_commend', '1')->field('goods_id,goods_name,goods_image,goods_marketprice')->select();
            $v['store_goodscount'] = $goods_count['count'];
            $v['store_goodscommend'] = $goods_count['info'];
            $info = array_merge($value, $v);
            $store_info[$value['store_id']] = $info;
        }
        return $store_info;
    }

}

class sortClass {

    //升序
    public static function sortArrayAsc($preData, $sortType = 'store_sort') {
        $sortData = array();
        foreach ($preData as $key_i => $value_i) {
            $price_i = isset($value_i[$sortType])?$value_i[$sortType]:0;
            $min_key = '';
            $sort_total = count($sortData);
            foreach ($sortData as $key_j => $value_j) {
                $value_j[$sortType] = isset($value_j[$sortType])?$value_j[$sortType]:0;
                if ($price_i < $value_j[$sortType]) {
                    $min_key = $key_j + 1;
                    break;
                }
            }
            if (empty($min_key)) {
                array_push($sortData, $value_i);
            } else {
                $sortData1 = array_slice($sortData, 0, $min_key - 1);
                array_push($sortData1, $value_i);
                if (($min_key - 1) < $sort_total) {
                    $sortData2 = array_slice($sortData, $min_key - 1);
                    foreach ($sortData2 as $value) {
                        array_push($sortData1, $value);
                    }
                }
                $sortData = $sortData1;
            }
        }
        return $sortData;
    }

    //降序
    public static function sortArrayDesc($preData, $sortType = 'store_sort') {
        $sortData = array();
        foreach ($preData as $key_i => $value_i) {
            $price_i = isset($value_i[$sortType])?$value_i[$sortType]:0;
            $min_key = '';
            $sort_total = count($sortData);
            foreach ($sortData as $key_j => $value_j) {
                $value_j[$sortType] = isset($value_j[$sortType])?$value_j[$sortType]:0;
                if ($price_i > $value_j[$sortType]) {
                    $min_key = $key_j + 1;
                    break;
                }
            }
            if (empty($min_key)) {
                array_push($sortData, $value_i);
            } else {
                $sortData1 = array_slice($sortData, 0, $min_key - 1);
                array_push($sortData1, $value_i);
                if (($min_key - 1) < $sort_total) {
                    $sortData2 = array_slice($sortData, $min_key - 1);
                    foreach ($sortData2 as $value) {
                        array_push($sortData1, $value);
                    }
                }
                $sortData = $sortData1;
            }
        }
        return $sortData;
    }

}
