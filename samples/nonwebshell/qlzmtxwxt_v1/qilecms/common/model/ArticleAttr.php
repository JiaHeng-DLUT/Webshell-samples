<?php
namespace app\common\model;
use think\Model;

class ArticleAttr extends Base
{
   protected $autoCheckFields = true;
   public  function getArticleAttr(){
     return $list = $this->select();
  
   }
  public function getArticleAttrByName($attrValue){
   return  $this->where("attr_value","in",$attrValue)->select();
  }


}
