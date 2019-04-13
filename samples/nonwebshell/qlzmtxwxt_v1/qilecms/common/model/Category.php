<?php
namespace app\common\model;
use think\Model;
use think\Cache;
use think\Db;
class Category extends Base
{

   protected $autoCheckFields = true;
   public $error = NULL;
   public function isExistsCategoryName($table,$cname){
    $where['cname'] =$cname;
    return $list = DB::name($table)->where($where)->find();
   }
   public  function getCategory($table,$cid){
             $where['cid'] = $cid;
      return $list = DB::name($table)->where($where)->find();

   }
   public  function getChildCategory($table,$pid){
    //获得子分类
             $where['pid'] = $pid;
      return $list = DB::name($table)->where($where)->select();

   }
   public function add($table,$data){
   
   	    if(empty($data) || !is_array($data) ){ 
   	    	return false;
   	    }

        $res = DB::name($table)->insertGetId($data);
        if($res){
            return $res;
        }else{
	    	    return false;
	    }
 

  }

//获得当前分类的所有分类
//三级分类
  public function getCategoryCid($table,$cid){
     $where['cid'] = $cid;
     $one = DB::name($table)->field('cid,pid')->where($where)->find();
     if($one['pid'] != 0){
       $where2['cid'] =$one['pid'];
       $two =  DB::name($table)->field('cid,pid')->where($where2)->find();
       if($two['pid'] != 0){
          $where3['cid'] = $two['pid'];
          $three =  DB::name($table)->field('cid,pid')->where($where2)->find();
          return $cid.','.$two['cid'].','.$three['cid'];
       }else{
         return $cid.','.$one['cid'];
       }
     }else{
        return $cid;
     }

  }

   public function categoryUpdate($table,$data){
        if(empty($data) || !is_array($data) ){ 
          return false;
        }
        $where['cid']  = $data['cid'];
        if(DB::name($table)->update($data)){
             return true;
        }else{
             return false;
      }
 
  }
   public function edit($table,$data=[]){
      
        if(empty($data) || !is_array($data) ){ 
          return false;
        }
        $where['cid'] = $data['cid'];
        DB::name($table)->where($where)->update($data);
        return true;
     
 
  }
   public function del($table,$cid){
      
      if(is_array($cid)){

           $cid_data = implode(',',$cid);

           foreach($cid as $v){
             //检查是否有下级分类
              $child = model('category')->getChildCategory($table,$v);
              $children = obj_to_array($child);
              if(!empty($children)){
                 model('category')->error = '该分类含有子类，不能直接删除，请先删除子分类';
              }  
           }
      }else{
                 //检查是否有下级分类
          $child = model('category')->getChildCategory($table,$cid);
          $children = obj_to_array($child);
          if(!empty($children)){
            model('category')->error = '该分类含有子类，不能直接删除，请先删除子分类';
          }  
          $cid_data =$cid;  
      }
     
     if(model('category')->error != ""){
        return model('category')->error;
     }
     $res = DB::name($table)->where("cid",'in',$cid_data)->delete();
  
   }



}
