<?php
if (!defined('puyuetian'))
	exit('403');

global $exp, $hcexp, $lv, $xb;
$exp = Cnum($_G['USER']['JIFEN']) % 100;
$hcexp = 100 - $exp;
$lv = (int)(Cnum($_G['USER']['JIFEN']) / 100);
if ($_G['TABLE']['USER_MESSAGE'] -> getDatas(0, 1, array('islook' => 0, 'uid' => $_G['USER']['ID']))) {
	$_G['TEMP']['NMJS'] = '
<script>
	$(function(){
		TextSSS("userbox-msgbtn");
	});
</script>
			';
}
