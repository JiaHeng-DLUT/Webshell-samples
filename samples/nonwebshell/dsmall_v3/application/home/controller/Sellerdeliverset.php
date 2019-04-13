<?php

/*
 * 发货设置
 */

namespace app\home\controller;

use think\Lang;

class Sellerdeliverset extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellerdeliver.lang.php');
    }

    /**
     * 发货地址列表
     */
    public function index() {
        $daddress_model = model('daddress');
        $condition = array();
        $condition['store_id'] = session('store_id');
        $address_list = $daddress_model->getAddressList($condition, '*', '', 20);
        $this->assign('address_list', $address_list);
        /* 设置卖家当前菜单 */
        $this->setSellerCurMenu('sellerdeliverset');
        /* 设置卖家当前栏目 */
        $this->setSellerCurItem('daddress');
        return $this->fetch($this->template_dir . 'index');
    }

    /**
     * 新增/编辑发货地址
     */
    public function daddress_add() {
        $address_id = intval(input('param.address_id'));
        if ($address_id > 0) {
            $daddress_mod = model('daddress');
            //编辑
            if (!request()->isPost()) {
                $address_info = $daddress_mod->getAddressInfo(array('daddress_id' => $address_id, 'store_id' => session('store_id')));
                $this->assign('address_info', $address_info);
                return $this->fetch($this->template_dir . 'daddress_add');
            } else {
                $data = array(
                    'seller_name' => input('post.seller_name'),
                    'area_id' => input('post.area_id'),
                    'city_id' => input('post.city_id'),
                    'area_info' => input('post.region'),
                    'daddress_detail' => input('post.address'),
                    'daddress_telphone' => input('post.telphone'),
                    'daddress_company' => input('post.company'),
                );
                //验证数据  BEGIN
                $sellerdeliverset_validate = validate('sellerdeliverset');
                if (!$sellerdeliverset_validate->scene('daddress_add')->check($data)) {
                    ds_json_encode(10001, $sellerdeliverset_validate->getError());
                }
                //验证数据  END
                $result = $daddress_mod->editDaddress($data, array('daddress_id' => $address_id, 'store_id' => session('store_id')));
                if ($result) {
                    ds_json_encode(10000,lang('ds_common_op_succ'));
                } else {
                    ds_json_encode(10001,lang('store_daddress_modify_fail'));
                }
            }
        } else {
            //新增
            if (!request()->isPost()) {
                $address_info = array(
                    'daddress_id' => '', 'city_id' => '1', 'area_id' => '1', 'seller_name' => '',
                    'area_info' => '', 'daddress_detail' => '', 'daddress_telphone' => '', 'daddress_company' => '',
                );
                $this->assign('address_info', $address_info);
                return $this->fetch($this->template_dir . 'daddress_add');
            } else {
                $data = array(
                    'store_id' => session('store_id'),
                    'seller_name' => input('post.seller_name'),
                    'area_id' => input('post.area_id'),
                    'city_id' => input('post.city_id'),
                    'area_info' => input('post.region'),
                    'daddress_detail' => input('post.address'),
                    'daddress_telphone' => input('post.telphone'),
                    'daddress_company' => input('post.company'),
                );
                //验证数据  BEGIN
                $sellerdeliverset_validate = validate('sellerdeliverset');
                if (!$sellerdeliverset_validate->scene('daddress_add')->check($data)) {
                    ds_json_encode(10001, $sellerdeliverset_validate->getError());
                }
                //验证数据  END
                $result = db('daddress')->insertGetId($data);
                if ($result) {
                    ds_json_encode(10000,lang('ds_common_op_succ'));
                } else {
                    ds_json_encode(10001,lang('store_daddress_add_fail'));
                }
            }
        }
    }

    /**
     * 删除发货地址
     */
    public function daddress_del() {
        $address_id = intval(input('param.address_id'));
        if ($address_id <= 0) {
            ds_json_encode(10001,lang('store_daddress_del_fail'));
        }
        $condition = array();
        $condition['daddress_id'] = $address_id;
        $condition['store_id'] = session('store_id');
        $delete = model('daddress')->delDaddress($condition);
        if ($delete) {
            ds_json_encode(10000,lang('store_daddress_del_succ'));
        } else {
            ds_json_encode(10001,lang('store_daddress_del_fail'));
        }
    }

    /**
     * 设置默认发货地址
     */
    public function daddress_default_set() {
        $address_id = intval(input('get.address_id'));
        if ($address_id <= 0)
            return false;
        $condition = array();
        $condition['store_id'] = session('store_id');
        $update = model('daddress')->editDaddress(array('daddress_isdefault' => 0), $condition);
        $condition['daddress_id'] = $address_id;
        $update = model('daddress')->editDaddress(array('daddress_isdefault' => 1), $condition);
    }

    public function express() {
        $storeextend_model = model('storeextend');
        if (!request()->isPost()) {
            $express_list = rkcache('express', true);

            //取得店铺启用的快递公司ID
            $express_select = ds_getvalue_byname('storeextend', 'store_id', session('store_id'), 'express');

            if (!is_null($express_select)) {
                $express_select = explode(',', $express_select);
            } else {
                $express_select = array();
            }
            $this->assign('express_select', $express_select);
            //页面输出
            $this->assign('express_list', $express_list);

            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('sellerdeliverset');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('express');
            return $this->fetch($this->template_dir . 'express');
        } else {
            $data['store_id'] = session('store_id');
            $cexpress_array = input('post.cexpress/a');#获取数组
            if (!empty($cexpress_array)) {
                $data['express'] = implode(',', $cexpress_array);
            } else {
                $data['express'] = '';
            }
            if (!$storeextend_model->getby_store_id(session('store_id'))) {
                $result = $storeextend_model->insert($data);
            } else {
                $result = $storeextend_model->where(array('store_id' => session('store_id')))->update($data);
            }
            if ($result) {
                ds_json_encode('10000', lang('ds_common_save_succ'));
            } else {
                ds_json_encode('10001', lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 免运费额度设置
     */
    public function free_freight() {
        if (!request()->isPost()) {
            $this->assign('store_free_price', $this->store_info['store_free_price']);
            $this->assign('store_free_time', $this->store_info['store_free_time']);

            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('sellerdeliverset');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('free_freight');
            return $this->fetch($this->template_dir . 'free_freight');
        } else {
            $store_model = model('store');
            $store_free_price = floatval(abs(input('post.store_free_price')));
            $store_free_time = input('post.store_free_time');
            $store_model->editStore(array(
                'store_free_price' => $store_free_price, 
                'store_free_time' => $store_free_time
                    ), array('store_id' => session('store_id')));
            ds_json_encode(10000,lang('ds_common_save_succ'));
        }
    }

    /**
     * 默认配送区域设置
     */
    public function deliver_region() {
        if (!request()->isPost()) {
            $deliver_region = array(
                '', ''
            );
            if (strpos($this->store_info['deliver_region'], '|')) {
                $deliver_region = explode('|', $this->store_info['deliver_region']);
            }
            $this->assign('deliver_region', $deliver_region);
            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('sellerdeliverset');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('deliver_region');
            return $this->fetch($this->template_dir . 'deliver_region');
        } else {
            model('store')->editStore(array('deliver_region' => input('post.area_ids') . '|' . input('post.region')), array('store_id' => session('store_id')));
            ds_json_encode(10000,lang('ds_common_save_succ'));
        }
    }

    /**
     * 发货单打印设置
     */
    public function print_set() {
        $store_info = $this->store_info;

        if (!request()->isPost()) {
            $this->assign('store_info', $store_info);
            /* 设置卖家当前菜单 */
            $this->setSellerCurMenu('sellerdeliverset');
            /* 设置卖家当前栏目 */
            $this->setSellerCurItem('print_set');
            return $this->fetch($this->template_dir . 'print_set');
        } else {
            $data = array(
                'store_printexplain' => input('store_printexplain')
            );

            $sellerdeliverset_validate = validate('sellerdeliverset');
            if (!$sellerdeliverset_validate->scene('print_set')->check($data)) {
                $this->error($sellerdeliverset_validate->getError());
            }
            $update_arr = array();
            //上传认证文件
            if ($_FILES['store_seal']['name'] != '') {
                $default_dir = BASE_UPLOAD_PATH . DS . ATTACH_STORE;
                $file_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999);
                $upload = request()->file('store_seal');
                $result = $upload->validate(['ext' => ALLOW_IMG_EXT])->move($default_dir, $file_name);
                if ($result) {
                    $update_arr['store_seal'] = $result->getFilename();
                    //删除旧认证图片
                    if (!empty($store_info['store_seal'])) {
                        @unlink(BASE_UPLOAD_PATH . DS . ATTACH_STORE . DS . $store_info['store_seal']);
                    }
                }
            }
            $update_arr['store_printexplain'] = input('post.store_printexplain');

            $rs = model('store')->editStore($update_arr,array('store_id' => session('store_id')));
            if ($rs) {
                $this->success(lang('ds_common_save_succ'));
            } else {
                $this->error(lang('ds_common_save_fail'));
            }
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string $menu_type 导航类型
     * @param string $menu_key 当前导航的menu_key
     * @return
     */
    function getSellerItemList() {
        $menu_array = array(
            array(
                'name' => 'daddress',
                'text' => '地址库',
                'url' => url('Sellerdeliverset/index')
            ),
            array(
                'name' => 'express',
                'text' => '默认物流公司',
                'url' => url('Sellerdeliverset/express')
            ),
            array(
                'name' => 'free_freight',
                'text' => '免运费额度',
                'url' => url('Sellerdeliverset/free_freight')
            ),
            array(
                'name' => 'deliver_region',
                'text' => '默认配送地区',
                'url' => url('Sellerdeliverset/deliver_region')
            ),
            array(
                'name' => 'print_set',
                'text' => '发货单打印设置',
                'url' => url('Sellerdeliverset/print_set')
            )
        );
        return $menu_array;
    }

}

?>
