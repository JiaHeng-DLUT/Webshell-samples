<?php
session_start();
header ('Content-Type: image/png');
$image=imagecreatetruecolor(100, 30);
//背景颜色为白色
$color=imagecolorallocate($image, 255, 255, 255);
imagefill($image, 20, 20, $color);
// for($i=0;$i<4;$i++){
    // $font=6;
    // $x=rand(5,10)+$i*100/4;
    // $y=rand(8, 15);
    // $string=rand(0, 9);
    // $color=imagecolorallocate($image, rand(0,120), rand(0,120), rand(0,120));
    // imagestring($image, $font, $x, $y, $string, $color);
// }
$code='';
for($i=0;$i<4;$i++){
    $fontSize=8;
    $x=rand(5,10)+$i*100/4;
    $y=rand(5, 15);
    $data='abcdefghijklmnopqrstuvwxyz123456789';
    $string=substr($data,rand(0, strlen($data)),1);
    $code.=$string;
    $color=imagecolorallocate($image,rand(0,120), rand(0,120), rand(0,120));
    imagestring($image, $fontSize, $x, $y, $string, $color);
}

setcookie("CmsCode",$code,time()+24*3600,"/");

for($i=0;$i<200;$i++){
    $pointColor=imagecolorallocate($image, rand(100, 255), rand(100, 255), rand(100, 255));
    imagesetpixel($image, rand(0, 100), rand(0, 30), $pointColor);
}
for($i=0;$i<2;$i++){
    $linePoint=imagecolorallocate($image, rand(150, 255), rand(150, 255), rand(150, 255));
    imageline($image, rand(10, 50), rand(10, 20), rand(80,90), rand(15, 25), $linePoint);
}
imagepng($image);
imagedestroy($image);
?>