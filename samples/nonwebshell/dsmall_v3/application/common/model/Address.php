<?php

namespace app\common\model;

use think\Model;

class Address extends Model {

    /**
     * 取得买家默认收货地址
     * @author csdeshang
     * @param array $condition 获取条件
     * @param string $order  排序
     * @return array
     */
    public function getDefaultAddressInfo($condition = array(), $order = 'address_is_default desc,dlyp_id asc,address_id desc') {
        return $this->getAddressInfo($condition, $order);
    }

    /**
     * 取得单条地址信息
     * @author csdeshang 
     * @param array $condition 条件
     * @param type $order 排序  
     * @return string
     */
    public function getAddressInfo($condition, $order = '') {
        $addr_info = db('address')->where($condition)->order($order)->find();
        if (config('delivery_isuse') && $addr_info['dlyp_id']) {
            $deliverypoint_model = model('deliverypoint');
            $dlyp_info = $deliverypoint_model->getDeliverypointOpenInfo(array('dlyp_id' => $addr_info['dlyp_id']));
            if (!empty($dlyp_info)) {
                $addr_info['dlyp_mobile'] = $dlyp_info['dlyp_mobile'];
                $addr_info['dlyp_telephony'] = $dlyp_info['dlyp_telephony'];
                $addr_info['dlyp_addressname'] = $dlyp_info['dlyp_addressname'];
                $addr_info['dlyp_area_info'] = $dlyp_info['dlyp_area_info'];
                $addr_info['dlyp_address'] = $dlyp_info['dlyp_address'];
                $addr_info['dlyp_mobile'] = $dlyp_info['dlyp_mobile'];
                $addr_info['area_id'] = $dlyp_info['dlyp_area_3'];
                $addr_info['area_info'] = $dlyp_info['dlyp_area_info'];
                $addr_info['address_detail'] = '（' . $dlyp_info['dlyp_addressname'] . ') ' . $dlyp_info['dlyp_address']
                        . '，电话：' . trim($dlyp_info['dlyp_mobile'] . '，' . $dlyp_info['dlyp_telephony'], '，');
            }
        }
        return $addr_info;
    }

    /**
     * 读取地址列表
     * @author csdeshang
     * @param array $condition 查询条件
     * @param type $order 排序
     * @return array  数组格式的返回结果
     */
    public function getAddressList($condition, $order = 'address_id desc') {
        $address_list = db('address')->where($condition)->order($order)->select();
        if (empty($address_list))
            return array();
        if (config('delivery_isuse')) {
            $dlyp_ids = array();
            $dlyp_new_list = array();
            foreach ($address_list as $k => $v) {
                if ($v['dlyp_id']) {
                    $dlyp_ids[] = $v['dlyp_id'];
                }
            }
            if (!empty($dlyp_ids)) {
                $deliverypoint_model = model('deliverypoint');
                $condition = array();
                $condition['dlyp_id'] = array('in', $dlyp_ids);
                $dlyp_list = $deliverypoint_model->getDeliverypointOpenList($condition);
                foreach ($dlyp_list as $k => $v) {
                    $dlyp_new_list[$v['dlyp_id']] = $v;
                }
            }
            if (!empty($dlyp_new_list)) {
                foreach ($address_list as $k => $v) {
                    if (!$v['dlyp_id'])
                        continue;
                    $dlyp_info = $dlyp_new_list[$v['dlyp_id']];
                    $address_list[$k]['area_info'] = $dlyp_info['dlyp_area_info'];
                    $address_list[$k]['address_detail'] = '（' . $dlyp_info['dlyp_addressname'] . ') ' . $dlyp_info['dlyp_address']
                            . '，电话：' . trim($dlyp_info['dlyp_mobile'] . '，' . $dlyp_info['dlyp_telephony'], '，');
                }
            }
        }
        return $address_list;
    }

    /**
     * 取数量
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getAddressCount($condition = array()) {
        return db('address')->where($condition)->count();
    }

    /**
     * 新增地址
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addAddress($data) {
        //当设置为默认地址，则此用户其他的地址设置为非默认地址
        if($data['address_is_default']==1){
            db('address')->where('member_id',$data['member_id'])->update(array('address_is_default'=>0));
        }
        return db('address')->insertGetId($data);
    }

    /**
     * 取单个地址
     * @author csdeshang
     * @param int $id 地址ID
     * @return array 数组类型的返回结果
     */
    public function getOneAddress($id) {
        if (intval($id) > 0) {
            $result = db('address')->where('address_id',intval($id))->find();
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 更新地址信息
     * @author csdeshang
     * @param array $update 更新数据
     * @param array $condition 更新条件
     * @return bool 布尔类型的返回结果
     */
    public function editAddress($update, $condition) {
        //当设置为默认地址，则此用户其他的地址设置为非默认地址
        if($update['address_is_default']==1 && $condition['member_id']>0){
            db('address')->where('member_id',$condition['member_id'])->update(array('address_is_default'=>0));
        }
        return db('address')->where($condition)->update($update);
    }

    /**
     * 验证地址是否属于当前用户
     * @author csdeshang
     * @param array $member_id 会员id
     * @param array $address_id 地址id
     * @return bool 布尔类型的返回结果
     */
    public function checkAddress($member_id, $address_id) {
        /**
         * 验证地址是否属于当前用户
         */
        $check_array = self::getOneAddress($address_id);
        if ($check_array['member_id'] == $member_id) {
            unset($check_array);
            return true;
        }
        unset($check_array);
        return false;
    }

    /**
     * 删除地址
     * @author csdeshang
     * @param array $condition记录ID
     * @return bool 布尔类型的返回结果
     */
    public function delAddress($condition) {
        return db('address')->where($condition)->delete();
    }

}

?>
