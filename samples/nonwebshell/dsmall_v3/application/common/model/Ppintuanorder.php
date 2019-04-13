<?php

/**
 * 拼团订单辅助,用于判断拼团订单是归属于哪一个团长的 
 *
 */

namespace app\common\model;

use think\Model;

class Ppintuanorder extends Model {

    const PINTUANORDER_STATE_CLOSE = 0;
    const PINTUANORDER_STATE_NORMAL = 1;
    const PINTUANORDER_STATE_SUCCESS = 2;

    private $pintuanorder_state_array = array(
        self::PINTUANORDER_STATE_CLOSE => '拼团取消',
        self::PINTUANORDER_STATE_NORMAL => '参团中',
        self::PINTUANORDER_STATE_SUCCESS => '拼团成功'
    );

    /**
     * 获取拼团订单表列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getPpintuanorderList($condition) {
        $ppintuanorder_list = db('ppintuanorder')->alias('ppintuanorder')->field('ppintuanorder.*,order.buyer_id,order.buyer_name,order.order_state')
                ->join('__ORDER__ order', 'ppintuanorder.order_id=order.order_id','LEFT')
                ->where($condition)
                ->select();
        if (!empty($ppintuanorder_list)) {
            foreach ($ppintuanorder_list as $key => $ppintuanorder) {
                $ppintuanorder_list[$key]['pintuanorder_state_text'] = $this->pintuanorder_state_array[$ppintuanorder['pintuanorder_state']];
                //参与者头像
                $ppintuanorder_list[$key]['pintuanorder_avatar'] = get_member_avatar_for_id($ppintuanorder['buyer_id']);
                $ppintuanorder_list[$key]['order_state_text'] = get_order_state($ppintuanorder);
            }
        }
        return $ppintuanorder_list;
    }

    /**
     * 获取拼团订单表列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getOnePpintuanorder($condition) {
        return db('ppintuanorder')->where($condition)->find();
    }

    /**
     * 增加拼团订单
     * @access public
     * @author csdeshang
     * @param type $data 参数内容
     * @return type
     */
    public function addPpintuanorder($data) {
        return db('ppintuanorder')->insertGetId($data);
    }

    /**
     * 编辑拼团订单
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $data 数据
     * @return type
     */
    public function editPpintuanorder($condition, $data) {
        return db('ppintuanorder')->where($condition)->update($data);
    }

}
