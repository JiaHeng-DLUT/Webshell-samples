<?php
namespace app\common\model;
class Friendlink extends Base
{
   protected $autoCheckFields = true;

 //通过ID获得信息
   public function getFriendlinkByFid($fid){
   	 $where['fid'] = $fid;
     return $this->where($where)->find();
    }

}
