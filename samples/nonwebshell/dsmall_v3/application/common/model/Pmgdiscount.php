<?php

namespace app\common\model;

use think\Model;

class Pmgdiscount extends Model {

    public function getPmgdiscountInfoByGoodsInfo($goods_info) {
        //判断店铺是否开启会员折扣
        $store = db('store')->where('store_id',$goods_info['store_id'])->find();
        if($store['store_mgdiscount_state'] != 1){
            return ;
        }
        //判断套餐时间
        $mgdiscountquota_model = model('pmgdiscountquota');
		if($store['is_platform_store']!=1){//非自营店就需要检查是否购买了套餐
        $current_mgdiscount_quota = $mgdiscountquota_model->getMgdiscountquotaCurrent($goods_info['store_id']);
        if(empty($current_mgdiscount_quota) || $current_mgdiscount_quota['mgdiscountquota_endtime']<TIMESTAMP){
            return ;
        }
		}
        //查看此商品是否单独设置了折扣
        if($goods_info['goods_mgdiscount'] != ''){
            return unserialize($goods_info['goods_mgdiscount']);
        }
        //当店铺设置了店铺会员等级折扣
        if($store['store_mgdiscount'] != ''){
            return unserialize($store['store_mgdiscount']);
        }
        return;
    }

}
