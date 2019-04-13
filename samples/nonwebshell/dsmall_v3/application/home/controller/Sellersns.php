<?php

namespace app\home\controller;

use think\Lang;

class Sellersns extends BaseSeller {

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/sellersns.lang.php');
    }

    public function index() {
        $this->add();
    }

    /**
     * 发布动态
     */
    public function add() {
        $goods_model = model('goods');
        // 热销商品
        // where条件
        $where = array('store_id' => session('store_id'));
        $field = 'goods_id,goods_name,goods_image,goods_price,goods_salenum,store_id';
        $order = 'goods_salenum desc';
        $hotsell_list = $goods_model->getGoodsOnlineList($where, $field, 0, $order, 8);
        $this->assign('hotsell_list', $hotsell_list);

        // 新品
        // where条件
        $where = array('store_id' => session('store_id'));
        $field = 'goods_id,goods_name,goods_image,goods_price,goods_salenum,store_id';
        $order = 'goods_id desc';
        $new_list = $goods_model->getGoodsOnlineList($where, $field, 0, $order, 8);
        $this->assign('new_list', $new_list);
        $this->setSellerCurItem('store_sns_add');
        $this->setSellerCurMenu('sellersns');
        echo $this->fetch($this->template_dir . 'store_sns_add');
        exit;
    }

    /**
     * 上传图片
     */
    public function image_upload() {
        // 判断图片数量是否超限
        $album_model = model('album');
        $album_limit = $this->store_grade['storegrade_album_limit'];
        if ($album_limit > 0) {
            $album_count = $album_model->getCount(array('store_id' => session('store_id')));
            if ($album_count >= $album_limit) {
                $error = lang('store_goods_album_climit');
                exit(json_encode(array('error' => $error)));
            }
        }

        $class_info = $album_model->getOne(array('store_id' => session('store_id'), 'aclass_isdefault' => 1), 'albumclass');
        
        //上传文件保存路径
        $upload_path = ATTACH_GOODS . DS .session('store_id');
        $save_name = session('store_id') . '_' . date('YmdHis') . rand(10000, 99999);
        $file = input('param.id');
        $result=upload_albumpic($upload_path,$file,$save_name);
        if($result['code'] == '10000'){
            $img_path=$result['result'];
            // 取得图像大小
            list($width, $height, $type, $attr) = getimagesize($img_path);
            $img_path=substr(strrchr($img_path, "/"), 1);
        }else{
            exit($result['message']);
        }
        

        // 存入相册
        $insert_array = array();
        $insert_array['apic_name'] = $img_path;
        $insert_array['apic_tag'] = '';
        $insert_array['aclass_id'] = $class_info['aclass_id'];
        $insert_array['apic_cover'] = $img_path;
        $insert_array['apic_size'] = intval($_FILES[input('param.id')]['size']);
        $insert_array['apic_spec'] = $width . 'x' . $height;
        $insert_array['apic_uploadtime'] = TIMESTAMP;
        $insert_array['store_id'] = session('store_id');
        $album_model->addAlbumpic($insert_array);

        $data = array();
        $data ['image'] = goods_cthumb($img_path, 240, session('store_id'));

        // 整理为json格式
        $output = json_encode($data);
        echo $output;
        exit();
    }

    /**
     * 保存动态
     */
    public function store_sns_save() {
        /**
         * 验证表单
         */
        $data=[
            'content'=>input('param.content'),
            'goods_url'=>input('goods_url')
        ];
        $sellersns_validate = validate('sellersns');
        if (!$sellersns_validate->scene('store_sns_save')->check($data)) {
            ds_json_encode(10001,$sellersns_validate->getError());
        }

        $goodsdata = '';
        $content = '';
        $type = intval(input('param.type'));
        switch ($type) {
            case '2':
                $sns_image = trim(input('param.sns_image'));
                if ($sns_image != '')
                    $content = '<div class="fd-media">
									<div class="thumb-image"><a href="javascript:void(0);" ds_type="thumb-image"><img src="' . $sns_image . '" /><i></i></a></div>
									<div class="origin-image"><a href="javascript:void(0);" ds_type="origin-image"></a></div>
								</div>';
                break;
            case '9':
                $data = $this->getGoodsByUrl(html_entity_decode(input('param.goods_url')));
                $goodsdata = addslashes(json_encode($data));
                break;
            case '10':
                $goods_id_array = input('post.goods_id/a');#获取数组
                if (empty($goods_id_array)) {
                    ds_json_encode(10001,lang('store_sns_choose_goods'));
                }
                $field = 'goods_id,store_id,goods_name,goods_image,goods_price,goods_freight';
                $where = array('store_id' => session('store_id'), 'goods_id' => array('in', $goods_id_array));
                $goods_array = model('goods')->getGoodsList($where, $field);
                if (!empty($goods_array) && is_array($goods_array)) {
                    $goodsdata = array();
                    foreach ($goods_array as $val) {
                        $goodsdata[] = addslashes(json_encode($val));
                    }
                }
                break;
            case '3':
                $goods_id_array = input('post.goods_id/a');#获取数组
                if(empty($goods_id_array)){
                    ds_json_encode(10001,lang('store_sns_choose_goods'));
                }
                $field = 'goods_id,store_id,goods_name,goods_image,goods_price,goods_freight';
                $where = array('store_id' => session('store_id'), 'goods_id' => array('in', $goods_id_array));
                $goods_array = model('goods')->getGoodsList($where, $field);
                if (!empty($goods_array) && is_array($goods_array)) {
                    $goodsdata = array();
                    foreach ($goods_array as $val) {
                        $goodsdata[] = addslashes(json_encode($val));
                    }
                }
                break;
            default:
                ds_json_encode(10001,lang('param_error'));
        }

        $storesnstracelog_model = model('storesnstracelog');
        // 插入数据
        $stracelog_array = array();
        $stracelog_array['stracelog_storeid'] = $this->store_info['store_id'];
        $stracelog_array['stracelog_storename'] = $this->store_info['store_name'];
        $stracelog_array['stracelog_storelogo'] = empty($this->store_info['store_avatar']) ? '' : $this->store_info['store_avatar'];
        $stracelog_array['stracelog_title'] = input('param.content');
        $stracelog_array['stracelog_content'] = $content;
        $stracelog_array['stracelog_time'] = time();
        $stracelog_array['stracelog_type'] = $type;
        if (isset($goodsdata) && is_array($goodsdata)) {
            $stracelog = array();
            foreach ($goodsdata as $val) {
                $stracelog_array['stracelog_goodsdata'] = $val;
                $stracelog[] = $stracelog_array;
            }
            $rs = $storesnstracelog_model->addStoresnstracelogAll($stracelog);
        } else {
            $stracelog_array['stracelog_goodsdata'] = $goodsdata;
            $rs = $storesnstracelog_model->addStoresnstracelog($stracelog_array);
        }
        if ($rs) {
            ds_json_encode(10000,lang('ds_common_op_succ'));
        } else {
            ds_json_encode(10001,lang('ds_common_op_fail'));
        }
    }

    /**
     * 动态设置
     */
    public function setting() {
        // 实例化模型
        $storesnssetting_model = model('storesnssetting');
        $storesnsset_info = $storesnssetting_model->getStoresnssettingInfo(array('storesnsset_storeid' => session('store_id')));
        if (request()->isPost()) {
            $update = array();
            $update['storesnsset_storeid'] = session('store_id');
            $update['storesnsset_new'] = input('post.new',0);
            $update['storesnsset_newtitle'] = trim(input('post.new_title'));
            $update['storesnsset_coupon'] = input('post.coupon',0);
            $update['storesnsset_coupontitle'] = trim(input('post.coupon_title'));
            $update['storesnsset_xianshi'] = input('post.xianshi',0);
            $update['storesnsset_xianshititle'] = trim(input('post.xianshi_title'));
            $update['storesnsset_mansong'] = input('post.mansong',0);
            $update['storesnsset_mansongtitle'] = trim(input('post.mansong_title'));
            $update['storesnsset_bundling'] = input('post.bundling',0);
            $update['storesnsset_bundlingtitle'] = trim(input('post.bundling_title'));
            $update['storesnsset_groupbuy'] = input('post.groupbuy',0);
            $update['storesnsset_groupbuytitle'] = trim(input('post.groupbuy_title'));
            $info=!empty($storesnsset_info) ? true:false;
            $result = $storesnssetting_model->isUpdate($info)->save($update);
            if($result>=0){
                ds_json_encode(10000,lang('ds_common_save_succ'));
            }else {
                ds_json_encode(10001,lang('ds_common_save_fail'));
            }
        } else {
            $this->assign('storesnsset_info', $storesnsset_info);
            $this->setSellerCurItem('store_sns_setting');
            $this->setSellerCurMenu('sellersns');
            return $this->fetch($this->template_dir . 'store_sns_setting');
        }
    }

    /**
     * 用户中心右边，小导航
     *
     * @param string	$menu_type	导航类型
     * @param string 	$menu_key	当前导航的menu_key
     * @return
     */
    protected function getSellerItemList() {
        $menu_array = array(
            array('name' => 'store_sns_add', 'text' => lang('store_sns_add'), 'url' => url('Sellersns/add')),
            array('name' => 'store_sns_setting', 'text' => lang('store_sns_setting'), 'url' => url('Sellersns/setting')),
            array('name' => 'store_sns_brower', 'text' => lang('store_sns_browse'), 'url' => url('Storesnshome/index', ['sid' => session('store_id')])),
        );
        return $menu_array;
    }

    /**
     * 根据url取得商品信息
     */
    private function getGoodsByUrl($url) {
        $array = parse_url($url);
        if (isset($array['query'])) {
            // 未开启伪静态
            parse_str($array['query'], $arr);
            $id = $arr['goods_id'];
        } else {
            // 开启伪静态
            $item = explode('/', $array['path']);
            $item = end($item);
            $id = preg_replace('/item-(\d+)\.html/i', '$1', $item);
        }
        if (intval($id) > 0) {
            // 查询商品信息
            $result = model('goods')->getGoodsInfoByID($id);
            if (!empty($result) && is_array($result)) {
                return $result;
            } else {
                ds_json_encode(10001,lang('store_sns_goods_url_error'));
            }
        } else {
            ds_json_encode(10001,lang('store_sns_goods_url_error'));
        }
    }

}

?>
