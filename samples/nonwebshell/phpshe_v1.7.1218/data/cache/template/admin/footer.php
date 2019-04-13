	<div class="clear"></div>
	<!--<div class="foot">Copyright <span class="num">©</span> 2008-2014 <a target="_blank" href="http://www.phpshe.com">灵宝简好网络科技有限公司</a> 版权所有</div>-->
</div>
<script type="text/javascript">
$(function(){
	win_init();
	$(window).resize(function() {
		win_init();
	});
	if ($(".right_bottom").height() == 0) {
		$(".right_bottom").remove();
	}
	if ($(".list tr:visible").length > 1) {
		$(".right_main").css("padding-bottom", 0);	
	}
	if ($(".left .sel").length) {
		$(".left").scrollTop(localStorage.getItem('left_scrolltop'));
	}
	else {
		localStorage.setItem('left_scrolltop', 0);
	}
	$(".left").scroll(function(){
		localStorage.setItem('left_scrolltop', $(".left").scrollTop());
	})
	$(".list").find("td").hover(
		function(){
			if ($(this).hasClass("bgtt") || $(this).is("[nosel=1]")) return;
			$(this).parent("tr").children("td[nosel!=1]").css("background-color", "#fbfbfb");
		},
		function(){
			if ($(this).hasClass("bgtt") || $(this).is("[nosel=1]")) return;
			$(this).parent("tr").children("td[nosel!=1]").css("background-color", "#fff");
		}
	)
})
function win_init() {
	$(".left").add(".right").css("height", $(window).height() - $(".pagetop").height());
}
pe_loadscript("<?php echo $pe['host_root'] ?>api.php?mod=cron");
</script>
</body>
</html>