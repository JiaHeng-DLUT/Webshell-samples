<?php
	$url = 'index.php?c=app&a=superadmin:index';
	header("Location:{$url}");
	exit("<script>location.href='{$url}'</script>");