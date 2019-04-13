<?php

namespace app\home\controller;

use think\Lang;


class Sellergoodsonline extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellergoodsadd.lang.php');
        $this->template_dir = 'default/seller/sellergoodsadd/';
    }

    public function index() {
        $this->goods_list();
    }

    /**
     * 出售中的商品列表
     */
    public function goods_list() {
        $goods_model = model('goods');

        $where = array();
        $where['store_id'] = session('store_id');

        $storegc_id = intval(input('get.storegc_id'));
        if ($storegc_id > 0) {
            $where['goods_stcids'] = array('like', '%,' . $storegc_id . ',%');
        }
        $keyword = trim(input('get.keyword'));
        $search_type = trim(input('get.search_type'));
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
        $goods_list = $goods_model->getGoodsCommonOnlineList($where);

        $this->assign('show_page', $goods_model->page_info->render());
        $this->assign('goods_list', $goods_list);
        // 计算库存
        $storage_array = $goods_model->calculateStorage($goods_list);
        $this->assign('storage_array', $storage_array);

        // 商品分类
        $store_goods_class = model('storegoodsclass')->getClassTree(array('store_id' => session('store_id'), 'storegc_state' => '1'));
        $this->assign('store_goods_class', $store_goods_class);

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsonline');
        $this->setSellerCurItem('goods_list');
        echo $this->fetch($this->template_dir . 'store_goods_list_online');
        exit;
    }

    /**
     * 编辑商品页面
     */
    public function edit_goods() {
        $common_id = intval(input('param.commonid'));
        if ($common_id <= 0) {
            $this->error(lang('wrong_argument'));
        }
        $goods_model = model('goods');
        $goodscommon_info = $goods_model->getGoodeCommonInfoByID($common_id);
        if (empty($goodscommon_info) || $goodscommon_info['store_id'] != session('store_id') || $goodscommon_info['goods_lock'] == 1) {
            $this->error('您的商品不存在，或商品已被锁定，请联系管理员删除抢购解除锁定');
        }

        $where = array('goods_commonid' => $common_id, 'store_id' => session('store_id'));
        $goodscommon_info['g_storage'] = $goods_model->getGoodsSum($where, 'goods_storage');
        $goodscommon_info['spec_name'] = unserialize($goodscommon_info['spec_name']);
        if ($goodscommon_info['mobile_body'] != '') {
            $goodscommon_info['mb_body'] = unserialize($goodscommon_info['mobile_body']);
            if (is_array($goodscommon_info['mb_body'])) {
                $mobile_body = '[';
                foreach ($goodscommon_info['mb_body'] as $val) {
                    $mobile_body .= '{"type":"' . $val['type'] . '","value":"' . $val['value'] . '"},';
                }
                $mobile_body = rtrim($mobile_body, ',') . ']';
            }
            $goodscommon_info['mobile_body'] = $mobile_body;
        }
        $this->assign('goods', $goodscommon_info);

        $class_id = intval(input('param.class_id'));
        if ($class_id > 0) {
            $goodscommon_info['gc_id'] = $class_id;
        }
        $goods_class = model('goodsclass')->getGoodsclassLineForTag($goodscommon_info['gc_id']);
        $this->assign('goods_class', $goods_class);

        $type_model = model('type');
        // 获取类型相关数据
        $typeinfo = $type_model->getAttribute($goods_class['type_id'], session('store_id'), $goodscommon_info['gc_id']);
        list($spec_json, $spec_list, $attr_list, $brand_list) = $typeinfo;
        $this->assign('spec_json', $spec_json);
        $this->assign('sign_i', count($spec_list));
        $this->assign('spec_list', $spec_list);
        $this->assign('attr_list', $attr_list);
        $this->assign('brand_list', $brand_list);

        // 取得商品规格的输入值
        $goods_array = $goods_model->getGoodsList($where, 'goods_id,goods_marketprice,goods_price,goods_storage,goods_serial,goods_storage_alarm,goods_spec');

        $sp_value = array();
        if (is_array($goods_array) && !empty($goods_array)) {

            // 取得已选择了哪些商品的属性
            $attr_checked_l = $type_model->typeRelatedList('goodsattrindex', array(
                'goods_id' => intval($goods_array[0]['goods_id'])
                    ), 'attrvalue_id');
            $attr_checked = array();
            if (is_array($attr_checked_l) && !empty($attr_checked_l)) {
                foreach ($attr_checked_l as $val) {
                    $attr_checked [] = $val ['attrvalue_id'];
                }
            }
            $this->assign('attr_checked', $attr_checked);

            $spec_checked = array();
            foreach ($goods_array as $k => $v) {
                $a = unserialize($v['goods_spec']);
                if (!empty($a)) {
                    foreach ($a as $key => $val) {
                        $spec_checked[$key]['id'] = $key;
                        $spec_checked[$key]['name'] = $val;
                    }
                    $matchs = array_keys($a);
                    //sort($matchs);
                    $id = str_replace(',', '', implode(',', $matchs));
                    $sp_value ['i_' . $id . '|marketprice'] = $v['goods_marketprice'];
                    $sp_value ['i_' . $id . '|price'] = $v['goods_price'];
                    $sp_value ['i_' . $id . '|id'] = $v['goods_id'];
                    $sp_value ['i_' . $id . '|stock'] = $v['goods_storage'];
                    $sp_value ['i_' . $id . '|alarm'] = $v['goods_storage_alarm'];
                    $sp_value ['i_' . $id . '|sku'] = $v['goods_serial'];
                }
            }
            $this->assign('spec_checked', $spec_checked);
        }
        $this->assign('sp_value', $sp_value);

        // 实例化店铺商品分类模型
        $store_goods_class = model('storegoodsclass')->getClassTree(array('store_id' => session('store_id'), 'storegc_state' => '1'));
        $this->assign('store_goods_class', $store_goods_class);
        //处理商品所属分类
        $store_goods_class_tmp = array();
        if (!empty($store_goods_class)) {
            foreach ($store_goods_class as $k => $v) {
                $store_goods_class_tmp[$v['storegc_id']] = $v;
                if (isset($v['child'])) {
                    foreach ($v['child'] as $son_k => $son_v) {
                        $store_goods_class_tmp[$son_v['storegc_id']] = $son_v;
                    }
                }
            }
        }
        $goodscommon_info['goods_stcids'] = trim($goodscommon_info['goods_stcids'], ',');
        $goods_stcids = empty($goodscommon_info['goods_stcids']) ? array() : explode(',', $goodscommon_info['goods_stcids']);
        $goods_stcids_tmp = $goods_stcids_new = array();
        if (!empty($goods_stcids)) {
            foreach ($goods_stcids as $k => $v) {
                $storegc_parent_id = $store_goods_class_tmp[$v]['storegc_parent_id'];
                //分类进行分组，构造为array('1'=>array(5,6,8));
                if ($storegc_parent_id > 0) {//如果为二级分类，则分组到父级分类下
                    $goods_stcids_tmp[$storegc_parent_id][] = $v;
                } elseif (empty($goods_stcids_tmp[$v])) {//如果为一级分类而且分组不存在，则建立一个空分组数组
                    $goods_stcids_tmp[$v] = array();
                }
            }
            foreach ($goods_stcids_tmp as $k => $v) {
                if (!empty($v) && count($v) > 0) {
                    $goods_stcids_new = array_merge($goods_stcids_new, $v);
                } else {
                    $goods_stcids_new[] = $k;
                }
            }
        }
        $this->assign('store_class_goods', $goods_stcids_new);

        // 是否能使用编辑器
        if (check_platform_store()) { // 平台店铺可以使用编辑器
            $editor_multimedia = true;
        } else {    // 三方店铺需要
            $editor_multimedia = false;
            if ($this->store_grade['storegrade_function'] == 'editor_multimedia') {
                $editor_multimedia = true;
            }
        }
        $this->assign('editor_multimedia', $editor_multimedia);

        // 小时分钟显示
        $hour_array = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
        $this->assign('hour_array', $hour_array);
        $minute_array = array('05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');
        $this->assign('minute_array', $minute_array);

        // 关联版式
        $plate_list = model('storeplate')->getStoreplateList(array('store_id' => session('store_id')), 'storeplate_id,storeplate_name,storeplate_position');
        $plate_list = array_under_reset($plate_list, 'storeplate_position', 2);
        $this->assign('plate_list', $plate_list);

        // F码
        if ($goodscommon_info['is_goodsfcode'] == 1) {
            $fcode_array = model('goodsfcode')->getGoodsfcodeList(array('goods_commonid' => $goodscommon_info['goods_commonid']));
            $this->assign('fcode_array', $fcode_array);
        }

        $this->assign('edit_goods_sign', true);
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsonline');
        $this->setSellerCurItem('edit_goods');
        return $this->fetch($this->template_dir . 'store_goods_add_step2');
    }

    /**
     * 编辑商品保存
     */
    public function edit_save_goods() {

        $common_id = intval(input('param.commonid'));
        if (!request()->isPost() || $common_id <= 0) {
            ds_json_encode(10001,lang('store_goods_index_goods_edit_fail'));
        }

        $gc_id = intval(input('post.cate_id'));

        // 验证商品分类是否存在且商品分类是否为最后一级
        $data = model('goodsclass')->getGoodsclassForCacheModel();
        if (!isset($data[$gc_id]) || isset($data[$gc_id]['child']) || isset($data[$gc_id]['childchild'])) {
            ds_json_encode(10001,lang('store_goods_index_again_choose_category1'));
        }
        
        // 三方店铺验证是否绑定了该分类
        if (!check_platform_store()) {
            //商品分类 提供批量显示所有分类插件
            $storebindclass_model = model('storebindclass');
            $goods_class = model('goodsclass')->getGoodsclassForCacheModel();
            $where['store_id'] = session('store_id');
            $class_2 = isset($goods_class[$gc_id]['gc_parent_id'])?$goods_class[$gc_id]['gc_parent_id']:0;
            $class_1 = isset($goods_class[$class_2]['gc_parent_id'])?$goods_class[$class_2]['gc_parent_id']:0;
            $where['class_1'] = ($class_1>0)?$class_1:(($class_2>0)?$class_2:$gc_id);
            $where['class_2'] = ($class_1>0)?$class_2:(($class_2>0)?$gc_id:0);
            $where['class_3'] = ($class_1>0 && $class_2>0)?$gc_id:0;
            $bind_info = $storebindclass_model->getStorebindclassInfo($where);
            if (empty($bind_info)) {
                $where['class_3'] = 0;
                $bind_info = $storebindclass_model->getStorebindclassInfo($where);
                if (empty($bind_info)) {
                    $where['class_2'] = 0;
                    $where['class_3'] = 0;
                    $bind_info = $storebindclass_model->getStorebindclassInfo($where);
                    if (empty($bind_info)) {
                        $where['class_1'] = 0;
                        $where['class_2'] = 0;
                        $where['class_3'] = 0;
                        $bind_info = $storebindclass_model->getStorebindclassInfo($where);
                        if (empty($bind_info)) {
                            ds_json_encode(10001,lang('store_goods_index_again_choose_category2'));
                        }
                    }
                }
            }
        }
        // 分类信息
        $goods_class = model('goodsclass')->getGoodsclassLineForTag(intval(input('post.cate_id')));
        $goods_model = model('goods');

        $update_common = array();
        $update_common['goods_name'] = input('post.g_name');
        $update_common['goods_advword'] = input('post.g_jingle');
        $update_common['gc_id'] = $gc_id;
        $update_common['gc_id_1'] = isset($goods_class['gc_id_1'])?intval($goods_class['gc_id_1']):0;
        $update_common['gc_id_2'] = isset($goods_class['gc_id_2'])?intval($goods_class['gc_id_2']):0;
        $update_common['gc_id_3'] = isset($goods_class['gc_id_3'])?intval($goods_class['gc_id_3']):0;
        $update_common['gc_name'] = input('post.cate_name');
        $update_common['brand_id'] = input('post.b_id');
        $update_common['brand_name'] = input('post.b_name');
        $update_common['type_id'] = intval(input('post.type_id'));
        $update_common['goods_image'] = input('post.image_path');
        $update_common['goods_price'] = floatval(input('post.g_price'));
        $update_common['goods_marketprice'] = floatval(input('post.g_marketprice'));
        $update_common['goods_costprice'] = floatval(input('post.g_costprice'));
        $update_common['goods_discount'] = floatval(input('post.g_discount'));
        $update_common['goods_serial'] = input('post.g_serial');
        $update_common['goods_storage_alarm'] = intval(input('post.g_alarm'));
        $update_common['goods_attr'] = !empty(input('post.attr/a'))?serialize(input('post.attr/a')):'';
        $update_common['goods_body'] = input('post.goods_body');
        // 序列化保存手机端商品描述数据
        $mobile_body = input('post.m_body');
        if ($mobile_body != '') {
            $mobile_body = str_replace('&quot;', '"', $mobile_body);
            $mobile_body = json_decode($mobile_body, true);
            if (!empty($mobile_body)) {
                $mobile_body = serialize($mobile_body);
            } else {
                $mobile_body = '';
            }
        }
        $update_common['mobile_body'] = $mobile_body;
        $update_common['goods_commend'] = intval(input('post.g_commend'));
        $update_common['goods_state'] = ($this->store_info['store_state'] != 1) ? 0 : intval(input('post.g_state'));            // 店铺关闭时，商品下架
        $update_common['goods_shelftime'] = strtotime(input('post.starttime')) + intval(input('post.starttime_H')) * 3600 + intval(input('post.starttime_i')) * 60;
        $update_common['goods_verify'] = (config('goods_verify') == 1) ? 10 : 1;
        $update_common['spec_name'] = !empty(input('post.spec/a')) ? serialize(input('post.sp_name/a')) : serialize(null);
        $update_common['spec_value'] = !empty(input('post.spec/a')) ? serialize(input('post.sp_val/a')) : serialize(null);
        $update_common['goods_vat'] = intval(input('post.g_vat'));
        $update_common['areaid_1'] = intval(input('post.province_id'));
        $update_common['areaid_2'] = intval(input('post.city_id'));
        $update_common['transport_id'] = (input('post.freight') == '0') ? '0' : intval(input('post.transport_id')); // 售卖区域
        $update_common['transport_title'] = input('post.transport_title');
        $update_common['goods_freight'] = floatval(input('post.g_freight'));

        $sellergoodsonline_validate = validate('sellergoodsonline');
        if (!$sellergoodsonline_validate->scene('edit_save_goods')->check($update_common)) {
            ds_json_encode('10001',$sellergoodsonline_validate->getError());
        }

        //查询店铺商品分类
        $goods_stcids_arr = array();
        $sgcate_id_array = input('post.sgcate_id/a');#获取数组
        if (!empty($sgcate_id_array)) {
            $sgcate_id_arr = array();
            foreach ($sgcate_id_array as $k => $v) {
                $sgcate_id_arr[] = intval($v);
            }
            $sgcate_id_arr = array_unique($sgcate_id_arr);
            $store_goods_class = model('storegoodsclass')->getStoregoodsclassList(array('store_id' => session('store_id'), 'storegc_id' => array('in', $sgcate_id_arr), 'storegc_state' => '1'));
            if (!empty($store_goods_class)) {
                foreach ($store_goods_class as $k => $v) {
                    if ($v['storegc_id'] > 0) {
                        $goods_stcids_arr[] = $v['storegc_id'];
                    }
                    if ($v['storegc_parent_id'] > 0) {
                        $goods_stcids_arr[] = $v['storegc_parent_id'];
                    }
                }
                $goods_stcids_arr = array_unique($goods_stcids_arr);
                sort($goods_stcids_arr);
            }
        }
        if (empty($goods_stcids_arr)) {
            $update_common['goods_stcids'] = '';
        } else {
            $update_common['goods_stcids'] = ',' . implode(',', $goods_stcids_arr) . ',';
        }
        $update_common['plateid_top'] = intval(input('post.plate_top')) > 0 ? intval(input('post.plate_top')) : '';
        $update_common['plateid_bottom'] = intval(input('post.plate_bottom')) > 0 ? intval(input('post.plate_bottom')) : '';
        $update_common['is_virtual'] = intval(input('post.is_gv'));
        $update_common['virtual_indate'] = input('post.g_vindate') != '' ? (strtotime(input('post.g_vindate')) + 24 * 60 * 60 - 1) : 0;  // 当天的最后一秒结束
        $update_common['virtual_limit'] = intval(input('post.g_vlimit')) > 10 || intval(input('post.g_vlimit')) < 0 ? 10 : intval(input('post.g_vlimit'));
        $update_common['virtual_invalid_refund'] = intval(input('post.g_vinvalidrefund'));
        $update_common['is_goodsfcode'] = intval(input('post.is_fc'));
        $update_common['is_appoint'] = intval(input('post.is_appoint'));     // 只有库存为零的商品可以预约
        $update_common['appoint_satedate'] = $update_common['is_appoint'] == 1 ? strtotime(input('post.g_saledate')) : '';   // 预约商品的销售时间
        $update_common['is_presell'] = $update_common['goods_state'] == 1 ? intval(input('post.is_presell')) : 0;     // 只有出售中的商品可以预售
        $update_common['presell_deliverdate'] = $update_common['is_presell'] == 1 ? strtotime(input('post.g_deliverdate')) : ''; // 预售商品的发货时间
        $update_common['is_platform_store'] = in_array(session('store_id'), model('store')->getOwnShopIds()) ? 1 : 0;

        // 开始事务
        model('goods')->startTrans();
        $goodsgift_model = model('goodsgift');
        // 清除原有规格数据
        $type_model = model('type');
        $type_model->delGoodsAttr(array('goods_commonid' => $common_id));

        // 更新商品规格
        $goodsid_array = array();
        $colorid_array = array();
        $spec_array = input('post.spec/a');#获取数组
        if (is_array($spec_array)&&!empty($spec_array)) {
            foreach ($spec_array as $value) {
                $goods_info = $goods_model->getGoodsInfo(array('goods_id' => $value['goods_id'], 'goods_commonid' => $common_id, 'store_id' => session('store_id')), 'goods_id');
                if (!empty($goods_info)) {
                    $goods_id = $goods_info['goods_id'];
                    $update = array();
                    $update['goods_commonid'] = $common_id;
                    $update['goods_name'] = $update_common['goods_name'] . ' ' . implode(' ', $value['sp_value']);
                    $update['goods_advword'] = $update_common['goods_advword'];
                    $update['store_id'] = session('store_id');
                    $update['store_name'] = session('store_name');
                    $update['gc_id'] = $update_common['gc_id'];
                    $update['gc_id_1'] = $update_common['gc_id_1'];
                    $update['gc_id_2'] = $update_common['gc_id_2'];
                    $update['gc_id_3'] = $update_common['gc_id_3'];
                    $update['brand_id'] = $update_common['brand_id'];
                    $update['goods_price'] = $value['price'];
                    $update['goods_marketprice'] = $value['marketprice'] == 0 ? $update_common['goods_marketprice'] : $value['marketprice'];
                    $update['goods_serial'] = $value['sku'];
                    $update['goods_storage_alarm'] = intval($value['alarm']);
                    $update['goods_spec'] = serialize($value['sp_value']);
                    $update['goods_storage'] = $value['stock'];
                    $update['goods_state'] = $update_common['goods_state'];
                    $update['goods_verify'] = $update_common['goods_verify'];
                    $update['goods_edittime'] = TIMESTAMP;
                    $update['areaid_1'] = $update_common['areaid_1'];
                    $update['areaid_2'] = $update_common['areaid_2'];
                    $update['color_id'] = isset($value['color'])?intval($value['color']):'';
                    $update['transport_id'] = $update_common['transport_id'];
                    $update['goods_freight'] = $update_common['goods_freight'];
                    $update['goods_vat'] = $update_common['goods_vat'];
                    $update['goods_commend'] = $update_common['goods_commend'];
                    $update['goods_stcids'] = $update_common['goods_stcids'];
                    $update['is_virtual'] = $update_common['is_virtual'];
                    $update['virtual_indate'] = $update_common['virtual_indate'];
                    $update['virtual_limit'] = $update_common['virtual_limit'];
                    $update['virtual_invalid_refund'] = $update_common['virtual_invalid_refund'];
                    $update['is_goodsfcode'] = $update_common['is_goodsfcode'];
                    $update['is_appoint'] = $update_common['is_appoint'];
                    $update['is_presell'] = $update_common['is_presell'];
                    // 虚拟商品不能有赠品
                    if ($update_common['is_virtual'] == 1) {
                        $update['is_have_gift'] = 0;
                        $goodsgift_model->delGoodsgift(array('goods_id' => $goods_id));
                    }
                    $update['is_platform_store'] = $update_common['is_platform_store'];
                    $goods_model->editGoodsById($update, $goods_id);
                } else {
                    $insert = array();
                    $insert['goods_commonid'] = $common_id;
                    $insert['goods_name'] = $update_common['goods_name'] . ' ' . implode(' ', $value['sp_value']);
                    $insert['goods_advword'] = $update_common['goods_advword'];
                    $insert['store_id'] = session('store_id');
                    $insert['store_name'] = session('store_name');
                    $insert['gc_id'] = $update_common['gc_id'];
                    $insert['gc_id_1'] = $update_common['gc_id_1'];
                    $insert['gc_id_2'] = $update_common['gc_id_2'];
                    $insert['gc_id_3'] = $update_common['gc_id_3'];
                    $insert['brand_id'] = $update_common['brand_id'];
                    $insert['goods_price'] = $value['price'];
                    $insert['goods_promotion_price'] = $value['price'];
                    $insert['goods_marketprice'] = $value['marketprice'] == 0 ? $update_common['goods_marketprice'] : $value['marketprice'];
                    $insert['goods_serial'] = $value['sku'];
                    $insert['goods_storage_alarm'] = intval($value['alarm']);
                    $insert['goods_spec'] = serialize($value['sp_value']);
                    $insert['goods_storage'] = $value['stock'];
                    $insert['goods_image'] = $update_common['goods_image'];
                    $insert['goods_state'] = $update_common['goods_state'];
                    $insert['goods_verify'] = $update_common['goods_verify'];
                    $insert['goods_addtime'] = TIMESTAMP;
                    $insert['goods_edittime'] = TIMESTAMP;
                    $insert['areaid_1'] = $update_common['areaid_1'];
                    $insert['areaid_2'] = $update_common['areaid_2'];
                    $insert['color_id'] = isset($value['color'])?intval($value['color']):'';
                    $insert['transport_id'] = $update_common['transport_id'];
                    $insert['goods_freight'] = $update_common['goods_freight'];
                    $insert['goods_vat'] = $update_common['goods_vat'];
                    $insert['goods_commend'] = $update_common['goods_commend'];
                    $insert['goods_stcids'] = $update_common['goods_stcids'];
                    $insert['is_virtual'] = $update_common['is_virtual'];
                    $insert['virtual_indate'] = $update_common['virtual_indate'];
                    $insert['virtual_limit'] = $update_common['virtual_limit'];
                    $insert['virtual_invalid_refund'] = $update_common['virtual_invalid_refund'];
                    $insert['is_goodsfcode'] = $update_common['is_goodsfcode'];
                    $insert['is_appoint'] = $update_common['is_appoint'];
                    $insert['is_presell'] = $update_common['is_presell'];
                    $insert['is_platform_store'] = $update_common['is_platform_store'];
                    $goods_id = $goods_model->addGoods($insert);
                }
                $goodsid_array[] = intval($goods_id);
                $colorid_array[] = isset($value['color'])?intval($value['color']):'';
                $type_model->addGoodsType($goods_id, $common_id, array('cate_id' => input('post.cate_id'), 'type_id' => input('post.type_id'), 'attr' => input('post.attr/a')));
            }
        } else {
            $goods_info = $goods_model->getGoodsInfo(array('goods_spec' => serialize(null), 'goods_commonid' => $common_id, 'store_id' => session('store_id')), 'goods_id');
            if (!empty($goods_info)) {
                $goods_id = $goods_info['goods_id'];
                $update = array();
                $update['goods_commonid'] = $common_id;
                $update['goods_name'] = $update_common['goods_name'];
                $update['goods_advword'] = $update_common['goods_advword'];
                $update['store_id'] = session('store_id');
                $update['store_name'] = session('store_name');
                $update['gc_id'] = $update_common['gc_id'];
                $update['gc_id_1'] = $update_common['gc_id_1'];
                $update['gc_id_2'] = $update_common['gc_id_2'];
                $update['gc_id_3'] = $update_common['gc_id_3'];
                $update['brand_id'] = $update_common['brand_id'];
                $update['goods_price'] = $update_common['goods_price'];
                $update['goods_marketprice'] = $update_common['goods_marketprice'];
                $update['goods_serial'] = $update_common['goods_serial'];
                $update['goods_storage_alarm'] = $update_common['goods_storage_alarm'];
                $update['goods_spec'] = serialize(null);
                $update['goods_storage'] = intval(input('post.g_storage'));
                $update['goods_state'] = $update_common['goods_state'];
                $update['goods_verify'] = $update_common['goods_verify'];
                $update['goods_edittime'] = TIMESTAMP;
                $update['areaid_1'] = $update_common['areaid_1'];
                $update['areaid_2'] = $update_common['areaid_2'];
                $update['color_id'] = 0;
                $update['transport_id'] = $update_common['transport_id'];
                $update['goods_freight'] = $update_common['goods_freight'];
                $update['goods_vat'] = $update_common['goods_vat'];
                $update['goods_commend'] = $update_common['goods_commend'];
                $update['goods_stcids'] = $update_common['goods_stcids'];
                $update['is_virtual'] = $update_common['is_virtual'];
                $update['virtual_indate'] = $update_common['virtual_indate'];
                $update['virtual_limit'] = $update_common['virtual_limit'];
                $update['virtual_invalid_refund'] = $update_common['virtual_invalid_refund'];
                $update['is_goodsfcode'] = $update_common['is_goodsfcode'];
                $update['is_appoint'] = $update_common['is_appoint'];
                $update['is_presell'] = $update_common['is_presell'];
                if ($update_common['is_virtual'] == 1) {
                    $update['is_have_gift'] = 0;
                    $goodsgift_model->delGoodsgift(array('goods_id' => $goods_id));
                }
                $update['is_platform_store'] = $update_common['is_platform_store'];
                $goods_model->editGoodsById($update, $goods_id);
            } else {
                $insert = array();
                $insert['goods_commonid'] = $common_id;
                $insert['goods_name'] = $update_common['goods_name'];
                $insert['goods_advword'] = $update_common['goods_advword'];
                $insert['store_id'] = session('store_id');
                $insert['store_name'] = session('store_name');
                $insert['gc_id'] = $update_common['gc_id'];
                $insert['gc_id_1'] = $update_common['gc_id_1'];
                $insert['gc_id_2'] = $update_common['gc_id_2'];
                $insert['gc_id_3'] = $update_common['gc_id_3'];
                $insert['brand_id'] = $update_common['brand_id'];
                $insert['goods_price'] = $update_common['goods_price'];
                $insert['goods_promotion_price'] = $update_common['goods_price'];
                $insert['goods_marketprice'] = $update_common['goods_marketprice'];
                $insert['goods_serial'] = $update_common['goods_serial'];
                $insert['goods_storage_alarm'] = $update_common['goods_storage_alarm'];
                $insert['goods_spec'] = serialize(null);
                $insert['goods_storage'] = intval(input('post.g_storage'));
                $insert['goods_image'] = $update_common['goods_image'];
                $insert['goods_state'] = $update_common['goods_state'];
                $insert['goods_verify'] = $update_common['goods_verify'];
                $insert['goods_addtime'] = TIMESTAMP;
                $insert['goods_edittime'] = TIMESTAMP;
                $insert['areaid_1'] = $update_common['areaid_1'];
                $insert['areaid_2'] = $update_common['areaid_2'];
                $insert['color_id'] = 0;
                $insert['transport_id'] = $update_common['transport_id'];
                $insert['goods_freight'] = $update_common['goods_freight'];
                $insert['goods_vat'] = $update_common['goods_vat'];
                $insert['goods_commend'] = $update_common['goods_commend'];
                $insert['goods_stcids'] = $update_common['goods_stcids'];
                $insert['is_virtual'] = $update_common['is_virtual'];
                $insert['virtual_indate'] = $update_common['virtual_indate'];
                $insert['virtual_limit'] = $update_common['virtual_limit'];
                $insert['virtual_invalid_refund'] = $update_common['virtual_invalid_refund'];
                $insert['is_goodsfcode'] = $update_common['is_goodsfcode'];
                $insert['is_appoint'] = $update_common['is_appoint'];
                $insert['is_presell'] = $update_common['is_presell'];
                $insert['is_platform_store'] = $update_common['is_platform_store'];
                $goods_id = $goods_model->addGoods($insert);
            }
            $goodsid_array[] = intval($goods_id);
            $colorid_array[] = 0;
            $type_model->addGoodsType($goods_id, $common_id, array('cate_id' => input('post.cate_id'), 'type_id' => input('post.type_id'), 'attr' => input('post.attr/a')));
        }
        

        // 清理商品数据
        $goods_model->delGoods(array('goods_id' => array('not in', $goodsid_array), 'goods_commonid' => $common_id, 'store_id' => session('store_id')));
        
        // 清理商品图片表
        $colorid_array = array_unique($colorid_array);
        $goods_model->delGoodsImages(array('goods_commonid' => $common_id, 'color_id' => array('not in', $colorid_array)));
        // 更新商品默认主图
        $default_image_list = $goods_model->getGoodsImageList(array('goods_commonid' => $common_id, 'goodsimage_isdefault' => 1), 'color_id,goodsimage_url');
        if (!empty($default_image_list)) {
            foreach ($default_image_list as $val) {
                $goods_model->editGoods(array('goods_image' => $val['goodsimage_url']), array('goods_commonid' => $common_id, 'color_id' => $val['color_id']));
            }
        }

        // 商品加入上架队列
        if (!empty(input('post.starttime'))) {
            $selltime = strtotime(input('post.starttime')) + intval(input('post.starttime_H')) * 3600 + intval(input('post.starttime_i')) * 60;
            if ($selltime > TIMESTAMP) {
                $this->addcron(array('exetime' => $selltime, 'exeid' => $common_id, 'type' => 1), true);
            }
        }
        // 添加操作日志
        $this->recordSellerlog('编辑商品，平台货号：' . $common_id);
        
        if ($update_common['is_virtual'] == 1 || $update_common['is_goodsfcode'] == 1 || $update_common['is_presell'] == 1) {
            // 如果是特殊商品清理促销活动，抢购、限时折扣、组合销售
            \mall\queue\QueueClient::push('clearSpecialGoodsPromotion', array('goods_commonid' => $common_id, 'goodsid_array' => $goodsid_array));
        } else {
            // 更新商品促销价格
            \mall\queue\QueueClient::push('updateGoodsPromotionPriceByGoodsCommonId', $common_id);
        }
        
        // 生成F码
        if ($update_common['is_goodsfcode'] == 1) {
            \mall\queue\QueueClient::push('createGoodsfcode', array('goods_commonid' => $common_id, 'goodsfcode_count' => intval(input('post.g_fccount')), 'goodsfcode_prefix' => input('post.g_fcprefix')));
        }
        
        $return = $goods_model->editGoodsCommon($update_common, array('goods_commonid' => $common_id, 'store_id' => session('store_id')));
        //if ($return>=0) {
            //提交事务
            model('goods')->commit();
            ds_json_encode(10000,lang('ds_common_op_succ'));
        /*} else {
            //回滚事务
            model('goods')->rollback();
            ds_json_encode(10001,lang('store_goods_index_goods_edit_fail'));
        }*/
    }

    /**
     * 编辑图片
     */
    public function edit_image() {
        $common_id = intval(input('param.commonid'));
        if ($common_id <= 0) {
            $this->error(lang('wrong_argument'), url('Seller/index'));
        }
        $goods_model = model('goods');
        $common_list = $goods_model->getGoodeCommonInfoByID($common_id);
        if ($common_list['store_id'] != session('store_id') || $common_list['goods_lock'] == 1) {
            $this->error(lang('wrong_argument'),  url('Seller/index'));
        }
        
        $spec_value = unserialize($common_list['spec_value']);
        $this->assign('value', $spec_value);

        $image_list = $goods_model->getGoodsImageList(array('goods_commonid' => $common_id));
        $image_list = array_under_reset($image_list, 'color_id', 2);

        $img_array = $goods_model->getGoodsList(array('goods_commonid' => $common_id), '*', 'color_id');
        // 整理，更具id查询颜色名称
        if (!empty($img_array)) {
            foreach ($img_array as $val) {
                if (isset($image_list[$val['color_id']])) {
                    $image_array[$val['color_id']] = $image_list[$val['color_id']];
                } else {
                    $image_array[$val['color_id']][0]['goodsimage_url'] = isset($val['goodsimage_url'])?$val['goodsimage_url']:'';
                    $image_array[$val['color_id']][0]['goodsimage_sort'] = 0;
                    $image_array[$val['color_id']][0]['goodsimage_isdefault'] = 1;
                }
                $colorid_array[] = $val['color_id'];
            }
        }
        $this->assign('img', $image_array);


        $spec_model = model('spec');
        $value_array = $spec_model->getSpecvalueList(array('spvalue_id' => array('in', $colorid_array), 'store_id' => session('store_id')), 'spvalue_id,spvalue_name');
        if (empty($value_array)) {
            $value_array[] = array('spvalue_id' => '0', 'spvalue_name' => '无颜色');
        }
        $this->assign('value_array', $value_array);

        $this->assign('commonid', $common_id);

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsonline');
        $this->setSellerCurItem('edit_image');
        $this->assign('edit_goods_sign', true);
        return $this->fetch($this->template_dir.'store_goods_add_step3');
    }

    /**
     * 保存商品图片
     */
    public function edit_save_image() {
        if (request()->isPost()) {
            $common_id = intval(input('param.commonid'));
            $img_array = input('post.img/a');#获取数组
            if ($common_id <= 0 || empty($img_array)) {
                ds_json_encode(10001,lang('wrong_argument'));
            }
            $goods_model = model('goods');
            // 删除原有图片信息
            $goods_model->delGoodsImages(array('goods_commonid' => $common_id, 'store_id' => session('store_id')));
            // 保存
            $insert_array = array();
            foreach ($img_array as $key => $value) {
                $k = 0;
                foreach ($value as $v) {
                    if ($v['name'] == '') {
                        continue;
                    }
                    // 商品默认主图
                    $update_array = array();        // 更新商品主图
                    $update_where = array();
                    $update_array['goods_image'] = $v['name'];
                    $update_where['goods_commonid'] = $common_id;
                    $update_where['store_id'] = session('store_id');
                    $update_where['color_id'] = $key;
                    if ($k == 0 || $v['default'] == 1) {
                        $k++;
                        $update_array['goods_image'] = $v['name'];
                        $update_where['goods_commonid'] = $common_id;
                        $update_where['store_id'] = session('store_id');
                        $update_where['color_id'] = $key;
                        // 更新商品主图
                        $goods_model->editGoods($update_array, $update_where);
                    }
                    $tmp_insert = array();
                    $tmp_insert['goods_commonid'] = $common_id;
                    $tmp_insert['store_id'] = session('store_id');
                    $tmp_insert['color_id'] = $key;
                    $tmp_insert['goodsimage_url'] = $v['name'];
                    $tmp_insert['goodsimage_sort'] = ($v['default'] == 1) ? 0 : intval($v['sort']);
                    $tmp_insert['goodsimage_isdefault'] = $v['default'];
                    $insert_array[] = $tmp_insert;
                }
            }
            $rs = $goods_model->addGoodsImagesAll($insert_array);
            if ($rs) {
                // 添加操作日志
                $this->recordSellerlog('编辑商品，平台货号：' . $common_id);
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } else {
                ds_json_encode(10001,lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 编辑分类
     */
    public function edit_class() {
        // 实例化商品分类模型
        $goodsclass_model = model('goodsclass');
        // 商品分类
        $goods_class = $goodsclass_model->getGoodsclass(session('store_id'));

        // 常用商品分类
        $staple_model = model('goodsclassstaple');
        $param_array = array();
        $param_array['member_id'] = session('member_id');
        $staple_array = $staple_model->getGoodsclassstapleList($param_array);

        $this->assign('staple_array', $staple_array);
        $this->assign('goods_class', $goods_class);

        $this->assign('commonid', input('param.commonid'));
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsonline');
        $this->setSellerCurItem('edit_class');
        $this->assign('edit_goods_sign', true);
        return $this->fetch($this->template_dir.'store_goods_add_step1');
    }

    /**
     * 删除商品
     */
    public function drop_goods() {
        $commonid = input('param.commonid');
        $common_id = $this->checkRequestCommonId($commonid);
        $commonid_array = explode(',', $common_id);

        $goods_model = model('goods');
        $where = array();
        $where['goods_commonid'] = array('in', $commonid_array);
        $where['store_id'] = session('store_id');
        $return = $goods_model->delGoodsNoLock($where);

        if ($return) {
            // 添加操作日志
            $this->recordSellerlog('删除商品，平台货号：' . $common_id);
            ds_json_encode(10000,lang('store_goods_index_goods_del_success'));
        } else {
            ds_json_encode(10001,lang('store_goods_index_goods_del_fail'));
        }
    }

    /**
     * 商品下架
     */
    public function goods_unshow() {
        $common_id = $this->checkRequestCommonId(input('param.commonid'));
        $commonid_array = explode(',', $common_id);
        $goods_model = model('goods');
        $where = array();
        $where['goods_commonid'] = array('in', $commonid_array);
        $where['store_id'] = session('store_id');
        $return = model('goods')->editProducesOffline($where);
        if ($return) {
            // 更新优惠套餐状态关闭
            $goods_list = $goods_model->getGoodsList($where, 'goods_id');
            if (!empty($goods_list)) {
                $goodsid_array = array();
                foreach ($goods_list as $val) {
                    $goodsid_array[] = $val['goods_id'];
                }
                model('pbundling')->editBundlingCloseByGoodsIds(array('goods_id' => array('in', $goodsid_array)));
            }
            // 添加操作日志
            $this->recordSellerlog('商品下架，平台货号：' . $common_id);
            ds_json_encode(10000,lang('store_goods_index_goods_unshow_success'));
        } else {
            ds_json_encode(10001,lang('store_goods_index_goods_unshow_fail'));
        }
    }

    /**
     * 设置广告词
     */
    public function edit_jingle() {
        if (request()->isPost()) {
            $common_id = $this->checkRequestCommonId(input('param.commonid'));
            $commonid_array = explode(',', $common_id);
            $where = array('goods_commonid' => array('in', $commonid_array), 'store_id' => session('store_id'));
            $update = array('goods_advword' => trim(input('post.g_jingle')));
            $return = model('goods')->editProducesNoLock($where, $update);
            if ($return) {
                // 添加操作日志
                $this->recordSellerlog('设置广告词，平台货号：' . $common_id);
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } else {
                ds_json_encode(10001,lang('ds_common_op_fail'));
            }
        }
        $common_id = $this->checkRequestCommonId(input('param.commonid'));

        return $this->fetch($this->template_dir.'edit_jingle');
    }

    /**
     * 设置关联版式
     */
    public function edit_plate() {
        if (request()->isPost()) {
            $common_id = $this->checkRequestCommonId(input('post.commonid'));
            $commonid_array = explode(',', $common_id);
            $where = array('goods_commonid' => array('in', $commonid_array), 'store_id' => session('store_id'));
            $update = array();
            $update['plateid_top'] = intval(input('post.plate_top')) > 0 ? intval(input('post.plate_top')) : '';
            $update['plateid_bottom'] = intval(input('post.plate_bottom')) > 0 ? intval(input('post.plate_bottom')) : '';
            $return = model('goods')->editGoodsCommon($update, $where);
            if ($return) {
                // 添加操作日志
                $this->recordSellerlog('设置关联版式，平台货号：' . $common_id);
                ds_json_encode(10000,lang('ds_common_op_succ'));
            } else {
                ds_json_encode(10001,lang('ds_common_op_fail'));
            }
        } else {
            $common_id = $this->checkRequestCommonId(input('param.commonid'));
            $plateid_bottom = db('goodscommon')->where(array('goods_commonid' => $common_id))->field('plateid_bottom,plateid_top')->find();
            $this->assign('plateid', $plateid_bottom);
            // 关联版式
            $plate_list = model('storeplate')->getStoreplateList(array('store_id' => session('store_id')), 'storeplate_id,storeplate_name,storeplate_position');

            $plate_list = array_under_reset($plate_list, 'storeplate_position', 2);
            $this->assign('plate_list', $plate_list);

            return $this->fetch($this->template_dir . 'edit_plate');
        }
    }

    /**
     * 添加赠品
     */
    public function add_gift() {
        $common_id = intval(input('param.commonid'));
        if ($common_id <= 0) {
            $this->error(lang('wrong_argument'), url('Seller/index'));
        }
        $goods_model = model('goods');
        $goodscommon_info = $goods_model->getGoodeCommonInfoByID($common_id);
        if (empty($goodscommon_info) || $goodscommon_info['store_id'] != session('store_id')) {
            $this->error(lang('wrong_argument'),  url('Seller/index'));
        }

        // 商品列表
        $goods_array = $goods_model->getGoodsListForPromotion(array('goods_commonid' => $common_id), '*', 0, 'gift');
        $this->assign('goods_array', $goods_array);

        // 赠品列表
        $gift_list = model('goodsgift')->getGoodsgiftList(array('goods_commonid' => $common_id));
        $gift_array = array();
        if (!empty($gift_list)) {
            foreach ($gift_list as $val) {
                $gift_array[$val['goods_id']][] = $val;
            }
        }
        $this->assign('gift_array', $gift_array);

        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsonline');
        $this->setSellerCurItem('add_gift');
        return $this->fetch($this->template_dir .'store_goods_edit_add_gift');
    }

    /**
     * 保存赠品
     */
    public function save_gift() {
        if (!request()->isPost()) {
            ds_json_encode(10001,lang('wrong_argument'));
        }
        $gift_array = input('post.gift/a');
        $commonid = intval(input('param.commonid'));
        if ($commonid <= 0) {
            ds_json_encode(10001,lang('wrong_argument'));
        }

        $goods_model = model('goods');
        $goodsgift_model = model('goodsgift');

        // 验证商品是否存在
        $goods_list = $goods_model->getGoodsListForPromotion(array('goods_commonid' => $commonid, 'store_id' => session('store_id')), 'goods_id', 0, 'gift');
        if (empty($goods_list)) {
            ds_json_encode(10001,lang('wrong_argument'));
        }
        // 删除该商品原有赠品
        $goodsgift_model->delGoodsgift(array('goods_commonid' => $commonid));
        // 重置商品礼品标记
        $goods_model->editGoods(array('is_have_gift' => 0), array('goods_commonid' => $commonid));
        // 商品id
        $goodsid_array = array();
        foreach ($goods_list as $val) {
            $goodsid_array[] = $val['goods_id'];
        }

        $insert = array();
        $update_goodsid = array();
        foreach ($gift_array as $key => $val) {

            $owner_gid = intval($key);  // 主商品id
            // 验证主商品是否为本店铺商品,如果不是本店商品继续下一个循环
            if (!in_array($owner_gid, $goodsid_array)) {
                continue;
            }
            $update_goodsid[] = $owner_gid;
            foreach ($val as $k => $v) {
                $gift_gid = intval($k); // 礼品id
                // 验证赠品是否为本店铺商品，如果不是本店商品继续下一个循环
                $gift_info = $goods_model->getGoodsInfoByID($gift_gid);
                $is_general = $goods_model->checkIsGeneral($gift_info);     // 验证是否为普通商品
                if ($gift_info['store_id'] != session('store_id') || $is_general == false) {
                    continue;
                }

                $array = array();
                $array['goods_id'] = $owner_gid;
                $array['goods_commonid'] = $commonid;
                $array['gift_goodsid'] = $gift_gid;
                $array['gift_goodsname'] = $gift_info['goods_name'];
                $array['gift_goodsimage'] = $gift_info['goods_image'];
                $array['gift_amount'] = intval($v);
                $insert[] = $array;
            }
        }
        // 插入数据
        if (!empty($insert))
            $goodsgift_model->addGoodsgiftAll($insert);
        // 更新商品赠品标记
        if (!empty($update_goodsid)){
            $goods_model->editGoodsById(array('is_have_gift' => 1), $update_goodsid);
        }
        ds_json_encode(10000,lang('ds_common_save_succ'));
    }

    /**
     * 推荐搭配
     */
    public function add_combo() {
        $common_id = intval(input('param.commonid'));
        if ($common_id <= 0) {
            $this->error(lang('wrong_argument'), url('Seller/index'));
        }
        $goods_model = model('goods');
        $goodscommon_info = $goods_model->getGoodeCommonInfoByID($common_id);
        if (empty($goodscommon_info) || $goodscommon_info['store_id'] != session('store_id')) {
            $this->error(lang('wrong_argument'), url('Seller/index'));
        }

        $goods_array = $goods_model->getGoodsListForPromotion(array('goods_commonid' => $common_id), '*', 0, 'combo');
        $this->assign('goods_array', $goods_array);

        // 推荐组合商品列表
        $combo_list = model('goodscombo')->getGoodscomboList(array('goods_commonid' => $common_id));
        $combo_goodsid_array = array();
        if (!empty($combo_list)) {
            foreach ($combo_list as $val) {
                $combo_goodsid_array[] = $val['combo_goodsid'];
            }
        }

        $combo_goods_array = $goods_model->getGeneralGoodsList(array('goods_id' => array('in', $combo_goodsid_array)), 'goods_id,goods_name,goods_image,goods_price');
        $combo_goods_list = array();
        if (!empty($combo_goods_array)) {
            foreach ($combo_goods_array as $val) {
                $combo_goods_list[$val['goods_id']] = $val;
            }
        }

        $combo_array = array();
        foreach ($combo_list as $val) {
            $combo_array[$val['goods_id']][] = $combo_goods_list[$val['combo_goodsid']];
        }
        $this->assign('combo_array', $combo_array);


        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellergoodsonline');
        $this->setSellerCurItem('add_combo');
        return $this->fetch($this->template_dir .'store_goods_edit_add_combo');
    }

    /**
     * 保存赠品
     */
    public function save_combo() {
        if (!request()->isPost()) {
            ds_json_encode(10001,lang('wrong_argument'));
        }
        
        $combo_array = input('post.combo/a');#获取数组
        if(!isset($combo_array)){
            ds_json_encode(10001,lang('wrong_argument'));
        }
        
        $commonid = intval(input('param.commonid'));
        if ($commonid <= 0) {
            ds_json_encode(10001,lang('wrong_argument'));
        }

        $goods_model = model('goods');
        $goodscombo_model = model('goodscombo');

        // 验证商品是否存在
        $goods_list = $goods_model->getGoodsListForPromotion(array('goods_commonid' => $commonid, 'store_id' => session('store_id')), 'goods_id', 0, 'combo');
        if (empty($goods_list)) {
            ds_json_encode(10001,lang('wrong_argument'));
        }
        // 删除该商品原有赠品
        $goodscombo_model->delGoodscombo(array('goods_commonid' => $commonid));
        // 商品id
        $goodsid_array = array();
        foreach ($goods_list as $val) {
            $goodsid_array[] = $val['goods_id'];
        }

        $insert = array();
        if (!empty($combo_array)) {
            foreach ($combo_array as $key => $val) {

                $owner_gid = intval($key);  // 主商品id
                // 验证主商品是否为本店铺商品,如果不是本店商品继续下一个循环
                if (!in_array($owner_gid, $goodsid_array)) {
                    continue;
                }
                $val = array_unique($val);
                foreach ($val as $v) {
                    $combo_gid = intval($v); // 礼品id
                    // 验证推荐组合商品是否为本店铺商品，如果不是本店商品继续下一个循环
                    $combo_info = $goods_model->getGoodsInfoByID($combo_gid);
                    $is_general = $goods_model->checkIsGeneral($combo_info);     // 验证是否为普通商品
                    if ($combo_info['store_id'] != session('store_id') || $is_general == false || $owner_gid == $combo_gid) {
                        continue;
                    }

                    $array = array();
                    $array['goods_id'] = $owner_gid;
                    $array['goods_commonid'] = $commonid;
                    $array['combo_goodsid'] = $combo_gid;
                    $insert[] = $array;
                }
            }
            // 插入数据
            $goodscombo_model->addGoodscomboAll($insert);
        }
        ds_json_encode(10000,lang('ds_common_save_succ'));
    }

    /**
     * 搜索商品（添加赠品/推荐搭配)
     */
    public function search_goods() {
        $where = array();
        $where['store_id'] = session('store_id');
        $name = input('param.name');
        if ($name) {
            $where['goods_name'] = array('like', '%' . $name . '%');
        }
        $goods_model = model('goods');
        $goods_list = $goods_model->getGeneralGoodsList($where, '*', 5);
        $this->assign('show_page', $goods_model->page_info->render());
        $this->assign('goods_list', $goods_list);
        echo $this->fetch($this->template_dir .'store_goods_edit_search_goods');exit;
    }

    /**
     * 下载F码
     */
    public function download_f_code_excel() {
        $common_id = input('param.commonid');
        if ($common_id <= 0) {
            $this->error(lang('wrong_argument'));
        }
        $common_info = model('goods')->getGoodeCommonInfoByID($common_id);
        if (empty($common_info) || $common_info['store_id'] != session('store_id')) {
            $this->error(lang('wrong_argument'));
        }
        //import('excels.excel',EXTEND_PATH);
        $excel_obj = new \excel\Excel();
        $excel_data = array();
        //设置样式
        $excel_obj->setStyle(array('id' => 's_title', 'Font' => array('FontName' => '宋体', 'Size' => '12', 'Bold' => '1')));
        //header
        $excel_data[0][] = array('styleid' => 's_title', 'data' => '号码');
        $excel_data[0][] = array('styleid' => 's_title', 'data' => '使用状态');
        $data = model('goodsfcode')->getGoodsfcodeList(array('goods_commonid' => $common_id));
        foreach ($data as $k => $v) {
            $tmp = array();
            $tmp[] = array('data' => $v['goodsfcode_code']);
            $tmp[] = array('data' => $v['goodsfcode_state'] ? '已使用' : '未使用');
            $excel_data[] = $tmp;
        }
        $excel_data = $excel_obj->charset($excel_data, CHARSET);
        $excel_obj->addArray($excel_data);
        $excel_obj->addWorksheet($excel_obj->charset($common_info['goods_name'], CHARSET));
        $excel_obj->generateXML($excel_obj->charset($common_info['goods_name'], CHARSET) . '-' . date('Y-m-d-H', time()));
    }

    /**
     * 验证commonid
     */
    private function checkRequestCommonId($common_ids) {
        if (!preg_match('/^[\d,]+$/i', $common_ids)) {
            ds_json_encode(10001,lang('param_error'));
        }
        return $common_ids;
    }

    /**
     * ajax获取商品列表
     */
    public function get_goods_list_ajax() {
        $common_id = input('param.commonid');
        if ($common_id <= 0) {
            echo 'false';
            exit();
        }
        $goods_model = model('goods');
        $goodscommon_list = $goods_model->getGoodeCommonInfoByID($common_id);
        if (empty($goodscommon_list) || $goodscommon_list['store_id'] != session('store_id')) {
            echo 'false';
            exit();
        }
        $goods_list = $goods_model->getGoodsList(array('store_id' => session('store_id'), 'goods_commonid' => $common_id), 'goods_id,goods_spec,store_id,goods_price,goods_serial,goods_storage_alarm,goods_storage,goods_image');
        if (empty($goods_list)) {
            echo 'false';
            exit();
        }

        $spec_name = array_values((array) unserialize($goodscommon_list['spec_name']));
        foreach ($goods_list as $key => $val) {
            $goods_spec = array_values((array) unserialize($val['goods_spec']));
            $spec_array = array();
            foreach ($goods_spec as $k => $v) {
                $spec_array[] = '<div class="goods_spec">' . $spec_name[$k] . lang('ds_colon') . '<em title="' . $v . '">' . $v . '</em>' . '</div>';
            }
            $goods_list[$key]['goods_image'] = goods_thumb($val, '240');
            $goods_list[$key]['goods_spec'] = implode('', $spec_array);
            $goods_list[$key]['alarm'] = ($val['goods_storage_alarm'] != 0 && $val['goods_storage'] <= $val['goods_storage_alarm']) ? 'style="color:red;"' : '';
            $goods_list[$key]['url'] = url('Goods/index',['goods_id'=>$val['goods_id']]);
        }

        echo json_encode($goods_list);
    }

    /**
     *    栏目菜单
     */
    function getSellerItemList() {
        $item_list = array(
            array(
                'name' => 'goods_list',
                'text' => '出售中的商品',
                'url' => url('Sellergoodsonline/index'),
            ),
        );
        if (request()->action() === 'edit_goods' || request()->action() === 'edit_image' || request()->action() === 'add_gift' || request()->action() === 'add_combo' || request()->action() === 'edit_class') {
            $item_list[] = array(
                'name' => 'edit_goods',
                'text' => '编辑商品',
                'url' => url('Sellergoodsonline/edit_goods', ['commonid' => input('param.commonid')]),
            );
            $item_list[] = array(
                'name' => 'edit_image',
                'text' => '编辑图片',
                'url' => url('Sellergoodsonline/edit_image', ['commonid' => input('param.commonid')]),
            );
            $item_list[] = array(
                'name' => 'add_gift',
                'text' => '赠送赠品',
                'url' => url('Sellergoodsonline/add_gift', ['commonid' => input('param.commonid')]),
            );
            $item_list[] = array(
                'name' => 'add_combo',
                'text' => '推荐组合',
                'url' => url('Sellergoodsonline/add_combo', ['commonid' => input('param.commonid')]),
            );
            $item_list[] = array(
                'name' => 'edit_class',
                'text' => '选择分类',
                'url' => url('Sellergoodsonline/edit_class', ['commonid' => input('param.commonid')]),
            );
        }
        return $item_list;
    }

}

?>
