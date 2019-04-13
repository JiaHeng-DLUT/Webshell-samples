<?php

/**
 * 拼团活动模型 
 *
 */

namespace app\common\model;

use think\Model;

class Ppintuangroup extends Model {

    public $page_info;
    const PINTUANGROUP_STATE_CLOSE = 0;
    const PINTUANGROUP_STATE_NORMAL = 1;
    const PINTUANGROUP_STATE_SUCCESS = 2;

    private $pintuangroup_state_array = array(
        self::PINTUANGROUP_STATE_CLOSE => '拼团取消',
        self::PINTUANGROUP_STATE_NORMAL => '参团中',
        self::PINTUANGROUP_STATE_SUCCESS => '拼团成功'
    );

    /**
     * 获取开团表列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $page 分页
     * @param type $order 排序
     * @return type
     */
    public function getPpintuangroupList($condition, $page = '',$order='pintuangroup_starttime desc') {
        $filed = "ppintuangroup.*,member.member_name";
        if ($page) {
            $result = db('ppintuangroup')->alias('ppintuangroup')->join('__MEMBER__ member','ppintuangroup.pintuangroup_headid=member.member_id')->field($filed)->where($condition)->order($order)->paginate($page, false, ['query' => request()->param()]);
            $this->page_info = $result;
            $ppintuangroup_list = $result->items();
        }else{
            $ppintuangroup_list =  db('ppintuangroup')->alias('ppintuangroup')->join('__MEMBER__ member','ppintuangroup.pintuangroup_headid=member.member_id')->field($filed)->where($condition)->order($order)->select();
        }
        if (!empty($ppintuangroup_list)) {
            foreach ($ppintuangroup_list as $key => $ppintuangroup) {
                //此拼团发起活动剩余还可购买的份额
                $pintuangroup_surplus = $ppintuangroup['pintuangroup_limit_number'] - $ppintuangroup['pintuangroup_joined'];
                $ppintuangroup_list[$key]['pintuangroup_state_text'] = $this->pintuangroup_state_array[$ppintuangroup['pintuangroup_state']];
                $ppintuangroup_list[$key]['pintuangroup_surplus'] = $pintuangroup_surplus;
                $ppintuangroup_list[$key]['pintuangroup_avatar'] = get_member_avatar_for_id($ppintuangroup['pintuangroup_headid']);
            }
        }
        return $ppintuangroup_list;
    }
    /**
     * 获取单个单团信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getOnePpintuangroup($condition){
        return db('ppintuangroup')->where($condition)->find();
    }
    
    /**
     * 插入拼团开团表
     * @access public
     * @author csdeshang
     * @param type $data 参数数据
     * @return type
     */
    public function addPpintuangroup($data)
    {
        return db('ppintuangroup')->insertGetId($data);
    }
 
    /**
     * 编辑拼团开团表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $data 数据
     * @return type
     */
    public function editPpintuangroup($condition,$data)
    {
        return db('ppintuangroup')->where($condition)->update($data);
    }
    
    /**
     * 拼团成功,拼团订单信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     */
    public function successPpintuangroup($condition)
    {
        //更新拼团开团信息
        $update_group['pintuangroup_state'] = 2;
        $update_group['pintuangroup_endtime'] = TIMESTAMP;
        $this->editPpintuangroup($condition, $update_group);
        //更新拼团订单信息
        $update_order['pintuanorder_state'] = 2;
        model('ppintuanorder')->editPpintuanorder($condition,$update_order);
    }
 
    /**
     * 拼团成功,拼团订单信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type 
     */
    public function failPpintuangroup($condition)
    {
        //更新拼团开团信息
        $update_group['pintuangroup_state'] = 0;
        $update_group['pintuangroup_endtime'] = TIMESTAMP;
        $this->editPpintuangroup($condition, $update_group);
        //更新拼团订单信息
        $update_order['pintuanorder_state'] = 0;
        model('ppintuanorder')->editPpintuanorder($condition,$update_order);
    }
  
    /**
     * 拼团状态数组
     * @access public
     * @author csdeshang
     * @return type
     */
    public function getPintuangroupStateArray() {
        return $this->pintuangroup_state_array;
    }
    
}
