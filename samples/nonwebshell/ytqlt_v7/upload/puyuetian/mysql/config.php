<?php
if (!defined('puyuetian'))
	exit('403');
$_G['SQL']['TYPE'] = 'mysql';
$_G['SQL']['LOCATION'] = '127.0.0.1';
$_G['SQL']['USERNAME'] = 'root';
$_G['SQL']['PASSWORD'] = 'hadsky.com';
$_G['SQL']['DATABASE'] = 'test';
$_G['SQL']['CHARSET'] = 'set names utf8';
$_G['SQL']['PREFIX'] = 'pk_';
$_G['MYSQL']['LOCATION'] = $_G['SQL']['LOCATION'];
$_G['MYSQL']['USERNAME'] = $_G['SQL']['USERNAME'];
$_G['MYSQL']['PASSWORD'] = $_G['SQL']['PASSWORD'];
$_G['MYSQL']['DATABASE'] = $_G['SQL']['DATABASE'];
$_G['MYSQL']['CHARSET'] = $_G['SQL']['CHARSET'];
$_G['MYSQL']['PREFIX'] = $_G['SQL']['PREFIX'];