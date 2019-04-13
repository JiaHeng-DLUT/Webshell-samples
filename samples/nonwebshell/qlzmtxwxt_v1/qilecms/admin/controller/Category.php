<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
class Category extends Base
{
// 公共模块调用类
  protected  $pageNum = 10; //分类列表分页默认显示数量
  protected  $module;       //请求的模块名称
  protected  $table;        //数据库模型名称
  protected  $level;       //分类级别
  protected  $beforeActionList = [
        'getController',
    ];
  public function  getController(){

          $this->module  = strtolower(request()->controller());
          $this->table = $this->module.'Category';
  }
// 分类
public  function category(){ 
      
      if(!$this->module){  exit('非法访问！');} 

      //分类级别 
       
      $this->level['info_category'] =2;

      $alias = '';        //需要别名时写别名，不需要的时候留空
      $param = $this->request->param();
      //默认where
      if(!empty($param['pid'])){
         $pid = $param['pid'];
         $defaultWhere = "pid = '$pid'";
       }else{
         $defaultWhere = "pid = 0";
       }
      $defaultOrder = '';  //默认排序
    //接收搜索表单数据
      $SearchFormData = $this->getSearchFormData($defaultWhere,$defaultOrder);
      $where = $SearchFormData['where'];
      $order = $SearchFormData['order'];
      

//组建关键词数据
     $keywordsData  =[
                  [
                  'field'   =>'cid', //字段名
                  'name'    =>'分类ID', //文本显示名称
                  'alias'   => $alias,  //字段对应的别名
                  ],
                  [
                  'field'   =>'cname',
                  'name'    =>'分类名称',
                  'alias'   => $alias,
                  ]
     ];
//组建日期筛选   
       $dateData = [
                  [
                  'title'        =>'创建时间',  //标签显示名称
                  'field'        =>'create_time', //筛选字段
                  'start_name'   =>'开始时间', //开始时间
                  'end_name'     =>'结束时间', //结束时间
                  'alias'        => $alias,  //字段别名
                  ],

              ];
//单个字段筛选
    $customSingleField =[]; 
// 组件字段组筛选
     $groupData   = [];
     $orderData   = [];  

     $this->assign('keywordsData',$keywordsData);
     $this->assign('customSingleField',$customSingleField);
     $this->assign('groupData',$groupData);
     $this->assign('dateData',$dateData);
     $this->assign('orderData',$orderData);

       $list  = DB::name($this->table)->where($where)->order($order)->paginate($this->pageNum);
       $page  = $list->render();
       $lists = $list->toArray();
       $list  = $lists['data'];
       foreach($list as $k=> $v){  
             $pid = $v['cid'];
             $result = model('category')->getChildCategory($this->table,$pid);           
             $list[$k]['childrenNum'] = count($result);
       }

      $this->assign('page', $page);
      $this->assign('list', $list);
      $this->assign('type',$this->module);
    
      $this->assign('level',$this->level);
      $this->assign('module_id',$param['module_id']);
      $this->assign('module_dir',$param['module_dir']);
      return $this->fetch('category/index');
   }

   public  function categoryAdd(){
    if(!$this->module){  exit('非法访问！');} 
    $param = input();

    if($this->request->isPost()){
//验证
      $rule =[
        'cname'=>'require|chsAlpha|max:8',
        'alias'=>'require|alpha|max:30',
      ];
      $msg= [
       'cname.require'  =>'分类名称不能为空',
       'cname.chsAlpha' =>'分类名称只能是汉字或字母',
       'cname.max'      =>'分类名称不能超过8个字符',
       'alias.require'   =>'别名英文缩写名称不能为空',
       'alias.alpha'     =>'别名英文缩写必须为字母格式',
       'alias.max'       =>'别名不能超过30个字符',       
      ];
       $result = $this->checkSubmit($param,$rule,$msg);
       if($result){
            return error_json($result);
       }else{
           if(isset($param['status'])){
              $param['status'] =1;
           }

            $r = model('category')->isExistsCategoryName($this->table,$param['cname']);
            if(!empty($r)){
              return error_json('分类名已经存在');
            }
         $data['cname'] = $param['cname'];
         $data['alias'] = $param['alias'];
         $data['pid'] = $param['pid'];
         $data['seotitle'] = $param['seotitle'];
         $data['description'] = $param['description'];
         $data['keywords'] = $param['keywords'];
         $data['path'] = $param['path'];
         $data['list_template'] = $param['list_template'];
         $data['detail_template'] = $param['detail_template'];
         $data['sort'] = $param['sort'];  
         $data['status'] = $param['status'];
      
            
         $insertcid = model('category')->add($this->table,$data);
          if($insertcid){
            // 更新路径
             $data2['path']   = get_top_pid($this->table,$insertcid);
             $data2['cid']   = $insertcid;
             $data2['level']   = count(explode(',',$data2['path'])); 
              model('category')->edit($this->table,$data2);
            $this->updateCategoryCache();
            return success_json('分类添加成功');
           }else{
            return error_json('分类添加失败');
           }
         
       }
     

       
    }else{
       $cid = !empty($param['cid'])?$param['cid']:0;
       $list = model('category')->getCategory($this->table,$cid);
       $this->assign('type',$this->module);
       $this->assign('pid',$cid); //父类ID
       $this->assign('pname',$list['cname']); //父类名称

       $this->getCateTemplate(); //获得分类模板
       return $this->fetch('category/categoryAdd'); 
    }
    
   }
   public  function categoryEdit(){
 //分类表
     $param =  $this->request->param();  
       
    if($this->request->isPost()){
          if(!$this->module){  error_json('非法访问！');} 
//验证
      $rule =[
        'cname'=>'require|chsAlpha|max:8',
        'alias'=>'require|alpha|max:30',
      ];
      $msg= [
       'cname.require' =>'分类名称不能为空',
       'cname.chsAlpha' =>'分类名称只能是汉字或字母',
       'cname.max' =>'分类名称不能超过8个字符',
       'alias.require' =>'别名英文缩写名称不能为空',
       'alias.alpha' =>'别名英文缩写必须为字母格式',
       'alias.max' =>'别名名称不能超过30个字符',       
      ];
       $result = $this->checkSubmit($param,$rule,$msg);
       if($result){
         return error_json($result);
       }else{
         if(isset($param['status'])){
            $param['status'] =1;
         }
    
         $data['cid'] = $param['cid'];
         $data['cname'] = $param['cname'];
         $data['alias'] = $param['alias'];
         $data['pid'] = $param['pid'];
         $data['seotitle'] = $param['seotitle'];
         $data['description'] = $param['description'];
         $data['keywords'] = $param['keywords'];

         $data['list_template'] = $param['list_template'];
         $data['detail_template'] = $param['detail_template'];
         $data['sort'] = $param['sort'];  
         $data['status'] = $param['status'];
        $res =model('category')->edit($this->table,$data);

       
         if($res){
  
         $data2['cid']     = $param['cid'];
         $data2['path']    = get_top_pid($this->table,$param['cid']);
         $data2['level']   = count(explode(',',$data2['path']));
          model('category')->edit($this->table,$data2);

          $this->updateCategoryCache();
           return success_json('分类编辑成功');
         }else{
           return error_json('分类编辑失败');
         }
         
       }
     

       
    }else{
        
        $cid = !empty($param['cid'])?$param['cid']:0;
          $this->assign('type',$this->module);
     

        $category = model('category')->getCategory($this->table,$cid);

        $parentcategory = model('category')->getCategory($this->table,$category['pid']);
        $this->getCateTemplate(); //获得分类模板
        $this->assign('pid',$category['pid']); //父类名称
        $this->assign('pname',$parentcategory['cname']); //父类名称
        $this->assign('category',$category); //分类名称
        return $this->fetch('category/categoryEdit');
    }
   }
   public  function del(){
    if(!$this->module){  exit('非法访问！');} 

     $param = input();

     if(!$param['cid']){  return error_json('请求参数错误');    }

     $res = model('category')->del($this->table,$param['cid']);
     if(model('category')->error == NULL){
        $this->updateCategoryCache();
        return success_json('删除成功');
     }else{
        return error_json($res);
     }
   }

   public  function categoryUpdate(){

    if(!$this->module){  exit('非法访问！');} 


      if($this->request->isPost()){
         $param = $this->request->param();
         if(!is_null($param['status'])){
           $data['status'] = $param['status'];
         }
         
         if(!is_null($param['sort'])){
           $data['sort'] = $param['sort'];
         }
         $data['cid'] = $param['cid'];


         $res = model('category')->categoryUpdate($this->table,$data);

          $this->updateCategoryCache();
         return success_json('分类更新成功');

      }
   }


//生成分类缓存
   protected function updateCategoryCache(){
    if(!$this->module){  exit('非法访问！');} 
    //更新分类的缓存文件
     cache($this->table,NULL); //清空缓存
     $data = DB::name($this->table)->where('status = 1')->select(); 
     $this->setCache($this->table,'cid'); 


    }
//获得列表和内容模板
 protected function getCateTemplate()
 {    

    $where['type'] = 1;
    $where['status'] = 1;
    $defaultTheme = model('template')->infoData($where);



     $list_path = QL_ROOT.'template/pc/'.$defaultTheme['dirname'].'/'.$this->module.'/list/';
     $list_template = [];
       foreach(glob($list_path."*.html") as $k=>$v){
         $list_temp = str_replace($list_path,'',$v);
         $list_template[$k]['name'] = $this->module.'/list/'.$list_temp;
       }
       $this->assign('list_template',$list_template); //列表模板

     $detail_path = QL_ROOT.'template/pc/'.$defaultTheme['dirname'].'/'.$this->module.'/detail/';
     $detail_template = [];
       foreach(glob($detail_path."*.html") as $k=>$v){
       $detail_temp = str_replace($detail_path,'',$v);
         $detail_template[$k]['name'] = $this->module.'/detail/'.$detail_temp;
       }
       $this->assign('detail_template',$detail_template); //列表模板

 }
}