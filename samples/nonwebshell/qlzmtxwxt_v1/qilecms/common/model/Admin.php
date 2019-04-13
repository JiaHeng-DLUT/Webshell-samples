<?php
namespace app\common\model;
// 管理员表
class Admin extends Base
{
  protected $autoCheckFields = true;

  public function getAdminList(){
    $data = $this->select();
    return $data;
  }


//用于获取单个管理员信息
  public function getAdminInfo($where){
      $data = $this->where($where)->find();
      if($data){
        return $data;
      }else{
        return false;
      }
  }

    public function updateInfo($uid,$info){
      $where['uid'] = $uid;
      $this->where($where)->update($info);
    }




}
