<?php
if (!defined('puyuetian'))
	exit('403');

$must = '<link rel="stylesheet" href="template/puyuetianUI/css/puyuetian.css"><script src="template/puyuetianUI/js/puyuetian.js"></script>';

if ($_G['SET']['GLOBALCDN']) {
	$_G['SET']['EMBED_HEADMARKS'] = '
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	' . $must . $_G['SET']['EMBED_HEADMARKS'];
} else {
	$_G['SET']['EMBED_HEADMARKS'] = '
	<link rel="stylesheet" href="template/puyuetianUI/css/font-awesome.min.css">
	<script src="template/puyuetianUI/js/jquery-3.3.1.min.js"></script>
	<!--[if lt IE 9]>
		<script src="template/puyuetianUI/js/respond.js"></script>
	<![endif]-->
	' . $must . $_G['SET']['EMBED_HEADMARKS'];
}
