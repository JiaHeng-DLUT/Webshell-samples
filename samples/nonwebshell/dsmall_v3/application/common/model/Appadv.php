<?php

namespace app\common\model;

use think\Model;

class Appadv extends Model
{
    /**
     * 获取APP广告位列表
     * @author csdeshang
     * @param array $condition 查询条件
     * @param int $page 分页页数
     * @param str $orderby 排序
     * @return array 二维数组
     */
    public function getAppadvpositionList($condition = array(), $page = '', $orderby = 'ap_id desc') {
        if ($page) {
            $result = db('appadvposition')->where($condition)->order($orderby)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('appadvposition')->where($condition)->order($orderby)->select();
        }
    }

    /**
     * 根据条件查询多条记录
     * @author csdeshang
     * @param array $condition 查询条件
     * @param int $page 分页页数
     * @param int $limit 数量限制
     * @param str $orderby 排序
     * @return array 二维数组
     */
    public function getAppadvList($condition = array(), $page = '', $limit = '', $orderby = 'adv_id desc') {
        if ($page) {
            $result = db('appadv')->where($condition)->order($orderby)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        } else {
            return db('appadv')->where($condition)->order($orderby)->select();
        }
    }
    /**
     * 新增广告位
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addAppadvposition($data) {
        return db('appadvposition')->insertGetId($data);
    }
    /**
     * 新增广告
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addAppadv($data) {
        $result = db('appadv')->insertGetId($data);
        $apId = (int) $data['ap_id'];
        dkcache("appadv/{$apId}");
        return $result;
    }
    /**
     * 更新广告位记录
     * @author csdeshang
     * @param array $data 更新内容
     * @return bool
     */
    public function editAppadvposition($data) {
        $apId = (int) $data['ap_id'];
        dkcache("appadv/{$apId}");
        return db('appadvposition')->where('ap_id', $data['ap_id'])->update($data);
    }
     
    /**
     * 获取一个app广告位
     * @author csdeshang
     * @param array $condition 查询条件
     * @return array
     */
    public function getOneAppadvposition($condition = array()) {
        return db('appadvposition')->where($condition)->find();
    }

    /**
     * 删除一个广告位
     * @author csdeshang
     * @param array $ap_id 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function delAppadvposition($ap_id) {
        $apId = (int) $ap_id;
        dkcache("appadv/{$apId}");
        return db('appadvposition')->where('ap_id', $apId)->delete();
    }
    /**
     * 获取一个广告位
     * @author csdeshang
     * @param array $condition 条件
     * @return type
     */
    public function getOneAppadv($condition = array()) {
        return db('appadv')->where($condition)->find();
    }

    /**
     * 更新记录
     * @author csdeshang
     * @param array $data 更新内容
     * @return bool
     */
    public function editAppadv($data) {
        $adv_array = db('appadv')->where('adv_id', $data['adv_id'])->find();
        if ($adv_array) {
            // drop cache
            $apId = (int) $adv_array['ap_id'];
            dkcache("appadv/{$apId}");
        }
        return db('appadv')->where('adv_id', $data['adv_id'])->update($data);
    }

    /**
     * 删除一条广告
     * @author csdeshang
     * @param array $adv_id 广告位id
     * @return bool 布尔类型的返回结果
     */
    public function delAppadv($adv_id) {
        $condition['adv_id'] = $adv_id;
        $adv = db('appadv')->where($condition)->find();
        if ($adv) {
            // drop cache
            $apId = (int) $adv['ap_id'];
            dkcache("appadv/{$apId}");
        }
        @unlink(BASE_UPLOAD_PATH . DS . ATTACH_APPADV. DS .$adv['adv_code']);
        return db('appadv')->where($condition)->delete();
    }
}