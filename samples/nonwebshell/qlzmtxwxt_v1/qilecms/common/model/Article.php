<?php
namespace app\common\model;
class Article extends Base
{
   protected $autoCheckFields = true;
   public  function getArticleInfo($aid){
      $where['aid'] = $aid;
      $info = $this->where($where)->find();
      return $info;
   }


}
