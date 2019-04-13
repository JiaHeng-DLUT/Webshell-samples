<?php

namespace app\common\model;


use think\Model;

class Fleaupload extends Model
{
    public $page_info;


    /**
     * 取单个内容
     * @access public
     * @author csdeshang
     * @param int $id 分类ID
     * @return array 数组类型的返回结果
     */
    public function getOneFleaupload($id){
            $result = db('fleaupload')->where(array('fleaupload_id'=>intval($id)))->find();
            return $result;
    }

    /**
     * 新增
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addFleaupload($data){
        if (empty($data)){
            return false;
        }
        if (is_array($data)){

            $result = db('fleaupload')->insertGetId($data);
            return $result;
        }else {
            return false;
        }
    }

    /**
     * 更新信息
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @param array $condition 条件数组
     * @return bool 布尔类型的返回结果
     */
    public function editFleaupload($data, $condition) {
        $result = db('fleaupload')->where($condition)->update($data);
        return $result;
    }

    /**
     * 删除图片信息，根据where
     * @access public
     * @author csdeshang
     * @param array $conditionarr 条件数组
     * @return bool 布尔类型的返回结果
     */
    public function delFleaupload($condition){
        if (empty($condition)||empty($condition['store_id'])) {
            return false;
        }
        $image_more = db('fleaupload')->where($condition)->field('fleafile_name')->select();
        if (is_array($image_more) && !empty($image_more)) {
            foreach ($image_more as $v) {
                @unlink(BASE_UPLOAD_PATH . DS . ATTACH_MFLEA . DS . $condition['store_id'] . DS . $v['fleafile_name']);
            }
        }
        $state = db('fleaupload')->where($condition)->delete();
        return $state;
    }
}