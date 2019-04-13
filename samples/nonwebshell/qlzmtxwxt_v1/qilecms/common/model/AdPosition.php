<?php
namespace app\common\model;
use think\Model;

class AdPosition extends Base
{
   protected $autoCheckFields = true;
   //通过ID获得信息
   public function getAdPositionById($position_id){
   	 $where['position_id'] = $position_id;
     return $this->where($where)->find();
    }
//获得所有信息
   public function getAdPosition($where="",$order="",$limit=""){
     return $this->where($where)->order($order)->limit($limit)->select();
   }

}
