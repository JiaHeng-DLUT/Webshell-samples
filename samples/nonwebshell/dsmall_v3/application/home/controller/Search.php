<?php

namespace app\home\controller;

use think\Lang;

class Search extends BaseMall {

    //每页显示商品数
    const PAGESIZE = 12;

    //模型对象
    private $_model_search;

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/search.lang.php');
    }

    public function index() {

        $this->_model_search = model('search');
        //显示左侧分类
        //默认分类，从而显示相应的属性和品牌
        $cate_id = $default_classid = intval(input('param.cate_id'));
        $keyword = input('param.keyword');
        $goods_class_array = array();
        if ($default_classid > 0) {
            $goods_class_array = $this->_model_search->getLeftCategory(array($default_classid));
        } elseif ($keyword != '') {
            //从TAG中查找分类
            $goods_class_array = $this->_model_search->getTagCategory($keyword);
            //取出第一个分类作为默认分类，从而显示相应的属性和品牌
            $default_classid = isset($goods_class_array[0]) ? $goods_class_array[0] : "";
            $goods_class_array = $this->_model_search->getLeftCategory($goods_class_array, 1);
        }

        $this->assign('goods_class_array', $goods_class_array);
        $this->assign('default_classid', $default_classid);

        //优先从全文索引库里查找
        list($indexer_ids, $indexer_count) = $this->_model_search->indexerSearch(input('param.'), self::PAGESIZE);

        //获得经过属性过滤的商品信息 
        list($goods_param, $brand_array, $initial_array, $attr_array, $checked_brand, $checked_attr) = $this->_model_search->getAttribute(input('param.'), $default_classid);
        $this->assign('brand_array', $brand_array);
        $this->assign('initial_array', $initial_array);
        $this->assign('attr_array', $attr_array);
        $this->assign('checked_brand', $checked_brand);
        $this->assign('checked_attr', $checked_attr);

        //处理排序
        $order = 'is_platform_store desc,goods_id desc';
        $key = input('param.key');
        $order = input('param.order');
        if (in_array($key, array('1', '2', '3'))) {
            $sequence = $order == '1' ? 'asc' : 'desc';
            $order = str_replace(array('1', '2', '3'), array('goods_salenum', 'goods_click', 'goods_promotion_price'), $key);
            $order .= ' ' . $sequence;
        }
        $goods_model = model('goods');
        // 字段
        $fields = "goods_id,goods_commonid,goods_name,goods_advword,gc_id,store_id,store_name,goods_price,goods_promotion_price,goods_promotion_type,goods_marketprice,goods_storage,goods_image,goods_freight,goods_salenum,color_id,evaluation_good_star,evaluation_count,is_virtual,is_goodsfcode,is_appoint,is_presell,is_have_gift";

        $condition = array();
        if (is_array($indexer_ids)) {

            //商品主键搜索
            $condition['goods_id'] = array('in', $indexer_ids);
            $goods_list = $goods_model->getGoodsOnlineList($condition, $fields, 0, $order, self::PAGESIZE, null, false);

            //如果有商品下架等情况，则删除下架商品的搜索索引信息
            if (count($goods_list) != count($indexer_ids)) {
                $this->_model_search->delInvalidGoods($goods_list, $indexer_ids);
            }

        } else {
            //执行正常搜索
            if (isset($goods_param['class']['depth'])) {
                $condition['gc_id_' . $goods_param['class']['depth']] = $goods_param['class']['gc_id'];
            }
            $b_id = intval(input('param.b_id'));
            if ($b_id > 0) {
                $condition['brand_id'] = $b_id;
            }
            if ($keyword != '') {
                $condition['goods_name|goods_advword'] = array('like', '%' . $keyword . '%');
            }
            $area_id = intval(input('param.area_id'));
            if ($area_id > 0) {
                $condition['areaid_1'] = $area_id;
            }

            $type = intval(input('param.type'));
            if ($type == 1) {
                $condition['is_platform_store'] = 1;
            }
            $gift = intval(input('param.gift'));
            if ($gift == 1) {
                $condition['is_have_gift'] = 1;
            }
            if (isset($goods_param['goodsid_array'])) {
                $condition['goods_id'] = array('in', $goods_param['goodsid_array']);
            }
            $priceMin = intval(input('param.priceMin'));
            if ($priceMin > 0) {
                $condition['goods_price'] = array('egt', $priceMin);
            }
            $priceMax = intval(input('param.priceMax'));
            if ($priceMax > 0) {
                $condition['goods_price'] = array('elt', $priceMax);
            }

            if ($priceMin > 0 && $priceMax > 0) {
                $condition['goods_price'] = array('between', array($priceMin, $priceMax));
            }
            $goods_list = $goods_model->getGoodsListByColorDistinct($condition, $fields, $order, self::PAGESIZE);
        }
        $this->assign('show_page', is_object($goods_model->page_info)?$goods_model->page_info->render():"");

        // 商品多图
        if (!empty($goods_list)) {
            $commonid_array = array(); // 商品公共id数组
            $storeid_array = array();       // 店铺id数组
            foreach ($goods_list as $value) {
                $commonid_array[] = $value['goods_commonid'];
                $storeid_array[] = $value['store_id'];
            }
            $commonid_array = array_unique($commonid_array);
            $storeid_array = array_unique($storeid_array);

            // 商品多图
            $goodsimage_more = model('goods')->getGoodsImageList(array('goods_commonid' => array('in', $commonid_array)));

            // 店铺
            $store_list = model('store')->getStoreMemberIDList($storeid_array);
            //搜索的关键字
            $search_keyword = $keyword;
            foreach ($goods_list as $key => $value) {
                // 商品多图
                //商品列表主图限制不越过5个
                $n = 0;
                foreach ($goodsimage_more as $v) {
                    if ($value['goods_commonid'] == $v['goods_commonid'] && $value['store_id'] == $v['store_id'] && $value['color_id'] == $v['color_id']) {
                        $n++;
                        $goods_list[$key]['image'][] = $v;
                        if ($n >= 5)
                            break;
                    }
                }
                // 店铺的开店会员编号
                $store_id = $value['store_id'];
                $goods_list[$key]['member_id'] = $store_list[$store_id]['member_id'];
                //将关键字置红
                if ($search_keyword) {
                    $goods_list[$key]['goods_name_highlight'] = str_replace($search_keyword, '<font style="color:#f00;">' . $search_keyword . '</font>', $value['goods_name']);
                } else {
                    $goods_list[$key]['goods_name_highlight'] = $value['goods_name'];
                }
            }
        }
        $this->assign('goods_list', $goods_list);
        if ($keyword != '') {
            $this->assign('show_keyword', $keyword);
        } else {
            $this->assign('show_keyword', isset($goods_param['class']['gc_name']) ? $goods_param['class']['gc_name'] : '');
        }

        $goodsclass_model = model('goodsclass');

        // SEO
        if ($keyword == '') {
            $seo_class_name = isset($goods_param['class']['gc_name'])?$goods_param['class']['gc_name']:'';
            if (is_numeric($cate_id) && empty($keyword)) {
                $seo_info = $goodsclass_model->getKeyWords($cate_id);
                if (empty($seo_info[1])) {
                    $seo_info[1] = config('site_name') . ' - ' . $seo_class_name;
                }
                $seo = model('seo')->type($seo_info)->param(array('name' => $seo_class_name))->show();
                $this->_assign_seo($seo);
            }
        } elseif ($keyword != '') {
            $this->assign('html_title', (empty($keyword) ? '' : $keyword . ' - ') . config('site_name') . lang('ds_common_search'));
        }

        // 当前位置导航
        $nav_link_list = $goodsclass_model->getGoodsclassnav($cate_id);
        $this->assign('nav_link_list', $nav_link_list);

        // 得到自定义导航信息
        $nav_id = intval(input('param.nav_id'));
        $this->assign('index_sign', $nav_id);

        // 地区
        $province_array = model('area')->getTopLevelAreas();
        $this->assign('province_array', $province_array);

        /* 引用搜索相关函数 */
        require_once(APP_PATH . '/home/common_search.php');

        // 浏览过的商品
        $viewed_goods = model('goodsbrowse')->getViewedGoodsList(session('member_id'), 20);
        $this->assign('viewed_goods', $viewed_goods);

        return $this->fetch($this->template_dir . 'search');
    }

    /**
     * 获得推荐商品
     */
    public function get_hot_goods() {
        $gc_id = input('param.cate_id');
        if ($gc_id <= 0) {
            exit;
        }
        // 获取分类id及其所有子集分类id
        $goods_class = model('goodsclass')->getGoodsclassForCacheModel();
        if (empty($goods_class[$gc_id])) {
            exit;
        }
        $child = (!empty($goods_class[$gc_id]['child'])) ? explode(',', $goods_class[$gc_id]['child']) : array();
        $childchild = (!empty($goods_class[$gc_id]['childchild'])) ? explode(',', $goods_class[$gc_id]['childchild']) : array();
        $gcid_array = array_merge(array($gc_id), $child, $childchild);
        // 查询添加到推荐展位中的商品id
        $boothgoods_list = model('goods')->getGoodsOnlineList(array('gc_id' => array('in', $gcid_array)), 'goods_id', 4, '');
        if (empty($boothgoods_list)) {
            exit;
        }

        $goodsid_array = array();
        foreach ($boothgoods_list as $val) {
            $goodsid_array[] = $val['goods_id'];
        }

        $fieldstr = "goods_id,goods_commonid,goods_name,goods_advword,store_id,store_name,goods_price,goods_promotion_price,goods_promotion_type,goods_marketprice,goods_storage,goods_image,goods_freight,goods_salenum,color_id,evaluation_count";
        $goods_list = model('goods')->getGoodsOnlineList(array('goods_id' => array('in', $goodsid_array)), $fieldstr);
        if (empty($goods_list)) {
            exit;
        }

        $this->assign('goods_list', $goods_list);
        echo $this->fetch($this->template_dir.'goods_hot');
    }

    /**
     * 获得同类商品排行
     */
    public function get_listhot_goods() {
        $gc_id = input('param.cate_id');
        if ($gc_id <= 0) {
            return false;
        }
        // 获取分类id及其所有子集分类id
        $goods_class = model('goodsclass')->getGoodsclassForCacheModel();
        if (empty($goods_class[$gc_id])) {
            return false;
        }
        $child = (!empty($goods_class[$gc_id]['child'])) ? explode(',', $goods_class[$gc_id]['child']) : array();
        $childchild = (!empty($goods_class[$gc_id]['childchild'])) ? explode(',', $goods_class[$gc_id]['childchild']) : array();
        $gcid_array = array_merge(array($gc_id), $child, $childchild);
        // 查询添加到推荐展位中的商品id
        $boothgoods_list = model('goods')->getGoodsOnlineList(array('gc_id' => array('in', $gcid_array)));
        if (empty($boothgoods_list)) {
            return false;
        }

        $goodsid_array = array();
        foreach ($boothgoods_list as $val) {
            $goodsid_array[] = $val['goods_id'];
        }

        $fieldstr = "goods_id,goods_commonid,goods_name,goods_advword,store_id,store_name,goods_price,goods_promotion_price,goods_promotion_type,goods_marketprice,goods_storage,goods_image,goods_freight,goods_salenum,color_id,evaluation_count";
        $goods_list = model('goods')->getGoodsOnlineList(array('goods_id' => array('in', $goodsid_array)), $fieldstr, 5, 'goods_salenum desc');
        if (empty($goods_list)) {
            return false;
        }

        $this->assign('goods_list', $goods_list);
    }

    /**
     * 获得推荐商品
     */
    public function get_booth_goods() {
        $gc_id = input('param.cate_id');
        if ($gc_id <= 0) {
            exit;
        }
        // 获取分类id及其所有子集分类id
        $goods_class = model('goodsclass')->getGoodsclassForCacheModel();
        if (empty($goods_class[$gc_id])) {
            exit;
        }
        $child = (!empty($goods_class[$gc_id]['child'])) ? explode(',', $goods_class[$gc_id]['child']) : array();
        $childchild = (!empty($goods_class[$gc_id]['childchild'])) ? explode(',', $goods_class[$gc_id]['childchild']) : array();
        $gcid_array = array_merge(array($gc_id), $child, $childchild);
        // 查询添加到推荐展位中的商品id
        $boothgoods_list = model('pbooth')->getBoothgoodsList(array('gc_id' => array('in', $gcid_array)), 'goods_id', 0, 4, '');
        if (empty($boothgoods_list)) {
            exit;
        }

        $goodsid_array = array();
        foreach ($boothgoods_list as $val) {
            $goodsid_array[] = $val['goods_id'];
        }

        $fieldstr = "goods_id,goods_commonid,goods_name,goods_advword,store_id,store_name,goods_price,goods_promotion_price,goods_promotion_type,goods_marketprice,goods_storage,goods_image,goods_freight,goods_salenum,color_id,evaluation_count";
        $goods_list = model('goods')->getGoodsOnlineList(array('goods_id' => array('in', $goodsid_array)), $fieldstr);
        if (empty($goods_list)) {
            exit;
        }

        $this->assign('goods_list', $goods_list);
        echo $this->fetch($this->template_dir.'goods_booth');
    }

    public function auto_complete() {
        if (!config('fullindexer.open')) return;
        try {
            require(EXTEND_PATH . 'xs/lib/XS.php');
            $obj_doc = new \XSDocument();
            $obj_xs = new \XS(config('fullindexer.appname'));
            $obj_index = $obj_xs->index;
            $obj_search = $obj_xs->search;
            $obj_search->setCharset(CHARSET);
            $corrected = $obj_search->getExpandedQuery(input('param.term'));
            if (count($corrected) !== 0) {
                $data = array();
                foreach ($corrected as $word) {
                    $row['id'] = $word;
                    $row['label'] = $word;
                    $row['value'] = $word;
                    $data[] = $row;
                }
                exit(json_encode($data));
            }
        } catch (XSException $e) {
            if (is_object($obj_index)) {
                $obj_index->flushIndex();
            }
        }
    }

    /**
     * 获得猜你喜欢
     */
    public function get_guesslike() {
        $goodslist = model('goodsbrowse')->getGuessLikeGoods(session('member_id'), 20);
        if (!empty($goodslist)) {
            $this->assign('goodslist', $goodslist);
            echo $this->fetch($this->template_dir.'goods_guesslike');
        }
    }

}

?>
