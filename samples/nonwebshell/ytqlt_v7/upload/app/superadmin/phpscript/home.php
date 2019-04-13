<?php
if (!defined('puyuetian'))
	exit('403');

$contenthtml = template('superadmin:home-' . ($_G['GET']['T'] ? $_G['GET']['T'] : 'info'), TRUE);
