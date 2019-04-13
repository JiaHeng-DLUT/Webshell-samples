<?php
$lang['voucher_unavailable']    = '代金券功能尚未开启';
$lang['voucher_quotastate_activity']	= '正常';
$lang['voucher_quotastate_cancel']    = '取消';
$lang['voucher_quotastate_expire']    = '结束';
$lang['voucher_templatestate_usable']	= '有效';
$lang['voucher_templatestate_disabled']= '失效';
$lang['voucher_quotalist']= '套餐列表';
$lang['voucher_applyquota']= '申请套餐';
$lang['voucher_applyadd']= '购买套餐';
$lang['voucher_templateadd']= '新增代金券';
$lang['voucher_templateedit']= '编辑代金券';
$lang['voucher_templateinfo']= '代金券详细';
/**
 * 套餐申请
 */
$lang['voucher_apply_num_error']= '数量不能为空，且必须为1-12之间的整数';
$lang['voucher_apply_fail']= '套餐申请失败';
$lang['voucher_apply_succ']= '套餐申请成功，请等待审核';
$lang['voucher_apply_date']= '申请日期';
$lang['voucher_apply_num']    		= '申请数量';
$lang['voucher_apply_addnum']    		= '套餐购买数量';
$lang['voucher_apply_add_tip1']    		= '购买单位为月(30天)，一次最多购买12个月，您可以在所购买周期内以月为单位发布代金券活动';
$lang['voucher_apply_add_tip2']    		= '每月您需要支付%s元';
$lang['voucher_apply_add_tip3']    		= '每月最多发布活动%s次';
$lang['voucher_apply_add_tip4']    		= '套餐时间从审批后开始计算';
$lang['voucher_apply_add_confirm1']    	= '您总共需要支付';
$lang['voucher_apply_add_confirm2']    	= '元,确认购买吗？';
$lang['voucher_apply_buy_succ']			= '套餐购买成功';

/**
 * 套餐
 */
$lang['voucher_quota_startdate']    	= '开始时间';
$lang['voucher_quota_enddate']    		= '结束时间';
$lang['voucher_quota_timeslimit']    	= '活动次数限制';
$lang['voucher_quota_publishedtimes']   = '已发布活动次数';
$lang['voucher_quota_residuetimes']    	= '剩余活动次数';
/**
 * 代金券模板
 */
$lang['voucher_template_quotanull']			= '当前没有可用的套餐，请先申请套餐';
$lang['voucher_template_noresidual']		= "当前套餐中活动已满%s条活动信息，不可再发布活动";
$lang['voucher_template_pricelisterror']	= '平台代金券面额设置出现问题，请联系客服帮助解决';
$lang['voucher_template_title_error'] 		= "模版名称不能为空且不能大于50个字符";
$lang['voucher_template_total_error'] 		= "可发放数量不能为空且必须为整数";
$lang['voucher_template_price_error']		= "模版面额不能为空且必须为整数，且面额不能大于限额";
$lang['voucher_template_limit_error'] 		= "模版使用消费限额不能为空且必须是数字";
$lang['voucher_template_describe_error'] 	= "模版描述不能为空且不能大于255个字符";
$lang['voucher_template_title']			= '代金券名称';
$lang['voucher_template_enddate']		= '有效期';
$lang['voucher_template_enddate_tip']		= '有效期应在套餐有效期内，正使用的套餐有效期为';
$lang['voucher_template_price']			= '面额';
$lang['voucher_template_total']			= '可发放总数';
$lang['voucher_template_eachlimit']		= '每人限领';
$lang['voucher_template_eachlimit_item']= '不限';
$lang['voucher_template_eachlimit_unit']= '张';
$lang['voucher_template_orderpricelimit']	= '消费金额';
$lang['voucher_template_describe']		= '代金券描述';
$lang['voucher_template_styleimg']		= '选择代金券皮肤';
$lang['voucher_template_styleimg_text']	= '店铺优惠券';
$lang['voucher_template_image']			= '代金券图片';
$lang['voucher_template_image_tip']		= '该图片将在积分中心的代金券模块中显示，上传后点击保存，建议尺寸为160*160px。';
$lang['voucher_template_list_tip1'] = "1、手工设置代金券失效后,用户将不能领取该代金券,但是已经领取的代金券仍然可以使用";
$lang['voucher_template_list_tip2'] = "2、代金券模版和已发放的代金券过期后自动失效";
$lang['voucher_template_backlist'] 	= "返回列表";
$lang['voucher_template_giveoutnum']= '已领取';
$lang['voucher_template_usednum']	= '已使用';
/**
 * 代金券
 */
$lang['voucher_voucher_state'] = "状态";
$lang['voucher_voucher_state_unused'] = "未使用";
$lang['voucher_voucher_state_used'] = "已使用";
$lang['voucher_voucher_state_expire'] = "已过期";
$lang['voucher_voucher_price'] = "金额";
$lang['voucher_voucher_storename'] = "适用店铺";
$lang['voucher_voucher_indate'] = "有效期";
$lang['voucher_voucher_usecondition'] = "使用条件";
$lang['voucher_voucher_usecondition_desc'] = "订单满";
$lang['voucher_voucher_vieworder'] = "查看订单";
$lang['voucher_voucher_readytouse'] = "马上使用";
$lang['voucher_voucher_code'] = "编码";

//index
$lang['set_meal_renewal']		= '套餐续费';
$lang['set_expiration_time']		= '套餐过期时间';
$lang['please_buy_package_first']		= '当前没有可用套餐，请先购买套餐';
$lang['deduction_settlement_payment_days']		= '相关费用会在店铺的账期结算中扣除';

//templateadd
$lang['store_classification']		= '店铺分类';
$lang['blank_defaults']		= '留空则默认30天之后到期';
$lang['image_upload']		= '图片上传';

$lang['voucher_template_eachlimit']		= '每人限领';

//controller
$lang['buy_voucher_package'] = '购买代金券套餐';
$lang['buy'] = '购买';
$lang['voucher_plan'] = '份代金券套餐，单价';
