<?php
namespace app\admin\controller;
use common\model;
use app\common\controller\Common; //跨模块调用 
use think\Validate;
use think\facade\Request;
use think\Auth;
use think\Db;
use think\Url;
use think\helper\Time;
class Base extends Common
{
    public  $auth;
//初始化
    public function initialize(){
           parent::initialize();
            if(!session('admin_uid')){ 
               //跳转前台首页，防止非法用户发现后台登陆入口
              $this->redirect('/');
           }
      
          include EXTEND_PATH.'Auth.php';
          $controller = $this->request->controller();
          $action     = $this->request->action();

         //管理权限授权检查
           $auth = new Auth();
           $name = strtolower($controller .'/'.$action);//通用匹配
           $arr= ['index/index'];  //默认后台首页不需要验证
           if(!in_array($name,$arr)){
               if(!$auth->check($name,session('admin_uid'))){
                  $this->error('抱歉，您暂无权限访问','',['url'=>$name]);
                }  
            }

         
         //获得登录用户的权限列表
        $this->auth = $auth;
        $this->assign('auth',$auth);
          if(session('admin_uid') == 1){
          //   //超级管理员拥有所有菜单权限
              $adminNav = model('admin_nav')->getNavTree("display =1");
          }else{
              //其他管理员
              $rulelist = $this->auth->getRoles(session('admin_uid'));
              $rules = $rulelist[0]['rules'];
              $where = "id in (".$rules.")  and  display =1 "; 
              $adminNav = model('admin_nav')->getNavTree($where);
          }
        
        
          $this->assign('adminNav',$adminNav); //授权列表

    }



 

  public function getSearchFormData($defaultWhere='',$defaultOrder='',$limit='10'){
           
        $order ='';
        if($this->request->isPost()){
            $param = $this->request->param();        //获得请求参数

            $post_order_name   = !empty($param['order']['name'])?$param['order']['name']:''; 
            $post_group        = !empty($param['group'])?$param['group']:'';     //字段分类筛选
            $post_SingleField  = !empty($param['SingleField'])?$param['SingleField']:''; //单个字段筛选

      //*************************************不需要修改的部分**开始******************************************
                   $where = 1;  //定义开始where
        
      //关键词筛选
                  $keywords = !empty($param['keywords'])?$param['keywords']:'';//获得关键词数据
                  if($param['keywords']['name']){
                    if($keywords['value']){
        
                         $where .= " and ".$keywords['name']." = '".$keywords['value']."'";
                    }  
                  }
         
      // 时间多字段筛选
                 $post_date = !empty($param['date'])?$param['date']:'';
                 if(is_array($post_date) && !empty($post_date)){
                        foreach($post_date as $k => $v){
                                            $start_time =  $v['start_time']; //开始时间
                                            $end_time   =  $v['end_time'];  //结束时间
                                            $field      =  $v['field'];     //数据库中需要筛选的字段名
                                            $alias      =  $v['alias'];      //字段别名
                                                // 判断别名是否存在
                                              if($alias){
                                                $alias_name = $alias.'.';
                                              }
                                           if($start_time && $end_time ==''){
                                            //筛选大于开始时间的数据
                                              $end_time = strtotime(date("Y-m-d",time()));
                                        
                                              $where   .= " and ".$alias_name.$field." >= '".strtotime($start_time)."'";
                                           }elseif($start_time == '' && $end_time){
                                            // 筛选小于结束时间的数据
                                              $start_time = strtotime(date("Y-m-d",time()));
                                              $where   .= " and ".$alias_name.$field." <= '".strtotime($end_time)."'";
                                           }elseif($start_time  && $end_time){
                                            // 筛选开始与结束时间之间的数据
                                              $where   .= " and ".$alias_name.$field." between '".strtotime($start_time)."' and '".strtotime($end_time)."'";  
                                           }
                                     }
   
                 }
               
      //字段组筛选条件创建
            if(is_array($post_group) && !empty($post_group)){
               foreach($post_group as $k =>$v){

                $field =$v[$v['field']];
                  if($field){
                         if($v['alias']){
                             $v['alias'] = $v['alias'].'.';
                         }
                  
                      $where.=  ' and '.$v['alias'].$v['field']." = '$field'" ;         
                  }

               }
          }
      //单字段筛选
            if(is_array($post_SingleField) && !empty($post_SingleField)){
         
              foreach($post_SingleField as $k=>$v){
                if($v['value'] != null){
                  if(empty($v['query'])){
                      if($v['alias']){
                         $v['alias'] =$v['alias'].'.';
                       }
                       $value = $v['value'];
                       $where .= ' and '.$v['alias'].$v['field']." = '$value'" ; 
                  }
                               
                }

               }
            }
         // 排序筛选
              if(!empty($post_order_name)){
                   $order .= $post_order_name;
                }
        }else{
            $where ='';
        }

  //********************************************************************************
   //默认where条件
          if(!empty($defaultWhere)){
             if($where){
                $where .=' and ';
             }
                $where .= $defaultWhere;
          }
        //默认排序
         if(!empty($defaultOrder)){
               if(!empty($order)){
                   $order .=','; 
               } 
                $order .= $defaultOrder; 
            }   
           
        return ['where'=>$where,'order'=>$order,'pageNum'=>$limit];
      //*************************************不需要修改的部分**结束******************************************
      }

//批删除数据
  protected function delData($model,$field,$request_field=""){
     $param = $this->request->param();
     if($this->request->isAjax()){
         if(empty($request_field)){
           $ids = $param[$field];
         }else{
           $ids = $param[$request_field];
         }

         if(empty($ids)){  
          return error_json('请求参数错误'); 
         }
         if(empty($model)){
          return error_json('请求模型错误');
         }

         $where[]= [$field,'IN',$ids];
         $res= model($model)->delData($where);
        
         if($res){
          return success_json('删除成功');
         }else{
          return error_json('删除失败');
         }     
     }

  }

}
