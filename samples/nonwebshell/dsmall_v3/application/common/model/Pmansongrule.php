<?php

/**
 * 满即送活动规则模型 
 *
 */

namespace app\common\model;

use think\Model;

class Pmansongrule extends Model {

    
    /**
     * 读取满即送规则列表
     * @access public
     * @author csdeshang
     * @param type $mansong_id  满即送ID
     * @return type
     */
    public function getMansongruleListByID($mansong_id) {
        $condition = array();
        $condition['mansong_id'] = $mansong_id;
        $mansong_rule_list = db('pmansongrule')->where($condition)->order('mansongrule_price desc')->select();
        if (!empty($mansong_rule_list)) {
            $goods_model = model('goods');

            for ($i = 0, $j = count($mansong_rule_list); $i < $j; $i++) {
                $goods_id = intval($mansong_rule_list[$i]['goods_id']);
                if (!empty($goods_id)) {
                    $goods_info = $goods_model->getGoodsOnlineInfoByID($goods_id);
                    if (!empty($goods_info)) {
                        if (empty($mansong_rule_list[$i]['mansong_goods_name'])) {
                            $mansong_rule_list[$i]['mansong_goods_name'] = $goods_info['goods_name'];
                        }
                        $mansong_rule_list[$i]['goods_image'] = $goods_info['goods_image'];
                        $mansong_rule_list[$i]['goods_image_url'] = goods_cthumb($goods_info['goods_image'], $goods_info['store_id']);
                        $mansong_rule_list[$i]['goods_storage'] = $goods_info['goods_storage'];
                        $mansong_rule_list[$i]['goods_id'] = $goods_id;
                        $mansong_rule_list[$i]['goods_url'] = url('Goods/index', array('goods_id' => $goods_id));
                    }
                }
            }
        }
        return $mansong_rule_list;
    }

    /**
     * 增加 
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @return bool
     */
    public function addMansongrule($data) {
        return db('pmansongrule')->insertGetId($data);
    }

    /**
     * 批量增加 
     * @access public
     * @author csdeshang
     * @param array $array 参数内容
     * @return bool
     */
    public function addMansongruleArray($array) {
        return db('pmansongrule')->insertAll($array);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delMansongrule($condition) {
        return db('pmansongrule')->where($condition)->delete();
    }

}
