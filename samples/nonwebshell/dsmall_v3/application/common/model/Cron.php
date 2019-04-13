<?php

namespace app\common\model;

use think\Model;

class Cron extends Model {
    


    /**
     * 取单条任务信息
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @return type
     */
    public function getCronInfo($condition = array()) {
        return db('cron')->where($condition)->find();
    }
    /**
     * 任务队列列表
     * @access public
     * @author csdeshang 
     * @param array $condition 检索条件
     * @param number $limit 数目限制
     * @return array
     */
    public function getCronList($condition, $limit = 100) {
        return db('cron')->where($condition)->limit($limit)->select();
    }
    
    /**
     * 保存任务队列
     * @access public
     * @author csdeshang 
     * @param unknown $data 参数内容
     * @return array
     */
    public function addCronAll($data) {
        return db('cron')->insertAll($data);
    }
    
    /**
     * 保存任务队列
     * @access public
     * @author csdeshang
     * @param array $data 参数内容
     * @return boolean
     */
    public function addCron($data) {
        return db('cron')->insert($data);
    }
    
    /**
     * 删除任务队列
     * @access public
     * @author csdeshang 
     * @param array $condition 条件
     * @return array
     */
    public function delCron($condition) {
        return db('cron')->where($condition)->delete();
    }
    
}

?>
