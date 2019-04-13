<?php
namespace app\common\model;
class Notice extends Base
{
   protected $autoCheckFields = true;

 //通过ID获得信息
   public function getNoticeById($id){
   	 $where['id'] = $id;
     return $this->where($where)->find();
    }

}
