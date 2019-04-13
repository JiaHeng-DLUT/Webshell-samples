<?php
namespace app\ajax\controller;
use app\common\controller\Common; //跨模块调用  
class Base extends Common{

    public function initialize()
    {

	    parent::initialize();
        // 下面防当前初始化内容
		   	
	 }
      static public $return_code = [
        '-1'   => '操作失败',
        '0'    => '操作成功',
        // '1001' => '操作成功',

    ];

}