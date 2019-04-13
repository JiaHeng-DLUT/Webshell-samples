<?php
/**
 * Project: Catfish.
 * Author: A.J
 * Date: 2017/7/20
 */
namespace app\user\controller;

use app\user\controller\Common;
use think\Request;

class Error extends Common
{
    public function index(Request $request)
    {
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        $template = $this->receive();
        if(Request::instance()->isMobile() && is_file(APP_PATH.'../public/'.$template.'/mobile/404.html'))
        {
            $htmls = $this->fetch(APP_PATH.'../public/'.$template.'/mobile/404.html');
        }
        elseif(is_file(APP_PATH.'../public/'.$template.'/404.html'))
        {
            $htmls = $this->fetch(APP_PATH.'../public/'.$template.'/404.html');
        }
        else
        {
            $htmls = $this->fetch(APP_PATH.'../public/common/html/404/index.html');
        }
        return $htmls;
    }
}