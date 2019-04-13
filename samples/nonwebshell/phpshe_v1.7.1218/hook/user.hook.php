<?php
function user_login_callback($type, $user) {
	global $db, $pe, $cache_setting;
	if (!is_array($user)) $user = $db->pe_select('user', array('user_id'=>$user));
	$db->pe_update('user', array('user_id'=>$user['user_id']), array('user_ltime'=>time()));
	$_SESSION['user_idtoken'] = md5($user['user_id'].$pe['host_root']);
	$_SESSION['user_id'] = $user['user_id'];
	$_SESSION['user_name'] = $user['user_name'];
	$_SESSION['user_ltime'] = $user['user_ltime'];
	$_SESSION['pe_token'] = pe_token_set($_SESSION['user_idtoken']);
	if ($type == 'reg') {
		//记录推荐人
		if ($cache_setting['tg_state'] && $_COOKIE['tguser_id']) {
			$tguser = $db->pe_select('user', array('user_id'=>intval($_COOKIE['tguser_id'])), 'user_id, user_name');
			if ($tguser['user_id']) {
				$sql_set['tguser_id'] = $tguser['user_id'];
				$sql_set['tguser_name'] = $tguser['user_name'];	
				$db->pe_update('user', array('user_id'=>$user['user_id']), pe_dbhold($sql_set));
				add_tguser($user['user_id']);		
			}
		}
		add_pointlog($user['user_id'], 'give', $cache_setting['point_reg'], '新用户注册奖励');
		userlevel_callback($user['user_id']);	
	}
	else {
		if (!$db->pe_num('pointlog', " and `user_id` = '{$user['user_id']}' and `pointlog_type` = 'give' and `pointlog_text` = '每日登录' and `pointlog_atime` >= '".strtotime(date('Y-m-d'))."'")) {
			add_pointlog($user['user_id'], 'give', $cache_setting['point_login'], '每日登录奖励');				
		}
	}
}

//记录交易明细
function add_moneylog($user_id, $type, $money, $text=null, $time='') {
	global $db;
	$money = pe_num($money, 'floor', 1);
	if ($money <= 0) return false;	
	if (in_array($type, array('recharge', 'add', 'back', 'tg'))) {
		$sql_user = "`user_money` = `user_money` + '{$money}'";
		$sql_set['moneylog_in'] = $money;
	}
	else {
		$sql_user = "`user_money` = `user_money` - '{$money}'";
		$sql_set['moneylog_out'] = $money;
	}
	if ($db->pe_update('user', array('user_id'=>$user_id), $sql_user)) {
		$user = $db->pe_select('user', array('user_id'=>$user_id));
		$sql_set['moneylog_text'] = $text;
		$sql_set['moneylog_now'] = $user['user_money'];
		$sql_set['moneylog_atime'] = $time ? $time : time();
		$sql_set['moneylog_type'] = $type;
		$sql_set['user_id'] = $user['user_id'];
		$sql_set['user_name'] = $user['user_name'];
		$db->pe_insert('moneylog', pe_dbhold($sql_set, array('moneylog_text')));
		return true;
	}
	else {
		return false;
	}
}

//增加积分
function add_pointlog($user_id, $type, $point = 0, $text = null) {
	global $db, $cache_setting;
	if (!$cache_setting['point_state']) return false;
	$point = intval($point);
	if (!$point) return false;	
	if (in_array($type, array('give', 'add', 'back'))) {
		$sqlset_user = " `user_point` = `user_point` + '{$point}', `user_point_all` = `user_point_all` + '{$point}'";
		$sqlset_pointlog['pointlog_in'] = $point;
	}
	else {
		$sqlset_user = " `user_point` = `user_point` - '{$point}', `user_point_all` = `user_point_all` - '{$point}'";
		$sqlset_pointlog['pointlog_out'] = $point;
	}
	if ($db->pe_update('user', array('user_id'=>$user_id), $sqlset_user)) {
		$user = $db->pe_select('user', array('user_id'=>$user_id));
		if (!$user['user_id']) return false;
		$sqlset_pointlog['pointlog_text'] = $text;
		$sqlset_pointlog['pointlog_now'] = $user['user_point'];
		$sqlset_pointlog['pointlog_atime'] = time();
		$sqlset_pointlog['pointlog_type'] = $type;
		$sqlset_pointlog['user_id'] = $user['user_id'];
		$sqlset_pointlog['user_name'] = $user['user_name'];
		$db->pe_insert('pointlog', pe_dbhold($sqlset_pointlog, array('pointlog_text')));
		return true;
	}
	else {
		return false;
	}
}

//获取用户积分
function user_point($user_id, $type = '') {
	global $db, $cache_setting;
	$user = $db->pe_select('user', array('user_id'=>$user_id), "`user_point`");
	//冻结积分
	$order = $db->pe_select('order', array('user_id'=>$user_id, 'order_state'=>array('notpay', 'paid', 'send')), "sum(`order_point_use`) as `point`");
	//冻结金额
	$user_lock = $order['point'];	
	$user_real = round($user['user_point'] - $user_lock, 1);
	$user_money = $cache_setting['point_money'] ? round($user_real/$cache_setting['point_money'], 1) : 0;
	$point_arr = array('all'=>$user['user_point'], 'real'=>$user_real, 'lock'=>$user_lock, 'money'=>$user_money);
	if ($type) {
		return $point_arr[$type];
	}
	else {
		return $point_arr;
	}
}

//获取用户金额
function user_money($user_id, $type = '') {
	global $db;
	$user = $db->pe_select('user', array('user_id'=>$user_id), "`user_money`");
	//申请提现中金额
	$cashout = $db->pe_select('cashout', array('user_id'=>$user_id, 'cashout_state'=>0), "sum(`cashout_money`) as `money`");
	//冻结金额
	$user_lock = round($cashout['money'], 1);	
	$user_real = round($user['user_money'], 1);
	//浮点数精度问题，相减round后等于-0(2015-08-19修正)
	if ($user_real == '-0') $user_real = 0;
	$money_arr = array('all'=>$user['user_money'], 'real'=>$user_real, 'lock'=>$user_lock);
	if ($type) {
		return $money_arr[$type];
	}
	else {
		return $money_arr;
	}
}
//获取用户等级
function get_userlevel($user, $key = null, $real = 0){
	global $db;
	$cache_userlevel = cache::get('userlevel');
	$real && $user['userlevel_id'] = 0;
	$userlevel_id = $user['userlevel_id'];
	if (!is_array($cache_userlevel[$userlevel_id]) or $cache_userlevel[$userlevel_id]['userlevel_up'] == 'auto') {
		foreach ($cache_userlevel as $v) {
			if ($v['userlevel_up'] == 'hand') continue;
			if ($user['user_money_cost'] >= $v['userlevel_value']) {
				$userlevel_id = $v['userlevel_id'];
			}
			else {
				break;
			}
		}
	}
	return $key ? $cache_userlevel[$userlevel_id][$key] : $cache_userlevel[$userlevel_id];
}
//用户等级回调
function userlevel_callback($user_id = 0) {
	global $db;
	$cache_userlevel = cache::get('userlevel');
	$cache_userlevel_arr = cache::get('userlevel_arr');
	if ($user_id) {
		$user = $db->pe_select('user', array('user_id'=>$user_id), 'userlevel_id, user_money_cost');
		if ($user['userlevel_id'] && $cache_userlevel[$user['userlevel_id']]['userlevel_up'] == 'hand') return true;
		foreach ($cache_userlevel_arr['auto'] as $v) {
			if ($user['user_money_cost'] >= $v['userlevel_value']) {
				$userlevel_id = $v['userlevel_id'];
			}
			else {
				break;
			}
		}
		if ($userlevel_id != $user['userlevel_id']) {
			$db->pe_update('user', array('user_id'=>$user_id), array('userlevel_id'=>$userlevel_id));
		}
	}
	else {
		$hand_id = implode("','", array_keys($cache_userlevel_arr['hand']));
		foreach ($cache_userlevel_arr['auto'] as $v) {
			//if ($v['userlevel_up'] == 'hand') continue;
			$db->pe_update('user', "and `user_money_cost` >= '{$v['userlevel_value']}' and `userlevel_id` not in('{$hand_id}')", array('userlevel_id'=>$v['userlevel_id']));
		}
	}
}

//检测优惠券是否过期
function user_quancheck() {
	global $db;
	$db->pe_update('quanlog', " and `quanlog_state` = 0 and `quan_edate` < '".date('Y-m-d')."'", array('quanlog_state'=>2));
	$db->pe_update('quanlog', " and `quanlog_state` = 2 and `quan_edate` >= '".date('Y-m-d')."'", array('quanlog_state'=>0));
}

//获取可用优惠券
function user_quanlist($cart) {
	global $db;
	if (!pe_login('user')) return array();
	$info_list = $db->index('quanlog_id')->pe_selectall('quanlog', array('user_id'=>$_SESSION['user_id'], 'quanlog_state'=>0, 'order by'=>'quan_money desc, quanlog_atime desc'));
	$quan_list = array();
	foreach ($info_list as $k=>$v) {
		if ($v['product_id']) {
			$product_money = 0;
			foreach ($cart['all_list'] as $vv) {
				if (in_array($vv['product_id'], explode(',', $v['product_id']))) {
					$product_money += $vv['product_money'] * $vv['product_num'];
				}
			}
			if ($product_money >= $v['quan_limit']) $quan_list[$k] = $v;
		}
		else {
			if ($cart['info']['order_product_money'] >= $v['quan_limit']) $quan_list[$k] = $v;
		}
	}	
	return $quan_list;
}

//更新优惠券状态
function user_quanupdate($quanlog_id, $state) {
	global $db;
	if (!$quanlog_id) return false;
	$sql_set['quanlog_utime'] = $state == 1 ? time() : 0;
	$sql_set['quanlog_state'] = intval($state);	
	$db->pe_update('quanlog', array('quanlog_id'=>intval($quanlog_id)), $sql_set);
	//统计领取数和使用数
	$info = $db->pe_select('quanlog', array('quanlog_id'=>intval($quanlog_id)), 'quan_id');	
	$quan_num_get = $db->pe_num('quanlog', "and `quan_id` = '{$info['quan_id']}' and `user_id` > 0");
	$quan_num_use = $db->pe_num('quanlog', "and `quan_id` = '{$info['quan_id']}' and `user_id` > 0 and `quanlog_state` = 1");
	$db->pe_update('quan', array('quan_id'=>$info['quan_id']), array('quan_num_get'=>$quan_num_get, 'quan_num_use'=>$quan_num_use));
	user_quancheck();
}

//获取购物车商品数
function user_cartnum() {
	global $db, $_c_cart_list;
	$user_id = $_SESSION['user_id'] ? $_SESSION['user_id'] : pe_user_id();
	$info_list = $db->pe_selectall('cart', array('cart_act'=>'cart', 'user_id'=>$user_id));
	foreach ($info_list as $v) {
		$cartnum += $v['product_num'];
	}
	return intval($cartnum);
}

//获取用户二维码
function user_qrcode($url) {
	global $pe, $db;
	$info = $db->pe_select('user', array('user_id'=>$_SESSION['user_id']), 'user_logo');
	$user_logo = $info['user_logo'] ? str_ireplace($pe['host_root'], $pe['host_path'], pe_thumb($info['user_logo'], '_120', '_120', 'avatar')) : '';
	$user_qrcode = "{$pe['path_root']}data/cache/thumb/".date('Y-m')."/".md5($url).".png";
	if (!is_file($user_qrcode)) {
		if (!is_dir("{$pe['path_root']}data/cache/thumb/".date('Y-m'))) {
			mkdir("{$pe['path_root']}data/cache/thumb/".date('Y-m'), 0777, true);		
		}
		pe_lead('include/class/phpqrcode.class.php');
		QRcode::png($url, $user_qrcode);
	}
	if ($user_logo) {
		$qrcode = imagecreatefromstring(file_get_contents($user_qrcode));
		$logo = imagecreatefromstring(file_get_contents($user_logo));
		$QR_width = imagesx($qrcode);//二维码图片宽度
		$QR_height = imagesy($qrcode);//二维码图片高度
		$logo_width = imagesx($logo);//logo图片宽度
		$logo_height = imagesy($logo);//logo图片高度
		$logo_qr_width = $QR_width / 5;
		$scale = $logo_width / $logo_qr_width;
		$logo_qr_height = $logo_height / $scale;
		$from_width = ($QR_width - $logo_qr_width) / 2;
		//重新组合图片并调整大小
		imagecopyresampled($qrcode, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
		//输出图片
		imagepng($qrcode, $user_qrcode);
	}
	return "{$pe['host_root']}data/cache/thumb/".date('Y-m')."/".md5($url).".png";	
}

//显示收款账号
function userbank_num($val) {
	if (preg_match("/^1[34578]{1}\d{9}$/", $val)) {
		$val = substr($val, 0, 3).'**'.substr($val, -4);
	}
	elseif (stripos($val, '@') !== false) {
		$val = substr($val, 0, 3).'**'.stristr($val, '@');
	}
	else {
		$val = substr($val, 0, 4).'**'.substr($val, -4);
	}
	return $val;
}

//检测游客购买
function user_checkguest() {
	global $cache_setting;
	if ($_SESSION['user_id'] or $cache_setting['web_guestbuy']) return true;
	return false;
}

//添加推荐用户
function add_tguser($user_id) {
	global $db;
	//选出父级用户
	$info = $db->pe_select('user', array('user_id'=>$user_id), "`user_id`, `user_name`, `user_atime`, `tguser_id`, `tguser_name`");
	//选出所有上级用户
	$info_list = $db->index('tguser_level')->pe_selectall('tguser', array('user_id'=>$info['tguser_id']), "`tguser_id`, `tguser_name`, `tguser_level`");
	$info_list[0] = array('tguser_id'=>$info['tguser_id'], 'tguser_name'=>$info['tguser_name']);
	foreach ($info_list as $k=>$v) {
		//if (!$v['user_id']) continue;
		$sql_set['tguser_id'] = $v['tguser_id'];
		$sql_set['tguser_name'] = $v['tguser_name'];
		$sql_set['tguser_level'] = $k+1;
		$sql_set['user_id'] = $info['user_id'];
		$sql_set['user_name'] = $info['user_name'];
		$sql_set['user_atime'] = $info['user_atime'];
		$db->pe_insert('tguser', pe_dbhold($sql_set));
	}
}

//添加下单收货地址
function useraddr_add($info) {
	global $db, $_s_user_id, $_c_pe_useraddr;
	if (pe_login('user')) {
		if ($info['address_default'] == 1) {
			$db->pe_update('useraddr', array('user_id'=>$_s_user_id), array('address_default'=>0));
		}
		$result = $address_id = $db->pe_insert('useraddr', pe_dbhold($info));
	}
	else {
		$useraddr_list = pe_getcookie('pe_useraddr', 'array');
		if ($info['address_default'] == 1) {
			foreach ($useraddr_list as $k=>$v) {
				$useraddr_list[$k]['address_default'] = 0; 
			}
		}
		$info['address_id'] = $address_id = md5(time().rand(1,99999));
		$address_new = array($address_id=>$info);
		$useraddr_list = count($useraddr_list) ? array_merge($address_new, $useraddr_list) : $address_new;
		pe_setcookie('pe_useraddr', $useraddr_list);
		$result = true;
	}
	if ($result) {
		pe_jsonshow(array('result'=>true, 'show'=>'添加成功', 'id'=>$address_id));
	}
	else {
		pe_jsonshow(array('result'=>false, 'show'=>'添加失败'));
	}
}

//获取下单收货地址
function useraddr_list($address_id) {
	global $db, $_s_user_id, $_c_pe_useraddr;
	$info_list = $info = array();
	if (pe_login('user')) {
		$info_list = $db->pe_selectall('useraddr', array('user_id'=>$_s_user_id, 'order by'=>'address_default desc, address_id desc'));
	}
	else {
		$useraddr_list = pe_getcookie('pe_useraddr', 'array');
		foreach ($useraddr_list as $k=>$v) {
			if ($v['address_default']) {
				unset($useraddr_list[$k]);
				$address_new = array($k=>$v);
			}
		}
		$info_list = is_array($address_new) ? array_merge($address_new, $useraddr_list) : $useraddr_list;
	}
	$one = key($info_list);
	foreach ($info_list as $k=>$v) {
		if ($address_id && $address_id == $v['address_id']) {
			$info_list[$k]['sel'] = 1;
			$info = $v;
		}
		elseif (!$address_id && $k == $one) {
			$info_list[$k]['sel'] = 1;
			$info = $v;			
		}
	}
	pe_jsonshow(array('result'=>true, 'list'=>$info_list, 'info'=>$info));
}
//获取下单地址详情
function useraddr_info($address_id) {
	global $db, $_s_user_id, $_c_pe_useraddr;
	if (pe_login('user')) {
		$info = $db->pe_select('useraddr', array('user_id'=>$_s_user_id, 'address_id'=>intval($address_id)));
	}
	else {
		$useraddr_list = pe_getcookie('pe_useraddr', 'array');
		foreach ($useraddr_list as $k=>$v) {
			if ($v['address_id'] == $address_id) {
				$info = $v;
				break;
			}
		}
	}
	return $info;
}
?>