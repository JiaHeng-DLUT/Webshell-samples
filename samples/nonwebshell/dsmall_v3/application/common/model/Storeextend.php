<?php

namespace app\common\model;

use think\Model;

class Storeextend extends Model {

    /**
     * 查询店铺扩展信息
     * @access public
     * @author csdeshang
     * @param array $condition 店铺编号
     * @param string $field 查询字段
     * @return array
     */
    public function getStoreextendInfo($condition, $field = '*') {
        return db('storeextend')->field($field)->where($condition)->find();
    }

    /**
     * 编辑店铺扩展信息
     * @access public
     * @author csdeshang
     * @param type $update 更新数据
     * @param type $condition 条件
     * @return type
     */
    public function editStoreextend($update, $condition) {
        $extend=new Storeextend();
        $result=$extend->where($condition)->find();
        if($result){
            $res= $extend->save($update,$condition);
        }else{
            $update=array_merge($update,$condition);
            $res= $extend->save($update);
        }
        return $res;

    }

    /**
     * 删除店铺扩展信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function delStoreextend($condition) {
        return db('storeextend')->where($condition)->delete();
    }
    

}

?>
