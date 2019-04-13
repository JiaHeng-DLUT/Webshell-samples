<?php

namespace app\home\controller;

use think\Lang;

class Showjoinin extends BaseMall {
    

    public function _initialize() {
        parent::_initialize();
        Lang::load(APP_PATH . 'home/lang/'.config('default_lang').'/showjoinin.lang.php');
    }
    /*
     * 入驻相关首页介绍
     */

    public function index() {
        $code_info = config('store_joinin_pic');
        $info['pic'] = array();
        $info['show_txt'] = '';
        if (!empty($code_info)) {
            $info = unserialize($code_info);
        }
        $this->assign('pic_list', $info['pic']); //首页图片
        $this->assign('show_txt', $info['show_txt']); //贴心提示
        $help_model = model('help');
        $condition['helptype_id'] = '1'; //入驻指南
        $help_list = $help_model->getHelpList($condition, '', 4); //显示4个
        //获取第一文章分类的前三篇文章
        $index_articles=db('article')->where('ac.ac_code','notice')->where('a.article_show',1)->alias('a')->field('a.article_id,a.article_url,a.article_title')->order('a.article_sort asc,a.article_time desc')->limit(5)->join('__ARTICLECLASS__ ac','a.ac_id=ac.ac_id')->select();
        $this->assign('index_articles', $index_articles);
        $this->assign('help_list', $help_list);
        $this->assign('article_list', ''); //底部不显示文章分类
        $this->assign('show_sign', 'joinin');
        $this->assign('html_title', config('site_name') . ' - ' . lang('tenants'));
        return $this->fetch($this->template_dir . 'index');
    }

}

?>
