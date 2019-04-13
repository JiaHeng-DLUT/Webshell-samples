<?php
namespace app\common\model;
use think\Model;
class Info extends Base
{
   protected $autoCheckFields = true;

 //通过ID获得信息
   public function getInfoById($id){
   	 $where['id'] = $id;
     return $this->where($where)->find();
    }


}
