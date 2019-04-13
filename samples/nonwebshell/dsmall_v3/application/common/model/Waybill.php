<?php
namespace app\common\model;
use think\Model;
use think\Validate;

class Waybill extends Model
{
    public $page_info;
    const WAYBILL_PIXEL_CONSTANT = 3.8;
    const WAYBILL_USABLE = 1;
  
    /**
     * 读取列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param int $page 分页
     * @param str $order 排序
     * @param str $field 字段
     * @return array
     */
    public function getWaybillList($condition, $page='', $order='waybill_usable desc', $field='*') {
        $waybill =  db('waybill')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$waybill;
        $waybill_list=$waybill->items();
        foreach ($waybill_list as $key => $value) {
            $waybill_list[$key]['waybill_image_url'] = get_waybill_imageurl($value['waybill_image']);
            $waybill_list[$key]['waybill_usable_text'] = $value['waybill_usable'] ? '是' : '否';
            $waybill_list[$key]['waybill_type_text'] = $value['store_id'] ? '用户模板' : '平台模板';
        }
        return $waybill_list;
    }

    /**
     * 读取可用列表
     * @access public
     * @author csdeshang
     * @param type $express_id 快递ID
     * @param type $store_id 店铺id
     * @return type
     */
    public function getWaybillUsableList($express_id, $store_id = 0) {
        $condition['express_id'] = $express_id;
        $condition['waybill_usable'] = self::WAYBILL_USABLE;
        if($store_id > 0) {
            $condition['store_id'] = array('in', "0,{$store_id}");
        } else {
            $condition['store_id'] = 0;
        }
        return $this->getWaybillList($condition, '', 'waybill_usable desc', '*');
    }

    /**
     * 读取平台模板列表
     * @access public
     * @author csdeshang
     * @param type $page 分页
     * @return type
     */
    public function getWaybillAdminList($page = '') {
        $condition = array();
        $condition['store_id'] = 0;
        return $this->getWaybillList($condition, $page);
    }

    /**
     * 读取商家模板列表
     * @access public
     * @author csdeshang
     * @param type $store_id 店铺id
     * @return type
     */
    public function getWaybillSellerList($store_id = 0) {
        if($store_id <= 0) {
            return null;
        }

        $condition = array();
        $condition['store_id'] = $store_id;
        return $this->getWaybillList($condition);
    }

    /**
     * 读取单条记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getWaybillInfo($condition) {
        $waybill_info =  db('waybill')->where($condition)->find();
        if($waybill_info) {
            $waybill_info['waybill_image_url'] = get_waybill_imageurl($waybill_info['waybill_image']);
            $waybill_info['waybill_pixel_width'] = $waybill_info['waybill_width'] * self::WAYBILL_PIXEL_CONSTANT;
            $waybill_info['waybill_pixel_height'] = $waybill_info['waybill_height'] * self::WAYBILL_PIXEL_CONSTANT;
            $waybill_info['waybill_pixel_top'] = $waybill_info['waybill_top'] * self::WAYBILL_PIXEL_CONSTANT;
            $waybill_info['waybill_pixel_left'] = $waybill_info['waybill_left'] * self::WAYBILL_PIXEL_CONSTANT;
            if(!empty($waybill_info['waybill_data'])) {
                $waybill_info['waybill_data'] = unserialize($waybill_info['waybill_data']);

                //整理打印模板
                $waybill_item = $this->getWaybillItemList();
                foreach ($waybill_info['waybill_data'] as $key => $value) {
                    $waybill_info['waybill_data'][$key]['content'] = $waybill_item[$key]['item_text'];
                }
            }
        }
        return $waybill_info;
    }

    /**
     * 根据编号读取单条记录
     * @access public
     * @author csdeshang
     * @param type $waybill_id 运单编号
     * @return boolean|array
     */
    public function getWaybillInfoByID($waybill_id) {
        $waybill_id = intval($waybill_id);
        if($waybill_id <= 0) {
            return false;
        }

        $waybill_info = $this->getWaybillInfo(array('waybill_id' => $waybill_id));
        return $waybill_info;
    }

    /**
     * 获取设计数据
     * @access public
     * @author csdeshang
     * @param type $waybill_id 运单编号
     * @param type $store_id 店铺编号，验证模板的所属店铺
     * @return type
     */
    public function getWaybillDesignInfo($waybill_id, $store_id = 0) {
        $waybill_id = intval($waybill_id);

        if($waybill_id <= 0) {
            return array('error' => '运单模板不存在');
        }

        $waybill_info = $this->getWaybillInfoByID($waybill_id);
        if(!$waybill_info) {
            return array('error' => '运单模板不存在');
        }
        if($store_id > 0 && $waybill_info['store_id'] != $store_id) {
            return array('error' => '运单模板不存在');
        }

        $waybill_info_data = $waybill_info['waybill_data'];
        unset($waybill_info['waybill_data']);

        //项目列表
        $waybill_item_list = $this->getWaybillItemList();

        if(!empty($waybill_info_data)) {
            foreach ($waybill_info_data as $key => $value) {
                $waybill_info_data[$key]['item_text'] = $waybill_item_list[$key]['item_text'];
            }
        }

        foreach ($waybill_item_list as $key => $value) {
            $waybill_item_list[$key]['check'] = isset($waybill_info_data[$key]['check']) ? 'checked' : '';
            $waybill_item_list[$key]['width'] = $waybill_info_data[$key]['width'] ? $waybill_info_data[$key]['width'] : '0';
            $waybill_item_list[$key]['height'] = $waybill_info_data[$key]['height'] ? $waybill_info_data[$key]['height'] : '0';
            $waybill_item_list[$key]['top'] = $waybill_info_data[$key]['top'] ? $waybill_info_data[$key]['top'] : '0';
            $waybill_item_list[$key]['left'] = $waybill_info_data[$key]['left'] ? $waybill_info_data[$key]['left'] : '0';
        }

        return array(
            'waybill_info' => $waybill_info,
            'waybill_info_data' => $waybill_info_data,
            'waybill_item_list' => $waybill_item_list,
        );

    }

    /**
     * 增加
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool
     */
    public function addWaybill($data){
        return  db('waybill')->insertGetId($data);
    }

    /*
     * 更新
     * @access public
     * @author csdeshang
     * @param array $update 更新数据
     * @param array $condition 条件
     * @return bool
     */
    public function editWaybill($update, $condition) {
        return  db('waybill')->where($condition)->update($update);
    }

    /**
     * 更新
     * @access public
     * @author csdeshang
     * @param array $waybill_data 运单数据
     * @param int $waybill_id 运单编号
     * @param int $store_id 店铺id
     * @return bool
     */
    public function editWaybillDataByID($waybill_data, $waybill_id, $store_id = 0) {
        $waybill_id = intval($waybill_id);
        if($waybill_id <= 0) {
            return false;
        }

        $update = array();
        $update['waybill_data'] = serialize($waybill_data);

        $condition = array();
        $condition['waybill_id'] = $waybill_id;
        if(!empty($store_id)) {
            $condition['store_id'] = $store_id;
        }

        return $this->editWaybill($update, $condition);
    }

    /**
     * 保存
     * @access public
     * @author csdeshang
     * @param type $post 参数数据
     * @param type $store_id 店铺id
     * @return type
     */
    public function saveWaybill($post, $store_id = 0) {
        $data = array();
        $data['waybill_name'] = $post['waybill_name'];
        $data['waybill_width'] = $post['waybill_width'];
        $data['waybill_height'] = $post['waybill_height'];
        $data['waybill_left'] = $post['waybill_left'];
        $data['waybill_top'] = $post['waybill_top'];
        $data['waybill_usable'] = $post['waybill_usable'];
        $data['store_id'] = $store_id;
        list($data['express_id'], $data['express_name']) = explode('|', input('post.waybill_express'));

        //图片上传

        if (!empty($_FILES['waybill_image']['name'])) {
            $waybill_image = $this->_waybill_image_upload();
            if (!isset($waybill_image['error'])) {
                $data['waybill_image'] = $waybill_image;
                if (!empty($data['old_waybill_image'])) {
                    $this->delWaybillImage(input('post.old_waybill_image'));
                }
            }
        }

        //验证数据
        $error = $this->validWaybill($data);
        if (!$error){
            return array('error' => $error);
        }

        if(empty($post['waybill_id'])) {
            //添加
            $result = $this->addWaybill($data);
            $waybill_id = $result;
        } else {
            //编辑
            $condition = array();
            $condition['waybill_id'] = intval($post['waybill_id']);
            if($store_id > 0) {
                $condition['store_id'] = $store_id;
            }
            $result = $this->editWaybill($data, $condition);
            $waybill_id = $post['waybill_id'];
        }

        if($result) {
            return $waybill_id;
        } else {
            return array('error' => '保存失败');
        }
    }

    /**
     * 图片上传
     * @access public
     * @author csdeshang 
     * @return type
     */
    private function _waybill_image_upload() {
        $upload=request()->file('waybill_image');
        $dir=BASE_UPLOAD_PATH.'/'.ATTACH_WAYBILL.'/';
        $result=$upload->rule('uniqid')->validate(['ext'=>ALLOW_IMG_EXT])->move($dir);
        if($result) {
            return $result->getFilename();
        } else {
            return array('error' => $upload->getError());
        }
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delWaybill($condition) {
        $waybill_id_string = '';

        //删除模板图片
        $wayblii_list = $this->getWaybillList($condition, null);
        foreach ($wayblii_list as $value) {
            $this->delWaybillImage($value['waybill_image']);
            $waybill_id_string .= $value['waybill_id'];
        }

        //删除已经建立的绑定
        $storewaybill_model = model('storewaybill');
        $storewaybill_model->delStorewaybill(array('waybill_id' => array('in', $waybill_id_string)));

        return  db('waybill')->where($condition)->delete();
    }

    public function delWaybillImage($image_name) {
        $image = BASE_UPLOAD_PATH . DS . ATTACH_WAYBILL . DS . $image_name;
        if(is_file($image)) {
            @unlink($image);
        }
    }

    /**
     * 获取运单项目列表
     * @access public
     * @author csdeshang
     * @return array
     */
    public function getWaybillItemList() {
        $item = array(
            'buyer_name' => array('item_text' => '收货人'),
            'buyer_area' => array('item_text' => '收货人地区'),
            'buyer_address' => array('item_text' => '收货人地址'),
            'buyer_mobile' => array('item_text' => '收货人手机'),
            'buyer_phone' => array('item_text' => '收货人电话'),
            'seller_name' => array('item_text' => '发货人'),
            'seller_area' => array('item_text' => '发货人地区'),
            'seller_address' => array('item_text' => '发货人地址'),
            'seller_phone' => array('item_text' => '发货人电话'),
            'seller_company' => array('item_text' => '发货人公司'),
        );
        return $item;
    }

    /**
     * 验证
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @return bool
     */
    public function validWaybill($data) {
        $rule= [
            'waybill_name'=>'require',
            'waybill_width'=>'require',
            'waybill_height'=>'require'
        ];
        $msg=[
            'waybill_name.require' =>'模板名称不能为空',
            'waybill_width.require'=>'宽度不能为空',
            'waybill_height.require'=>'高度不能为空',
        ];

        $data=[
            'waybill_name'=>$data['waybill_name'],
            'waybill_width'=>$data['waybill_width'],
            'waybill_height'=>$data['waybill_height']
        ];
        $obj_validate = new Validate($rule,$msg);
        return $obj_validate->check($data);
    }

    /**
     * 根据订单信息获取打印数据
     * @access public
     * @author csdeshang
     * @param type $order_info 订单信息
     * @return type
     */
    public function getPrintInfoByOrderInfo($order_info) {
        $daddress_model = model('daddress');

        //获取打印数据
        $print_info = array();
        $daddress_id = $order_info['extend_order_common']['daddress_id'];
        $daddress_info = array();
        if(!empty($daddress_id)) {
            $daddress_info = $daddress_model->getAddressInfo(array('daddress_id' => $daddress_id));
        }
        $reciver_info = $order_info['extend_order_common']['reciver_info'];
        $print_info['buyer_name'] = $order_info['extend_order_common']['reciver_name'];
        $print_info['buyer_area'] = $reciver_info['area'];
        $print_info['buyer_address'] = $reciver_info['street'];
        $print_info['buyer_mobile'] = $reciver_info['mob_phone'];
        $print_info['buyer_phone'] = $reciver_info['tel_phone'];
        $print_info['seller_name'] = $daddress_info['seller_name'];
        $print_info['seller_area'] = $daddress_info['area_info'];
        $print_info['seller_address'] = $daddress_info['daddress_detail'];
        $print_info['seller_phone'] = $daddress_info['daddress_telphone'];
        $print_info['seller_company'] = $daddress_info['daddress_company'];

        return $print_info;
    }
}