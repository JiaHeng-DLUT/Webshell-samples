<?php
namespace app\common\model;
use think\Model;

class TemplateMobile extends Base
{
   protected $autoCheckFields = true;

 //通过ID获得信息
   public function getTemplateById($id){
   	 $where['id'] = $id;
     return $this->where($where)->find();
    }

 //通过模板名称获得信息
   public function getTemplateByName($name){
     $where['name'] = $name;
     return $this->where($where)->find();
    }

//获得已安装
   public function getInstall(){
     $where['status'] = 0;
     return $this->where($where)->select();

   }
//获得已安装
   public function getOpen($name){
     $where['status'] = 1;
     $where['name'] = $name;
     return $this->where($where)->find();

   }
 

}
