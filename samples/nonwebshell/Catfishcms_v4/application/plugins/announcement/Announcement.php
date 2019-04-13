<?php
/**
 * Plugin Name: Announcement
 * Description: The Announcement Plugin displays a bulletin at the top of the Home page
 * Author: A.J
 * Version: V1.0
 * Plugin URL: www.catfish-cms.com
 * Appliance: cms
 */
namespace app\plugins\announcement;

use app\common\Plugin;

class Announcement extends Plugin
{
    private $plugin = 'announcement'; //设置插件名
    public function open(&$params)
    {
        //插件开启时执行，传入参数$this->plugin为插件名
        $this->statement('Catfish cms plugin');//声明鲶鱼cms插件，用来区别鲶鱼Blog插件
        $this->set($this->plugin.'_announcement','');//设置用来存储公告的变量,建议变量名使用“插件名_变量名”的格式
    }
    public function close(&$params)
    {
        //插件被关闭时执行，传入参数$this->plugin为插件名
        $this->delete($this->plugin.'_announcement');//删除设置的变量
    }
    public function settings(&$params)
    {
        //后台设置，表单页，$this->plugin为插件名
        $params['view'] = '<form method="post">
    <div class="form-group">
        <label>'.lang('Notice content').'：</label>
        <textarea class="form-control" name="announcement_gonggao" rows="3" autofocus>'.$this->get($this->plugin.'_announcement').'</textarea>
    </div>
    <button type="submit" class="btn btn-default">'.lang('Save').'</button>
</form>'; //$this->get($this->plugin.'_announcement')获取变量的内容
    }
    public function settings_post(&$params)
    {
        //后台设置，表单提交，$this->plugin为插件名
        $this->set($this->plugin.'_announcement',$this->getPost('announcement_gonggao'));
    }

    //输出公告内容
    public function home_top(&$params)
    {
        //执行代码,输出到“home_top”
        $data = '<div class="container">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-body">
        <span class="glyphicon glyphicon-volume-up"></span>&nbsp;'.$this->get($this->plugin.'_announcement').'
      </div>
    </div>
  </div>
</div>';
        $this->add($params,'home_top',$data);//将公告内容追加到“home_top”
    }
}