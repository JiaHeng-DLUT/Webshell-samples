<?php
namespace app\admin\controller;
use think\controller;
class TemplateMobile extends Base
{
	public function index(){
		$path = QL_ROOT."template/mobile/";
		$dir = glob($path.'*/');
         $uninstall = [];
		 foreach($dir as $k=>$v){
          $config_dir = $v.'config.xml';  //配置目录
            if(is_file($config_dir)){
            	$dirname                  = str_replace([$path,'/'],'',$v);
              $xml                      = file_get_contents($config_dir);
              $arr                      = xml_to_array($xml);
      			  $uninstall[$k]            = xml_to_array($xml);
      			  $uninstall[$k]['dirname'] = $dirname;  //目录名称
              $where['dirname']         = $dirname;
              $where['type']            = 2; //移动端
      			  $res = model('template')->infoData($where);
      			  $uninstall[$k]['status']  =  $res['status'];
              $uninstall[$k]['thumb']   =  $res['thumb'];
      			  $uninstall[$k]['id']      =  $res['id'];
            }
		   }


        $this->assign('uninstall',$uninstall);
	    	return $this->fetch();
	}

	public function install(){
       $param = $this->request->param();
       if(!$param['dirname']){ error_json('参数错误！');}
       $path = QL_ROOT."template/mobile/";
       if(is_file($path.$param['dirname'].'/config.xml')){
          $xml = file_get_contents($path.$param['dirname']."/config.xml"); 
          $arr = xml_to_array($xml);
          $data['name']         = $arr['name'];
          $data['dirname']      = $param['dirname'];
          $data['author']       = $arr['author'];
          $data['copyright']    = $arr['copyright'];
          $data['thumb']        = '/template/mobile/'.$param['dirname'].'/cover.png';
          $data['create_time']  = time();
          $data['type']         = 2; //移动端
          
          $where['dirname']     = $data['dirname'];
          $where['type']        = $data['type'];
          if(model('template')->infoData($where)){
          	return error_json('已经安装，请勿重复安装'); 
          }
          model('template')->addData($data);
           return success_json('安装成功');
       }else{
       	  return  error_json('模板配置文件缺失');
       }
      
	}

	public function uninstall(){
       $param = $this->request->param(); 
       if(empty($param)){
         return error_json('请求参数错误');
       }
          $where['id'] = intval($param['id']);
          model('template')->delData($where);
          return success_json('卸载成功');
 
      
	}
	public function open(){
         $param = $this->request->param();
          $data['status'] = 1;
          $where['id'] = $param['id'];
          $where['type']   = 2;
          model('template')->editData($data,$where);
          

          $data2['status'] = 0;
          $where2[]  = ['id','neq',$param['id']];
          $where2[]  = ['type','=',2];
          model('template')->editData($data2,$where2);


          $map['status'] = 1;
          $map['type']   = 2;  //移动端
          $DefaultTheme = model('template')->infoData($map);
          cache('template',$DefaultTheme); //生成PC端缓存
          return success_json('模板启用成功');
  	}	

}