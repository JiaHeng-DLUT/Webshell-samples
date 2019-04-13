<?php

namespace app\home\controller;

class Api {
    
    /* QQ登录 */
    public function oa_qq() {
        include PLUGINS_PATH . '/login/qq/oauth/qq_login.php';
    }
    /* QQ登录回调 */
    public function oa_qq_callback() {
        include PLUGINS_PATH . '/login/qq/oauth/qq_callback.php';
    }

    /* sina Login */
    public function oa_sina() {
        if (input('param.step') == 'callback') {
            include PLUGINS_PATH . '/login/sina/callback.php';
        } else {
            include PLUGINS_PATH . '/login/sina/index.php';
        }
    }


}