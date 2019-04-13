<?php
/****************奇乐网站授权管理系统 商业版********************/
/*                                                             */
/*  auth.qilewl.com (C)2018 qilewl.com Inc.                    */
/*  This is NOT a freeware, use is subject to license terms    */
/*  奇乐网站授权管理系统是商业软件,使用于商业用途请购买授权    */
/*  V1.0.0 2018                                                */
/*  官方网址：http://www.qilewl.com                            */ 
/*                                                             */                      
/***************************************************************/




$type    = !empty($_POST['type'])?addslashes($_POST['type']):'';
$version = SYS_VERSION;  //当前系统版本
$hosturl = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);

if($type =='check'){

//检测新版本，并且获得新版本信息
 $newVersion = getAPI(UPDATE_API_URL.'?a=check_new_version&version='.$version.'&domain='.$hosturl.'&code='.CLIENT_AUTH_CODE);

//无新版不需要升级
        if($newVersion['code'] >= 1){
           $arr['status'] = 0;
           $arr['msg'] = $newVersion['msg'];
           getJson($arr);
        }

//检查远程服务器补丁最新版本
        if($newVersion['data']['name'] > $version){
             $arr['status'] = 1;
  		        $arr['msg']  = '新版本号：'.SYS_NAME.' v'.$newVersion['data']['name'].'<br>';
              $arr['msg'] .= '更新内容:<br>'.$newVersion['data']['content'];
  		        getJson($arr);
        }else{
          	$arr['status'] = 0;
          	$arr['msg'] = '已经是最新版，不需要升级!' ;
          	getJson($arr);
        }

}elseif($type =='start'){
//开始更新程序
   
//升级接口 
       $updateData = getAPI(UPDATE_API_URL.'?a=update&version='.$version.'&domain='.$hosturl.'&code='.CLIENT_AUTH_CODE);
        if($updateData['code']  >= 1){
          $arr['status'] = 0;
          $arr['msg'] = $updateData['msg'];
          getJson($arr);  
        }
       
         $updateDataName = $updateData['data']['file'];

        if (strstr($updateDataName, 'zip')){
          // 下载数据
        $downUrl = UPDATE_API_URL.'?a=down&version='.$version.'&file='.$updateDataName.'&domain='.$hosturl.'&code='.CLIENT_AUTH_CODE;
     
             $update_dir = UPDATE_DIR;
            $updatezip_path = UPDATE_DIR.$updateDataName;  //升级包存放文件名称
             //删除升级包目录
                  delDir($update_dir);
                   
                  	//下载升级包
                    if(!file_exists($update_dir.$updateDataName)){
                          
                   
                             if(!httpcopy($downUrl,$update_dir)){
          			              $arr['status'] = -1;
                						  $arr['msg'] ='升级包下载失败!'; 
                						  getJson($arr);
          			              }
                   
                    }
                    //获得升级包所有文件名称
                        $updatezip =  new PclZip($updatezip_path);
					        if (($list = $updatezip->listContent()) == 0) {
					               		$arr['status'] = -1;
                						$arr['msg'] ='获取的压缩包可能已经损坏'; 
                						getJson($arr);
					        }
								$filename = array();
								foreach($list as $v){
								  if(is_file(ROOT_PATH.$v['filename'])){
								   array_push($filename,ROOT_PATH.$v['filename']);   
								  }
								}
                   
				         $all_file = implode(',',$filename);        
                    unset($list);

                    // 开启备份
                      if($AutoBackup == true){
                         //第一步：备份上一个升级前的网站所有程序
                            $backup_name = str_replace('.zip','',$updateDataName);
                            //$zip_path：备份的压缩包存放路径和名称
                            $zip_path = BACKUP_DIR.$backup_name.'_'.date('YmdHis').'_backup.zip';

                            if(!is_dir(BACKUP_DIR)){
                              @mkdir(BACKUP_DIR,0755);
                            }
                            $zip = new PclZip($zip_path);
                            $list = $zip->create($all_file);
                              if($list == 0){
                                  $arr['status'] = -1;
                                  $arr['msg'] ='备份失败 : '.$zip->errorInfo(true); 
                                  getJson($arr);
                               }             
                             }


                  // 第二步 : 解压升级包 
                        $unzip_path = ROOT_PATH;  //解压的目录  网站根目录
                        $archive = new PclZip($updatezip_path); 
                        if ($archive -> extract(PCLZIP_OPT_PATH,$unzip_path, PCLZIP_OPT_REPLACE_NEWER) == 0){
                          $arr['status'] = -1;
                          $arr['msg'] = '远程升级文件不存在,升级失败!';
                          getJson($arr);
                        }else{
                           //升级数据库
                          $sqlfile = $update_dir.'update.sql';
                            if(file_exists($sqlfile)){
                              
                                 $sql = file_get_contents($sqlfile);
                                  if($sql){
                                    $sql = str_replace("yk365_",TABLE_PREFIX,$sql);
                                      foreach(explode(";[\r\n]+", $sql) as $v){ 
                                          $Db->query($v);
                                      }
                                  }
                            }
                        }
                         //升级完成，删除升级包
                         if($UpgradePackage == true){
                            delDir($update_dir);
                         }
                     
                          $arr['status'] = 2;
                          $arr['msg'] ='恭喜您，升级完成!';
                          getJson($arr);

			  }else{
                      $arr['status'] = -1;
                      $arr['msg'] = '服务器没有检测到升级包';
                      getJson($arr);
        }

}else{
  $arr['status'] =0;
  $arr['msg'] ='类型错误';
  getJson($arr);
}




