<?php

namespace app\common\model;


use think\Model;

class Storemsgsetting extends Model
{
    public $page_info;
 
    /**
     * 店铺消息接收设置列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @param type $key 键值
     * @param type $page 分页
     * @param type $order 排序
     * @return type
     */
    public function getStoremsgsettingList($condition, $field = '*', $key = '', $page = 0, $order = 'storemt_code asc') {
        $res=db('storemsgsetting')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$res;
        $result= $res->items();
        return ds_change_arraykey($result,$key);

    }

    /**
     * 店铺消息接收设置详细
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @return type
     */
    public function getStoremsgsettingInfo($condition, $field = '*') {
        return db('storemsgsetting')->field($field)->where($condition)->find();
    }

    /**
     * 添加店铺模板接收设置
     * @access public
     * @author csdeshang
     * @param array $data 新增数据
     * @return bool
     */
    public function addStoremsgsetting($data) {
        return db('storemsgsetting')->insert($data);
    }

    /**
     * 编辑店铺模板接收设置
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @return bool
     */
    public function editStoremsgsetting($data, $condition) {
        return db('storemsgsetting')->where($condition)->update($data);
    }
}