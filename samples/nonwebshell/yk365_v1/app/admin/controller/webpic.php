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
$fileurl  = url('webpic');
$tempfile = 'webpic.html';
$table    = table('website');
$type     = !empty($_GET['type'])?htmlspecialchars($_GET['type']):'';

$pagesize = 15;
/** page */
$curpage = !empty($_GET['page'])?intval($_GET['page']):1;

if ($curpage > 1) {
	$start = ($curpage - 1) * $pagesize;
} else {
	$start = 0;
	$curpage = 1;
}

/** download */
if ($action == 'down') {



	$where = "web_status > 0";

	if ($type == 'part') {
		$where .= " AND web_pic=''";
	}
	

	$websites = $Db->query("SELECT web_id, web_name, web_url FROM $table WHERE $where ORDER BY web_id asc LIMIT $start, $pagesize");

    $totalnum = $Db->getCount($table,'*',$where);
	$totalpage = @ceil($totalnum / $pagesize);
	$d = $curpage/$totalpage;

	if ($totalnum > 0 && ($totalpage >= $curpage)) {
	$curpage = $curpage + 1;
		echo  '<table class="layui-table">';
		echo '<tr>';
		echo  '<th style="width:100px;">ID</th>';
		echo  '<th>网站名称</th>';
		echo  '<th>状态</th>';
		echo '</tr>';
		//网站截图保存本地的地址
         $savepath = ROOT_PATH.$options['upload_dir'].'/website/';
		
		echo '<meta http-equiv="refresh" content=3;url="'.$fileurl.'?act='.$action.'&type='.$type.'&page='.$curpage.'">';
		echo '<div class="alert alert-info">正在下载远程图片...   进度：共需采集 '.$totalpage.' 页，每次下载 '.$pagesize.' 张，当前第 '.$curpage.' 页，</div>';
		foreach ($websites as $row) {

	$filepath  = save_to_local(str_replace(['http://','https://'], '',  get_domain($row['web_url'])), $savepath);
 
		//保存本地的地址插入数据库
    $newpath = str_replace(ROOT_PATH, '/', $filepath);

			if (isset($newpath)) {
				$status = '<i class="fa fa-check-circle" aria-hidden="true" style="color:green"></i> 成功';
				$web_id= $row['web_id'];
				$Db->update($table, array('web_pic' => $newpath),"web_id = '$web_id'");

			} else {
				$status = '下载失败';
			}

			echo '<tr><td>'.$row['web_id'].'</td><td>'.$row['web_name'].'</td><td>'.$status.'</td></tr>';
		


		}
		echo '<tr><td colspan="3">本页已采集完成，5秒后将自动采集下一页</td></tr>';
		// msgbox('本页已采集完成，5秒后将自动采集下一页...');	
		
	} else {
		msgbox('已经将所有的远程图片本地化!',url('website',['act'=>'down']));
		exit;	
	}
	echo '</div>';
	echo '</table>';
}

/** check */
if ($action == 'check') {
	$pagesize = 10;
	$curpage = $curpage + 1;

	$where = "web_status=3 and web_pic !=''";
	$websites = $Db->query("SELECT web_id, web_name, web_pic FROM $table WHERE $where ORDER BY web_id DESC LIMIT $start, $pagesize");
	$totalnum = $Db->getCount($table,'*',$where);
	$totalpage = @ceil($totalnum / $pagesize);

	echo '<div style="font-size: 12px; line-height: 25px; padding: 10px;">';
	if(!empty($totalnum)){
			  if ($curpage <= $totalpage) {
					// $savepath = '../'.$options['upload_dir'].'/';
					
					echo '<meta http-equiv="refresh" content=3;url="'.$fileurl.'?act='.$action.'&page='.$curpage.'">';
					echo '<h3>总共 '.$totalpage.' 页，每次检测 '.$pagesize.' 条，正在检测第 '.$curpage.' 页...</h3>';
					foreach ($websites as $row) {
					
							if (!is_file(ROOT_PATH.$row['web_pic'])) {
								$status = '图片不存在！';
								$web_id = $row['web_id'];
								$Db->update($table, array('web_pic' => ''), "web_id = '$web_id'");
							} else {
								$status = '图片存在！';
							}
							echo $row['web_id'].' - '.$row['web_name'].' ------ '.$status.'<br />';
					
					}
					echo '<h3>本页已检测完成，3秒后将自动检测下一页...<h3>';
				} else {
					echo '<h3>所有站点检测成功!</h3>';
				}
				echo '</div>';
				echo '</table>';    
	}else{
		echo '没有采集到任何图片';
	}
	
}

Youke_display($tempfile);