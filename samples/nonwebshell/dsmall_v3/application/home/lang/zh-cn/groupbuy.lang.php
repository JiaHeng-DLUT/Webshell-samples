<?php
/**
 * 抢购状态
 */
$lang['groupbuy_state_all'] = '全部抢购';
$lang['groupbuy_state_verify'] = '未审核';
$lang['groupbuy_state_cancel'] = '已取消';
$lang['groupbuy_state_progress'] = '已通过';
$lang['groupbuy_state_fail'] = '审核失败';
$lang['groupbuy_state_close'] = '已结束';

/**
 * 抢购字段
 **/
$lang['group_template'] = '抢购活动';
$lang['group_template_tip'] = '选择要参加的抢购活动及时间段';
$lang['group_name'] = '抢购名称';
$lang['group_name_tip'] = '抢购标题名称长度最多可输入30个字符';
$lang['group_goods_sel'] = '选择商品';
$lang['group_help'] = '抢购说明';
$lang['start_time'] = '开始时间';
$lang['end_time'] = '结束时间';
$lang['goods_price'] = '商品原价';
$lang['goods_storage'] = '商品库存数';
$lang['store_price'] = '商城价';
$lang['groupbuy_price'] = '抢购价格';
$lang['groupbuy_price_tip'] = '抢购价格为该商品参加活动时的促销价格<br/>必须是0.01~1000000之间的数字(单位：元)<br/>抢购价格应包含邮费，抢购商品系统默认不收取邮费';
$lang['limit_type'] = '限制类型';
$lang['virtual_quantity'] = '虚拟数量';
$lang['min_quantity'] = '成抢数量';
$lang['sale_quantity'] = '限购数量';
$lang['max_num'] = '商品总数';
$lang['group_intro'] = '本抢介绍';
$lang['group_pic'] = '抢购图片';
$lang['group_edit'] = '编辑内容';

$lang['groupbuy_class'] = '抢购类别';
$lang['groupbuy_class_tip'] = '请选择抢购商品的所属类别';
$lang['groupbuy_area'] = '所属区域';
$lang['groupbuy_goods'] = '抢购商品';
$lang['groupbuy_goods_explain'] = '点击上方输入框从已发布商品中选择要参加抢购的商品';
$lang['min_quantity_explain'] = '抢购成功的最低数值，默认为 "1"';
$lang['virtual_quantity_explain'] = '虚拟购买数量，只用于前台显示，不影响成交记录';
$lang['sale_quantity_explain'] = '每个买家ID可抢购的最大数量，不限数量请填 "0"';
$lang['max_num_explain'] = '抢购商品总数应等于或小于该商品库存数量<br/>请提前确认要参与活动的商品库存数量足够充足';
$lang['group_pic_explain'] = '用于抢购活动页面的图片,请使用宽度440像素、高度293像素、大小1M内的图片，<br/>支持jpg、jpeg、gif、png格式上传。';
$lang['group_pic_explain2'] = '用于抢购页侧边推荐位，首页推荐位的图片,请使用宽度210像素、高度180像素、大小1M内的图片，<br/>支持jpg、jpeg、gif、png格式上传。';
$lang['groupbuy_message_not_start'] = '抢购活动尚未开始';
$lang['groupbuy_message_close'] = '抢购活动已经结束';
$lang['groupbuy_message_start'] = '数量有限请您尽快下单';
$lang['groupbuy_message_success'] = '抢购成功可继续购买';

/**
 * 错误提示
 **/
$lang['groupbuy_unavailable'] = '抢购功能没有开启';
$lang['no_groupbuy_template_in_progress'] = '没有正在进行中的抢购活动';
$lang['no_groupbuy_info'] = '没有抢购信息';
$lang['no_groupbuy_template_soon'] = '没有即将开始的抢购活动';
$lang['no_groupbuy_template_history'] = '没有历史抢购活动';
$lang['no_groupbuy'] = '当前没有抢购信息';
$lang['param_error'] = '参数错误';
$lang['group_name_error'] = '抢购名称不能为空';
$lang['group_goods_error'] = '请选择抢购商品';
$lang['group_help_error'] = '抢购说明不能为空';
$lang['start_time_error'] = '开始时间不能为空';
$lang['end_time_error'] = '结束时间不能为空';
$lang['groupbuy_price_error'] = '请输入正确的抢购价格';
$lang['group_pic_error'] = '抢购图片不能为空，且必须为jpg/gif/png格式';
$lang['min_quantity_error'] = '成抢数量不能为空，且必须为大于0的整数';
$lang['virtual_quantity_error'] = '虚拟数量不能为空，且必须为整数';
$lang['sale_quantity_error'] = '限购数量不能为空，其必须为整数';
$lang['max_num_error'] = '商品总数不能为空，且必须小于当前库存';
$lang['groupbuy_none'] = '平台当前没有进行中的抢购活动';
$lang['group_goods_is_exist'] = '该商品已经在本期抢购活动中，请选择其它商品';
$lang['goods_info'] = '商品信息';
$lang['buyer_list'] = '购买记录';
$lang['store_info'] = '店铺信息';
$lang['groupbuy_not_state'] = '抢购活动尚未开始';
$lang['groupbuy_closed'] = '抢购活动已经结束';
$lang['goods_not_enough'] = '商品库存不足';
$lang['groupbuy_not_enough'] = '抢购余额不足';
$lang['groupbuy_sale_quantity'] = '您最多只能购买';
$lang['can_not_buy'] = '您不能购买自己发布的商品';

$lang['groupbuy_add_success'] = '抢购活动发布成功请等待审核';
$lang['groupbuy_add_fail'] = '抢购活动发布失败';
$lang['groupbuy_edit_success'] = '抢购活动编辑成功';
$lang['groupbuy_edit_fail'] = '抢购活动编辑失败';
$lang['groupbuy_quota_add_success'] = '抢购活动套餐购买成功';

/**
 * 文字
 **/
$lang['groupbuy_title'] = '商品抢购';
$lang['groupbuy_soon'] = '即将开始';
$lang['groupbuy_history'] = '往期抢购';
$lang['text_year'] = '年';
$lang['text_month'] = '月';
$lang['text_day'] = '日';
$lang['text_tian'] = '天';
$lang['text_hour'] = '小时';
$lang['text_minute'] = '分';
$lang['text_second'] = '秒';
$lang['text_to'] = '至';
$lang['text_di'] = '第';
$lang['text_qi'] = '期';
$lang['text_groupbuy'] = '商城抢购';
$lang['text_groupbuy_list'] = '抢购列表';
$lang['text_groupbuy_detail'] = '抢购详情';
$lang['text_goods_price'] = '原价';
$lang['text_zhe'] = '折';
$lang['text_discount'] = '折扣';
$lang['text_save'] = '节省';
$lang['groupbuy_buy'] = '我要抢';
$lang['groupbuy_close'] = '已结束';
$lang['text_end_time'] = '距离本期结束';
$lang['text_start_time'] = '距离本期开始';
$lang['text_no_limit'] = '不限';
$lang['text_class'] = '分类';
$lang['text_price'] = '价格';
$lang['text_unit_price'] = '单价';
$lang['text_default'] = '默认';
$lang['text_sale'] = '销量';
$lang['text_rebate'] = '折扣';
$lang['text_order'] = '排序';
$lang['text_country'] = '全国';
$lang['text_people'] = '人';
$lang['text_buy'] = '已购买';
$lang['text_jiangyu'] = '将于';
$lang['text_start'] = '准时开抢';
$lang['see_store'] = '逛逛店铺';
$lang['see_goods'] = '查看商品';
$lang['to_see'] = '去看看';
$lang['history_hot'] = '往期热销排行';
$lang['current_hot'] = '本期热门抢购';
$lang['text_buyer'] = '买家';
$lang['text_buy_count'] = '购买数量';
$lang['text_buy_now'] = '立即购买';
$lang['text_buy_time'] = '下单时间';
$lang['text_piece'] = '件';
$lang['text_goods_buy'] = '本商品已被抢购';
$lang['text_goods_store'] = '商品所在店铺';
$lang['text_goods_commend'] = '店铺推荐商品';
$lang['text_read_agree1'] = '我已阅读';
$lang['text_read_agree2'] = '并同意';
$lang['text_agreement'] = '抢购服务协议';
$lang['agree_must'] = '您必须同意本协议';
$lang['store_goods_album_insert_users_photo'] = '插入相册图片';
$lang['text_remain'] = '剩余';

/**
 * index
 */
$lang['groupbuy_index_no_right']			= '您的店铺等级没有此权限';
$lang['groupbuy_index_in_audit']			= '您的店铺等级正在审核中';
$lang['groupbuy_index_add_success']			= '添加抢购活动成功';
$lang['groupbuy_index_add_fail']			= '添加抢购活动失败';
$lang['groupbuy_index_not_exists']			= '未找到抢购活动';
$lang['groupbuy_index_modify_success']		= '修改抢购活动成功';
$lang['groupbuy_index_modify_fail']			= '修改抢购活动失败';
$lang['groupbuy_index_default_spec']		= '默认规格';
$lang['groupbuy_index_all_group']			= '全部抢购';
$lang['groupbuy_index_unpublish']			= '未发布';
$lang['groupbuy_index_canceled']			= '已取消';
$lang['groupbuy_index_going']				= '进行中';
$lang['groupbuy_index_finished']			= '已完成';
$lang['groupbuy_index_ended']				= '已结束';
$lang['groupbuy_index_num']					= '(人数)';
$lang['groupbuy_index_amount']				= '(数量)';
$lang['groupbuy_index_desc']				= '说明';
$lang['groupbuy_index_order_num']			= '订购数';
$lang['groupbuy_index_input_name']			= '请填写抢购名称';
$lang['groupbuy_index_desc']				= '抢购说明';
$lang['groupbuy_index_end_time']			= '结束时间';
$lang['groupbuy_index_search_first']		= '请先搜索抢购商品';
$lang['groupbuy_index_input_right_num']		= '请正确填写成抢人数';
$lang['groupbuy_index_input_right_amount']	= '请正确填写成抢件数';
$lang['groupbuy_index_def_quantity_error']  = '请正确填写已订购数';
$lang['groupbuy_index_goods_sum_null']		= '商品总数不能为空';
$lang['groupbuy_index_goods_sum_one']		= '商品总数不能小于1';
$lang['groupbuy_index_input_right_price']	= '请正确填写抢购价格';
$lang['groupbuy_index_max_per_user_error']  = '请正确填写每人限购数量';
$lang['groupbuy_index_input_price']			= '请填写抢购价格';
$lang['groupbuy_index_base_info']			= '抢购基本信息';
$lang['groupbuy_index_activity_name']		= '活动名称';
$lang['groupbuy_index_publish_now']			= '立即发布';
$lang['groupbuy_index_yes']					= '是';
$lang['groupbuy_index_no']					= '否';
$lang['groupbuy_index_publish_tip']			= '如果“立即发布”，除“抢购说明”外的信息将不能再被更改';
$lang['groupbuy_index_start_time']			= '开始时间';
$lang['groupbuy_index_end_time']			= '结束时间';
$lang['groupbuy_index_goods_info']			= '抢购商品信息';
$lang['groupbuy_index_choose_goods']		= '选择商品';
$lang['groupbuy_index_order_num_now']		= '已订购数';
$lang['groupbuy_index_order_num_published']	= '发布后显示的已订购数';
$lang['groupbuy_index_condition']			= '限制条件';
$lang['groupbuy_index_by_num']				= '以购买成功人数成抢';
$lang['groupbuy_index_by_amount']			= '以产品购买数量成抢';
$lang['groupbuy_index_group_num']			= '成抢人数';
$lang['groupbuy_index_group_espect_num']	= '能完成抢购的期望订购人数';
$lang['groupbuy_index_group_amount']		= '成抢件数';
$lang['groupbuy_index_group_espect_amount']	= '能完成抢购的期望订购件数';
$lang['groupbuy_index_amount_limit']		= '每人限购';
$lang['groupbuy_index_amount_limit_tip']	= '每个参抢者最多能订购的件数，0为不限制';
$lang['groupbuy_index_goods_sum']			= '商品总数';
$lang['groupbuy_index_amount_max_limit']	= '所有参抢者最多能订购的数量，默认为商品库存数';
$lang['groupbuy_index_intro']				= '本抢介绍';
$lang['groupbuy_index_spec_price']			= '规格价格';
$lang['groupbuy_index_spec']				= '规格';
$lang['groupbuy_index_stock']				= '库存';
$lang['groupbuy_index_store_price']			= '店铺价格';
$lang['groupbuy_index_group_price']			= '抢购价';
$lang['groupbuy_index_search']				= '查询';
$lang['groupbuy_index_submit']				= '提交';
$lang['groupbuy_index_new_group']			= '新增抢购';
$lang['groupbuy_index_activity_state']		= '活动状态';
$lang['groupbuy_index_start_time']			= '起始时间';
$lang['groupbuy_index_group_num']			= '已抢购';
$lang['groupbuy_index_to']					= '至';
$lang['groupbuy_index_year']				= '年';
$lang['groupbuy_index_month']				= '月';
$lang['groupbuy_index_day']					= '日';
$lang['groupbuy_index_publish_tip']			= '发布后除修改说明外不能再被编辑，您确定要发布吗';
$lang['groupbuy_index_publish']				= '发布';
$lang['groupbuy_index_del_tip']				= '若该抢购已完成，则删除该抢购将导致未下单的用户无法下单，您确定要这么做吗';
$lang['groupbuy_index_order']				= '订单';
$lang['groupbuy_index_order_state']			= '订购情况';
$lang['groupbuy_index_finish_tip']			= '该操作将要把抢购设置为成功状态，您确定要结束预定吗';
$lang['groupbuy_index_finish']				= '完成';
$lang['groupbuy_index_end']				    = '结束预定';
$lang['groupbuy_index_no_record']			= '没有找到符合条件的商品';
$lang['groupbuy_index_loading_list']		= '正在加载商品列表';
$lang['groupbuy_index_no_goods']			= '没有找到相关商品';
$lang['groupbuy_index_choose_goods']		= '选择商品';
$lang['groupbuy_index_goods_name']			= '商品名称';
$lang['groupbuy_index_store_class']			= '本店分类';
$lang['groupbuy_index_please_choose']		= '全部分类';
$lang['groupbuy_index_search_back']			= '请先从上面搜索';
$lang['groupbuy_index_publish_success']		= '发布成功';
$lang['groupbuy_index_change_to_finish']		= '已更改状态为完成';
$lang['groupbuy_index_group_canceled']			= '抢购商品已取消';
$lang['groupbuy_index_modify_intro_success']	= '修改商品说明成功';
$lang['groupbuy_index_modify_order_num_sucess']	= '修改商品订购数成功';
$lang['groupbuy_index_cancel_reason']			= '取消原因';
$lang['groupbuy_index_username']				= '用户名';
$lang['groupbuy_index_linkman']					= '联系人';
$lang['groupbuy_index_phone']					= '联系电话';
$lang['groupbuy_index_jian']					= '件';
$lang['groupbuy_index_no_record_now']			= '暂无订购记录';
$lang['groupbuy_index_del_success']		= '删除抢购活动成功';
$lang['groupbuy_index_del_fail']		= '删除抢购活动失败';
$lang['groupbuy_index_datefail']		= '日期不能小于当日，\n默认抢购时间为7天！';
$lang['groupbuy_index_startdatefail']		= '抢购开始时间不早于当日，\n默认抢购开始时间为当日！';

//groupbug
$lang['virtual_grab']					= '虚拟抢';
$lang['online_grab']					= '线上抢';
$lang['maximum_purchase_per_person']					= '每人最多购买';
$lang['limited_quantity']					= '数量有限，欲购从速!';
$lang['people_have_been_robbed']					= '人已抢';
$lang['remaining_time']					= '剩余时间';
$lang['product_evaluation']					= '商品评价';
$lang['use_statement']					= '使用声明';
$lang['explanatory_text1']					= ' 1. 本次抢购活动的最终有效期至';
$lang['explanatory_text2']					= '，兑换码/券的使用期限是';
$lang['explanatory_text3']					= '，逾期未使用将被视为自动放弃兑换';
$lang['explanatory_text4']					= '2. 消费抢购兑换码/券时，请向商家提供系统发送的“虚拟抢购兑换码”，一码一销。';
$lang['explanatory_text5']					= '3. 单人每笔订单最多抢购';
$lang['explanatory_text6']					= '个兑换码/券，如需更多请再次购买。';
$lang['praise']					= '好评';
$lang['people_participation_score']					= '人参与评分';
$lang['common']					= '共有';
$lang['medium_rating']					= '中评';
$lang['poor_rating']					= '差评';
$lang['goods_evaluated']					= '您可对已购商品进行评价';
$lang['evaluation_goods']					= '评价商品';
$lang['captions_merchants']					= '商&#12288;&#12288;家';
$lang['composite_score']					= '综合评分';
$lang['store_dynamic_score']					= '店铺动态评分';
$lang['compared_with_industry']					= '与行业相比';
$lang['online_customer_service']					= '在线客服';
$lang['captions_phone']					= '电&#12288;&#12288;话';
$lang['captions_address']					= '地&#12288;&#12288;址';
$lang['traffic_information']					= '交通信息';
$lang['enter_stores']					= '进入商家店铺';
$lang['store_name']					= '商铺名称';
$lang['store_address']					= '商铺地址';


//groupbuy_evaluate
$lang['user_rating']					= '用户评分';
$lang['evaluation_details']					= '评价详情';
$lang['explanation']					= '解释';
$lang['photo_posting']					= '晒单图片';

//groupbuy_list
$lang['ongoing']					= '正在进行';
$lang['about_to_start']					= '即将开始';
$lang['finished']					= '已经结束';

//groupbuy_order
$lang['no_purchase']					= '暂无人购买';

//index
$lang['online_snap_up_recommendations']					= '线上抢购推荐';
$lang['check_out_more']					= '查看更多';
$lang['snap_up_recommendations_wirelessly']					= '暂无线上抢购推荐';
$lang['virtual_panic_buying_recommendation']					= '虚拟抢购推荐';
$lang['no_virtual_panic_buying_recommendation']					= '暂无虚拟抢购推荐';


//controller
$lang['not_at_the'] = '未开始';
$lang['has_ended'] = '已结束';



