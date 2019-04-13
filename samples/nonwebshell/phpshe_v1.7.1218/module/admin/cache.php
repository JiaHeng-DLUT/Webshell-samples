<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2012-0501 koyshe <koyshe@gmail.com>
 */
$menumark = 'cache';
switch ($act) {
	//####################// 缓存更新 //####################//
	case 'update':
		pe_token_match();
		pe_lead('hook/cache.hook.php');
		cache_write($_g_cache);
		pe_success('更新成功!');
	break;
	//####################// 缓存列表 //####################//
	default:
		//数据缓存
		$info_list['data']['cache_name'] = '数据缓存';
		$info_list['data']['cache_text'] = '网站数据显示错乱或不显示时，可尝试更新此项。';
		$data_list = pe_dirlist("{$pe['path_root']}data/cache/*.cache.php");
		foreach ($data_list as $v) {
			$data_size += filesize("{$pe['path_root']}data/cache/{$v}");
		}
		$info_list['data']['cache_size'] = round($data_size/1024, 1);
		//模板缓存
		$info_list['template']['cache_name'] = '模板缓存';
		$info_list['template']['cache_text'] = '网站界面显示错乱或不显示时，可尝试更新此项。';
		$info_list['template']['cache_size'] = round(pe_dirsize("{$pe['path_root']}data/cache/template")/1024, 1);
		//附件缓存
		$info_list['attachment']['cache_name'] = '附件缓存';
		$info_list['attachment']['cache_text'] = '附件缓存占用过多空间时，可更新此项。';
		$info_list['attachment']['cache_size'] = round(pe_dirsize("{$pe['path_root']}data/cache/attachment")/1024, 1);
		//图片缓存
		$info_list['thumb']['cache_name'] = '图片缓存';
		$info_list['thumb']['cache_text'] = '图片缓存占用过多空间时，可更新此项。';
		$info_list['thumb']['cache_size'] = round(pe_dirsize("{$pe['path_root']}data/cache/thumb")/1024, 1);

		$seo = pe_seo($menutitle='缓存管理', '', '', 'admin');
		include(pe_tpl('cache_list.html'));
	break;
}
?>