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
//包含模块下的基本文件
$userinfo = is_login();



$pageurl = url('article');
$tplfile = 'article.html';
$table   = table('articles');



$action = I('get.act','list');
$Youke->assign('action', $action); 

if (!$Youke->isCached($tplfile)) {
	/** list */
	if ($action == 'list') {
		$pagename = '文章管理';
		$Youke->assign('site_title', $pagename.' - '.$options['site_name']);

		$pagesize  = 10;
		$curpage   = I('get.page','','intval');
		if ($curpage > 1) {
			$start = ($curpage - 1) * $pagesize;
		} else {
			$start   = 0;
			$curpage = 1;
		}
		
		$where = "a.user_id=".$userinfo['user_id'];
	
		$articles = get_article_list($where, 'ctime', 'DESC', $start, $pagesize);
		$total    = $Db->getCount($table.' a','*',$where);
		$showpage = showpage($pageurl, $total, $curpage, $pagesize);
		
		$Youke->assign('pagename', $pagename);
		$Youke->assign('articles', $articles);
		$Youke->assign('total', $total);
		$Youke->assign('showpage', $showpage);
	}
	
	/** add */
	if ($action == 'add') {
		$pagename = '发布文章';
		
		$Youke->assign('pagename', $pagename);
		$Youke->assign('site_title', $pagename.' - '.$options['site_name']);
		$Youke->assign('category_option', get_category_option('article', 0, 0, 0));	
		$Youke->assign('do', 'saveadd');
	}
	
	/** edit */
	if ($action == 'edit') {
		$pagename = '编辑文章';
		
		$art_id = I('get.aid','','intval');
		$where  = "a.user_id=$userinfo[user_id] AND a.art_id=$art_id";
		$row = get_one_article($where);
		if (!$row) {
			msgbox('您要修改的内容不存在或无权限！');
		}
		$row['art_content'] = str_replace('[upload_dir]', $options['site_root'].$options['upload_dir'].'/', $row['art_content']);
		
		$Youke->assign('pagename', $pagename);
		$Youke->assign('site_title', $pagename.' - '.$options['site_title']);
		$Youke->assign('category_option', get_category_option('article', 0, $row['cate_id'], 0));
		$Youke->assign('row', $row);
		$Youke->assign('do', 'saveedit');
	}
	
	/** save */
	 $do = I('post.do');
	if (in_array($do, array('saveadd', 'saveedit'))) {
//获得表单数据
		$cate_id   = I('post.cate_id','','intval');
		$art_title = I('post.art_title','','addslashes');
		$copy_from = I('post.copy_from','','addslashes');
		$copy_url  = I('post.copy_url','','addslashes');
		 if(!get_magic_quotes_gpc()){
           $art_content = I('post.art_content','','addslashes');
      }else{
 	       $art_content = I('post.art_content');
       }
		$art_time = time();
		
		if ($cate_id <= 0) {
			msgbox('请选择文章所属分类！');
		} else {
			$cate = get_one_category($cate_id);
			if ($cate['cate_childcount'] > 0) {
				msgbox('指定的分类下有子分类，请选择子分类进行操作！');
			}
		}
		
		if (empty($art_title)) {
			msgbox('请输入文章标题！');
		} else {
			if (!censor_words($options['filter_words'], $art_title)) {
				msgbox('文章标题中含有非法关键词！');	
			}
		}

		
		if (empty($copy_from)) $copy_from = '本站原创';
		if (empty($copy_url))  $copy_url = $options['site_url'];
		

		
		if (empty($art_content)) {
			msgbox('请输入文章内容！');
		} else {
			if (!censor_words($options['filter_words'], $art_content)) {
				msgbox('文章内容中含有非法关键词！');	
			}
		}
		
		$art_content = str_replace($options['site_root'].$options['upload_dir'].'/', '[upload_dir]', $art_content);
		
		$art_data = array(
			'user_id'   => $userinfo['user_id'],
			'cate_id'   => $cate_id,
			'art_title' => $art_title,
			'copy_from' => $copy_from,
			'copy_url'  => $copy_url,
			'art_content' => $art_content,
			'art_status'  => 2,
			'art_ctime'   => $art_time,
		);
		
		if ($do == 'saveadd') {
    		$query = $Db->query("SELECT art_id FROM $table WHERE art_title='$art_title'");
    		if (count($query)) {
        		msgbox('您所发布的文章已存在！');
    		}
			$Db->insert($table, $art_data);
			$insert_id = $Db->insert_id();
		
			msgbox('文章发布成功！', $pageurl);	
		} elseif ($do == 'saveedit') {
			$art_id = I('post.art_id','','intval');
			$where  = "art_id ='$art_id'";
			$Db->update($table, $art_data, $where);
			
			msgbox('文章编辑成功！', $pageurl);
		}
	}
}

Youke_display($tplfile);
