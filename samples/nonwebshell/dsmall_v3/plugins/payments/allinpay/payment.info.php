<?php

return array(
    'payment_code' => 'allinpay',
    'payment_name' => '通联支付',
    'payment_desc' => '通联支付',
    'payment_is_online' => '1',
    'payment_platform' => 'pc', #支付平台 pc h5 app
    'payment_author' => '长沙德尚',
    'payment_website' => 'https://aipboss.allinpay.com/know/devhelp/index.php',
    'payment_version' => '1.0',
    'payment_config' => array(
        array('name' => 'allinpay_appid', 'type' => 'text', 'value' => '', 'desc' => '描述'),
        array('name' => 'allinpay_key', 'type' => 'text', 'value' => '', 'desc' => '描述'),
        array('name' => 'allinpay_mch_id', 'type' => 'text', 'value' => '', 'desc' => '描述'),
    ),
);
?>
