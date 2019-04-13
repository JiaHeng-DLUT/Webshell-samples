<?php

namespace app\home\controller;

use think\Lang;

class Sellergoodsoffline extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellergoodsadd.lang.php');
        $this->template_dir = 'default/seller/sellergoodsadd/';
    }

    public function index() {
        $this->goods_storage();
    }

    /**
     * 仓库中的商品列表
     */
    public function goods_storage() {
        $goods_model = model('goods');

        $where = array();
        $where['store_id'] = session('store_id');

        $storegc_id = intval(input('get.storegc_id'));
        if ($storegc_id > 0) {
            $where['goods_stcids'] = array('like', '%,' . $storegc_id . ',%');
        }
        $keyword = input('get.keyword');
        $search_type = input('get.search_type');
        if (trim($keyword) != '') {
            switch ($search_type) {
                case 0:
                    $where['goods_name'] = array('like', '%' . trim($keyword) . '%');
                    break;
                case 1:
                    $where['goods_serial'] = array('like', '%' . trim($keyword) . '%');
                    break;
                case 2:
                    $where['goods_commonid'] = intval($keyword);
                    break;
            }
        }

        $type = input('param.type');
        $verify = input('get.verify');
        switch ($type) {
            // 违规的商品
            case 'lock_up':
                /* 设置卖家当前菜单 */
                $this->setSellerCurMenu('sellergoodsoffline');
                $this->setSellerCurItem('goods_lockup');
                $goods_list = $goods_model->getGoodsCommonLockUpList($where);
                break;
            // 等待审核或审核失败的商品
            case 'wait_verify':
                /* 设置卖家当前菜单 */
                $this->setSellerCurMenu('sellergoodsoffline');
                $this->setSellerCurItem('goods_verify');
                if (isset($verify) && in_array($verify, array('0', '10'))) {
                    $where['goods_verify'] = $verify;
                }
                $goods_list = $goods_model->getGoodsCommonWaitVerifyList($where);
                break;
            // 仓库中的商品
            default:
                /* 设置卖家当前菜单 */
                $this->setSellerCurMenu('sellergoodsoffline');
                $this->setSellerCurItem('goods_storage');
                $goods_list = $goods_model->getGoodsCommonOfflineList($where);
                break;
        }

        $this->assign('show_page', $goods_model->page_info->render());
        $this->assign('goods_list', $goods_list);

        // 计算库存
        $storage_array = $goods_model->calculateStorage($goods_list);
        $this->assign('storage_array', $storage_array);

        // 商品分类
        $store_goods_class = model('storegoodsclass')->getClassTree(array('store_id' => session('store_id'), 'storegc_state' => '1'));
        $this->assign('store_goods_class', $store_goods_class);

        switch ($type) {
            // 违规的商品
            case 'lock_up':
                echo $this->fetch($this->template_dir.'store_goods_list_offline_lockup');
                break;
            // 等待审核或审核失败的商品
            case 'wait_verify':
                $this->assign('verify', array('0' => '未通过', '10' => '等待审核'));
                echo $this->fetch($this->template_dir.'store_goods_list_offline_waitverify');
                break;
            // 仓库中的商品
            default:
                echo $this->fetch($this->template_dir.'store_goods_list_offline');
                break;
        }
        exit;
    }

    /**
     * 商品上架
     */
    public function goods_show() {
        $commonid = input('param.commonid');
        if (!preg_match('/^[\d,]+$/i', $commonid)) {
            ds_json_encode(10001,lang('param_error'));
        }
        $commonid_array = explode(',', $commonid);
        if ($this->store_info['store_state'] != 1) {
            ds_json_encode(10001,lang(lang('store_goods_index_goods_show_fail') . '，店铺正在审核中或已经关闭'));
        }
        $return = model('goods')->editProducesOnline(array('goods_commonid' => array('in', $commonid_array), 'store_id' => session('store_id')));
        if ($return) {
            // 添加操作日志
            $this->recordSellerlog('商品上架，平台货号：' . $commonid);
            ds_json_encode(10000,lang('store_goods_index_goods_show_success'));
        } else {
            ds_json_encode(10001,lang('store_goods_index_goods_show_fail'));
        }
    }

    /**
     *    栏目菜单
     */
    function getSellerItemList() {
        $item_list = array(
            array(
                'name' => 'goods_storage',
                'text' => lang('ds_member_path_goods_storage'),
                'url' => url('Sellergoodsoffline/index'),
            ),
            array(
                'name' => 'goods_lockup',
                'text' => lang('ds_member_path_goods_state'),
                'url' => url('Sellergoodsoffline/index', ['type' => 'lock_up']),
            ),
            array(
                'name' => 'goods_verify',
                'text' => lang('ds_member_path_goods_verify'),
                'url' => url('Sellergoodsoffline/index', ['type' => 'wait_verify']),
            ),
        );
        return $item_list;
    }

}

?>
