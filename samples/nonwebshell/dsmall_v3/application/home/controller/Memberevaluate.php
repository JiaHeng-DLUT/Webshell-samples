<?php

namespace app\home\controller;

use think\Lang;
use think\Model;

class Memberevaluate extends BaseMember {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/memberevaluate.lang.php');
    }

    /**
     * 订单添加评价
     */
    public function add() {
        $order_id = intval(input('order_id'));
        if (!$order_id) {
            $this->error(lang('wrong_argument'), 'member_order/index');
        }

        $order_model = model('order');
        $store_model = model('store');
        $evaluategoods_model = model('evaluategoods');
        $evaluatestore_model = model('evaluatestore');

        //获取订单信息
        $order_info = $order_model->getOrderInfo(array('order_id' => $order_id));
        //判断订单身份
        if ($order_info['buyer_id'] != session('member_id')) {
            $this->error(lang('wrong_argument'), 'member_order/index');
        }
        //订单为'已收货'状态，并且未评论
        $order_info['evaluate_able'] = $order_model->getOrderOperateState('evaluation', $order_info);
        if (empty($order_info) || !$order_info['evaluate_able']) {
            $this->error(lang('member_evaluation_order_notexists'), 'member_order/index');
        }

        //查询店铺信息
        $store_info = $store_model->getStoreInfoByID($order_info['store_id']);
        if (empty($store_info)) {
            $this->error(lang('member_evaluation_store_notexists'), 'member_order/index');
        }

        //获取订单商品
        $order_goods = $order_model->getOrdergoodsList(array('order_id' => $order_id));
        if (empty($order_goods)) {
            $this->error(lang('member_evaluation_order_notexists'), 'member_order/index');
        }

        //判断是否为页面
        if (!request()->isPost()) {
            /* for ($i = 0, $j = count($order_goods); $i < $j; $i++) {
              $order_goods[$i]['goods_image_url'] = goods_cthumb($order_goods[$i]['goods_image'], 240, $store_info['store_id']);
              } */

            //处理积分、经验值计算说明文字
            $expset = rkcache('config', true);
            $ruleexplain = '';
            $exppoints_rule = $expset['expset'] ? unserialize($expset['expset']) : array();
            $exppoints_rule['exp_comments'] = intval($exppoints_rule['comment_exp']);

            if ($exppoints_rule['exp_comments'] > 0) {
                $ruleexplain .= lang('evaluation_completed_will_obtained');
                if ($exppoints_rule['exp_comments'] > 0) {
                    $ruleexplain .= (' “' . $exppoints_rule['exp_comments'] . lang('experience_value'));
                }
            }
            $this->assign('ruleexplain', $ruleexplain);

            //不显示左菜单
            $this->assign('left_show', 'order_view');
            $this->assign('order_id', $order_id);
            $this->assign('order_info', $order_info);
            $this->assign('order_goods', $order_goods);
            $this->assign('store_info', $store_info);
            /* 设置买家当前菜单 */
            $this->setMemberCurMenu('member_evaluate');
            /* 设置买家当前栏目 */
            $this->setMemberCurItem('evaluate');
            return $this->fetch($this->template_dir . 'evaluation_add');
        } else {
            $evaluate_goods_array = array();
            $goodsid_array = array();

            $goods_array = input('post.goods/a');#获取评价数组
            
            foreach ($order_goods as $value) {
                //如果未评分，默认为5分
                $evaluate_score = intval($goods_array[$value['goods_id']]['score']);
                if ($evaluate_score <= 0 || $evaluate_score > 5) {
                    $evaluate_score = 5;
                }
                //默认评语
                $evaluate_comment = $goods_array[$value['goods_id']]['comment'];
                if (empty($evaluate_comment)) {
                    $evaluate_comment = lang('great');
                }

                $evaluate_goods_info = array();
                $evaluate_goods_info['geval_orderid'] = $order_id;
                $evaluate_goods_info['geval_orderno'] = $order_info['order_sn'];
                $evaluate_goods_info['geval_ordergoodsid'] = $value['rec_id'];
                $evaluate_goods_info['geval_goodsid'] = $value['goods_id'];
                $evaluate_goods_info['geval_goodsname'] = $value['goods_name'];
                $evaluate_goods_info['geval_goodsprice'] = $value['goods_price'];
                $evaluate_goods_info['geval_goodsimage'] = $value['goods_image'];
                $evaluate_goods_info['geval_scores'] = $evaluate_score;
                $evaluate_goods_info['geval_content'] = $evaluate_comment;
                $evaluate_goods_info['geval_isanonymous'] = input('post.anony') ? 1 : 0;
                $evaluate_goods_info['geval_addtime'] = TIMESTAMP;
                $evaluate_goods_info['geval_storeid'] = $store_info['store_id'];
                $evaluate_goods_info['geval_storename'] = $store_info['store_name'];
                $evaluate_goods_info['geval_frommemberid'] = session('member_id');
                $evaluate_goods_info['geval_frommembername'] = session('member_name');

                $evaluate_goods_array[] = $evaluate_goods_info;

                $goodsid_array[] = $value['goods_id'];
            }

            $evaluategoods_model->addEvaluategoodsArray($evaluate_goods_array, $goodsid_array);

            //             //添加店铺评价
            if (!$store_info['is_platform_store']) {

                $store_desccredit = intval(input('post.store_desccredit'));
                if ($store_desccredit <= 0 || $store_desccredit > 5) {
                    $store_desccredit = 5;
                }
                $store_servicecredit = intval(input('post.store_servicecredit'));
                if ($store_servicecredit <= 0 || $store_servicecredit > 5) {
                    $store_servicecredit = 5;
                }
                $store_deliverycredit = intval(input('post.store_deliverycredit'));
                if ($store_deliverycredit <= 0 || $store_deliverycredit > 5) {
                    $store_deliverycredit = 5;
                }

                $evaluate_store_info = array();
                $evaluate_store_info['seval_orderid'] = $order_id;
                $evaluate_store_info['seval_orderno'] = $order_info['order_sn'];
                $evaluate_store_info['seval_addtime'] = time();
                $evaluate_store_info['seval_storeid'] = $store_info['store_id'];
                $evaluate_store_info['seval_storename'] = $store_info['store_name'];
                $evaluate_store_info['seval_memberid'] = session('member_id');
                $evaluate_store_info['seval_membername'] = session('member_name');
                $evaluate_store_info['seval_desccredit'] = $store_desccredit;
                $evaluate_store_info['seval_servicecredit'] = $store_servicecredit;
                $evaluate_store_info['seval_deliverycredit'] = $store_deliverycredit;
                $evaluatestore_model->addEvaluatestore($evaluate_store_info);
            }

            //更新订单信息并记录订单日志
            $state = $order_model->editOrder(array('evaluation_state' => 1), array('order_id' => $order_id));
            $order_model->editOrdercommon(array('evaluation_time' => TIMESTAMP), array('order_id' => $order_id));
            if ($state) {
                $data = array();
                $data['order_id'] = $order_id;
                $data['log_role'] = 'buyer';
                $data['log_msg'] = lang('order_log_eval');
                $order_model->addOrderlog($data);
            }

            //添加会员积分
            if (config('points_isuse') == 1) {
                $points_model = model('points');
                $points_model->savePointslog('comments', array('pl_memberid' => session('member_id'), 'pl_membername' => session('member_name')));
            }
            //添加会员经验值
            model('exppoints')->saveExppointslog('comments', array('explog_memberid' => session('member_id'), 'explog_membername' => session('member_name')));

            ds_json_encode(10000,lang('member_evaluation_evaluat_success'));
        }
    }

    /**
     * 虚拟商品评价
     */
    public function add_vr() {
        $order_id = intval(input('param.order_id'));
        if (!$order_id) {
            ds_json_encode('10001', lang('wrong_argument'));
        }

        $vrorder_model = model('vrorder');
        $store_model = model('store');
        $evaluategoods_model = model('evaluategoods');

        //获取订单信息
        $order_info = $vrorder_model->getVrorderInfo(array('order_id' => $order_id));
        //判断订单身份
        if ($order_info['buyer_id'] != session('member_id')) {
            ds_json_encode('10001', lang('wrong_argument'));
        }
        //订单为'已收货'状态，并且未评论
        $order_info['evaluate_able'] = $vrorder_model->getVrorderOperateState('evaluation', $order_info);
        if (!$order_info['evaluate_able']) {
            ds_json_encode('10001', lang('member_evaluation_order_notexists'));
        }

        //查询店铺信息
        $store_info = $store_model->getStoreInfoByID($order_info['store_id']);
        if (empty($store_info)) {
            ds_json_encode('10001', lang('member_evaluation_store_notexists'));
        }
        $order_goods = array($order_info);

        //判断是否为页面
        if (!request()->isPost()) {
            $order_goods[0]['goods_image_url'] = goods_cthumb($order_info['goods_image'], 240, $order_info['store_id']);

            //处理积分、经验值计算说明文字
            $ruleexplain = '';
            $exppoints_rule = config("exppoints_rule") ? unserialize(config("exppoints_rule")) : array();
            $exppoints_rule['exp_comments'] = intval($exppoints_rule['exp_comments']);
            $points_comments = intval(config('points_comments'));
            if ($exppoints_rule['exp_comments'] > 0 || $points_comments > 0) {
                $ruleexplain .= lang('evaluation_completed_will_obtained');
                if ($exppoints_rule['exp_comments'] > 0) {
                    $ruleexplain .= (' “' . $exppoints_rule['exp_comments'] . lang('experience_value'));
                }
                if ($points_comments > 0) {
                    $ruleexplain .= (' “' . $points_comments . lang('integral'));
                }
                $ruleexplain .= '。';
            }
            $this->assign('ruleexplain', $ruleexplain);

            //不显示左菜单
            $this->assign('left_show', 'order_view');
            $this->assign('order_info', $order_info);
            $this->assign('order_goods', $order_goods);
            $this->assign('store_info', $store_info);
            /* 设置买家当前菜单 */
            $this->setMemberCurMenu('member_evaluate');
            /* 设置买家当前栏目 */
            $this->setMemberCurItem('evaluate');
            return $this->fetch($this->template_dir . 'evaluation_add');
        } else {
            $evaluate_goods_array = array();
            $goodsid_array = array();
            
            $goods_array = input('post.goods/a');#获取提交的数组
            
            foreach ($order_goods as $value) {
                //如果未评分，默认为5分
                $evaluate_score = intval($goods_array[$value['goods_id']]['score']);
                if ($evaluate_score <= 0 || $evaluate_score > 5) {
                    $evaluate_score = 5;
                }
                //默认评语
                $evaluate_comment = $goods_array[$value['goods_id']]['comment'];
                if (empty($evaluate_comment)) {
                    $evaluate_comment = lang('great');
                }

                $evaluate_goods_info = array();
                $evaluate_goods_info['geval_orderid'] = $order_id;
                $evaluate_goods_info['geval_orderno'] = $order_info['order_sn'];
                $evaluate_goods_info['geval_ordergoodsid'] = $order_id;
                $evaluate_goods_info['geval_goodsid'] = $value['goods_id'];
                $evaluate_goods_info['geval_goodsname'] = $value['goods_name'];
                $evaluate_goods_info['geval_goodsprice'] = $value['goods_price'];
                $evaluate_goods_info['geval_goodsimage'] = $value['goods_image'];
                $evaluate_goods_info['geval_scores'] = $evaluate_score;
                $evaluate_goods_info['geval_content'] = $evaluate_comment;
                $evaluate_goods_info['geval_isanonymous'] = input('post.anony') ? 1 : 0;
                $evaluate_goods_info['geval_addtime'] = TIMESTAMP;
                $evaluate_goods_info['geval_storeid'] = $store_info['store_id'];
                $evaluate_goods_info['geval_storename'] = $store_info['store_name'];
                $evaluate_goods_info['geval_frommemberid'] = session('member_id');
                $evaluate_goods_info['geval_frommembername'] = session('member_name');

                $evaluate_goods_array[] = $evaluate_goods_info;

                $goodsid_array[] = $value['goods_id'];
            }
            $evaluategoods_model->addEvaluategoodsArray($evaluate_goods_array, $goodsid_array);

            //更新订单信息并记录订单日志
            $vrorder_model->editVrorder(array('evaluation_state' => 1, 'evaluation_time' => TIMESTAMP), array('order_id' => $order_id));

            //添加会员积分
            if (config('points_isuse') == 1) {
                $points_model = model('points');
                $points_model->savePointslog('comments', array('pl_memberid' => session('member_id'), 'pl_membername' => session('member_name')));
            }
            //添加会员经验值
            model('exppoints')->saveExppointslog('comments', array('explog_memberid' => session('member_id'), 'explog_membername' => session('member_name')));

            ds_json_encode('10000', lang('member_evaluation_evaluat_success'));
        }
    }

    /**
     * 评价列表
     */
    public function index() {
        $evaluategoods_model = model('evaluategoods');

        $condition = array();
        $condition['geval_frommemberid'] = session('member_id');
        $goodsevallist = $evaluategoods_model->getEvaluategoodsList($condition, 5, 'geval_id desc');
        $this->assign('goodsevallist', $goodsevallist);
        /* 设置买家当前菜单 */
        $this->setMemberCurMenu('member_evaluate');
        /* 设置买家当前栏目 */
        $this->setMemberCurItem('evaluate');
        $this->assign('show_page', $evaluategoods_model->page_info->render());

        return $this->fetch($this->template_dir . 'index');
    }

    public function add_image() {
        $geval_id = intval(input('geval_id'));

        $evaluategoods_model = model('evaluategoods');
        $store_model = model('store');
        $snsalumb_model = model('snsalbum');

        $geval_info = $evaluategoods_model->getEvaluategoodsInfoByID($geval_id);

        if (!empty($geval_info['geval_image'])) {
            $this->error(lang('goods_have_been_posted'));
        }

        if ($geval_info['geval_frommemberid'] != session('member_id')) {
            $this->error(lang('param_error'));
        }
        $this->assign('geval_info', $geval_info);

        $store_info = $store_model->getStoreInfoByID($geval_info['geval_storeid']);
        $this->assign('store_info', $store_info);

        $ac_id = $snsalumb_model->getSnsAlbumClassDefault(session('member_id'));

        $this->assign('ac_id', $ac_id);
        /* 设置买家当前菜单 */
        $this->setMemberCurMenu('member_evaluate');
        /* 设置买家当前栏目 */
        $this->setMemberCurItem('evaluate');
        //不显示左菜单
        $this->assign('left_show', 'order_view');
        return $this->fetch($this->template_dir . 'add_image');
    }

    public function add_image_save() {
        $geval_id = intval(input('param.geval_id'));
        $geval_image = '';
        $evaluate_image_array = input('post.evaluate_image/a');#获取数组
        foreach ($evaluate_image_array as $value) {
            if (!empty($value)) {
                $geval_image .= $value . ',';
            }
        }
        $geval_image = rtrim($geval_image, ',');

        $evaluategoods_model = model('evaluategoods');

        $geval_info = $evaluategoods_model->getEvaluategoodsInfoByID($geval_id);
        if (empty($geval_info)) {
            ds_json_encode(10001,lang('param_error'));
        }
        if ($geval_info['geval_frommemberid'] != session('member_id')) {
            ds_json_encode(10001,lang('param_error'));
        }

        $update = array();
        $update['geval_image'] = $geval_image;
        $condition = array();
        $condition['geval_id'] = $geval_id;
        $result = $evaluategoods_model->editEvaluategoods($update, $condition);
        if ($result) {
            ds_json_encode(10000,lang('ds_common_save_succ'));
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    public function getMemberItemList() {
        $menu_array = array(
            array(
                'name' => 'evaluate',
                'text' => lang('trade_reviews_orders'),
                'url' => url('Memberevaluate/index')
            ),
        );
        return $menu_array;
    }

}
