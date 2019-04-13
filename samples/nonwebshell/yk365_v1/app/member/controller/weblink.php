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

//登陆验证
$userinfo = is_login();

$pageurl = url('weblink');
$tplfile = 'weblink.html';
$table   = table('weblinks');

$action = I('get.act','list');
$Youke->assign('action', $action); 




$do = I('post.do');
if (!$Youke->isCached($tplfile)) {
	/** list */
	if ($action == 'list') {
		$pagename = '链接管理';
		$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
		$curpage = I('get.page','','intval');
		$pagesize = 10;
		
		if ($curpage > 1) {
			$start = ($curpage - 1) * $pagesize;
		} else {
			$start = 0;
			$curpage = 1;
		}
		
		$where = "l.user_id=".$userinfo['user_id'];
		$results = get_weblink_list($where, 'time', 'DESC', $start, $pagesize);
		$weblinks = array();
		foreach($results as $row) {
			if ($row['link_days'] > 0) {
				$endtime = $row['link_time'] + $row['link_days'] * 24 * 3600;
				$row['link_status'] = $endtime > $row['link_time'] ? '<span class="gre">'.$row['link_days'].'天后过期</span>' : '<span class="red">已过期</span>';
			} else {
				$row['link_status'] = '<span class="org">长期有效</span>';
			}
			
			$row['deal_type']  = $deal_types[$row['deal_type']];
			$row['link_price'] = ($row['link_price'] > 0 ? $row['link_price'] : '面议');
			$row['link_time']  = date('Y-m-d', $row['link_time']);
			$weblinks[]        = $row;
		}
		$total = $Db->getCount($table.' l','*',$where);
		$showpage = showpage($pageurl, $total, $curpage, $pagesize);
		
		$Youke->assign('pagename', $pagename);
		$Youke->assign('weblinks', $weblinks);
		$Youke->assign('total', $total);
		$Youke->assign('showpage', $showpage);
	}
	
	/** add */
	if ($action == 'add') {
		$pagename = '发布链接';
		
		$Youke->assign('pagename', $pagename);
		$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
		$Youke->assign('weburl_option', get_weburl_option($userinfo['user_id']));
		$Youke->assign('dealtype_radio', get_dealtype_radio());
		$Youke->assign('linktype_radio', get_linktype_radio());
		$Youke->assign('linkpos_radio',  get_linkpos_radio());
		
		$Youke->assign('do', 'saveadd');
	}
	
	/** edit */
	if ($action == 'edit') {
		$pagename = '链接编辑';
		
		$link_id = I('get.id','','intval');
		$where = "l.user_id=$userinfo[user_id] AND l.link_id=$link_id";
		$row = get_one_weblink($where);
		if (!$row) {
			msgbox('您要修改的内容不存在或无权限！');
		}
		
		$Youke->assign('pagename', $pagename);
		$Youke->assign('site_title', $pagename.' - '.$options['site_title']);
		$Youke->assign('weburl_option', get_weburl_option($userinfo['user_id'], $row['web_id']));
		$Youke->assign('dealtype_radio', get_dealtype_radio($row['deal_type']));
		$Youke->assign('linktype_radio', get_linktype_radio($row['link_type']));
		$Youke->assign('linkpos_radio', get_linkpos_radio($row['link_pos']));
		$Youke->assign('row', $row);	
		$Youke->assign('do', 'saveedit');
	}
	
	/** del */
	if ($action == 'del') {
		$link_ids = (array) ($_POST['id'] ? $_POST['id'] : $_GET['id']);
	
		$Db->delete($table, 'link_id IN ('.dimplode($link_ids).')');
		unset($link_ids);
	
		redirect($pageurl);
	}
	
	/** save */
	if (in_array($do, array('saveadd', 'saveedit'))) {

		$web_id     = I('post.web_id','','intval');
		$deal_type  = I('post.deal_type','','intval');
		$link_name  = I('post.link_name','','addslashes');
		$link_type  = I('post.link_type','','intval');
		$link_pos   = I('post.link_pos','','intval');
		$link_price = I('post.link_price','','intval');
		$link_if1   = I('post.link_if1','','addslashes');
		$link_if2   = I('post.link_if2','','addslashes');
		$link_if3   = I('post.link_if3','','addslashes');
		$link_if4   = I('post.link_if4','','addslashes');
		$link_intro = I('post.link_intro','','addslashes');
		$link_days  = I('post.link_days','','intval');
		$link_time  = time();
		
		if ($web_id <= 0) {
			msgbox('请选择站点！');
		}
		
		if (empty($link_name)) {
			msgbox('请输入链接名称！');
		} else {

			if (utf8_strlen($link_name) > 20) {
				msgbox('链接名称长度不能超过20个字符！');	
			}
			
		
			if (!censor_words($options['filter_words'], $link_name)) {
				msgbox('链接名称中含有非法关键词！');	
			}

		}
		
	if (empty($link_if1)) {
		msgbox('请输入百度收录条数');
	}

	if (!isset($link_if2)) {
		msgbox('请输入百度BR值');
	}

	if (empty($link_if3)) {
		msgbox('请输入百度的快照时间');
	}
	if (empty($link_if4)) {
		msgbox('请输入对方首页外链');
	}
		$link_data = array(
			'user_id'   => $userinfo['user_id'],
			'web_id'    => $web_id,
			'deal_type' => $deal_type,
			'link_name' => $link_name,
			'link_type' => $link_type,
			'link_pos'  => $link_pos,
			'link_price'=> $link_price,
			'link_if1'  => $link_if1,
			'link_if2'  => $link_if2,
			'link_if3'  => $link_if3,
			'link_if4'  => $link_if4,
			'link_intro'=> $link_intro,
			'link_days' => $link_days,
			'link_time' => $link_time,
		);
		

		if ($do == 'saveadd') {
    		$query = $Db->query("SELECT link_id FROM $table WHERE web_id='$web_id'");
    		if (!empty($query)) {
        		msgbox('您所发布的链接已存在！');
    		}
			$Db->insert($table, $link_data);
			$insert_id = $Db->insert_id();
		
			msgbox('链接发布成功！', $pageurl);	
		} elseif ($do == 'saveedit') {
			$link_id = I('post.link_id','intval');
			$where ="link_id = '$link_id'";
			$Db->update($table, $link_data, $where);
			
			msgbox('链接编辑成功！', $pageurl);
		}
	}
}

Youke_display($tplfile);
