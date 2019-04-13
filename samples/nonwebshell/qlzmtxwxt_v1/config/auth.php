<?php
return [
			'auth_on'           => 1, // 权限开关
		    'auth_type'         => 1, // 认证方式，1为实时认证；2为登录认证。
		    'auth_role'         => 'admin_role', // 用户组数据不带前缀表名

		    'auth_role_access'  => 'admin_role_access', // 用户-用户组关系不带前缀表名

		    'auth_rule'         => 'admin_nav', // 权限规则不带前缀表名
		    'auth_user'         => 'admin', // 用户信息不带前缀表名
 ];