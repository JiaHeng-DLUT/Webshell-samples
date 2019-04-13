<?php
/**
 * The debug view file of chat module of RanZhi.
 *
 * @copyright   Copyright 2009-2018 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Gang Liu <liugang@cnezsoft.com>
 * @package     chat
 * @version     $Id$
 * @link        http://www.ranzhi.org
 */
?>
<?php if($this->app->user->admin != 'super'):?>
<?php include '../../common/view/header.lite.html.php';?>
<div class='container'>
  <div class='notice text-center' style='font-size:24px;'>
    <?php $_SERVER['SCRIPT_NAME'] = '/index.php';?>
    <?php $link = $this->loadModel('user')->isLogon() ? $this->createLink('user', 'logout') : $this->createLink('user', 'login');?>
    <?php printf($lang->chat->debugTips, html::a($link, $lang->login));?>
  </div>
</div>
<?php else:?>
<?php include '../../common/view/header.modal.html.php';?>
<?php js::set('showLog', $config->xuanxuan->debug);?>
<div class='panel'>
  <table class='table table-form table-noFixedHeader'>
    <tr>
      <th class='w-80px'><?php echo $lang->chat->version;?></th>
      <td><?php echo $config->xuanxuan->version;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->chat->key;?></th>
      <td><?php echo $config->xuanxuan->key;?></td>
    </tr>
    <tr>
      <th><?php echo $lang->chat->url;?></th>
      <td><?php echo commonModel::getSysURL() . $this->config->webRoot . 'x.php';?></td>
    </tr>
    <?php if(!empty($config->xuanxuan->debug)):?>
    <tr>
      <th class='text-top'><?php echo $lang->chat->log;?></th>
      <td id='log'></td>
    </tr>
    <?php endif;?>
    <?php if(!helper::isAjaxRequest()):?>
    <tr>
      <th></th>
      <td><?php commonModel::printLink('setting', 'xuanxuan', '', $lang->goback, "class='btn btn-primary'");?></td>
    </tr>
    <?php endif;?>
  </table>
</div>
<?php endif;?>
<?php if($config->debug) js::import($jsRoot . 'jquery/form/min.js');?>
<?php if(isset($pageJS)) js::execute($pageJS);?>
</body>
</html>
