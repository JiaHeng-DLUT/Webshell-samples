<?php

return array(
    'payment_code' => 'unionpay',
    'payment_name' => '银联PC支付',
    'payment_desc' => 'PC端银联支付接口',
    'payment_is_online' => '1',
    'payment_platform' => 'pc', #支付平台 pc h5 app
    'payment_author' => '长沙德尚',
    'payment_website' => 'http://open.unionpay.com',
    'payment_version' => '1.0',
    'payment_config' => array(
        array('name' => 'unionpay_merid', 'type' => 'text', 'value' => '', 'desc' => '描述'),
        array('name' => 'unionpay_signcert_path', 'type' => 'file', 'value' => '', 'desc' => '描述'),
        array('name' => 'unionpay_signcert_pwd', 'type' => 'text', 'value' => '', 'desc' => '描述'),
    ),
);
?>
