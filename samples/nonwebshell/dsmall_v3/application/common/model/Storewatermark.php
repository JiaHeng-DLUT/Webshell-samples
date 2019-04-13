<?php

namespace app\common\model;

use think\Model;

class Storewatermark extends Model {

   
    /**
     * 根据店铺id获取水印
     * @access public
     * @author csdeshang
     * @param int $store_id 店铺ID
     * @return type
     */
    public function getOneStorewatermarkByStoreId($store_id) {
        $wm_arr = db('storewatermark')->where('store_id',$store_id)->find();
        return $wm_arr;
    }

    /**
     * 新增水印
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addStorewatermark($data) {
        return db('storewatermark')->insertGetId($data);
    }

    /**
     * 更新水印
     * @access public
     * @author csdeshang
     * @param array $data 更新数据
     * @return bool 布尔类型的返回结果
     */
    public function editStorewatermark($wm_id,$data) {
        return db('storewatermark')->where('swm_id',$wm_id)->update($data);
    }

    /**
     * 删除水印
     * @access public
     * @author csdeshang
     * @param int $id 记录ID
     * @return bool 布尔类型的返回结果
     */
    public function delStorewatermark($condition) {
        return db('storewatermark')->where($condition)->delete();
    }

}
