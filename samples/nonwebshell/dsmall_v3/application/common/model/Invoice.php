<?php

namespace app\common\model;


use think\Model;

class Invoice extends Model
{
    /**
     * 取得买家默认发票
     * @access public
     * @author csdeshang
     * @param array $condition 条件数组
     * @return array
     */
    public function getDefaultInvoiceInfo($condition = array())
    {
        return db('invoice')->where($condition)->order('invoice_state asc')->find();
    }

    /**
     * 取得单条发票信息
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     */
    public function getInvoiceInfo($condition = array())
    {
        return db('invoice')->where($condition)->find();
    }

    /**
     * 取得发票列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $limit 限制
     * @param type $field 字段
     * @return type
     */
    public function getInvoiceList($condition, $limit = '', $field = '*')
    {
        return db('invoice')->field($field)->where($condition)->limit($limit)->select();
    }

    /**
     * 删除发票信息
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delInvoice($condition)
    {
        return db('invoice')->where($condition)->delete();
    }

    /**
     * 新增发票信息
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool
     */
    public function addInvoice($data)
    {
        return db('invoice')->insertGetId($data);
    }
}