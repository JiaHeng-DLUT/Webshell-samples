<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
$f=$imgdate2;
//源文件
$s=$addrrr_sm;
//生成的缩略图文件名
//$w=90;
//缩略图宽
//$h=99;
//缩略图高
//
/*get flash width and h
$f='http://127.0.0.150/images/up_att/att2/20100518_1436356592.swf';
$data=GetImageSize($f);
print_r($data);
*/
$data=GetImageSize($f);
//echo "$hotellist<pre>".print_r($data,1)."</pre><hr>";
//exit;
switch($data[2]){
    case 1:
        $im=@imagecreatefromgif($f);
        break;
    case 2:
        $im=@imagecreatefromjpeg($f);
        break;
    case 3:
        $im=@imagecreatefrompng($f);
        break;
}

/*
Array
(
    [0] => 550
    [1] => 301
    [2] => 2
    [3] => width="550" height="301"
    [bits] => 8
    [channels] => 3
    [mime] => image/jpeg
)

*/
$sw=$data[0];$sh=$data[1];

$h=($up_w_s/$sw)*$sh;
$w=($sw*$h)/$sh;

if($h>$up_h_s){
$h=$up_h_s;
$w=($sw*$h)/$sh;
}
if($w>$up_w_s){
$w=$up_w_s;
$h=$w/$sw*$sh;
}
//就是说宽小，则以宽为基，还不够。那就先让被超，然后哪个（或宽或高）被超出了，就以哪个为基。
//这个用了两个多小时。这就是反其道而行。让先被超。

//echo "$w - $h";exit;
if($sw>$w || $sh>$h){

    // $ni=imagecreate($w,$h);
$ni=imagecreatetruecolor($w,$h);
// imagecopyresized($ni,$im,($w-$dw)/2,($h-$dh)/2,0,0,$dw,$dh,$sw,$sh);
  //  $newim = imagecreatetruecolor($newwidth, $newheight);
  // imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
   //	 imagecopyresized($ni,$im,0,0,0,0,$w,$h,$sw,$sh); //imagecopyresized会失真
	 imagecopyresampled($ni,$im,0,0,0,0,$w,$h,$sw,$sh);

$imclearly=80;///图片清晰度0-100，数字越大越清晰，文件尺寸越大
 switch($data[2])
  {
   case 1 :    imagegif($ni,$s); break; // GIF gif no imclearly
   case 2 :    imagejpeg($ni,$s,$imclearly);break; //以 JPEG 格式将图像输出到浏览器或文件
   case 3 :    imagepng($ni,$s); break; //png no ,$imclearly
   default :    return;
  }
// imagejpeg($ni,$s);
    imagedestroy($im);
    imagedestroy($ni);
}else{
    copy($f, $s);//if same size.then copy.
}

/*echo "sw -$sw -sh -$sh <hr>";echo "smallw -$w -h -$h <hr>";
echo "<img src=$f><hr>";//echo "<img src=$f width=$w><hr>";
echo "<img src=$s  >";
*/ 
?>