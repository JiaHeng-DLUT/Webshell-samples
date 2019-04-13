<?php

namespace app\common\model;
use think\Model;
use think\Db;
class Goodsclassstaple extends Model {

    /**
     * 常用分类列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $order 排序
     * @param string $field 字段
     * @param int $limit 限制
     * @return array 二维数组
     */
    public function getGoodsclassstapleList($condition, $field = '*', $order = 'staple_counter desc', $limit = 20) {
        $result = db('goodsclassstaple')->field($field)->where($condition)->order($order)->limit($limit)->select();
        return $result;
    }

    /**
     * 一条记录
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @param string $field 字段
     * @return array 一维数组结构的返回结果
     */
    public function getGoodsclassstapleInfo($condition, $field = '*') {
        $result = db('goodsclassstaple')->field($field)->where($condition)->find();
        return $result;
    }

    /**
     * 添加常用分类，如果已存在计数器+1
     * @access public
     * @author csdeshang
     * @param type $data 参数内容
     * @param type $member_id  会员ID
     * @return boolean
     */
    public function autoIncrementStaple($data, $member_id) {
        $where = array(
            'gc_id_1' => intval($data['gc_id_1']),
            'gc_id_2' => intval($data['gc_id_2']),
            'gc_id_3' => intval($data['gc_id_3']),
            'member_id' => $member_id
        );
        $staple_info = $this->getGoodsclassstapleInfo($where);
        if (empty($staple_info)) {
            $insert = array(
                'staple_name' => $data['gctag_name'],
                'gc_id_1' => intval($data['gc_id_1']),
                'gc_id_2' => intval($data['gc_id_2']),
                'gc_id_3' => intval($data['gc_id_3']),
                'type_id' => $data['type_id'],
                'member_id' => $member_id
            );
            $this->addGoodsclassstaple($insert);
        } else {
            $update = array('staple_counter' => Db::raw('staple_counter+1'));
            $where = array('staple_id' => $staple_info['staple_id']);
            $this->editGoodsclassstaple($update, $where);
        }
        return true;
    }

    /**
     * 新增
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return boolean 布尔类型的返回结果
     */
    public function addGoodsclassstaple($data) {
        $result = db('goodsclassstaple')->insertGetId($data);
        return $result;
    }

    /**
     * 更新
     * @access public
     * @author csdeshang
     * @param array $update 更新内容
     * @param array $where 条件
     * @return boolean
     */
    public function editGoodsclassstaple($update, $where) {
        $result = db('goodsclassstaple')->where($where)->update($update);
        return $result;
    }

    /**
     * 删除常用分类
     * @access public
     * @author csdeshang
     * @param array $condtion 条件
     * @return boolean
     */
    public function delGoodsclassstaple($condtion) {
        $result = db('goodsclassstaple')->where($condtion)->delete();
        return $result;
    }

}

?>
