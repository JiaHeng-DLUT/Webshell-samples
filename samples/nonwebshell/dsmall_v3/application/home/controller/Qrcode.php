<?php

namespace app\home\controller;


class Qrcode extends BaseMall {

    public function index() {
       import('qrcode.phpqrcode', EXTEND_PATH);
        $value = input('get.url');
        $errorCorrectionLevel = "L";
        $matrixPointSize = "4";
        \QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize,2);
        exit;
    }

}
