<?php
/**
 * @copyright     2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate     2012-1111 koyshe <koyshe@gmail.com>
 */
include('../common.php');
switch ($_g_step) {
	//####################// 配置信息 //####################//
	case 'setting':
		if (is_file("{$pe['path_root']}install/install.lock")) die('PHPSHE商城系统已经安装成功，如需再次安装请删除 ./install/install.lock 文件');
		if (isset($_p_pesubmit)) {
			$db = new db($_p_db_host, $_p_db_user, $_p_db_pw, $_p_db_name, 'utf8', false);
			$result = $db->connect($_p_db_host, $_p_db_user, $_p_db_pw);
			if ($result != 'success') pe_error($result);
			$result = $db->select_db($_p_db_name, 'utf8');
			if ($result != 'success') {
				$db->query("CREATE DATABASE `{$_p_db_name}` DEFAULT CHARACTER SET utf8");
				$result = $db->select_db($_p_db_name, 'utf8');
			}
			if ($result != 'success') pe_error($result);			

			$sql_arr = explode('/*#####################@ pe_cutsql @#####################*/', file_get_contents("{$pe['path_root']}install/phpshe.sql"));
			foreach ($sql_arr as $v) {
				$result = $db->query(trim(str_ireplace('{dbpre}', $_p_dbpre, $v)));
			}
			if ($result) {
				$db->query("update `{$_p_dbpre}admin` set `admin_name` = '{$_p_admin_name}', `admin_pw` = '".md5($_p_admin_pw)."' where `admin_id`=1", $dbconn);
				$config = "<?php\n\$pe['db_host'] = '{$_p_db_host}'; //数据库主机地址\n\$pe['db_name'] = '{$_p_db_name}'; //数据库名称\n\$pe['db_user'] = '{$_p_db_user}'; //数据库用户名\n\$pe['db_pw'] = '{$_p_db_pw}'; //数据库密码\n\$pe['db_coding'] = 'utf8';\n\$pe['url_model'] = 'pathinfo_safe'; //url模式,可选项(pathinfo/pathinfo_safe/php)\ndefine('dbpre','{$_p_dbpre}'); //数据库表前缀\n?>";
				file_put_contents("{$pe['path_root']}config.php", $config);
				pe_goto("{$pe['host_root']}install/index.php?step=success");
			}
			else {
				pe_error('数据库安装失败！');
			}
		}
		if (is_writeable("{$pe['path_root']}data/")) {
			$mod_data = '<strong class="cgreen num">Yes</strong>';
			$mod_data_result = true;				
		}
		else {
			$mod_data = '<strong class="cred num">No</strong>';
			$mod_data_result = false;
		}
		if (is_writeable("{$pe['path_root']}install/")) {
			$mod_install = '<strong class="cgreen num">Yes</strong>';
			$mod_install_result = true;				
		}
		else {
			$mod_install = '<strong class="cred num">No</strong>';
			$mod_install_result = false;
		}
		if (is_writeable("{$pe['path_root']}config.php")) {
			$mod_config = '<strong class="cgreen num">Yes</strong>';
			$mod_config_result = true;				
		}
		else {
			$mod_config = '<strong class="cred num">No</strong>';
			$mod_config_result = false;
		}
		$menucss_2 = "sel";
		$seo = pe_seo($menutitle='配置信息 -> PHPSHE商城系统安装向导', '', '', 'admin');
	break;
	//####################// 安装成功 //####################//
	case 'success':
		pe_lead('hook/cache.hook.php');
		$db = new db($pe['db_host'], $pe['db_user'], $pe['db_pw'], $pe['db_name'], $pe['db_coding']);
		cache_write();		
		$menucss_3 = "sel";
		$seo = pe_seo($menutitle='安装成功 -> PHPSHE商城系统安装向导');
		file_put_contents("{$pe['path_root']}install/install.lock", 'phpshe');
	break;
	//####################// 安装协议 //####################//
	default :
		$menucss_1 = "sel";
		$seo = pe_seo($menutitle='安装协议 -> PHPSHE商城系统安装向导');
		if (is_file("{$pe['path_root']}install/install.lock")) die('PHPSHE商城系统已经安装成功，如需再次安装请删除 ./install/install.lock 文件');
	break;
}
include('install.html');
pe_result();
?>