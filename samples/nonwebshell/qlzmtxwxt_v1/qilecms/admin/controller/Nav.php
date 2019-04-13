<?php
namespace app\admin\controller;
use app\admin\controller\Common;
class Nav extends Base
{

  public function index(){
//显示导航
    $Nav =  model('Nav');
    $list  = $Nav->getNavTree();
    $this->assign('list',$list);
    return $this->fetch();

  } 


	public function add()
    {
     $param = $this->request->param();


     if($this->request->isPost()){  
        //验证
        $rule =[
          'name'=>'require',
        ];
        $msg= [
          'name.require' =>'导航名称不能为空',  
        ];
         $error = $this->checkSubmit($param,$rule,$msg);  
       if($error){
             return error_json($error);
         }
         //判断是否存在相同导航
       $map['name'] = $param['name']; 
       if(model('nav')->infoData($map)){
          return error_json('导航名称已经存在');    
       }


         //表单数据
          $data['name'] = $param['name'];
          $data['url'] = $param['url'];
          $data['icon'] = $param['icon'];
          $data['pid'] = $param['pid'];
          $data['sort'] = $param['sort'];
          $data['create_time'] = time();
          $data['status'] = !empty($param['status'])?1:0;
       if($res = model('nav')->addData($data)){
        $data['id'] =$res->id;
         return success_json('添加成功',$data); 
        }
        
      }else{
        return $this->fetch();    
      }
	}
  public function edit(){
     $param = $this->request->param();
    if($this->request->isPost()){

         //验证
        $rule =[
          'name'=>'require',
        ];
        $msg= [
         'name.require' =>'导航标题不能为空',  
        ];
         $error = $this->checkSubmit($param,$rule,$msg);  
       if($error){
             return error_json($error);
         }
         //表单数据
          $data['name'] = $param['name'];
          $data['url'] = $param['url'];
          $data['icon'] = $param['icon'];
          $data['pid'] = $param['pid'];
          $data['sort'] = $param['sort'];
          $data['create_time'] = time();
          $data['status'] = !empty($param['status'])?1:0;

          $where['id'] = inval($param['id']);
          $res = model('nav')->editData($data,$where);
          return success_json('编辑成功'); 
    }else{
         $adminNav = model('nav')->getAdminNavInfoById($where['id']);
         $this->assign('nav',$nav);
         return $this->fetch();


    }  
  }
  public function update()
    {
      if($this->request->isAjax()){
         $param =$this->request->param();
       
      
          // $where['id'] = intval($param['id']);

          if(model('nav')->updateNav($param)){
            return success_json('菜单更新成功');
          }else{
            return error_json('菜单更新失败');
          }

        //   if(!empty($param['icon'])){
        //     $data['icon'] = $param['icon'];
        //   }
        //   if(!empty($param['name'])){
        //      $data['name'] = $param['name']; 
        //   }
        //   if(!empty($param['pid'])){
        //      $data['pid'] = $param['pid']; 
        //   }
        //    if(!empty($param['sort'])){
        //      $data['sort'] = $param['sort']; 
        //   } 
        //    if(!empty($param['url'])){
        //      $data['url'] = $param['url']; 
        //   }
        //   $target =$param['target'];
        //   $status =$param['status'];
        //   $is_wap =$param['is_wap'];

        // if(!is_null($target)){
        //        if($target ==1){
        //       $data['target'] = 1;
        //    }elseif($target == 0){
        //       $data['target'] = 0;
        //    }      
          
        //   }
        //   if(!is_null($status)){
        //        if($status ==1){
        //       $data['status'] = 1;
        //    }elseif($status == 0){
        //       $data['status'] = 0;
        //    }      
          
        //   }
     
        //  if(!is_null($is_wap)){

        //      if($is_wap ==1){
        //           $data['is_wap'] = 1;
        //        }elseif($is_wap == 0){
        //           $data['is_wap'] = 0;
        //        }      
        //     }
     
  

         // $Nav =model('Nav')->editData($data,$where);

         //  if($Nav){
         //     return success_json('菜单更新成功');
         //  }
      }
     

  }

  public function del()
    {
     $param = $this->request->param();
       if($this->request->isAjax()){
         if(!$param['id']){  return error_json('请求参数错误');    }
         //判断是否子类
         $map[] = ['pid','IN',$param['id']];
         $nav = model('nav')->infoData($map);
         if(!empty($nav)){
          return error_json('请先删除子导航');
         }
         return $this->delData('nav',"id");
       }

   
    }


}
