<?php
namespace app\common\model;
class AdminRoleAccess extends Base
{
   // protected $autoWriteTimestamp = true;
 
   public function getAdminRoleId($uid){
     $where['uid'] = $uid;
     return $this->field('role_id')->where($where)->find();
    }


}
