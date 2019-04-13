<?php
namespace app\common\model;
use think\Model;

class AdminNav extends Base
{
   protected $autoCheckFields = true;
   public  function getNavTree($where=''){

        $order['sort'] = 'desc';
        $order['create_time'] = 'asc';
        $list = $this->where($where)->order($order)->select()->toArray();
        return list_to_tree($list);
  
   }
  public function getAdminNavInfoByTitle($title){
        $where['title'] = $title;
       return   $this->where($where)->find();
   }
  public function getAdminNavInfoById($id){
     $where['id'] = $id;
     return $this->where($where)->find();
  }

   public function add($data){
   	   if(empty($data) || !is_array($data)){ 
   	    	return false;
   	    }
        return $this->data($data)->save();
    
  }
  public function edit($data,$where){
      if(empty($data) || !is_array($data)){ 
          return false;
        }
      return $this->save($data,$where);
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
   public function del($id)
    {
     $param = $this->request->param();
     if($this->request->isAjax()){
       if(!$param['id']){  return error_json('请求参数错误');    }
       //判断是否子类
       $map[] = ['pid','IN',$param['id']];
       $adminNav = model('adminNav')->listData($map);
       if(!empty($adminNav)){
        return success_json('请先删除下级导航');
       }
       return $this->delData('adminNav',"id");
   
    }
  }
 

}
