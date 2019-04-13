<?php

namespace app\common\model;

use think\Model;

class Storemoneylog extends Model {

    const TYPE_BILL=1;
    const TYPE_WITHDRAW=2;
    const TYPE_ADMIN=3;
    const TYPE_VERIFY=4;
    const TYPE_DEPOSIT_OUT=5;
    const TYPE_DEPOSIT_IN=6;
    
    const STATE_VALID=1;
    const STATE_WAIT=2;
    const STATE_AGREE=3;
    const STATE_REJECT=4;
    
    public $page_info;

    /**
     * 取提现单信息总数
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @return int
     */
    public function getStoremoneylogWithdrawCount($condition = array()) {
        return db('storemoneylog')->where(array('storemoneylog_type'=>self::TYPE_WITHDRAW))->where($condition)->count();
    }

    /**
     * 取得资金变更日志信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $fields 字段
     * @return array
     */
    public function getStoremoneylogInfo($condition = array(),$fields='') {

            $pdlog_list_paginate = db('storemoneylog')->where($condition)->field($fields)->find();
            return $pdlog_list_paginate;
    }
    /**
     * 取得资金变更日志信息
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $data 字段
     * @return array
     */
    public function editStoremoneylog($condition = array(),$data=array()) {

            $pdlog_list_paginate = db('storemoneylog')->where($condition)->update($data);
            return $pdlog_list_paginate;
    }
    /**
     * 取得资金变更日志列表
     * @access public
     * @author csdeshang
     * @param type $condition 条件
     * @param type $pagesize 页面信息
     * @param type $fields 字段
     * @param type $order 排序
     * @param type $limit 限制
     * @return array
     */
    public function getStoremoneylogList($condition = array(), $pagesize = '', $fields = '*', $order = '', $limit = '') {
        if ($pagesize) {
            $pdlog_list_paginate = db('storemoneylog')->where($condition)->field($fields)->order($order)->paginate($pagesize, false, ['query' => request()->param()]);
            $this->page_info = $pdlog_list_paginate;
            return $pdlog_list_paginate->items();
        } else {
            $pdlog_list_paginate = db('storemoneylog')->where($condition)->field($fields)->order($order)->limit($limit)->select();
            return $pdlog_list_paginate;
        }
    }


    /**
     * 变更资金
     * @access public
     * @author csdeshang
     * @param type $data
     * @return type
     */
    public function changeStoremoney($data = array()) {
        if(!isset($data['seller_id'])){
            exception(lang('param_error'));
        }
        $store_info=db('store')->where('store_id',$data['seller_id'])->field('store_avaliable_money,store_freeze_money,seller_name')->lock(true)->find();
        if(!$store_info){
            exception(lang('ds_store_is_not_exist'));
        }
        $data['seller_name']=$store_info['seller_name'];
        $store_data=array();
        if(isset($data['store_avaliable_money']) && $data['store_avaliable_money']!=0){
            if($data['store_avaliable_money']<0 && $store_info['store_avaliable_money']<abs($data['store_avaliable_money'])){//检查资金是否充足
                exception(lang('ds_store_avaliable_money_is_not_enough'));
            }
            $store_data['store_avaliable_money']=bcadd($store_info['store_avaliable_money'],$data['store_avaliable_money'],2);
        }
        if(isset($data['store_freeze_money']) && $data['store_freeze_money']!=0){
            if($data['store_freeze_money']<0 && $store_info['store_freeze_money']<abs($data['store_freeze_money'])){//检查资金是否充足
                exception(lang('ds_store_freeze_money_is_not_enough'));
            }
            $store_data['store_freeze_money']=bcadd($store_info['store_freeze_money'],$data['store_freeze_money'],2);
        }
        if(!empty($store_data)){
            if(!db('store')->where('store_id',$data['seller_id'])->update($store_data)){
                exception(lang('ds_store_money_adjust_fail'));
            }
        }
        $insert=db('storemoneylog')->insertGetId($data);
        if(!$insert){
            exception(lang('ds_store_money_log_insert_fail'));
        }
        return $insert;
    }



}
