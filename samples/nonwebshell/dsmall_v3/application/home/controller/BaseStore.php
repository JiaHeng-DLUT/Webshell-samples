<?php

/*
 * 店铺的类
 */

namespace app\home\controller;
use think\Lang;

class BaseStore extends BaseHome {
    protected $store_info;
    
    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/baseseller.lang.php');
        //店铺模板路径
        $this->template_dir = 'default/store/default/' . strtolower(request()->controller()) . '/';
        $this->assign('store_theme', 'default');
        //当方法为 store 进行执行
        if (request()->controller() == 'Store') {

            //输出会员信息
            $this->getMemberAndGradeInfo(false);

            $store_id = intval(input('param.store_id'));
            if ($store_id <= 0) {
                $this->error(lang('ds_store_close'));
            }

            $store_model = model('store');
            $store_info = $store_model->getStoreOnlineInfoByID($store_id);
            if (empty($store_info)) {
                $this->error(lang('ds_store_close'));
            } else {
                $this->store_info = $store_info;
            }


            $this->outputStoreInfo($this->store_info);
            $this->getStorenavigation($store_id);
            $this->outputSeoInfo($this->store_info);
        }
    }
    
    

    /**
     * 检查店铺开启状态
     *
     * @param int $store_id 店铺编号
     * @param string $msg 警告信息
     */
    protected function outputStoreInfo($store_info) {
            $store_model = model('store');

            //店铺分类
            $goodsclass_model = model('storegoodsclass');
            $goods_class_list = $goodsclass_model->getShowTreeList($store_info['store_id']);
            $this->assign('goods_class_list', $goods_class_list);

            //热销排行
            $hot_sales = $store_model->getHotSalesList($store_info['store_id'], 5);
            $this->assign('hot_sales', $hot_sales);

            //收藏排行
            $hot_collect = $store_model->getHotCollectList($store_info['store_id'], 5);
            $this->assign('hot_collect', $hot_collect);

        $this->assign('store_info', $store_info);
        $this->assign('page_title', $store_info['store_name']);
    }

    protected function getStorenavigation($store_id) {
        $storenavigation_model = model('storenavigation');
        $store_navigation_list = $storenavigation_model->getStorenavigationList(array('storenav_store_id' => $store_id));
        $this->assign('store_navigation_list', $store_navigation_list);
    }

    protected function outputSeoInfo($store_info) {
        $seo_param = array();
        $seo_param['shopname'] = $store_info['store_name'];
        $seo_param['key'] = $store_info['store_keywords'];
        $seo_param['description'] = $store_info['store_description'];
        //SEO 设置
        $this->_assign_seo(model('seo')->type('shop')->param($seo_param)->show());
    }
    
    

}

?>
