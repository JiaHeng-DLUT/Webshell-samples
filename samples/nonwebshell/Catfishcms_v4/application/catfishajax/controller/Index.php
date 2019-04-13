<?php
/**
 * Project: Catfish.
 * Author: A.J
 * Date: 2017/8/8
 */
namespace app\catfishajax\controller;

use think\Request;
use think\Hook;
use think\Url;

class Index extends Common
{
    public function index(Request $request)
    {
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $host = $_SERVER['HTTP_HOST'];
        $len = Request::instance()->isSsl() ? 8 : 7;
        if(substr($referer,$len,strlen($host)) == $host)
        {
            $this->params = $request->param();
            Hook::add('catfish_ajax',$this->plugins);
            Hook::listen('catfish_ajax',$this->params,$this->ccc);
            if(isset($this->params['return']))
            {
                echo $this->params['return'];
            }
        }
        else
        {
            $this->redirect(Url::build('/'));
            exit();
        }
    }
}