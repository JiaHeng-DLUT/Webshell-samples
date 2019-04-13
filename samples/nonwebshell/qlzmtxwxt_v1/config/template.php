<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 模板设置
// +----------------------------------------------------------------------


return [
    // 模板引擎类型 支持 php think 支持扩展
    'type'         => 'Think',
    // 默认模板渲染规则 1 解析为小写+下划线 2 全部转换小写
    'auto_rule'    => 1,
    //  // 模板路径
    'view_path'     => './template/',
     //默认主题
    'default_theme' => 'default', 
    // 模板后缀
    'view_suffix'  => 'html',
    // 模板文件名分隔符
    'view_depr'    => DIRECTORY_SEPARATOR,
    // 模板引擎普通标签开始标记
    'tpl_begin'    => '{',
    // 模板引擎普通标签结束标记
    'tpl_end'      => '}',
    // 标签库标签开始标记
    'taglib_begin' => '{',
    // 标签库标签结束标记
    'taglib_end'   => '}',
     // 预先加载的标签库
    'taglib_pre_load'     =>    'app\common\taglib\Form,app\common\taglib\Qilecms,app\common\taglib\Upload', 
   // 模板输出替换
    'tpl_replace_string'  =>  [ 
            '__PUBLIC__' => '/public',
            '__STATIC__' => '/public/static',
            '__JS__'     => '/public/static/common/js',
            '__CSS__'    => '/public/static/common/css',
            '__IMG__'    => '/public/static/common/images',
            '__PLUGIN__' => '/public/static/plugin', //js css 插件目录
            '__UPLOAD__ '=> '/public/upload',
            '__ADDONS__ '=> '',

   ],

        
];
