<?php

namespace app\common\model;


use think\Model;

class Consult extends Model
{
    public $page_info;
    /**
     * 咨询数量
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @return int
     */
    public function getConsultCount($condition)
    {
        return db('consult')->where($condition)->count();
    }

    /**
     * 添加咨询
     * @access public
     * @author csdeshang 
     * @param array $data 参数内容
     * @return int
     */
    public function addConsult($data)
    {
        return db('consult')->insertGetId($data);
    }

    /**
     * 商品咨询列表
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param str $field 字段
     * @param int $page 分页信息
     * @param str $order 排序
     * @return array
     */
    public function getConsultList($condition, $field = '*', $page=10, $order = 'consult_id desc')
    {
         $res=db('consult')->where($condition)->field($field)->order($order)->paginate($page,false,['query' => request()->param()]);
         $this->page_info=$res;
         return $res->items();
    }
    /**
     * 获取咨询信息
     * @access public
     * @author csdeshang 
     * @param array $condition 咨询条件
     * @return array
     */
    public function getConsultInfo($condition)
    {
        return db('consult')->where($condition)->find();
    }

    /**
     * 删除咨询
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     */
    public function delConsult($condition)
    {
        return db('consult')->where($condition)->delete();
    }

    /**
     * 回复咨询
     * @access public
     * @author csdeshang 
     * @param array $condition 条件
     * @param array $data 参数内容
     * @return type
     */
    public function editConsult($condition, $data)
    {
        $data['consult_replytime'] = TIMESTAMP;
        return db('consult')->where($condition)->update($data);
    }
}