<?php

/**
 * 限时折扣套餐模型
 */

namespace app\common\model;

use think\Model;

class Pxianshiquota extends Model
{
    public $page_info;

    /**
     * 读取限时折扣套餐列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param int $page 分页
     * @param string $order 排序
     * @param string $field 字段
     * @return array 限时折扣套餐列表
     */
    public function getXianshiquotaList($condition, $page = null, $order = '', $field = '*')
    {
        $res = db('pxianshiquota')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
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
    public function getXianshiquotaInfo($condition)
    {
        $result = db('pxianshiquota')->where($condition)->find();
        return $result;
    }

    /**
     * 获取当前可用套餐
     * @access public
     * @author csdeshang
     * @param type $store_id 店铺ID
     * @return type
     */
    public function getXianshiquotaCurrent($store_id)
    {
        $condition = array();
        $condition['store_id'] = $store_id;
        $condition['xianshiquota_endtime'] = array('gt', TIMESTAMP);
        return $this->getXianshiquotaInfo($condition);
    }

    /**
     * 增加
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @return bool
     */
    public function addXianshiquota($data)
    {
        return db('pxianshiquota')->insertGetId($data);
    }

    /**
     * 更新
     * @access public
     * @author csdeshang
     * @param type $update 更新数据
     * @param type $condition 检索条件
     * @return bool
     */
    public function editXianshiquota($update, $condition)
    {
        return db('pxianshiquota')->where($condition)->update($update);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return bool
     */
    public function delXianshiquota($condition)
    {
        return db('pxianshiquota')->where($condition)->delete();
    }

}
