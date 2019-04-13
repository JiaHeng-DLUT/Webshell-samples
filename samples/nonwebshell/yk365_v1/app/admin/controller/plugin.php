<?php
/****************优客365网址导航系统 商业版********************/
/*                                                            */
/*  Youke365.site (C)2019 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航商业版 ，如未授权商用，侵犯知识产权必究    */
/*  2019.3                                                    */
/*  官方网址：http://www.youke365.site                        */
/*  官方论坛：http://bbs.youke365.site                        */                           
/**************************************************************/
if (!defined('IN_YOUKE365')) exit('Access Denied');
include APP_PATH.__MODULE__.'/base.php';
$pageurl = url('plugin');
$tempfile = 'plugin.html';
$table = table('plugin');

$pagesize = 3;
if (empty($action)) $action = 'list';

/** list */
if ($action == 'list') {
// 扩展目录说明  
// app 应用程序目录，install 扩展安装目录 info.php 插件信息配置
// 

		$cfg = get_options();
		// 获得所有PC模板

  
		if(is_dir(PLUGIN_PATH)){
            
            //获得所有插件
            //
			$total_list = glob(PLUGIN_PATH.'*');
		    
		  
		    $list = [];
     
		    $common_list = array_slice($total_list,$curpage-1,$pagesize);
		

			foreach($common_list as $k=>$plugin_path){
   
				if(is_file($plugin_path.'/info.php')){
                  $data = require $plugin_path.'/info.php';  //读取插件信息文件
                  $list[$k]['config']  = require $plugin_path.'/config.php';//读取配置文件

				    $list[$k]['name']        = $data['name'];
			      $list[$k]['directory']   = str_replace([PLUGIN_PATH,'/'],'',$plugin_path);
			      $list[$k]['author']      = !empty($data['author'])?$data['author']:'';
			      $list[$k]['version']     = !empty($data['version'])?$data['version']:'';
			      $list[$k]['description'] = !empty($data['description'])?$data['description']:'';
			      $list[$k]['website']     = !empty($data['website'])?$data['website']:'';
			      $list[$k]['is_admin']    = !empty($data['is_admin'])?$data['is_admin']:0;
            $list[$k]['doc_url']     = !empty($data['doc_url'])?$data['doc_url']:'';
                  $list[$k]['has_config']  = !empty($data['has_config'])?$data['has_config']:0;
			      
                  $directory = $list[$k]['directory'];

			      $plugin_info = $Db->query("select * from ".$table." where  directory = '$directory' limit 1");
			 
			      if(!empty($plugin_info)){
			      	   $list[$k]['status']  = $plugin_info[0]['status'];
                       $list[$k]['id']  = $plugin_info[0]['id'];
                       
			      }
                
			     

			       $list[$k]['admin_menu'] = '';

				}
				
			}
          
			$Youke->assign('list', $list);
		}

$total    = count($total_list);

$showpage = showpage($pageurl, $total, $curpage, $pagesize);

$Youke->assign('showpage', $showpage);
Youke_display($tempfile);

}elseif($action == 'config'){
    
        if(isAjax()){
//数据保存
           if(!I('id')){ 
            return error_json('请求参数错误');
           }
          

           $data =[];
           $config = I('config');
           $id  = I('id');

           $data['config'] = serialize($config);
      
           $where= " id =  ".$id;
           
           $Db->update(table('plugin'),$data,$where);
 
      
            success_json('保存成功！');

          }else{
            $id          =   I('get.id',0,'intval');

            $res = $Db->query("select * from ".$table." where  id = '$id' limit 1");

            $plugin_info = $res[0];
                    if(!$plugin_info){
                        msgbox('插件未安装');
                    }

                        $plugin_info['addon_path']    = PLUGIN_PATH;
                        $db_config                    = $plugin_info['config']; //数据库配置
                        $plugin_info['config']        = include PLUGIN_PATH.$plugin_info['directory'].'/config.php';

                    
                        //获取已经安装的插件配置
                        if($db_config){
                            $db_config = unserialize($db_config);

                            $config = $plugin_info['config'];

                            foreach ($config as $key => $value)
                            {
                                if($value['type'] != 'group')
                                {

                                 $config[$key]['value'] = !empty($db_config[$key])?$db_config[$key]:'';           
                                }else{
                                   
                                    foreach ($value['options'] as $gourp => $options)
                                    {
                                        foreach ($options['options'] as $gkey => $value)
                                        {
                                            $plugin_info['config'][$key]['options'][$gourp]['options'][$gkey]['value'] = $db_config[$gkey];
                                        }
                                    }
                                }
                            }

                               //插件配置
                         $plugin_info['config'] = $config;
                        }

                     
                   
                        $Youke->assign('data',$plugin_info);


                        // if($plugin_info['custom_config']){
                        //   $this->assign('custom_config', $this->fetch($plugin_info['addon_path'].$plugin_info['custom_config']));
                     

                        // }
                         Youke_display('config.html');

       }
}elseif ($action == 'install') {
//安装
 header('Content-type: application/json'); 
 $data =[];
    $directory = I('post.directory','','addslashes');

    $info = include PLUGIN_PATH.'/'.$directory.'/info.php';  //读取配置文件
   
//判断插件是否安装
    $plugin_info = $Db->query("select * from ".$table." where  directory = '$directory' limit 1"); 
    if(!empty($plugin_info)){
       error_json('插件已经安装');
    }
    $install = PLUGIN_PATH.'/'.$directory.'/install.php';

    if(file_exists($install)){
       include $install;
    }

    // //获取安装数据库
    // $sql_files = PLUGIN_PATH.'/'.$directory.'/install/install.sql';
    // if(file_exists($sql_files)){
		  //   $sqls = file_get_contents($sql_files);  //读取配置文件
           
    //       $sql_list = parse_sql($sqls, ['yk365_' => TABLE_PREFIX]);

    //       if($sql_list){
    //       	$sql_list = array_filter($sql_list);
    //       }
    //       //执行数据库操作
    //        foreach ($sql_list as $v) { 
    //                 try {
    //                   $query = $Db->execsql($v); //安装数据

    //                 } catch(Exception $e) {
                     
                 
    //                     	$data['msg']  = '导入SQL失败，请检查install.sql的语句是否正确:'.$v."      ".$e;
				// 			$data['status'] = -1;
				// 			exit(json_encode($data)); 

    //                 }
    //             }

	
	

    // }

   if(file_exists(PLUGIN_PATH.'/'.$directory.'/admin_menu.php')){
   	  $admin_menu = include PLUGIN_PATH.'/'.$directory.'/admin_menu.php';  //读取配置文件
		 $data['admin_menu']= serialize($admin_menu);
   }
 
            $data['name']     = $info['name'];
            $data['author']      = $info['author'];
            $data['version']     = $info['version'];
            $data['description'] = $info['description'];
            $data['website']     = $info['website'];
            $data['is_admin']    = $info['is_admin'];
            $data['has_config']    = $info['has_config'];
            
            $data['directory'] = $directory;


  $Db->insert(table('plugin'),$data);
	$data['msg']  = '插件安装成功！';
	$data['status'] = 0;
	exit(json_encode($data)); 
}    
if ($action == 'open') {
//开启插件
    header('Content-type: application/json'); 
    $directory = I('post.directory','','addslashes');
    $id = I('post.id','','intval');
    $where = "id = '$id'";
    $arr['status'] = 1;
    $Db->update(table('plugin'),$arr,$where);
	$data['msg']  = '插件已开启！';
	$data['status'] = 0;
	exit(json_encode($data)); 
}
if ($action == 'close') {
//关闭插件
    header('Content-type: application/json'); 
    $directory = I('post.directory','','addslashes');
    $id = I('post.id','','intval');
    $data= [];
    $where = "id = '$id'";
    $arr['status'] = 0;
    $Db->update(table('plugin'),$arr,$where);
	$data['msg']  = '插件已关闭！';
	$data['status'] = 0;
	exit(json_encode($data)); 
}
if ($action == 'uninstall') {
//卸载，安装的那些文件和数据库，需要在卸载的时候删除
    header('Content-type: application/json'); 
    $directory = I('post.directory','','addslashes');
    $id = I('post.id','','intval');

    $uninstall = PLUGIN_PATH.'/'.$directory.'/install.php';

    if(file_exists($uninstall)){
       include $uninstall;
    }

    $where = "id = '$id'";
    $Db->delete(table('plugin'),$where);
	success_json('插件已卸载'); 
}



