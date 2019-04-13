<?php include(pe_tpl('header.html'));?>
<div class="right">
	<div class="now">
		<a href="admin.php?mod=cache" class="sel"><?php echo $menutitle ?><i></i></a>
		<div class="clear"></div>
	</div>
	<form method="post" id="form">
	<div class="right_main">
		<div class="tixing corg">温馨提示：当您网站上的数据或网页显示异常时请执行更新缓存操作。</div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="list mat10">
		<tr>
			<th class="bgtt" width="150">缓存名称</th>
			<th class="bgtt aleft">缓存说明</th>
			<th class="bgtt" width="150">大小(KB)</th>
			<th class="bgtt" width="70">操作</th>
		</tr>
		<?php foreach($info_list as $k => $v):?>
		<tr>
			<td><?php echo $v['cache_name'] ?></td>
			<td class="aleft"><?php echo $v['cache_text'] ?></td>
			<td class="num"><?php echo $v['cache_size'] ?></td>
			<td><a href="admin.php?mod=cache&act=update&cache=<?php echo $k ?>&token=<?php echo $pe_token ?>" class="admin_edit">更新</a></td>
		</tr>
		<?php endforeach;?>
		</table>
	</div>
	<div class="center mat20">
		<input type="hidden" name="pe_token" value="<?php echo $pe_token ?>" />
		<input type="button" name="pesubmit" value="全部更新" class="tjbtn" href="admin.php?mod=cache&act=update&cache=all&token=<?php echo $pe_token ?>" onclick="return pe_doall(this, 'form')" />
	</div>
	</form>
</div>
<?php include(pe_tpl('footer.html'));?>