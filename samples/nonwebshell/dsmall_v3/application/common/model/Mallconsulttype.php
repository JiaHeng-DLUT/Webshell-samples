<?php

namespace app\common\model;


use think\Model;

class Mallconsulttype extends Model
{
    /**
     * 咨询类型列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @param string $key 键
     * @param string $order 排序
     * @return array 
     */
    public function getMallconsulttypeList($condition, $field = '*', $key = '', $order = 'mallconsulttype_sort asc,mallconsulttype_id asc')
    {
        $res= db('mallconsulttype')->where($condition)->field($field)->order($order)->select();
        if(!empty($key)) {
            return ds_change_arraykey($res, $key);
        }else{
            return $res;
        }
    }

    /**
     * 单条咨询类型
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @return type 
     */
    public function getMallconsulttypeInfo($condition, $field = '*')
    {
        return db('mallconsulttype')->where($condition)->field($field)->find();
    }

    /**
     * 添加咨询类型
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool
     */
    public function addMallconsulttype($data)
    {
        return db('mallconsulttype')->insertGetId($data);
    }

    /**
     * 编辑咨询类型
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $update 数据
     * @return boolean
     */
    public function editMallconsulttype($condition, $update)
    {
        return db('mallconsulttype')->where($condition)->update($update);
    }

    /**
     * 删除咨询类型
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function delMallconsulttype($condition)
    {
        return db('mallconsulttype')->where($condition)->delete();
    }
}