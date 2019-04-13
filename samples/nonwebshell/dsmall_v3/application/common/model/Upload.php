<?php

namespace app\common\model;

use think\Model;

class Upload extends Model {

    public function getUploadList($condition, $field = '*') {
        $result = db('upload')->field($field)->order('upload_id asc')->where($condition)->select();
        return $result;
    }

    /**
     * 取单个内容
     * @access public
     * @author csdeshang
     * @param int $id 分类ID
     * @return array 数组类型的返回结果
     */
    public function getOneUpload($id) {
        $data['upload_id'] = intval($id);
        $result = db('upload')->where($data)->find();
        return $result;
    }

    /**
     * 新增
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addUpload($data) {
        $result = db('upload')->insertGetId($data);
        return $result;
    }

    /**
     * 更新信息
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @param array $condition 条件
     * @return bool
     */
    public function editUpload($data, $condition) {
        $result = db('upload')->where($condition)->update($data);
        return $result;
    }


    /**
     * 删除分类
     * @access public
     * @author csdeshang
     * @param int $condition 记录ID
     * @return bool 
     */
    public function delUpload($condition) {
        return db('upload')->where($condition)->delete();
    }



}