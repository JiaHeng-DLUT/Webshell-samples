<?php
namespace app\common\model;
class Ad extends Base
{
   protected $autoCheckFields = true;
   public function getAdInfo($ad_id){
   	 $where['ad_id'] = $ad_id;
     return $this->where($where)->find();
    }
   public function getCountAdByPositionId($position_id){
   	 $where['position_id'] = $position_id;
     return $this->where($where)->count(); 
   }
}
