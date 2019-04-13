<?php
namespace app\common\model;
use think\Model;

class Nav extends Base
{
   protected $autoCheckFields = true;

  public  function getNavTree(){
   	 $order['id']   = 'asc';
   	 $order['sort'] = 'desc';
     $list = $this->order($order)->select()->toArray();
     return  list_to_tree($list,'id');
   }
//获得导航信息
  public function getNavInfo($where=""){
    $order = "sort desc";

    return $this->where($where)->order($order)->select()->toArray();
  }
   public function updateNav($post){
        if(empty($post) || !is_array($post) ){ 
          return false;
        }

        if($this->update($post)){
            return true;
        }else{
             return false;
      }

  }
 
}
