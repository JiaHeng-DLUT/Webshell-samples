<?php
if (!defined('puyuetian'))
	exit('403');

function mysql_query($query, $link = false) {
	return sqlQuery($query);
}

function mysql_error() {
	return sqlError();
}
