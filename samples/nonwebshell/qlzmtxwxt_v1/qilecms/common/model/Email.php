<?php
namespace app\common\model;
use think\Model;

class Email extends Base
{
   protected $autoCheckFields = true;

 //通过ID获得信息
   public function getEmailById($id){
   	 $where['id'] = $id;
     return $this->where($where)->find();
    }


}
