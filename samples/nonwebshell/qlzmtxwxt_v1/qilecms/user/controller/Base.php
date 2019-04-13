<?php
namespace app\user\controller;
use app\common\controller\Common; //跨模块调用   
class Base  extends Common
{
  public function initialize()
    {
        parent::initialize();

    }
   //判断用户是否登陆
  protected function isLogin(){
    if(!session('uid')){
      return $this->redirect('@user/login');
    }
   }
//批删除数据
  protected function delData($model,$field){
     $param = $this->request->param();
     if($this->request->isAjax()){
         $ids = $param[$field];
         if(empty($ids)){  
          return error_json('请求参数错误'); 
         }
         if(empty($model)){
          return error_json('请求模型错误');
         }
         $where[]= [$field,'IN',$param[$field]];
         $res= model($model)->delData($where);
         if($res){
          return success_json('删除成功');
         }else{
          return error_json('删除失败');
         }     
     }

  }
}