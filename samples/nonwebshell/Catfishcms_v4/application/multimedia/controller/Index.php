<?php
/**
 * Project: Catfish.
 * Author: A.J
 * Date: 2016/12/30
 */
namespace app\multimedia\controller;

use think\Request;

class Index
{
    public function index()
    {
        if(Request::instance()->has('path','get') && Request::instance()->has('ext','get') && Request::instance()->has('media','get'))
        {
            if(Request::instance()->get('media') == 'image' && $this->isImage(Request::instance()->get('path')))
            {
                header("Content-Type: image/".Request::instance()->get('ext'));
                echo file_get_contents(APP_PATH.'plugins/'.$this->filterPath(Request::instance()->get('path')));
                exit;
            }
        }
    }
    private function isImage($image)
    {
        $pathinfo = pathinfo($image);
        if(in_array($pathinfo['extension'],['jpeg','jpg','png','gif']))
        {
            return true;
        }
        return false;
    }
    private function filterPath($path)
    {
        return str_replace('../','',$path);
    }
}