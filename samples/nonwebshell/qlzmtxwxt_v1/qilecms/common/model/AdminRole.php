<?php
namespace app\common\model;
class AdminRole extends Base
{

   protected $autoCheckFields = true; 
   public $error = '';
   public function getAdminRoleInfoById($id){
     $where['role_id'] = $id;
     return $this->where($where)->find();
    }

   public function getAdminRoleList(){
     $where['status'] = 1;
     return $this->where($where)->select();
    }

   public function delData($pk,$id){
      if(is_array($id)){
          if(!in_array('1',$id)){
              $idData = implode(',',$id);
          }else{
            $this->error = "超级管理员禁止删除";
          }
      }else{
        if($id != '1'){
           $idData = $id;
        }else{
          $this->error = "超级管理员禁止删除";
        }
      }  
     $res = $this->where($pk,'in',$idData)->delete();
     return $this->error;

  }  

}
