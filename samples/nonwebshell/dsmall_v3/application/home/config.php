<?php

return [
    //默认错误跳转对应的模板文件
    'dispatch_error_tmpl' => 'default/base/dispatch_jump',
    //默认成功跳转对应的模板文件
    'dispatch_success_tmpl' => 'default/base/dispatch_jump',
    
    
    'session' => [
        'id' => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix' => 'home',
        // 驱动方式 支持redis memcache memcached
        'type' => '',
        // 是否自动开启 SESSION
        'auto_start' => true,
    ],
];
