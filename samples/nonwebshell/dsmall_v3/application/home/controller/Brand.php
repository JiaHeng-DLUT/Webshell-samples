<?php

/**
 * 品牌管理
 */
namespace app\home\controller;
use think\Lang;
class Brand extends BaseMall {

    public function _initialize() {
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/brand.lang.php');
        parent::_initialize();
    }

    public function index() {

        //分类导航
        $nav_link = array(
            0 => array(
                'title' => lang('homepage'),
                'link' => HOME_SITE_URL
            ),
            1 => array(
                'title' => lang('brand_index_all_brand')
            )
        );
        $this->assign('nav_link_list', $nav_link);

        $brand_mod=model('brand');
        $brand_c_list = $brand_mod->getBrandList(array('brand_apply' => '1'));
        $brands = $this->_tidyBrand($brand_c_list);
        extract($brands);
        $this->assign('brand_c', $brand_listnew);
        $this->assign('brand_class', $brand_class);
        $this->assign('brand_r', $brand_r_list);

        //页面输出
        $this->assign('index_sign', 'brand');
        $seo = model('seo')->type('brand')->show();
        $this->_assign_seo($seo);
        $this->assign('html_title', lang('brand_index_brand_list'));

        return $this->fetch($this->template_dir . 'index');
    }

    /**
     * 所有品牌全部显示在一级类目下，不显示二三级类目
     * @param type $brand_c_list
     * @return type
     */
    private function _tidyBrand($brand_c_list) {
        $brand_listnew = array();#品怕分类下对应的品牌
        $brand_class = array();#品牌分类
        $brand_r_list = array();#推荐品牌
        if (!empty($brand_c_list) && is_array($brand_c_list)) {
            $goods_class = model('goodsclass')->getGoodsclassForCacheModel();
            foreach ($brand_c_list as $key => $brand_c) {
                $gc_array = $this->_getTopClass($goods_class, $brand_c['gc_id']);
                if (empty($gc_array)) {
                    if ($brand_c['brand_showtype'] == 1) {
                        $brand_listnew[0]['text'][] = $brand_c;
                    } else {
                        $brand_listnew[0]['image'][] = $brand_c;
                    }
                    $brand_class[0]['brand_class'] = lang('ds_other');
                } else {
                    if ($brand_c['brand_showtype'] == 1) {
                        $brand_listnew[$gc_array['gc_id']]['text'][] = $brand_c;
                    } else {
                        $brand_listnew[$gc_array['gc_id']]['image'][] = $brand_c;
                    }
                    $brand_class[$gc_array['gc_id']]['brand_class'] = $gc_array['gc_name'];
                }
                //推荐品牌
                if ($brand_c['brand_recommend'] == 1) {
                    $brand_r_list[] = $brand_c;
                }
            }
        }
        krsort($brand_class);
        krsort($brand_listnew);
        return array('brand_listnew' => $brand_listnew, 'brand_class' => $brand_class, 'brand_r_list' => $brand_r_list);
    }

    /**
     * 获取顶级商品分类\递归调用
     * @param type $goods_class
     * @param type $gc_id
     * @return type
     */
    private function _getTopClass($goods_class, $gc_id) {
        if (!isset($goods_class[$gc_id])) {
            return null;
        }
        if($goods_class[$gc_id]['gc_parent_id']==$gc_id){//自身ID等于父ID
            return null;
        }
        if(isset($goods_class[$goods_class[$gc_id]['gc_parent_id']]['gc_parent_id']) && $goods_class[$goods_class[$gc_id]['gc_parent_id']]['gc_parent_id']==$gc_id){//父分类的父ID等于自身ID
            return null;
        }
        return $goods_class[$gc_id]['gc_parent_id'] == 0 ? $goods_class[$gc_id] : $this->_getTopClass($goods_class, $goods_class[$gc_id]['gc_parent_id']);
    }

    /**
     * 品牌商品列表
     */
    //原方法 function list
    public function brand_goods() {
        /**
         * 验证品牌
         */
        $brand_model = model('brand');
        $brand_id = intval(input('param.brand_id'));
        $brand_info = $brand_model->getBrandInfo(array('brand_id' => $brand_id));
        if (!$brand_info) {
            $this->error(lang('wrong_argument'));
        }

        /**
         * 获得推荐品牌
         */
        $brand_r_list = model('brand')->getBrandPassedList(array('brand_recommend' => 1), 'brand_id,brand_name,brand_pic',10, 'brand_sort asc, brand_id desc');
        $this->assign('brand_r', $brand_r_list);

        // 得到排序方式
        $order = 'is_platform_store desc,goods_id desc';
        
        $key = input('param.key');
        
        if (!empty($key)) {
            $order_tmp = trim($key);
            $sequence = input('param.order') == 1 ? 'asc' : 'desc';
            switch ($order_tmp) {
                case '1' : // 销量
                    $order = 'goods_salenum' . ' ' . $sequence;
                    break;
                case '2' : // 浏览量
                    $order = 'goods_click' . ' ' . $sequence;
                    break;
                case '3' : // 价格
                    $order = 'goods_promotion_price' . ' ' . $sequence;
                    break;
            }
        }

        // 字段
        $fieldstr = "goods_id,goods_commonid,goods_name,goods_advword,store_id,store_name,goods_price,goods_promotion_price,goods_promotion_type,goods_marketprice,goods_storage,goods_image,goods_freight,goods_salenum,color_id,evaluation_good_star,evaluation_count,is_virtual,is_goodsfcode,is_appoint,is_presell,is_have_gift";
        // 条件
        $where = array();
        $where['brand_id'] = $brand_info['brand_id'];
        $area_id = intval(input('param.area_id'));
        if ($area_id > 0) {
            $where['areaid_1'] = $area_id;
        }
        if (input('param.type') == 1) {
            $where['is_platform_store'] = 1;
        }
        if (input('param.gift') == 1) {
            $where['is_have_gift'] = 1;
        }
        $goods_model = model('goods');
        
        $goods_list = $goods_model->getGoodsListByColorDistinct($where, $fieldstr, $order, 24);
        
        $this->assign('show_page', !empty($goods_list)?$goods_model->page_info->render():'');
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
            $goodsimage_more = $goods_model->getGoodsImageList(array('goods_commonid' => array('in', $commonid_array)));
            // 店铺
            $store_list = model('store')->getStoreMemberIDList($storeid_array);

            foreach ($goods_list as $key => $value) {
                // 商品多图
                foreach ($goodsimage_more as $v) {
                    if ($value['goods_commonid'] == $v['goods_commonid'] && $value['store_id'] == $v['store_id'] && $value['color_id'] == $v['color_id']) {
                        $goods_list[$key]['image'][] = $v;
                    }
                }
                // 店铺的开店会员编号
                $store_id = $value['store_id'];
                $goods_list[$key]['member_id'] = $store_list[$store_id]['member_id'];
                //将关键字置红
                $goods_list[$key]['goods_name_highlight'] = $value['goods_name'];
            }
        }
        $this->assign('goods_list', $goods_list);

        // 地区
        $province_array = model('area')->getTopLevelAreas();
        $this->assign('province_array', $province_array);

        /* 引用搜索相关函数 */
        require_once(APP_PATH . '/home/common_search.php');
        
        /**
         * 取浏览过产品的cookie(最大四组)
         */
        $viewed_goods = model('goodsbrowse')->getViewedGoodsList(session('member_id'), 20);
        $this->assign('viewed_goods', $viewed_goods);

        /**
         * 分类导航
         */
        $nav_link = array(
            0 => array(
                'title' => lang('homepage'),
                'link' => HOME_SITE_URL
            ),
            1 => array(
                'title' => lang('brand_index_all_brand'),
                'link' => url('Brand/index')
            ),
            2 => array(
                'title' => $brand_info['brand_name']
            )
        );
        $this->assign('nav_link_list', $nav_link);
        /**
         * 页面输出
         */
        $this->assign('index_sign', 'brand');
        
        //SEO 设置
        $seo = model('seo')->type('brand_list')->param(array('name' => $brand_info['brand_name']))->show();
        $this->_assign_seo($seo);
        
        return $this->fetch($this->template_dir.'brand_goods');
    }

}