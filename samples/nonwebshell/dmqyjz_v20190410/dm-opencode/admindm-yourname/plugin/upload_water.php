<?php
/******************************************************************************
使用说明:
1. 将PHP.INI文件里面的"extension=php_gd2.dll"一行前面的;号去掉,因为我们要用到GD库;
2. 将extension_dir =改为你的php_gd2.dll所在目录;php4.6.0以上版本使用默认路径
******************************************************************************/
//上传文件类型列表
//不完善的地方是透明水印图片不支持。以后解决。

$uptypes=array(
     'image/jpg',
     'image/jpeg',
     'image/png',
     'image/pjpeg',
     'image/gif',
     'image/bmp',
     'image/x-png'
);
$max_file_size = 500000;     //上传文件大小限制, 单位BYTE
$path_im = "prod_img/";      //生成大图保存文件夹路径
$path_sim = "prod_simg/";    //缩略图保存文件夹路径
$watermark = 1;              //是否加水印(1为加水印,其他为不加水印);
$watertype = 2;              //水印类型(1为文字,2为图片)
$waterstring = "http://www.**中国人*.com/";   //水印字符串
//$waterimg = '../'.$imgfo_z.'up_att/water/'.'water.gif';//is in text. or user fj.  //水印图片文件路径
$waterclearly = $waterpercent;         //水印透明度0-100，数字小透明高
$imclearly = 82;            //图片清晰度0-100，数字越大越清晰，文件尺寸越大
$simclearly = 75;            //缩略图清晰度0-100，数字越大越清晰，文件尺寸越大
$smallmark = 1;              //是否生成缩略图(1为加生成,其他为不);
$dst_sw = 80;                //定义缩略图宽度，高度我采用等比例缩放，所以只要比较宽度就可以了
$oldimg="$imgdate2";
//////////////////////////////////////////////////////////////////////
	 //$filename = $file["tmp_name"];
  $im_size = getimagesize($oldimg);
  $src_w = $im_size[0];
  $src_h = $im_size[1];
  $src_type = $im_size[2];

switch($src_type){
    case 1:
        $src_im=@imagecreatefromgif($oldimg);
        break;
    case 2:
        $src_im=@imagecreatefromjpeg($oldimg);
        break;
    case 3:
        $src_im=@imagecreatefrompng($oldimg);
        break;
}

 // $src_im = imagecreatefromjpeg($oldimg);


         //$iinfo = getimagesize($all_path,$iinfo);
         $dst_im = imagecreatetruecolor($src_w,$src_h);
   //根据原图尺寸创建一个相同大小的真彩色位图
         $white = imagecolorallocate($dst_im,255,255,255);//白
   //给新图填充背景色
        // $black = imagecolorallocate($dst_im,0,0,0);//黑
       //  $red = imagecolorallocate($dst_im,255,0,0);//红
       //$orange = imagecolorallocate($dst_im,255,85,0);//橙
         imagefill($dst_im,0,0,$white);



         imagecopymerge($dst_im,$src_im,0,0,0,0,$src_w,$src_h,100);//原图图像写入新建真彩位图中
         //imagefilledrectangle($dst_im,1,$src_h-15,80,$src_h,$white);
//bool imagecopymerge ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )
//将 src_im 图像中坐标从 src_x，src_y 开始，宽度为 src_w，高度为 src_h 的一部分拷贝到 dst_im 图像中坐标为 dst_x 和 dst_y 的位置上。两图像将根据 pct 来决定合并程度，其值范围从 0 到 100。当 pct = 0 时，实际上什么也没做，当为 100 时对于调色板图像本函数和 imagecopy() 完全一样，它对真彩色图像实现了 alpha 透明。

//取得水印图像尺寸，信息
$lim_size = getimagesize($waterimgv);
$src_lim ='';
switch($lim_size[2]){
    case 1:
        $src_lim=@imagecreatefromgif($waterimgv);
        break;
    case 2:
        $src_lim=@imagecreatefromjpeg($waterimgv);
        break;
    case 3:
        $src_lim=@imagecreatefrompng($waterimgv);
        break;
}

if($waterposi=='y'){
//水印居中
    $x = ($src_w-$lim_size[0])/2;   
     $y = ($src_h-$lim_size[1])/2;   
}else{
//水印在右下角
    $x =$src_w-$lim_size[0];  
    $y =$src_h-$lim_size[1];   
} 
imagecopymerge($dst_im,$src_lim,$x,$y,0,0,$lim_size[0],$lim_size[1],$waterclearly);// 合并两个图像，设置水印透明度$waterclearly

 imagedestroy($src_lim);

 switch($src_type)
  {
   case 1 :
    imagegif($dst_im,$oldimg); // GIF gif no imclearly
    break;
   case 2 :
    imagejpeg($dst_im,$oldimg,$imclearly); //以 JPEG 格式将图像输出到浏览器或文件
    break;
   case 3 :
    imagepng($dst_im,$oldimg); //png no ,$imclearly
    break;
   default :
    return;
  }

//imagejpeg($dst_im,$oldimg,$imclearly);//生成jpg文件，图片清晰度0-100
imagedestroy($dst_im);         //释放缓存
imagedestroy($src_im);//释放缓存

?>
