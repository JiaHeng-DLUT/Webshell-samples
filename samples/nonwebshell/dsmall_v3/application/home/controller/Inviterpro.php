<?php

namespace app\home\controller;

use think\Lang;

class Inviterpro extends BaseMall {

    //每页显示商品数
    const PAGESIZE = 12;

    //模型对象
    private $_model_search;

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/inviterpro.lang.php');
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
        } else{
            $goods_class_array = model('goodsclass')->getGoodsclassListByParentId(0);
        }

        $this->assign('goods_class_array', $goods_class_array);
        $this->assign('default_classid', $default_classid);
        
        $goods_model = model('goods');
        if (!config('inviter_open')) {
            $goods_list=array();
        } else {
            
            $condition = array();
            $condition['inviter_open'] = 1;

            if (input('param.keyword')) {
                $condition['goods_name'] = array('like', '%' . input('param.keyword') . '%');
            }
            if(input('param.cate_id')){
                $condition['gc_id_1|gc_id_2|gc_id_3'] = intval(input('param.cate_id'));
            }

            $goods_list = $goods_model->getGoodsCommonList($condition, '*', self::PAGESIZE);
            foreach ($goods_list as $key => $goods) {
                $goods_info=$goods_model->getGoodsInfo(array('goods_commonid'=>$goods['goods_commonid']),'goods_id');
                $goods_list[$key]['goods_id'] = $goods_info['goods_id'];
                $goods_list[$key]['goods_image_url'] = goods_cthumb($goods['goods_image'], 240);
                $goods_list[$key]['inviter_amount'] = 0;
                if (config('inviter_show')) {
                    $inviter_amount = round($goods['inviter_ratio_1'] / 100 * $goods['goods_price'], 2);
                    if ($inviter_amount > 0) {
                        $goods_list[$key]['inviter_amount'] = $inviter_amount;
                    }
                }
            }

        }
        $this->assign('goods_list', $goods_list);
        $this->assign('show_page', is_object($goods_model->page_info)?$goods_model->page_info->render():"");
        

        // 当前位置导航
        $this->assign('nav_link_list', array(array('title' => lang('homepage'), 'link' => url('Home/Index/index')),array('title'=>lang('inviterpro_inviter_market'))));


        return $this->fetch($this->template_dir . 'index');
    }


}

?>
