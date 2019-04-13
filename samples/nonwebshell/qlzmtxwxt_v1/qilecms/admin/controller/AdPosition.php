<?php
namespace app\admin\controller;
use think\Db;
class AdPosition extends Base
{
   

	public function index(){
      $param = $this->request->param();

      $module_id = $param["module_id"];
    
      $alias = '';        //需要别名时写别名，不需要的时候留空 
      if(!empty($module_id)){
      $defaultWhere = 'position_cate_id = "$module_id"';  //默认where
      }

      $defaultOrder = 'position_id desc';  //默认排序
    //接收搜索表单数据
      $SearchFormData = $this->getSearchFormData($defaultWhere,$defaultOrder);
      $where   = $SearchFormData['where'];
      $order   = $SearchFormData['order'];
      $pageNum = $SearchFormData['pageNum'];

//组建关键词数据
     $keywordsData  =[
                  [
                  'field'   =>'position_name', //字段名
                  'name'    =>'名称', //文本显示名称
                  'alias'   => $alias,  //字段对应的别名
                  ],
                   [
                  'field'   =>'position_id', //字段名
                  'name'    =>'广告位ID', //文本显示名称
                  'alias'   => $alias,  //字段对应的别名
                  ]
     ];
//组建日期筛选   
       $dateData = [];
//单个字段筛选
    $customSingleField =[
                            [
                             'name'=>'审核状态',
                             'field' => 'status', 
                             'data'  => [ 0 =>'关闭',1=>'开启',],
                             'alias'=>$alias,
                            ]
                       ]; 
// 组件字段组筛选
    $groupData = [];
     $orderData   = [];  

     $this->assign('keywordsData',$keywordsData);
     $this->assign('customSingleField',$customSingleField);
     $this->assign('groupData',$groupData);
     $this->assign('dateData',$dateData);
     $this->assign('orderData',$orderData);




     $lists = DB::name('ad_position')->where($where)->order($order)->paginate($pageNum);
     $page = $lists->render();
     $list = $lists->toArray()['data'];
     foreach($list as $k=>$v){
        $ad_num = model('ad')->getCountAdByPositionId($v['position_id']);
         $list[$k]['ad_num']= $ad_num;
     }
    
     $this->assign('page', $page);
     $this->assign('list',$list);


     return $this->fetch();
	}
// //增加
  public function add(){
    $param = $this->request->param(); 
    if($this->request->isPost()){   

        //验证
        $rule =[
          'position_name'=>'require',
        ];
        $msg= [
         'position_name.require' =>'广告位置名称不能为空',
 
        ];
         $error = $this->checkSubmit($param,$rule,$msg);  
       if($error){
              return error_json($error);
         }
         //表单数据
          $data['position_name']  = $param['position_name'];
          $data['position_cate_id'] = $param['position_cate_id'];
          $data['position_type'] = $param['position_type'];
          $data['position_width'] = $param['position_width'];
          $data['position_height'] = $param['position_height'];
          $data['position_desc'] = $param['position_desc'];
          $data['status'] = !empty($param['status'])?1:0;

       if(model('ad_position')->addData($data)){
         return success_json('添加成功'); 
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
          'position_name'=>'require',
        ];
        $msg= [
         'position_name.require' =>'广告位置名称不能为空',
 
        ];
         $error = $this->checkSubmit($param,$rule,$msg);  
       if($error){
              return error_json($error);
         }
    
        //表单数据       
          $data['position_name'] = $param['position_name'];
          $data['position_cate_id'] = $param['position_cate_id'];
          $data['position_type'] = $param['position_type'];
          $data['position_width'] = $param['position_width'];
          $data['position_height'] = $param['position_height'];
          $data['position_desc'] = $param['position_desc'];
          $data['status'] = !empty($param['status'])?1:0;
          $where['position_id'] = $param['position_id'];
          $res = model('AdPosition')->editData($data,$where);
          // echo  model('AdPosition')->getLastSql();
          return success_json('编辑成功'); 
    }else{
      
         $AdPosition = model('AdPosition')->getAdPositionById($param['position_id']);
         
         $this->assign('AdPosition',$AdPosition);

         return $this->fetch();


    }  
  }
  public function del(){
      $param =$this->request->param();
     if(!$param['position_id']){  return error_json('请求参数错误');    }

      $position_id = $param['position_id'];
     
     if(is_array($position_id)){
       $ids = implode(',',$position_id);
     }else{
       $ids = $position_id;
     }  
     $where[]= ['position_id','in',$ids];
     //删除广告位下的所广告
     $res1= model('ad')->delData($where);
     if($res1){
           $res= model('AdPosition')->delData($where);
             if($res){
               return success_json('删除成功');
             }else{
               return error_json($res);
             }
     }

    }
      
 
}