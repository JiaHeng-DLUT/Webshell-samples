<?php
/*
 * 根据文字生成对应图片
 */
namespace app\home\controller;


class Pnum extends BaseMall {

    public function index() {
        $pnum = input('get.pnum');
        $im = imagecreate(120, 16);
        $bg = imagecolorallocate($im, 247, 247, 247);
        $textcolor = imagecolorallocate($im, 101, 101, 101);
        imagestring($im, 5, 0, 0, $pnum, $textcolor);
        header("Content-type: image/png");
        imagepng($im);
    }

}
