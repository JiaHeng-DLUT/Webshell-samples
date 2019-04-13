<?php

namespace app\common\model;
use think\Model;

class Groupbuyquota extends Model
{
    public $page_info;
    /**
     * 读取抢购套餐列表
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @param int $page 分页数
     * @param string $order 排序
     * @param string $field 所需字段
     * @return array 抢购套餐列表
     *
     */
    public function getGroupbuyquotaList($condition, $page = null, $order = '', $field = '*')
    {
        $result = db('groupbuyquota')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$result;
        $result=$result->items();
        return $result;
    }

    /**
     * 读取单条记录
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @return array
     */
    public function getGroupbuyquotaInfo($condition)
    {
        $result = db('groupbuyquota')->where($condition)->find();
        return $result;
    }

    /**
     * 获取当前可用套餐
     * @access public
     * @author csdeshang
     * @param int $store_id 店铺id
     * @return array
     */
    public function getGroupbuyquotaCurrent($store_id)
    {
        $condition = array();
        $condition['store_id'] = $store_id;
        $condition['groupbuyquota_endtime'] = array('gt', TIMESTAMP);
        return $this->getGroupbuyquotaInfo($condition);
    }

    /**
     * 增加
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool
     */
    public function addGroupbuyquota($data)
    {
        return db('groupbuyquota')->insertGetId($data);
    }

    /**
     * 编辑更新抢购套餐
     * @access public
     * @author csdeshang
     * @param type $update 更新数据
     * @param type $condition 检索条件
     * @return bool
     */
    public function editGroupbuyquota($update, $condition)
    {
        return db('groupbuyquota')->where($condition)->update($update);
    }

    /*
     * 删除
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @return bool
     */
    public function delGroupbuyquota($condition)
    {
        return db('groupbuyquota')->where($condition)->delete();
    }
}