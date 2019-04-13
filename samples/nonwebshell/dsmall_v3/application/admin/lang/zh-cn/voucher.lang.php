<?php
$lang['admin_voucher_unavailable']    = '需开启 代金券、积分，正在跳转到设置页面 。。。';
$lang['admin_voucher_quotastate_activity']	= '正常';
$lang['admin_voucher_quotastate_cancel']    = '取消';
$lang['admin_voucher_quotastate_expire']    = '结束';
$lang['admin_voucher_templatestate_usable']	= '有效';
$lang['admin_voucher_templatestate_disabled']= '失效';
$lang['admin_voucher_storename']			= '店铺名称';
$lang['admin_voucher_cancel_confirm']    	= '您确认进行取消操作吗？';
$lang['admin_voucher_verify_confirm']    	= '您确认进行审核操作吗？';
//菜单
$lang['admin_voucher_apply_manage']= '套餐申请管理';
$lang['admin_voucher_quota_manage']= '套餐管理';
$lang['admin_voucher_template_manage']= '店铺代金券';
$lang['admin_voucher_template_edit']= '编辑代金券';
$lang['admin_voucher_setting']		= '设置';
$lang['admin_voucher_pricemanage']		= '面额设置';
$lang['admin_voucher_priceadd']		= '添加面额';
$lang['admin_voucher_priceedit']		= '面额编辑';
$lang['admin_voucher_styletemplate']	= '样式模板';
/**
 * 设置
 */
$lang['admin_voucher_setting_price_error']		= '购买单价应为大于0的整数';
$lang['admin_voucher_setting_storetimes_error']	= '每月活动数量应为大于0的整数';
$lang['admin_voucher_setting_buyertimes_error']	= '最大领取数量应为大于0的整数';
$lang['admin_voucher_setting_price']			= '购买单价（元/月）';
$lang['admin_voucher_setting_price_tip']		= '购买代金劵活动所需费用，购买后卖家可以在所购买周期内发布代金劵促销活动';
$lang['admin_voucher_setting_storetimes']		= '每月活动数量';
$lang['admin_voucher_setting_storetimes_tip']	= '每月最多可以发布的代金劵促销活动数量';
$lang['admin_voucher_setting_buyertimes']		= '买家最大领取数量';
$lang['admin_voucher_setting_buyertimes_tip']	= '买家最多只能拥有同一个店铺尚未消费抵用的店铺代金券最大数量';
//$lang['admin_voucher_setting_default_styleimg']	= '代金券默认样式模板';
/**
 * 代金券面额
 */
$lang['admin_voucher_price_error']   		= '代金券面额应为大于0的整数';
$lang['admin_voucher_price_describe_error'] = '描述不能为空';
$lang['admin_voucher_price_describe_lengtherror'] = '代金券描述不能为空且不能大于255个字符';
$lang['admin_voucher_price_points_error']   = '默认兑换积分数应为大于0的整数';
$lang['admin_voucher_price_exist']    		= '该代金券面额已经存在';
$lang['admin_voucher_price_title']    		= '代金券面额';
$lang['admin_voucher_price_describe']    	= '描述';
$lang['admin_voucher_price_points']    		= '兑换积分数';
$lang['admin_voucher_price_points_tip']    	= '当兑换代金券时，消耗的积分数';
$lang['admin_voucher_price_tip1']    	= '管理员规定代金券面额，店铺发放代金券时面额从规定的面额中选择';
/**
 * 代金券套餐申请
 */
$lang['admin_voucher_apply_message']    	= '您成功购买代金券活动%s个月，单价%s金币，总共花费%s金币，时间从审核后开始计算';
$lang['admin_voucher_apply_verifysucc']    	= '申请审核成功，活动套餐已经发放';
$lang['admin_voucher_apply_verifyfail']    	= '申请审核失败';
$lang['admin_voucher_apply_cancelsucc']    	= '申请取消成功';
$lang['admin_voucher_apply_cancelfail']    	= '申请取消失败';
$lang['admin_voucher_apply_list_tip1']    	= '对卖家的套餐申请进行审核，审核后系统会使用站内信通知卖家';
$lang['admin_voucher_apply_list_tip2']    	= '当卖家金币不足时审核会失败，卖家发布成功的代金券会出现在积分中心，买家可凭积分进行兑换';
$lang['admin_voucher_apply_num']    		= '申请数量';
$lang['admin_voucher_apply_date']    		= '申请日期';
/**
 * 代金券套餐
 */
$lang['admin_voucher_quota_cancelsucc']    	= '套餐取消成功';
$lang['admin_voucher_quota_cancelfail']    	= '套餐取消失败';
$lang['admin_voucher_quota_tip1']    	= '取消操作后不可恢复，请慎重操作';

$lang['admin_voucher_quota_startdate']    	= '开始时间';
$lang['admin_voucher_quota_enddate']    	= '结束时间';
$lang['admin_voucher_quota_timeslimit']    	= '活动次数限制';
$lang['admin_voucher_quota_publishedtimes']    	= '已发布活动次数';
$lang['admin_voucher_quota_residuetimes']    	= '剩余活动次数';
/**
 * 代金券
 */
$lang['admin_voucher_template_points_error']	= '兑换所需积分数应为大于0的整数';
$lang['admin_voucher_template_title']			= '代金券名称';
$lang['admin_voucher_template_enddate']			= '有效期';
$lang['admin_voucher_template_price']			= '面额';
$lang['admin_voucher_template_total']			= '可发放总数';
$lang['admin_voucher_template_eachlimit']		= '每人限领';
$lang['admin_voucher_template_orderpricelimit']	= '消费金额';
$lang['admin_voucher_template_describe']		= '代金券描述';
$lang['admin_voucher_template_styleimg']		= '选择代金券皮肤';
$lang['admin_voucher_template_image']			= '代金券图片';
$lang['admin_voucher_template_points']			= '兑换所需积分数';
$lang['admin_voucher_template_adddate']			= '添加时间';
$lang['admin_voucher_template_list_tip']		= '手工设置代金券失效后,用户将不能领取该代金券,但是已经领取的代金券仍然可以使用';
$lang['admin_voucher_template_giveoutnum']		= '已领取';
$lang['admin_voucher_template_usednum']			= '已使用';