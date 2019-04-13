<?php

namespace app\common\model;

use think\Model;

class Adv extends Model {

    public $page_info;

    /**
     * 新增广告位
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addAdvposition($data) {
        return db('advposition')->insertGetId($data);
    }

    /**
     * 新增广告
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addAdv($data) {
        $result = db('adv')->insertGetId($data);
        $apId = (int) $data['ap_id'];
        dkcache("adv/{$apId}");
        return $result;
    }

    /**
     * 删除一条广告
     * @author csdeshang
     * @param array $adv_id 广告id
     * @return bool 布尔类型的返回结果
     */
    public function delAdv($adv_id) {
        $condition['adv_id'] = $adv_id;
        $adv = db('adv')->where($condition)->find();
        if ($adv) {
            // drop cache
            $apId = (int) $adv['ap_id'];
            dkcache("adv/{$apId}");
        }
        @unlink(BASE_UPLOAD_PATH . DS . ATTACH_ADV. DS .$adv['adv_code']);
        return db('adv')->where($condition)->delete();
    }

    /**
     * 删除一个广告位
     * @author csdeshang
     * @param array $ap_id 广告位id
     * @return bool 布尔类型的返回结果
     */
    public function delAdvposition($ap_id) {
        $apId = (int) $ap_id;
        dkcache("adv/{$apId}");
        return db('advposition')->where('ap_id', $apId)->delete();
    }

    /**
     * 获取广告位列表
     * @author csdeshang
     * @param array $condition 查询条件
     * @param obj $page 分页页数
     * @param str $orderby 排序
     * @return array 二维数组
     */
    public function getAdvpositionList($condition = array(), $page = '', $orderby = 'ap_id desc') {
        if ($page) {
            $result = db('advposition')->where($condition)->order($orderby)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('advposition')->where($condition)->order($orderby)->select();
        }
    }

    public function getOneAdvposition($condition = array()) {
        return db('advposition')->where($condition)->find();
    }

    public function getOneAdv($condition = array()) {
        return db('adv')->where($condition)->find();
    }

    /**
     * 根据条件查询多条记录
     * @author csdeshang
     * @param array $condition 查询条件
     * @param obj $page 分页页数
     * @param int $limit 数量限制
     * @param str $orderby 排序
     * @return array 二维数组
     */
    public function getAdvList($condition = array(), $page = '', $limit = '', $orderby = 'adv_id desc') {
        if ($page) {
            $result = db('adv')->where($condition)->order($orderby)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('adv')->where($condition)->order($orderby)->select();
        }
    }

    /**
     * 手机端广告位获取
     * @author csdeshang
     * @param array $condition 条件
     * @param str $orderby 排序
     * @return array
     */
    public function mbadvlist($condition,$orderby='adv_sort desc'){
         return db('adv')->alias('a')->join('__ADVPOSITION__ n','a.ap_id=n.ap_id')->where($condition)->order($orderby)->select();
    }


    /**
     * 更新记录
     * @author csdeshang
     * @param array $data 更新内容
     * @return bool
     */
    public function editAdv($data) {
        $adv_array = db('adv')->where('adv_id', $data['adv_id'])->find();
        if ($adv_array) {
            // drop cache
            $apId = (int) $adv_array['ap_id'];
            dkcache("adv/{$apId}");
        }
        return db('adv')->where('adv_id', $data['adv_id'])->update($data);
    }

    /**
     * 更新广告位记录
     * @author csdeshang
     * @param array $data 更新内容
     * @return bool
     */
    public function editAdvposition($data) {
        $apId = (int) $data['ap_id'];
        dkcache("adv/{$apId}");
        return db('advposition')->where('ap_id', $data['ap_id'])->update($data);
    }



}

?>
