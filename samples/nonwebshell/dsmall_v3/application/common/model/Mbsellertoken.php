<?php

/**
 * 手机端买家令牌模型
 */

namespace app\common\model;

use think\Model;

class Mbsellertoken extends Model {
    
/**
     * 查询
     * @access public
     * @author csdeshang
     * @param array $condition 查询条件
     * @return array
     */
    public function getMbsellertokenInfo($condition) {
        return db('mbsellertoken')->where($condition)->find();
    }
    
    /**
     * 获取卖家令牌
     * @access public
     * @author csdeshang
     * @param type $token 令牌
     * @return type
     */
    public function getMbsellertokenInfoByToken($token) {
        if (empty($token)) {
            return null;
        }
        return $this->getMbsellertokenInfo(array('seller_token' => $token));
    }

    /**
     * 新增
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return bool 布尔类型的返回结果
     */
    public function addMbsellertoken($data) {
        return db('mbsellertoken')->insertGetId($data);
    }

    /**
     * 删除
     * @access public
     * @author csdeshang
     * @param int $condition 条件
     * @return bool 布尔类型的返回结果
     */
    public function delMbsellertoken($condition) {
        return db('mbsellertoken')->where($condition)->delete();
    }
    
    
}