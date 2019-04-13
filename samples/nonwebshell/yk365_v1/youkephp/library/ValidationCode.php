<?php
 class ValidationCode{
  private $width;
  private $height;
  private $codeNum;
  private $image;   //图像资源
  private $disturbColorNum;
  private $checkCode;
  function __construct($width=80, $height=20, $codeNum=4){
   $this->width=$width;
   $this->height=$height;
   $this->codeNum=$codeNum;
   $this->checkCode=$this->createCheckCode();
   $number=floor($width*$height/15);
  
   if($number > 240-$codeNum){
    $this->disturbColorNum= 240-$codeNum;
   }else{
    $this->disturbColorNum=$number;
   }
 
  }
  //通过访问该方法向浏览器中输出图像
  function showImage($fontFace=""){
   //第一步：创建图像背景
   $this->createImage();
   //第二步：设置干扰元素
   $this->setDisturbColor();
   //第三步：向图像中随机画出文本
   $this->outputText($fontFace);
   //第四步：输出图像
   $this->outputImage();
  }
  
  //通过调用该方法获取随机创建的验证码字符串
  function getCheckCode(){
   return $this->checkCode;
  }
  private function createImage(){
   //创建图像资源
   $this->image=imagecreatetruecolor($this->width, $this->height);
   //随机背景色
   $backColor=imagecolorallocate($this->image, rand(225, 255), rand(225,255), rand(225, 255));
   //为背景添充颜色
   imagefill($this->image, 0, 0, $backColor);
   //设置边框颜色
   $border=imagecolorallocate($this->image, 0, 0, 0);
   //画出矩形边框
   imagerectangle($this->image, 0, 0, $this->width-1, $this->height-1, $border);
  }
  private function  setDisturbColor(){
   for($i=0; $i<$this->disturbColorNum; $i++){
    $color=imagecolorallocate($this->image, rand(0, 255), rand(0, 255), rand(0, 255));
    imagesetpixel($this->image, rand(1, $this->width-2), rand(1, $this->height-2), $color);
   }
   for($i=0; $i<10; $i++){
    $color=imagecolorallocate($this->image, rand(200, 255), rand(200, 255), rand(200, 255));
    imagearc($this->image, rand(-10, $this->width), rand(-10, $this->height), rand(30, 300), rand(20, 200), 55, 44, $color);
   }
  }
  private function createCheckCode(){

//这里主要产生随机码，从2开始是为了区分1和l
   $code="023456789";
   $string='';
   for($i=0; $i < $this->codeNum; $i++){
    $char=$code{rand(0, strlen($code)-1)};
    $string.=$char;
   }
   return $string;
  }
  private function outputText($fontFace=""){
   for($i=0; $i<$this->codeNum; $i++){
    $fontcolor=imagecolorallocate($this->image, rand(0, 128), rand(0, 128), rand(0, 128));
    if($fontFace==""){
     $fontsize=rand(25, 36);
     $x=floor($this->width/$this->codeNum)*$i+3;
     $y=rand(0, $this->height-15);
     imagechar($this->image,$fontsize, $x, $y, $this->checkCode{$i},$fontcolor);
    }else{
     $fontsize=rand(25, 36); //字体尺寸
     $x=floor(($this->width-8)/$this->codeNum)*$i+8;
     $y=rand($fontSize+5, $this->height);
     imagettftext($this->image,$fontsize,rand(-30, 30),$x,$y ,$fontcolor, $fontFace, $this->checkCode{$i});
    }
   }
  }
  private function outputImage() {
   if(imagetypes() & IMG_GIF){
    header("Content-Type:image/gif");
    imagepng($this->image);
   }else if(imagetypes() & IMG_JPG){
    header("Content-Type:image/jpeg");
    imagepng($this->image);
   }else if(imagetypes() & IMG_PNG){
    header("Content-Type:image/png");
    imagepng($this->image);
   }else if(imagetypes() & IMG_WBMP){
    header("Content-Type:image/vnd.wap.wbmp");
    imagepng($this->image);
   }else{
    die("PHP不支持图像创建");
   }
  }
  function __destruct(){
   imagedestroy($this->image);
  }
 }
 
