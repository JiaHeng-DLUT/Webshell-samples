<?php

/**
 * 商品管理
 */

namespace app\admin\controller;
use think\Lang;

class Goods extends AdminControl {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'admin/lang/'.config('default_lang').'/goods.lang.php');
    }

    /**
     * 商品管理
     */
    public function index() {
        $goods_model = model('goods');
        /**
         * 处理商品分类
         */
        $choose_gcid = ($t = intval(input('param.choose_gcid'))) > 0 ? $t : 0;
        $gccache_arr = model('goodsclass')->getGoodsclassCache($choose_gcid, 3);
        $this->assign('gc_json', json_encode($gccache_arr['showclass']));
        $this->assign('gc_choose_json', json_encode($gccache_arr['choose_gcid']));

        /**
         * 查询条件
         */
        $where = array();
        $search_goods_name = trim(input('param.search_goods_name'));
        if ($search_goods_name != '') {
            $where['goods_name'] = array('like', '%' . $search_goods_name . '%');
        }
        $search_commonid = intval(input('param.search_commonid'));
        if ($search_commonid > 0) {
            $where['goods_commonid'] = $search_commonid;
        }
        $search_store_name = trim(input('param.search_store_name'));
        if ($search_store_name != '') {
            $where['store_name'] = array('like', '%' .$search_store_name . '%');
        }
        $b_id = intval(input('param.b_id'));
        if ($b_id > 0) {
            $where['brand_id'] = $b_id;
        }
        if ($choose_gcid > 0) {
            $where['gc_id_' . ($gccache_arr['showclass'][$choose_gcid]['depth'])] = $choose_gcid;
        }
        $goods_state = input('param.goods_state');
        if (in_array($goods_state, array('0', '1', '10'))) {
            $where['goods_state'] = $goods_state;
        }
        $goods_verify = input('param.goods_verify');
        if (in_array($goods_verify, array('0', '1', '10'))) {
            $where['goods_verify'] = $goods_verify;
        }

        $type = input('param.type');
        switch ($type) {
            // 禁售
            case 'lockup':
                $goods_list = $goods_model->getGoodsCommonLockUpList($where);
                break;
            // 等待审核
            case 'waitverify':
                $goods_list = $goods_model->getGoodsCommonWaitVerifyList($where, '*', 10, 'goods_verify desc, goods_commonid desc');
                break;
            // 全部商品
            default:
                $goods_list = $goods_model->getGoodsCommonList($where);
                break;
        }

        $this->assign('goods_list', $goods_list);
        $this->assign('show_page', $goods_model->page_info->render());

        $storage_array = $goods_model->calculateStorage($goods_list);
        $this->assign('storage_array', $storage_array);

        // 品牌
        $brand_list = model('brand')->getBrandPassedList(array());

        $this->assign('search', $where);
        $this->assign('brand_list', $brand_list);

        $this->assign('state', array('1' => '出售中', '0' => '仓库中', '10' => '违规下架'));

        $this->assign('verify', array('1' => '通过', '0' => '未通过', '10' => '等待审核'));

        $this->assign('ownShopIds', array_fill_keys(model('store')->getOwnShopIds(), true));

        $type = input('param.type');
        if(!in_array($type, array('lockup','waitverify','allgoods'))){
            $type = 'allgoods';
        }
        
        $this->assign('type', $type);
        $this->setAdminCurItem($type);
        return $this->fetch();
    }


    /**
     * 计算商品库存
     */
    public function goods_storage($goods_list) {
        $goods_model = model('goods');
        // 计算库存
        $storage_array = array();
        if (!empty($goods_list)) {
            foreach ($goods_list as $value) {
                $storage_array[$value['goods_commonid']]['goods_storage'] = $goods_model->getGoodsSum(array('goods_commonid'=>$value['goods_commonid']),'goods_storage');
                $storage_array[$value['goods_commonid']][] = $goods_model->getGoodsInfo(array('goods_commonid'=>$value['goods_commonid']),'goods_id');
            }
            return $storage_array;
        } else {
            return false;
        }
    }

    /**
     * 违规下架
     */
    public function goods_lockup() {
        if (request()->isPost()) {
            $commonids = input('param.commonids');
            $commonid_array = ds_delete_param($commonids);
            if ($commonid_array == FALSE) {
                $this->error(lang('ds_common_op_fail'));
            }
            
            $update = array();
            $update['goods_stateremark'] = trim(input('post.close_reason'));

            $where = array();
            $where['goods_commonid'] = array('in', $commonid_array);

            model('goods')->editProducesLockUp($update, $where);
            dsLayerOpenSuccess(lang('ds_common_op_succ'));
        } else {
            $this->assign('commonids', input('param.commonid'));
            echo $this->fetch('close_remark');
        }
    }

    /**
     * 删除商品
     */
    public function goods_del() {
        $common_id = input('param.common_id');
        $common_id_array = ds_delete_param($common_id);
        if ($common_id_array == FALSE) {
            ds_json_encode('10001', lang('ds_common_op_fail'));
        }
        $condition = array();
        $condition['goods_commonid'] = array('in',$common_id_array);
        model('goods')->delGoodsAll($condition);
        ds_json_encode('10000', lang('ds_common_op_succ'));
    }

    /**
     * 审核商品
     */
    public function goods_verify() {
        if (request()->isPost()) {
            $commonids = input('param.commonids');
            $commonid_array = ds_delete_param($commonids);
            if ($commonid_array == FALSE) {
                $this->error(lang('ds_common_op_fail'));
            }

            $update2 = array();
            $update2['goods_verify'] = intval(input('param.verify_state'));

            $update1 = array();
            $update1['goods_verifyremark'] = trim(input('param.verify_reason'));
            $update1 = array_merge($update1, $update2);
            $where = array();
            $where['goods_commonid'] = array('in', $commonid_array);

            $goods_model = model('goods');
            if (intval(input('param.verify_state')) == 0) {
                $goods_model->editProducesVerifyFail($where, $update1, $update2);
            } else {
                $goods_model->editProduces($where, $update1, $update2);
            }
            dsLayerOpenSuccess(lang('ds_common_op_succ'));
        } else {
            $this->assign('commonids', input('param.commonid'));
            echo $this->fetch('verify_remark');
        }
    }

    //ajax获取同一个commonid下面的商品信息
    public function get_goods_list_ajax() {
        $common_id = input('param.commonid');
        if (empty($common_id)) {
            $this->error(lang('param_error'));
        }
        $map['goods_commonid'] = $common_id;
        $goods_model = model('goods');
        $common_info = $goods_model->getGoodeCommonInfo($map,'spec_name');
        $goods_list = $goods_model->getGoodsList($map);
        //halt($goods_list);
        $spec_name = array_values((array) unserialize($common_info['spec_name']));
        foreach ($goods_list as $key => $val) {
            $goods_spec = array_values((array) unserialize($val['goods_spec']));
            $spec_array = array();
            foreach ($goods_spec as $k => $v) {
                $spec_array[] = '<div class="goods_spec">' . $spec_name[$k] . ':' . '<em title="' . $v . '">' . $v . '</em>' . '</div>';
            }
            $goods_list[$key]['goods_image'] = goods_cthumb($val['goods_image']);
            $goods_list[$key]['goods_spec'] = implode('', $spec_array);
            $goods_list[$key]['url'] = url('Home/Goods/index', array('goods_id' => $val['goods_id']));
        }
        return json_encode($goods_list);
    }

    /**
     * 获取卖家栏目列表,针对控制器下的栏目
     */
    protected function getAdminItemList() {
        $menu_array = array(
            array(
                'name' => 'allgoods',
                'text' => '所有商品',
                'url' => url('Goods/index')
            ),
            array(
                'name' => 'lockup',
                'text' => '下架商品',
                'url' => url('Goods/index', ['type' => 'lockup'])
            ),
            array(
                'name' => 'waitverify',
                'text' => '待审核',
                'url' => url('Goods/index', ['type' => 'waitverify'])
            ),
        );
        return $menu_array;
    }

}

?>
