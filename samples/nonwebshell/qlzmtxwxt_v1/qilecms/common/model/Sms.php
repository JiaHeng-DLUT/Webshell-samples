<?php
namespace app\common\model;
use think\Model;

class Sms extends Base
{
   protected $autoCheckFields = true;

 //通过ID获得信息
   public function getSmsById($id){
   	 $where['id'] = $id;
     return $this->where($where)->find();
    }

   public function getSmsAll(){
     $where['status'] =1;
     return $this->where($where)->select();
   }



}
