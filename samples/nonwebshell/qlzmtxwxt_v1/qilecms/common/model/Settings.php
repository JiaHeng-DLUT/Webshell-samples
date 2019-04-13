<?php
namespace app\common\model;
use think\Model;

class Settings extends Base
{
   // Protected $autoCheckFields = true;

   public  function getSettings(){

     $list = $this->select();

     $data = [];

     // foreach($list as $k=>$v){
     //       if(!empty($v['value'])){

     //          $value = unserialize($v['value']);
     //       }else{
     //          $value ='';
     //       }
     //         $data[$v['groupname']] = $value;

     // }

     return $data;
   }

   public function addSettings($groupname,$post){
          $data = serialize($post);
          $this->groupname = $groupname;
          $this->value= $data;
             if($this->save()){
                return true;
             }else{
                return false;
             }
  
  }

   public function updateSettings($groupname,$post){
         $data = serialize($post);
         if($this->where('groupname',$groupname)->find()){
            if($this->where('groupname',$groupname)->update(['value' => $data])){
              return true;
            }else{
              return false;
            }
         }else{

             if($this->addSettings($groupname,$post)){
               return true;
             }else{
               return false;
             }
         }

  }


}
