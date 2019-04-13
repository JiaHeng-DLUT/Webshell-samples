<?php
/**
 * @copyright   2008-2015 简好网络 <http://www.phpshe.com>
 * @creatdate   2010-1001 koyshe <koyshe@gmail.com>
 */
error_reporting(E_ALL ^ E_NOTICE);
class authcode {
	private $width, $height, $codenum;
	public $checkcode;     //产生的验证码
	private $checkimage;    //验证码图片
	private $disturbColor = ''; //干扰像素
	/*
	* 参数：（宽度，高度，字符个数）
	*/
	function __construct($width = '100', $height = '30', $codenum = '4')
	{
		$this->width = $_GET['w'] ? $_GET['w'] : $width;
		$this->height = $_GET['h'] ? $_GET['h'] : $height;
		$this->codenum = $codenum;
	}
	function get()
	{
		//产生验证码
		$this->docode();
		//产生图片
		$this->doimage();
		//设置干扰像素
		$this->dodisturb();
		//往图片上写验证码
		$this->writeCheckCodeToImage();
		ob_clean();
		header("Content-type:image/png");
		imagepng($this->checkimage);
		imagedestroy($this->checkimage);
	}
	/**
	* 产生验证码
	*/
	private function docode()
	{
		$this->checkcode = strtoupper(substr(md5(rand()),0,$this->codenum));
		session_start();
		//$_SESSION['authcode'] = strtolower($this->checkcode);
		$_SESSION['authcode'] = $this->checkcode;
	}
	/**
	* 产生验证码图片
	*/
	private function doimage()
	{
		$this->checkimage = @imagecreate($this->width, $this->height);
		$black = imagecolorallocate($this->checkimage, 250, 250, 250);
		$border = imagecolorallocate($this->checkimage, 250, 250, 250);  
		imagefilledrectangle($this->checkimage,0,0,$this->width - 1,$this->height - 1,$black); // 白色底
		imagerectangle($this->checkimage,0,0,$this->width - 1,$this->height - 1,$border);   // 黑色边框
	}
	/**
	* 设置图片的干扰像素
	*/
	private function dodisturb()
	{

		for ($i=0;$i<2;$i++) {
			$color = imagecolorallocate($this->checkimage, rand(0,156), rand(0,156), rand(0,156));
			imageline($this->checkimage, rand(0,$this->width), rand(0,$this->height), rand(0,$this->width), rand(0,$this->height), $color);
		}
		for ($i=0;$i<=200;$i++)
		{
			$this->disturbColor = imagecolorallocate($this->checkimage, rand(0,255), rand(0,255), rand(0,255));
			imagesetpixel($this->checkimage, rand(0,$this->width), rand(0,$this->height), $this->disturbColor);
		}
	}
	/**
	*
	* 在验证码图片上逐个画上验证码
	*
	*/
	private function writeCheckCodeToImage()
	{
		$font = dirname(__FILE__)."/t1.ttf";
		for ($i=0;$i<=$this->codenum;$i++)
		{
			$bg_color = imagecolorallocate ($this->checkimage, rand(0,255), rand(0,128), rand(0,255));
			$x = floor($this->width/$this->codenum)*$i + 5;
			$y = $this->height/1.5;
			//imagechar ($this->checkimage, rand(5, 10), $x, $y, $this->checkcode[$i], $bg_color);
			imagettftext($this->checkimage, 11, 0, $x, $y, $bg_color, $font, substr($this->checkcode, $i, 1));
		}
	}
	function __destruct()
	{
		unset($this->width,$this->height,$this->codenum);
	}
}
$authcode = new authcode();
echo $authcode->get();
?>