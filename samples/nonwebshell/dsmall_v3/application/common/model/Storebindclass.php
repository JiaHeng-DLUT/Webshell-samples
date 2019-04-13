<?php

/**
 * 店铺分类分佣比例
 *
 */

namespace app\common\model;

use think\Model;

class Storebindclass extends Model {

    
    /**
     * 读取列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param int $page 分页
     * @param string $order 排序
     * @param string $field 字段
     * @return array
     */
    public function getStorebindclassList($condition, $page = '', $order = '', $field = '*') {
        if($page){
            $result = db('storebindclass')->field($field)->where($condition)->order($order)->paginate($page,false,['query' => request()->param()]);
            $this->page_info = $result;
            return $result->items();
        }else{
            $result = db('storebindclass')->field($field)->where($condition)->order($order)->select();
            return $result;
        }
    }

    /**
     * 读取单条记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getStorebindclassInfo($condition) {
        $result = db('storebindclass')->where($condition)->find();
        return $result;
    }

    /**
     * 增加
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @return bool
     */
    public function addStorebindclass($data) {
        return db('storebindclass')->insertGetId($data);
    }

    /**
     * 增加
     * @access public
     * @author csdeshang
     * @param type $data 数据
     * @return type
     */
    public function addStorebindclassAll($data) {
        return db('storebindclass')->insertAll($data);
    }

    /**
     * 更新
     * @access public
     * @author csdeshang
     * @param type $update 更新数据
     * @param type $condition 条件
     * @return type
     */
    public function editStorebindclass($update, $condition) {
        return db('storebindclass')->where($condition)->update($update);
    }


    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delStorebindclass($condition) {
        return db('storebindclass')->where($condition)->delete();
    }

    /**
     * 总数量
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return int
     */
    public function getStorebindclassCount($condition = array()) {
        return db('storebindclass')->where($condition)->count();
    }

    /**
     * 取得店铺下商品分类佣金比例
     * @access public
     * @author csdeshang
     * @param array $goods_list 商品列表
     * @return array
     */
    public function getStoreGcidCommisRateList($goods_list) {

        if (empty($goods_list) || !is_array($goods_list))
            return array();

        // 获取绑定所有类目的自营店
        $own_shop_ids = model('store')->getOwnShopIds(true);

        //定义返回数组
        $store_gc_id_commis_rate = array();

        //取得每个店铺下有哪些商品分类
        $store_gc_id_list = array();
        foreach ($goods_list as $goods) {
            if (!intval($goods['gc_id']))
                continue;
            if (empty($store_gc_id_list) || empty($store_gc_id_list[$goods['store_id']]) || !in_array($goods['gc_id'], $store_gc_id_list[$goods['store_id']])) {
                if (in_array($goods['store_id'], $own_shop_ids)) {
                    //平台店铺佣金为0
                    //$store_gc_id_commis_rate[$goods['store_id']][$goods['gc_id']] = 0;
                } else {
                    //$store_gc_id_list[$goods['store_id']][] = $goods['gc_id'];
                }
                $store_gc_id_list[$goods['store_id']][] = $goods['gc_id'];
            }
        }

        if (empty($store_gc_id_list))
            return $store_gc_id_commis_rate;

        $condition = array();
        foreach ($store_gc_id_list as $store_id => $gc_id_list) {
            $condition['store_id'] = $store_id;
            $condition['class_1|class_2|class_3'] = array('in', $gc_id_list);
            $bind_list = $this->getStorebindclassList($condition);
            if (!$bind_list) {
                $condition = array();
                $condition['store_id'] = $store_id;
                $condition['class_1'] = 0;
                $condition['class_2'] = 0;
                $condition['class_3'] = 0;
                $bind_list = $this->getStorebindclassList($condition);
            }
            if (!empty($bind_list) && is_array($bind_list)) {
                foreach ($bind_list as $bind_info) {
                    if ($bind_info['store_id'] != $store_id)
                        continue;
                    //如果class_1,2,3有一个字段值匹配，就有效
                    $bind_class = array($bind_info['class_3'], $bind_info['class_2'], $bind_info['class_1']);
                    foreach ($gc_id_list as $gc_id) {
                        //if (in_array($gc_id,$bind_class)) {
                        $store_gc_id_commis_rate[$store_id][$gc_id] = $bind_info['commis_rate'];
                        //}
                    }
                }
            }
        }
        return $store_gc_id_commis_rate;
    }

}
