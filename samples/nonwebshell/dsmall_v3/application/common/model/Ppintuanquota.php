<?php

/**
 * 限时折扣套餐模型
 */

namespace app\common\model;

use think\Model;

class Ppintuanquota extends Model {

    public $page_info;

    /**
     * 获取拼团套餐列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $order 排序
     * @param type $field 字段
     * @return type
     */
    public function getPintuanquotaList($condition, $page = null, $order = '', $field = '*') {
        $res = db('ppintuanquota')->field($field)->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
        $this->page_info = $res;
        $result = $res->items();
        return $result;
    }

    /**
     * 读取单条记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getPintuanquotaInfo($condition) {
        $result = db('ppintuanquota')->where($condition)->find();
        return $result;
    }

    /**
     * 获取当前可用套餐
     * @access public
     * @author csdeshang
     * @param type $store_id 店铺ID
     * @return type
     */
    public function getPintuanquotaCurrent($store_id) {
        $condition = array();
        $condition['store_id'] = $store_id;
        $condition['pintuanquota_endtime'] = array('gt', TIMESTAMP);
        return $this->getPintuanquotaInfo($condition);
    }

    /**
     * 增加
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @return type
     */
    public function addPintuanquota($data) {
        return db('ppintuanquota')->insertGetId($data);
    }

    /**
     * 更新
     * @access public
     * @author csdeshang
     * @param type $update 更新数据
     * @param type $condition 条件
     * @return type
     */
    public function editPintuanquota($update, $condition) {
        return db('ppintuanquota')->where($condition)->update($update);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function delPintuanquota($condition) {
        return db('ppintuanquota')->where($condition)->delete();
    }

}
