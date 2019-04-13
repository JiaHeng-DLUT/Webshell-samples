<?php

namespace app\home\controller;

use think\Lang;

class Sellercost extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellercost.lang.php');
    }

    public function cost_list() {
        $storecost_model = model('storecost');
        $condition = array();
        $condition['storecost_store_id'] = session('store_id');
        $storecost_remark = input('get.storecost_remark');
        if (!empty($storecost_remark)) {
            $condition['storecost_remark'] = array('like', '%' . $storecost_remark . '%');
        }
        $add_time_from = input('get.add_time_from');
        $add_time_to = input('get.add_time_to');
        if (!empty($add_time_from) && !empty($add_time_to)) {
            $condition['storecost_time'] = array('between', array(strtotime($add_time_from), strtotime($add_time_to)));
        }
        $cost_list = $storecost_model->getStorecostList($condition, 10, 'storecost_id desc');

        $this->assign('cost_list', $cost_list);
        $this->assign('show_page', $storecost_model->page_info->render());

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellercost');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('cost_list');
        return $this->fetch($this->template_dir.'cost_list');
    }


    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @param array $array 附加菜单
     * @return
     */
    protected function getSellerItemList()
    {
        $menu_array = array(
            array(
                'name' => 'cost_list',
                'text' => '消费列表',
                'url' => url('Sellercost/cost_list')
            ),
        );
        return $menu_array;
    }
    
    
}
