<?php

/**
 * 满即送套餐模型
 *
 */

namespace app\common\model;

use think\Model;

class Pmansongquota extends Model
{
    public $page_info;

    /**
     * 读取满即送套餐列表
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @param int $page 分页数
     * @param string $order 排序
     * @param string $field 所需字段
     * @return array 满即送套餐列表
     *
     */
    public function getMansongquotaList($condition, $page = null, $order = '', $field = '*')
    {
        $res = db('pmansongquota')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
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
    public function getMansongquotaInfo($condition)
    {
        $result = db('pmansongquota')->where($condition)->find();
        return $result;
    }

    /**
     * 获取当前可用套餐
     * @access public
     * @author csdeshang
     * @param int $store_id 店铺id
     * @return array
     */
    public function getMansongquotaCurrent($store_id)
    {
        $condition = array();
        $condition['store_id'] = $store_id;
        $condition['mansongquota_endtime'] = array('gt', TIMESTAMP);
        return $this->getMansongquotaInfo($condition);
    }

    /**
     * 增加 
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @return bool
     */
    public function addMansongquota($data)
    {
        return db('pmansongquota')->insertGetId($data);
    }

    /**
     * 更新
     * @access public
     * @author csdeshang
     * @param array $update 更新数据 
     * @param array $condition 条件
     * @return bool
     */
    public function editMansongquota($update, $condition)
    {
        return db('pmansongquota')->where($condition)->update($update);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delMansongquota($condition)
    {
        return db('pmansongquota')->where($condition)->delete();
    }

}
