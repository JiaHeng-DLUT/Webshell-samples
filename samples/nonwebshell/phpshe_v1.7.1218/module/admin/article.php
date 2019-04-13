<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'article';
$cache_class = cache::get('class');
$cache_class_arr = cache::get('class_arr');
switch ($act) {
	//####################// 文章添加 //####################//
	case 'add':
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$_p_info['article_atime'] = $_p_info['article_atime'] ? strtotime($_p_info['article_atime']) : time();		
			if ($db->pe_insert('article', pe_dbhold($_p_info, array('article_text')))) {
				pe_success('添加成功!', 'admin.php?mod=article');
			}
			else {
				pe_error('添加失败...');
			}
		}
		$seo = pe_seo($menutitle='添加文章', '', '', 'admin');
		include(pe_tpl('article_add.html'));
	break;
	//####################// 文章修改 //####################//
	case 'edit':
		$article_id = intval($_g_id);
		if (isset($_p_pesubmit)) {
			pe_token_match();
			$_p_info['article_atime'] = $_p_info['article_atime'] ? strtotime($_p_info['article_atime']) : time();
			if ($db->pe_update('article', array('article_id'=>$article_id), pe_dbhold($_p_info, array('article_text')))) {
				pe_success('修改成功!', $_g_fromto);
			}
			else {
				pe_error('修改失败...');
			}
		}
		$info = $db->pe_select('article', array('article_id'=>$article_id));
		$seo = pe_seo($menutitle='修改文章', '', '', 'admin');
		include(pe_tpl('article_add.html'));
	break;
	//####################// 文章删除 //####################//
	case 'del':
		pe_token_match();
		if ($db->pe_delete('article', array('article_id'=>is_array($_p_article_id) ? $_p_article_id : $_g_id))) {
			pe_success('删除成功!');
		}
		else {
			pe_error('删除失败...');
		}
	break;
	//####################// 文章列表 //####################//
	default :
		$sqlwhere = $_g_type ? "b.`class_type` = 'help'" : "b.`class_type` = 'news'";
		$_g_name && $sqlwhere .= " and a.`article_name` like '%{$_g_name}%'";
		$_g_class_id && $sqlwhere .= " and a.`class_id` = '{$_g_class_id}'";
		$sqlwhere .= " order by a.`article_id` desc";
		$sql = "select * from `".dbpre."article` a left join `".dbpre."class` b on a.`class_id` = b.`class_id` where {$sqlwhere}";
		$info_list = $db->sql_selectall($sql, array(30, $_g_page));

		$tongji['news'] = $db->sql_num("select count(1) from `".dbpre."article` a left join `".dbpre."class` b on a.`class_id` = b.`class_id` where b.`class_type` = 'news'");
		$tongji['help'] = $db->sql_num("select count(1) from `".dbpre."article` a left join `".dbpre."class` b on a.`class_id` = b.`class_id` where b.`class_type` = 'help'");
		$seo = pe_seo($menutitle='文章列表', '', '', 'admin');
		include(pe_tpl('article_list.html'));
	break;
}
?>