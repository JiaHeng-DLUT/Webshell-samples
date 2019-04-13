<?php
namespace app\common\model;
class User extends Base
{

  protected $autoCheckFields = true;
//用于获取单个会员信息
  public function getUserInfo($where){
      $data = $this->where($where)->limit(1)->find();
      if($data){
        return $data;
      }else{
        return false;
      }
  }
//获得用户列表
  // public function 
  public function getUserByUsername($username){
    $data = $this->where("username =  '$username'")->find();
    return $data;
  }

  public function getUserByUid($uid){
     $where =[
      'uid'=>$uid 
      ];
      $data = $this->where($where)->find();
      return $data;
  }

    public function updateInfo($uid,$info){
      $where['uid'] = $uid;
      $this->where($where)->update($info);
    }


}
