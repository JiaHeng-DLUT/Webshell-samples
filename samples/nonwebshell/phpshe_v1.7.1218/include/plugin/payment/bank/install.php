<?php
$config['name'] = '转账汇款';
$config['type'] = 'bank';
$config['desc'] = '通过线下转账汇款方式支付，汇款帐号：建设银行 621700254000005xxxx 刘某某';
$config['model']['bank_text']['name'] = '收款信息';
$config['model']['bank_text']['type'] = 'textarea';
return $config;
?>