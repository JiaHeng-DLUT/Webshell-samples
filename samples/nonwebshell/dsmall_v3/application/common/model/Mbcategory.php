<?php

namespace app\common\model;

use think\Model;

class Mbcategory extends Model {

    /**
     * 列表
     * @access public
     * @author csdeshang
     * @param array $condition 检索条件
     * @param int $page 分页
     * @param string $order 分页
     * @return array 数组结构的返回结果
     */
    public function getMbcategoryList($condition, $page = '',$order='gc_id') {
        $result = db('mbcategory')->where($condition)->order($order)->select();
        return $result;
    }

    /**
     * 取单个内容
     * @access public
     * @author csdeshang
     * @param int $id ID
     * @return array 数组类型的返回结果
     */
    public function getOneMbcategory($id) {
        $result = db('mbcategory')->where('gc_id='.intval($id))->find();
        return $result;
    }

    /**
     * 新增
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addMbcategory($data) {
        return db('mbcategory')->insert($data);
    }

    /**
     * 更新信息
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @param array $gc_id ID
     * @return bool 布尔类型的返回结果
     */
    public function editMbcategory($data,$gc_id) {
        return db('mbcategory')->where('gc_id='.$gc_id)->update($data);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param int $id 记录ID
     * @return bool 布尔类型的返回结果
     */
    public function delMbcategory($id) {
        return db('mbcategory')->where('gc_id='.$id)->delete();
    }

}

?>
