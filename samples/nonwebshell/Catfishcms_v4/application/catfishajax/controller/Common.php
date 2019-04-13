<?php
/**
 * Project: Catfish.
 * Author: A.J
 * Date: 2017/8/9
 */
namespace app\catfishajax\controller;

use app\common\Package;
use think\Lang;

class Common extends Package
{
    public function _initialize()
    {
        $this->lang = Lang::detect();
        $this->lang = $this->filterLanguages($this->lang);
        $this->ccc = 'Catfish CMS Copyright';
        $this->getPlugins();
    }
}