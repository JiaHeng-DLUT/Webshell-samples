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
 * index
 */
$lang['groupbuy_index_manage']		= '抢购管理';
$lang['groupbuy_verify']    		= '待审核';
$lang['groupbuy_cancel']    		= '已取消';
$lang['groupbuy_progress']  		= '已审核';
$lang['groupbuy_close']     		= '已结束';
$lang['groupbuy_back']     		= '返回列表';

$lang['groupbuy_recommend_goods']	= '推荐商品';
$lang['groupbuy_template_list']		= '抢购活动';
$lang['groupbuy_template_add']		= '添加活动';
$lang['groupbuy_template_name']		= '活动名称';
$lang['groupbuy_class_list']		= '抢购分类';
$lang['groupbuy_class_add']		    = '添加分类';
$lang['groupbuy_class_edit']	    = '编辑分类';
$lang['groupbuy_class_name']	    = '分类名称';
$lang['groupbuy_parent_class']	    = '父级分类';
$lang['groupbuy_root_class']	    = '一级分类';
$lang['groupbuy_area_list'] 		= '抢购地区';
$lang['groupbuy_area_add']		    = '添加地区';
$lang['groupbuy_area_edit'] 	    = '编辑地区';
$lang['groupbuy_area_name'] 	    = '地区名称';
$lang['groupbuy_parent_area']	    = '父级地区';
$lang['groupbuy_root_area'] 	    = '一级地区';
$lang['groupbuy_price_list']		= '抢购价格区间';
$lang['groupbuy_price_add']		    = '添加价格区间';
$lang['groupbuy_price_edit']	    = '编辑价格区间';
$lang['groupbuy_price_name']	    = '价格区间名称';
$lang['groupbuy_price_range_start']	    = '价格区间上限';
$lang['groupbuy_price_range_end']	    = '价格区间下限';
$lang['groupbuy_detail'] = '抢购信息详情';
$lang['gprange_name']	    = '价格区间名称';
$lang['gprange_start']	    = '价格区间下限';
$lang['gprange_end']	    = '价格区间上限';
$lang['groupbuy_index_name']		= '抢购名称';
$lang['groupbuy_index_goods_name']	= '商品名称';
$lang['groupbuy_index_store_name']	= '店铺名称';
$lang['start_time']             	= '开始时间';
$lang['end_time']               	= '结束时间';
$lang['join_end_time']             	= '报名截止时间';
$lang['groupbuy_index_start_time']	= '开始时间';
$lang['groupbuy_index_end_time']	= '结束时间';
$lang['day']						= '日';
$lang['hour']						= '时';
$lang['groupbuy_index_state']		= '抢购状态';
$lang['groupbuy_index_pub_state']	= '发布状态';
$lang['groupbuy_index_click']		= '浏览数';
$lang['groupbuy_index_long_group']	= '长期活动';
$lang['groupbuy_index_un_pub']		= '未发布';
$lang['groupbuy_index_canceled']	= '已取消';
$lang['groupbuy_index_going']		= '进行中';
$lang['groupbuy_index_finished']	= '已完成';
$lang['groupbuy_index_ended']		= '已结束';
$lang['groupbuy_index_published']	= '已发布';
$lang['group_template'] = '抢购活动';
$lang['group_name'] = '抢购名称';
$lang['store_name'] = '店铺名称';
$lang['goods_name'] = '商品名称';
$lang['group_help'] = '抢购说明';
$lang['start_time'] = '开始时间';
$lang['end_time'] = '结束时间';
$lang['goods_price'] = '商品原价';
$lang['store_price'] = '商城价';
$lang['groupbuy_price'] = '抢购价格';
$lang['limit_type'] = '限制类型';
$lang['virtual_quantity'] = '虚拟数量';
$lang['min_quantity'] = '成抢数量';
$lang['sale_quantity'] = '限购数量';
$lang['max_num'] = '商品总数';
$lang['group_intro'] = '本抢介绍';
$lang['group_pic'] = '抢购图片';
$lang['buyer_count'] = '已购买人数';
$lang['def_quantity'] = '已购商品数量';
$lang['base_info'] = '基本信息';


/**
 * 页面说明
 **/
$lang['groupbuy_template_help1'] = '点击活动的管理按钮查看活动详细信息，对抢购申请进行审批管理';
$lang['groupbuy_template_help2'] = '未开始的活动可以直接删除，删除后该活动下的所有抢购信息将被同时删除';
$lang['groupbuy_template_help3'] = '活动开始后可以点击关闭按钮手动关闭该活动';
$lang['groupbuy_template_help4'] = '推荐抢购商品到首页，请到抢购活动管理页面点亮推荐列下的对勾';
$lang['groupbuy_template_add_help1'] = '活动时间不能重叠，新活动的开始时间必须大于已有活动的结束时间';
$lang['groupbuy_template_add_help2'] = '报名截止时间必须小于活动开始时间';
$lang['groupbuy_starttime_explain'] = '抢购活动开始时间不能早于';
$lang['groupbuy_class_help1'] = '抢购分类后台为2级分类，前台默认显示1级，如需扩展需要二次开发';
$lang['groupbuy_area_help1'] = '抢购地区后台为3级分类，前台默认显示1级，如需扩展需要二次开发';
$lang['groupbuy_price_range_help1'] = '前台抢购按价格筛选的区间，各个区间段的金额不要发生重叠';
$lang['groupbuy_index_help1']		= "点击导航菜单中的'返回列表'链接返回活动列表页";
$lang['groupbuy_index_help2']		= '抢购信息审核后才会出现在前台页面';
$lang['groupbuy_parent_class_add_tip'] = '请选择父级分类，默认为一级分类';
$lang['groupbuy_parent_area_add_tip'] = '请选择父级地区，默认为一级地区';
$lang['sort_tip'] = '排序数值从0到255，数字0优先级最高';
$lang['price_range_tip'] = "区间名称应该明确，比如'1000元以下'和'2000元-3000元'";
$lang['price_range_price_tip'] = '价格必须为正整数';
$lang['goods_class_index_name']                = '分类名称';

$lang['groupbuy_recommend_help1'] = '此页面显示的是已经通过审核的正在抢购中的商品，只能进行推荐操作';

$lang['state_text_notstarted'] = '未开始';
$lang['state_text_in_progress'] = '进行中';
$lang['state_text_closed'] = '已关闭';

$lang['groupbuy_slider_help1'] = '该组幻灯片滚动图片应用于抢购聚合页上部使用，最多可上传4张图片。';
$lang['groupbuy_slider_help2'] = '图片要求使用宽度为970像素，高度为300像素jpg/gif/png格式的图片。';
$lang['groupbuy_slider_help3'] = '上传图片后请添加格式为“http://网址...”链接地址，设定后将在显示页面中点击幻灯片将以另打开窗口的形式跳转到指定网址。';
$lang['groupbuy_slider_help4'] = '清空操作将删除聚合页上的滚动图片，请注意操作';

/**
 * 抢购删除
 */
$lang['groupbuy_del_choose']		= '请选择要删除的内容';
$lang['groupbuy_del_succ']			= '删除成功';
$lang['groupbuy_del_fail']			= '删除失败';
/**
 * 抢购推荐
 */
$lang['groupbuy_recommend_choose']	= '请选择要推荐的内容';
$lang['groupbuy_recommend_succ']	= '推荐成功';
$lang['groupbuy_recommend_fail']	= '推荐失败';


/**
 * 提示信息
 */
$lang['class_name_error'] = '分类名称不能为空';
$lang['sort_error'] = '排序必须是数字';
$lang['area_name_error'] = '地区名称不能为空';
$lang['verify_success'] = '审核通过';
$lang['verify_fail'] = '审核失败';
$lang['ensure_verify_success'] = '确认审核通过该抢购活动?';
$lang['ensure_verify_fail'] = '确认审核失败该抢购活动?';
$lang['op_close'] = '结束';
$lang['ensure_close'] = '确认结束该抢购活动?';
$lang['template_name_error'] = '活动名称不能为空';
$lang['start_time_error'] = '开始时间不能为空';
$lang['end_time_error'] = '结束时间不能为空，且必须大于开始时间';
$lang['join_end_time_error'] = '报名截止时间不能为空';
$lang['range_name_error'] = '价格区间名称不能为空';
$lang['range_start_error'] = '价格区间上限不能为空且必须为数字';
$lang['range_end_error'] = '价格区间下限不能为空且必须为数字';
$lang['start_time_overlap'] = '抢购活动时间有重叠请您重新选择抢购开始时间';
/**
 * 提示信息
 */

$lang['admin_groupbuy_unavailable'] = '抢购功能尚未开启，是否自动开启';
$lang['groupbuy_template_add_success'] = '抢购活动添加成功';
$lang['groupbuy_template_add_fail'] = '抢购活动添加失败';
$lang['groupbuy_tempalte_drop_success'] = '抢购活动删除成功';
$lang['groupbuy_template_drop_fail'] = '抢购活动删除失败';
$lang['groupbuy_tempalte_close_success'] = '抢购活动关闭成功';
$lang['groupbuy_template_close_fail'] = '抢购活动关闭失败';
$lang['groupbuy_verify_success'] = '抢购审核操作成功';
$lang['groupbuy_verify_fail'] = '抢购审核操作失败';
$lang['groupbuy_close_success'] = '抢购结束成功';
$lang['groupbuy_close_fail'] = '抢购结束失败';
$lang['groupbuy_class_add_success'] = '抢购分类添加成功';
$lang['groupbuy_class_add_fail'] = '抢购分类添加失败';
$lang['groupbuy_class_edit_success'] = '抢购分类编辑成功';
$lang['groupbuy_class_edit_fail'] = '抢购分类编辑失败';
$lang['groupbuy_class_drop_success'] = '抢购分类删除成功';
$lang['groupbuy_class_drop_fail'] = '抢购分类删除失败';
$lang['groupbuy_area_add_success'] = '抢购地区添加成功';
$lang['groupbuy_area_add_fail'] = '抢购地区添加失败';
$lang['groupbuy_area_edit_success'] = '抢购地区编辑成功';
$lang['groupbuy_area_edit_fail'] = '抢购地区编辑失败';
$lang['groupbuy_area_drop_success'] = '抢购地区删除成功';
$lang['groupbuy_area_drop_fail'] = '抢购地区删除失败';
$lang['groupbuy_price_range_add_success'] = '抢购价格区间添加成功';
$lang['groupbuy_price_range_add_fail'] = '抢购价格区间添加失败';
$lang['groupbuy_price_range_edit_success'] = '抢购价格区间编辑成功';
$lang['groupbuy_price_range_edit_fail'] = '抢购价格区间编辑失败';
$lang['groupbuy_price_range_drop_success'] = '抢购价格区间删除成功';
$lang['groupbuy_price_range_drop_fail'] = '抢购价格区间删除失败';

$lang['groupbuy_close_confirm'] = '确认关闭抢购活动？关闭后无法再次开启。';