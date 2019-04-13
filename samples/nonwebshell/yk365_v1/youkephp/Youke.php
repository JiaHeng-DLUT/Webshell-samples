<?php
include './vendor/autoload.php';
class Youke extends Smarty
{
   public $const;
   public function __construct()
   {
 
   parent::__construct();
   $this->debugging       = false;
	$this->caching         = CACHE_ON;//是否使用缓存
   $this->cache_lifetime  = CACHE_LIFETIME;
	$this->template_dir    = ROOT_PATH."themes";//设置模板目录
	$this->compile_dir     = ROOT_PATH."runtime/temp";//设置编译目录
	$this->cache_dir       = ROOT_PATH."runtime/cache";//缓存文件夹
	 //修改左右边界符号
	$this->left_delimiter  = "<{"; 
	$this->right_delimiter = "}>";



   }

//成功跳转
   public function success($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
   {
      // return '';      
   }
// 失败跳转
   public function error($msg = '', $url = null, $data = '', $wait = 3, array $header = [])
   {
   	  // return '';
   } 


}