<?php
$config['name'] = '微信支付';
$config['type'] = 'wechat';
$config['desc'] = '实现微信PC扫码支付/H5支付/公众号支付';
$config['model']['wechat_appid']['name'] = '开发者AppID';
$config['model']['wechat_appid']['type'] = 'text';
$config['model']['wechat_mchid']['name'] = '商户号';
$config['model']['wechat_mchid']['type'] = 'text';
$config['model']['wechat_key']['name'] = 'API密钥';
$config['model']['wechat_key']['type'] = 'text';
return $config;
?>