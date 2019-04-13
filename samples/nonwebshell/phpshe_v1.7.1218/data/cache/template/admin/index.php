<?php include(pe_tpl('header.html'));?>
<div class="right">
	<div class="index_center">
		<div class="dfk_main">
			<div class="dfk_img1"><i></i></div>
			<div class="dfk_info">
				<a href="admin.php?mod=order&state=wpay" target="_blank"><p><?php echo $tongji['order_wpay'] ?></p>待付款订单</a>
			</div>
			<div class="clear"></div>
		</div>
		<div class="dfk_main">
			<div class="dfk_img2"><i></i></div>
			<div class="dfk_info">
				<a href="admin.php?mod=order&state=wsend" target="_blank"><p><?php echo $tongji['order_wsend'] ?></p>待发货订单</a>
			</div>
		</div>
		<div class="dfk_main">
			<div class="dfk_img3"><i></i></div>
			<div class="dfk_info">
				<a href="admin.php?mod=refund&state=wcheck" target="_blank"><p><?php echo $tongji['refund_wcheck'] ?></p>待审退款/货</a>
			</div>
		</div>
		<div class="dfk_main">
			<div class="dfk_img4"><i></i></div>
			<div class="dfk_info">
				<a href="admin.php?mod=cashout" target="_blank"><p><?php echo $tongji['cashout_js'] ?></p>待结算提现</a>
			</div>
		</div>	
		<div class="clear"></div>
		<div class="xtxx_fl mat10">
			<div class="xtxx" style="height:auto; border-bottom:0">
				<div class="xt_tt"><span>数据统计</span></div>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="wenzhang_bak tj_tb">
				<tr>
					<td class="aright" width="80"><span>商品总数：</span></td>
					<td><a href="admin.php?mod=product" target="_blank"><?php echo $tongji['product_num'] ?> <span>个</span></a></td>
				</tr>
				<tr style="background:#f9fafc">
					<td class="aright"><span>商品分类：</span></td>
					<td><a href="admin.php?mod=category" target="_blank"><?php echo $tongji['category_num'] ?> <span>个</span></a></td>
				</tr>
				<tr>
					<td class="aright"><span>商品品牌：</span></td>
					<td><a href="admin.php?mod=brand" target="_blank"><?php echo $tongji['brand_num'] ?> <span>个</span></a></td>
				</tr>
				<tr style="background:#f9fafc">
					<td class="aright"><span>评价总数：</span></td>
					<td><a href="admin.php?mod=comment" target="_blank"><?php echo $tongji['comment_num'] ?> <span>个</span></a></td>
				</tr>
				<tr>
					<td class="aright"><span>订单总数：</span></td>
					<td><a href="admin.php?mod=order" target="_blank"><?php echo $tongji['order_num'] ?> <span>个</span></a></td>
				</tr>
				<tr style="background:#f9fafc">
					<td class="aright"><span>退款退货：</span></td>
					<td><a href="admin.php?mod=refund" target="_blank"><?php echo $tongji['refund_num'] ?> <span>个</span></a></td>
				</tr>
				<!--<tr>
					<td class="aright"><span>限时折扣：</span></td>
					<td><?php echo $tongji['zhekou_num'] ?> <span>个</span></td>
				</tr>
				<tr style="background:#f9fafc">
					<td class="aright"><span>限时拼团：</span></td>
					<td><?php echo $tongji['pintuan_num'] ?> <span>个</span></td>
				</tr>-->
				</table>
				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="wenzhang_bak tj_tb">
				<tr>
					<td class="aright" width="80"><span>访客总数：</span></td>
					<td><a href="admin.php?mod=tongji" target="_blank"><?php echo $tongji['iplog_num'] ?> <span>人</span></a></td>
				</tr>
				<tr style="background:#f9fafc">
					<td class="aright" width="80"><span>会员总数：</span></td>
					<td><a href="admin.php?mod=user" target="_blank"><?php echo $tongji['user_num'] ?> <span>人</span></a></td>
				</tr>
				<tr>
					<td class="aright"><span>账户余额：</span></td>
					<td><a href="admin.php?mod=moneylog" target="_blank"><?php echo $tongji['user_money'] ?> <span>元</span></a></td>
				</tr>
				<tr style="background:#f9fafc">
					<td class="aright"><span>积分余额：</span></td>
					<td><a href="admin.php?mod=pointlog" target="_blank"><?php echo $tongji['user_point'] ?> <span>个</span></a></td>
				</tr>
				<tr>
					<td class="aright" width="80"><span>提现总数：</span></td>
					<td><a href="admin.php?mod=cashout" target="_blank"><?php echo $tongji['cashout_num'] ?> <span>笔</span></a></td>
				</tr>
				<tr style="background:#f9fafc">
					<td class="aright"><span>签到总数：</span></td>
					<td><a href="admin.php?mod=sign&act=list" target="_blank"><?php echo $tongji['sign_num'] ?> <span>次</span></a></td>
				</tr>
				</table>
				<div class="clear"></div>
			</div>
		</div>
		<div class="gzhfs">
			<div class="xt_tt"><span>流量统计</span></div>
			<div class="gzhfs_left mat10">
				<div id="iplog_chart" style="height:280px;width:470px;"></div>
			</div>
			<div class="gzhfs_right">
				<ul>
				<li class="shop_ico3">
					<div class="padd10">
						<h3><?php echo $tongji['iplog_today'] ?></h3>
						<div class="mat5">今日访客</div>
					</div>
				</li>
				<li class="shop_ico3">
					<div class="padd10">
						<h3><?php echo $tongji['user_today'] ?></h3>
						<div class="mat5">今日注册</div>
					</div>
				</li>
				<li class="shop_ico3">
					<div class="padd10">
						<h3><?php echo $tongji['sign_today'] ?></h3>
						<div class="mat5">今日签到</div>
					</div>
				</li>
				<li class="shop_ico3">
					<div class="padd10">
						<h3><?php echo $tongji['iplog_lastday'] ?></h3>
						<div class="mat5">昨日访客</div>
					</div>
				</li>
				<li class="shop_ico3" style="margin-bottom:20px">
					<div class="padd10">
						<h3><?php echo $tongji['user_lastday'] ?></h3>
						<div class="mat5">昨日注册</div>
					</div>
				</li>
				<li class="shop_ico3" style="margin-bottom:20px">
					<div class="padd10">
						<h3><?php echo $tongji['sign_lastday'] ?></h3>
						<div class="mat5">昨日签到</div>
					</div>
				</li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="index_right">
		<div class="xtxx mab15">
			<div class="xt_tt"><span>官方动态</span></div>
			<div class="gfdt">
				<iframe src="http://www.phpshe.com/api/shop?type=news&v=<?php echo $ini['phpshe']['version'] ?>" frameborder="0" width="100%" height="352px"></iframe>
			</div>
		</div>
		<div class="xtxx mab15">
			<div class="xt_tt"><span>系统信息</span></div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="xx_tb">
			<tr>
				<td align="right" class="c888" width="62">当前版本：</td>
				<td style="border-top:0"><a href="http://www.phpshe.com" target="_blank" class="corg">PHPSHE<?php echo $ini['phpshe']['version'] ?>商业版</a></td>
			</tr>
			<tr>
				<td align="right" class="c888">授权编号：</td>
				<td style="border-top:0"><a href="http://www.phpshe.com/phpshe/license" target="_blank" id="license_num">未授权</a></td>
			</tr>
			<tr>
				<td align="right" class="c888">购买授权：</td>
				<td>
					<a href="http://wpa.qq.com/msgrd?v=3&uin=76265959&site=qq&menu=yes" target="_blank"><img border="0" src="http://www.phpshe.com/template/default/index/images/qq.png" alt="咨询客服" title="咨询客服"/></a>
				</td>
			</tr>
			<tr>
				<td align="right" class="c888">咨询热线：</td>
				<td>15839823500</td>
			</tr>
			<tr>
				<td align="right" class="c888">官方网站：</td>
				<td><a class="cblue" href="http://www.phpshe.com" target="_blank">http://www.phpshe.com</a></td>
			</tr>
			<tr>
				<td align="right" class="c888">系统环境：</td>
				<td><span style="line-height:20px;"><?php echo $php_os ?> <?php echo $php_apache ?> <!--PHP/<?php echo $php_version ?> <a href="admin.php?mod=index&act=phpinfo" target="_blank" class="c888">[详情]</a>--></span></td>
			</tr>
			<tr>
				<td align="right" class="c888">PHP版本：</td>
				<td>PHP/<?php echo $php_version ?> <a href="admin.php?mod=index&act=phpinfo" target="_blank" class="cblue mal10">[详情]</a></td>
			</tr>
			<tr>
				<td align="right" class="c888">数&nbsp;&nbsp;据&nbsp;库：</td>
				<td><?php echo $php_mysql ?></td>
			</tr>
			</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo $pe['host_root'] ?>include/js/echarts.min.js"></script>
<script type="text/javascript">
$(function(){
	$.getJSON("http://www.phpshe.com/index.php?mod=api&act=license&version=<?php echo $ini['phpshe']['version'] ?>&callback=?", function(json){
		if (json.result) $("#license_num").html(json.license_num);
	})
})
// 基于准备好的dom，初始化echarts实例
var iplog_chart = echarts.init(document.getElementById('iplog_chart'));
// 指定图表的配置项和数据
iplog_option = {
    tooltip: {
        trigger: 'axis'
    },
    grid: {
    	top: '15px',
        left: '20px',
        right: '20px',
        bottom: '15px',
        containLabel: true
    },
    xAxis: {
        type: 'category',
        boundaryGap: false,
		axisLabel: {interval: 0},
        data: ['<?php echo implode("','", $chart_x) ?>']
    },
    yAxis: {
        type: 'value'
    },
    series: [
        {
            name:'今日访客',
            type:'line',
            //stack: '总量',
            data:['<?php echo implode("','", $chart_y) ?>'],
			areaStyle: {
				normal: {
					color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
						offset: 0,
						color: 'rgba(30, 144, 255,0.5)'
					}, {
						offset: 1,
						color: 'rgba(30, 144, 255,0.8)'
					}], false)
				}
			},
			itemStyle: {
				normal: {
					color: '#52a9ff'
				}
			},
			lineStyle: {
				normal: {
					width: 1
				}
			}
        }
    ]
};
// 使用刚指定的配置项和数据显示图表。
iplog_chart.setOption(iplog_option);
</script>
<?php include(pe_tpl('footer.html'));?>