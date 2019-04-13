<?php

namespace app\common\model;


use think\Model;

class Offpayarea extends Model
{
    /**
     * 增加某店铺设置
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool
     */
    public function addOffpayarea($data)
    {
        return db('offpayarea')->insert($data);
    }

    /**
     * 取得某店铺设置
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return array
     */
    public function getOffpayareaInfo($condition)
    {
        return db('offpayarea')->where($condition)->find();
    }

    /**
     * 更新某店铺设置
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $data 数据
     * @return bool
     */
    public function editOffpayarea($condition, $data)
    {
        return db('offpayarea')->where($condition)->update($data);
    }

    /**
     * 某县级地区是否支持货到付款
     * @access public
     * @author csdeshang
     * @param int $area_id 地区ID
     * @param int $store_id 店铺ID（目前只会传平台店铺）
     * @return bool
     */
    public function checkSupportOffpay($area_id, $store_id)
    {
        if (empty($area_id)) return false;
        $area = $this->getOffpayareaInfo(array('store_id' => $store_id));
        if (!empty($area['area_id'])) {
            $area_id_array = unserialize($area['area_id']);
        } else {
            $area_id_array = array();
        }
        if (empty($area_id_array)) {
            $area_id_array = array();
        }
        return in_array($area_id, $area_id_array) ? true : false;
    }

    /**
     * 某县级地区是否支持货到付款（多个店铺）
     * @access public
     * @author csdeshang
     * @param int $area_id 地区ID
     * @param array $store_ids 店铺IDs
     * @return array
     */
    public function checkSupportOffpayBatch($area_id, array $store_ids)
    {
        if (empty($area_id))
            return array_fill($store_ids, false);

        $area = db('offpayarea')->where(array(
            'store_id' => array('in', $store_ids),
        ))->select();
        $area = ds_change_arraykey($area, 'store_id');
        $ret = array();
        foreach ($store_ids as $sid) {
            $ret[$sid] = false;
            if (empty($area[$sid]['area_id']))
                continue;

            $area_id_array = unserialize($area[$sid]['area_id']);
            if (!is_array($area_id_array))
                continue;

            if (!in_array($area_id, $area_id_array))
                continue;

            $ret[$sid] = true;
        }

        return $ret;
    }
}