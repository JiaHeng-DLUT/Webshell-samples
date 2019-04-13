<?php

namespace app\common\model;

use think\Model;

class Groupbuypricerange extends Model
{
    public $page_info;


    /**
     * 读取列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param int $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getGroupbuypricerangeList($condition = array(), $page = '',$order='gprange_id desc')
    {
        if ($page) {
            $res = db('groupbuypricerange')->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $res;
            return $res->items();
        }else{
            return db('groupbuypricerange')->where($condition)->order($order)->select();
        }
    }


    /**
     * 根据编号获取单个内容
     * @access public
     * @author csdeshang
     * @param int $id 主键编号
     * @return array 数组类型的返回结果
     */
    public function getOneGroupbuypricerange($id) {
        $condition['gprange_id'] = intval($id);
        $result = db('groupbuypricerange')->where($condition)->find();
        return $result;
    }

    /**
     * 判断是否存在
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return bool
     */
    public function isGroupbuypricerangeExist($condition = '')
    {
        $list = db('groupbuypricerange')->where($condition)->select();
        return $list;
    }

    /**
     * 增加
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool
     */
    public function addGroupbuypricerange($data)
    {
        return db('groupbuypricerange')->insertGetId($data);

    }

    /**
     * 更新
     * @param array $update_array 更新数据
     * @param array $where_array 更新条件
     * @return bool
     */
    public function editGroupbuypricerange($update_array, $where_array)
    {
        return db('groupbuypricerange')->where($where_array)->update($update_array);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @return bool
     */
    public function delGroupbuypricerange($condition)
    {
        return db('groupbuypricerange')->where($condition)->delete();
    }

}