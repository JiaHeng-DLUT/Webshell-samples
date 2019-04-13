<?php
namespace app\common\model;
class Module extends Base
{
   protected $autoCheckFields = true;
   public  function getModuleList($where)
   {

    return $data = $this->where($where)->order('sort','desc')->select();
   }

 
 //安装模块 
  public function install($config){
    $data['name'] = $config['name'];
    $data['module'] = $config['module'];
    $data['dir'] = $config['module'];
    $data['version'] = $config['version'];
    $data['uninstall'] = $config['uninstall'];
    $data['description'] = $config['description'];
    $data['create_time'] = time();
    return $this->save($data);
 
  }
//开启模块
 public function open($mid,$status){
  $where['mid'] = $mid;
  $data['status'] =$status;
  $this->where($where)->update($data);
  return true;
 }

//开闭模块
 public function close($mid,$status){
  $where['mid'] = $mid;
  $data['status'] =$status;
  $this->where($where)->update($data);
  return true;
 }
}
