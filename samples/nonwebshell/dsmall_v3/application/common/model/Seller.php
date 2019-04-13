<?php

namespace app\common\model;

use think\Model;

class Seller extends Model {
    

    /**
     * 登录时创建会话SESSION
     * @access public
     * @author csdeshang
     * @param type $member_info 会员信息
     * @param type $store_info 店铺信息
     * @param type $seller_info 卖家信息
     * @param type $seller_group_info 分组信息
     */
    public function createSellerSession($member_info,$store_info,$seller_info,$seller_group_info) {
        if (empty($member_info) || !is_array($member_info)) {
            return;
        }
        $member_gradeinfo = model('member')->getOneMemberGrade(intval($member_info['member_exppoints']));
        $member_info = array_merge($member_info, $member_gradeinfo);
        
        /* 此处卖家登录需要和买家登录 session 一致 createSession方法  BEGIN */
        session('is_login', '1');
        session('member_id', $member_info['member_id']);
        session('member_name', $member_info['member_name']);
        session('member_email', $member_info['member_email']);
        session('is_buy', $member_info['is_buylimit']);
        session('avatar', $member_info['member_avatar']);
        session('level', isset($member_info['level']) ? $member_info['level'] : '');
        session('level_name', isset($member_info['level_name']) ? $member_info['level_name'] : '');
        session('member_exppoints', $member_info['member_exppoints']);  //经验值
        session('member_points', $member_info['member_points']);        //积分值
        /* END */

        session('grade_id', $store_info['grade_id']); //店铺等级
        session('seller_id', $seller_info['seller_id']);
        session('seller_name', $seller_info['seller_name']);
        session('seller_is_admin', intval($seller_info['is_admin']));
        session('store_id', intval($seller_info['store_id']));
        session('store_name', $store_info['store_name']);
        session('is_platform_store', (bool) $store_info['is_platform_store']);
        session('bind_all_gc', (bool) $store_info['bind_all_gc']);
        session('seller_limits', isset($seller_group_info['sellergroup_limits']) ? explode(',', $seller_group_info['sellergroup_limits']) : '');
        if ($seller_info['is_admin']) {
            session('seller_group_name', '管理员');
            session('seller_smt_limits', false);
        } else {
            session('seller_group_name', isset($seller_group_info['sellergroup_name']) ? $seller_group_info['sellergroup_name'] : NULL);
            session('seller_smt_limits', isset($seller_group_info['smt_limits']) ? explode(',', $seller_group_info['smt_limits']) : '');
        }
        if (!$seller_info['last_logintime']) {
            $seller_info['last_logintime'] = TIMESTAMP;
        }
        session('seller_last_logintime', date('Y-m-d H:i', $seller_info['last_logintime']));
    }
 
    /**
     * 读取列表
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @param string $order 排序
     * @return array
     */
    public function getSellerList($condition, $order = '') {
        $result = db('seller')->alias('seller')->join('__MEMBER__ member', 'member.member_id = seller.member_id', 'LEFT')->field('seller.*,member.member_name')->where($condition)->order($order)->select();
        return $result;
    }

    /**
     * 读取单条记录
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return type
     */
    public function getSellerInfo($condition) {
        $result = db('seller')->where($condition)->find();
        return $result;
    }

    /**
     * 判断是否存在
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return boolean
     */
    public function isSellerExist($condition) {
        $result = $this->getSellerInfo($condition);
        if (empty($result)) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * 增加 
     * @access public
     * @author csdeshang
     * @param array $data 数据
     * @return bool
     */
    public function addSeller($data) {
        return db('seller')->insertGetId($data);
    }

    /**
     * 更新
     * @access public
     * @author csdeshang
     * @param array $update更新审数据
     * @param array $condition 条件
     * @return bool
     */
    public function editSeller($update, $condition) {
        return db('seller')->where($condition)->update($update);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param array $condition 条件
     * @return bool
     */
    public function delSeller($condition) {
        return db('seller')->where($condition)->delete();
    }

}
