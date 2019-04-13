<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2018 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.youke365.site                        */
/*  官方论坛：http://bbs.youke365.site                        */                           
/**************************************************************/

if (!defined('IN_YOUKE365')) exit('Access Denied');

$pageurl = url('website');
$tplfile = 'website.html';
$action  = I('get.act','list');
$Youke->assign('action', $action); 
//登陆验证
$userinfo = is_login();

$table = table('website');

$do= I('post.do');
if (!$Youke->isCached($tplfile)) {
	/** list */
	if ($action == 'list') {
		$pagename = '网站管理';
		$Youke->assign('site_title', $pagename.' - '.$options['site_name']);

		$pagesize  = 10;
		$curpage   = I('get.page',1,'intval');
		if ($curpage > 1) {
			$start = ($curpage - 1) * $pagesize;
		} else {
			$start = 0;
			$curpage = 1;
		}
		
		$where    = "w.user_id=".$userinfo['user_id'];
	
		$weblist  = get_website_list($where, 'ctime', 'DESC', $start, $pagesize);
		$total    = $Db->getCount($table.' w','*',$where);
		$showpage = showpage($pageurl, $total, $curpage, $pagesize);
		
		$Youke->assign('pagename', $pagename);
		$Youke->assign('weblist', $weblist);
		$Youke->assign('total', $total);
		$Youke->assign('showpage', $showpage);
	}
	
	/** add */
	if ($action == 'add') {
		$pagename = '网站提交';
		
		#统计当日可提交的站点数量
		if (!empty($options['submit_limit']) && $options['submit_limit'] > 0) {
			$time = time() - (3600 * 12);
			$today_count = $Db->getCount(table('websites'), '*',"web_ctime>='$time'");
			$submit_limit = $options['submit_limit'] - $today_count;
			$Youke->assign('submit_limit', $submit_limit);
		}

          
		$Youke->assign('pagename', $pagename);
		$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
		$Youke->assign('category_option', get_category_option('webdir',0, 0, 0));	
		$Youke->assign('do', 'saveadd');
	}
	
	/** edit */
	if ($action == 'edit') {
		$pagename = '网站编辑';
		$web_id = I('get.wid','','intval');
		$where = "a.user_id='$userinfo[user_id]' AND a.web_id='$web_id'";
		$web = get_one_website($where);


		if (!$web) {
			msgbox('您要修改的内容不存在或无权限！');
		}

		#分类ID

		$parent_cids = get_category_parent_ids($web['cate_id']);

	
		if (strpos($parent_cids, ',') !== false) {
			$cate_pids = explode(',', $parent_cids);
			array_shift($cate_pids);
		} else {
			$cate_pids = (array) $parent_cids;
		}

		$web['web_ip'] = long2ip($web['web_ip']);
		

	
		$Youke->assign('pagename', $pagename);
		$Youke->assign('site_title', $pagename.' - '.$options['site_title']);
		$Youke->assign('cate_pids', $cate_pids);
		$Youke->assign('category_option', get_category_option(0, $web['cate_id'], 0));
		$Youke->assign('web', $web);	
		$Youke->assign('do', 'saveedit');
	}
	
	/** save */
	if (in_array($do, array('saveadd', 'saveedit'))) {
		$cate_id   = I('post.cate_id','','intval');
		$web_name  = I('post.web_name','','addslashes');
		$web_url   = I('post.web_url','','addslashes');
		$web_tags  = I('post.web_tags','','addslashes');
		$web_intro = I('post.web_intro','','addslashes');
		$web_ip    = I('post.web_ip','','addslashes');
		$web_r360  = I('post.web_r360','','intval');
		$web_brank = I('post.web_brank','','intval');
		$web_srank = I('post.web_srank','','intval');
		$web_arank = I('post.web_arank','','intval');
		$web_time  = time();
		
		if ($cate_id <= 0) {
			msgbox('请选择网站所属分类！');
		} else {
			$cate = get_one_category($cate_id);
			if ($cate['cate_childcount'] > 0) {
				msgbox('指定的分类下有子分类，请选择子分类进行操作！');
			}
		}
	
		if (empty($web_name)) {
			msgbox('请输入网站名称！');
		} else {
			if (!censor_words($options['filter_words'], $web_name)) {
				msgbox('网站名称中含有非法关键词！');	
			}
		}
		
		if (empty($web_url)) {
			msgbox('请输入网站域名！');
		} else {
			if (!is_valid_domain($web_url)) {
				msgbox('请输入正确的网站域名！');
			}
		}
		
		if (!empty($web_tags)) {
			if (!censor_words($options['filter_words'], $web_tags)) {
				msgbox('TAG标签中含有非法关键词！');
			}
			
			$web_tags = str_replace('，', ',', $web_tags);
			$web_tags = str_replace(',,', ',', $web_tags);
			if (substr($web_tags, -1) == ',') {
				$web_tags = substr($web_tags, 0, strlen($web_tags) - 1);
			}
		}
			
		if (empty($web_intro)) {
			msgbox('请输入网站简介！');
		} else {
			if (!censor_words($options['filter_words'], $web_intro)) {
				msgbox('网站简介中含有非法关键词！');	
			}
		}
		
		$web_ip = sprintf("%u", ip2long($web_ip));
		
		$web_data = array(
			'cate_id'    => $cate_id,
			'user_id'    => $userinfo['user_id'],
			'web_name'   => $web_name,
			'web_url'    => $web_url,
			'web_tags'   => $web_tags,
			'web_intro'  => $web_intro,
			'web_status' => 2,
			'web_ctime'  => $web_time,
		);
		
		if ($do == 'saveadd') {
    		$query = $Db->query("SELECT web_id FROM $table WHERE web_url='$web_url'");
    		if (count($query)) {
        		msgbox('您所提交的网站已存在！');
    		}
			$Db->insert($table, $web_data);
			$insert_id = $Db->insert_id();
			

			$stat_data = array(
				'web_id' => $insert_id,
				'web_ip' => $web_ip,
				'web_r360' => $web_r360,
				'web_brank' => $web_brank,
				'web_srank' => $web_srank,
				'web_arank' => $web_arank,
				'web_utime' => $web_time,
			);
			$Db->insert(table('webdata'), $stat_data);
		
			msgbox('网站提交成功！', $pageurl);	
		} elseif ($do == 'saveedit') {
			$web_id  = I('web_id','','intval');
			$where   = "web_id = '$web_id'";
			$Db->update($table, $web_data, $where);
			
			$stat_data = array(
				'web_ip'    => $web_ip,
				'web_r360'  => $web_r360,
				'web_brank' => $web_brank,
				'web_srank' => $web_srank,
				'web_arank' => $web_arank,
				'web_utime' => $web_time,
			);

         
			$Db->update(table('webdata'), $stat_data, $where);
			
			msgbox('网站编辑成功！', $pageurl);
		}
	}
}

Youke_display($tplfile);

