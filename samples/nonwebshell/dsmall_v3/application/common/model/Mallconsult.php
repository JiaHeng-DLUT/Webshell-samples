<?php

namespace app\common\model;


use think\Model;

class Mallconsult extends Model
{
    public $page_info;

    /**
     * 咨询列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $field 字段
     * @param int $page 分页
     * @param string $order 排序
     * @return array
     */
    public function getMallconsultList($condition, $field = '*', $page = 0, $order = 'mallconsult_id desc') {
        $res= db('mallconsult')->where($condition)->field($field)->order($order)->paginate($page,false,['query' => request()->param()]);
        $this->page_info=$res;
        return $res->items();
    }

    /**
     * 咨询数量
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return int
     */
    public function getMallconsultCount($condition) {
        return db('mallconsult')->where($condition)->count();
    }

    /**
     * 单条咨询
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $field 字段
     * @return type
     */
    public function getMallconsultInfo($condition, $field = '*') {
        return db('mallconsult')->where($condition)->field($field)->find();
    }

    /**
     * 咨询详细信息
     * @access public
     * @author csdeshang
     * @param int $mallconsult_id ID编号
     * @return boolean|multitype:
     */
    public function getMallconsultDetail($mallconsult_id) {
        $consult_info = $this->getMallconsultInfo(array('mallconsult_id' => $mallconsult_id));
        if (empty($consult_info)) {
            return false;
        }

        $type_info = model('mallconsulttype')->getMallconsulttypeInfo(array('mallconsulttype_id' => $consult_info['mallconsulttype_id']), 'mallconsulttype_name');
        return array_merge($consult_info, $type_info);
    }

    /**
     * 添加咨询
     * @access public
     * @author csdeshang
     * @param array $insert 参数内容
     * @return bool
     */
    public function addMallconsult($insert) {
        $insert['mallconsult_addtime'] = TIMESTAMP;
        return db('mallconsult')->insertGetId($insert);
    }

    /**
     * 编辑咨询
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param array $update 数据
     * @return boolean
     */
    public function editMallconsult($condition, $update) {
        return db('mallconsult')->where($condition)->update($update);
    }

    /**
     * 删除咨询
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return boolean
     */
    public function delMallconsult($condition) {
        return db('mallconsult')->where($condition)->delete();
    }
}