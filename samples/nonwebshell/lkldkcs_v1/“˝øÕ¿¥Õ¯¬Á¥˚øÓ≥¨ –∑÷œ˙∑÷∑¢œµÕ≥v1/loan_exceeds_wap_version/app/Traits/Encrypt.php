<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-12-6
 * Time: 17:11
 */

namespace App\Traits;


trait Encrypt
{
    private static $_vi =  'DaiFox@YSJR18~19';//私钥,16
    public $_key = 'LoanLoanFox2018-2019@YSJR.$#%^&*';//公匙,32
    public $_aes = 'AES-256-CBC';//加密方式
    /**
     * 填充字符串
     * @param $text
     * @param $blocksize
     * @return string
     */
    public static function fill($text, $blocksize) {//PKCS5Padding
        //根据加密算法的大小获得最终字符串
        if(is_array($text)){//数组
            $array_text = implode('',$text);
            $pad = $blocksize - (strlen($array_text) % $blocksize);
            return $text . str_repeat(chr($pad), $pad);
        }
        if(gettype($text)=='json'){//json数据
            $json_text = implode('',json_decode($text,true));
            $pad = $blocksize - (strlen($json_text) % $blocksize);
            return $text . str_repeat(chr($pad), $pad);
        }
        //字符串数据
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * 加密
     * @param $input 输入
     * @param $key   加密key
     * @return string
     */

    public static function encrypt_pass($input,$aes, $key) {
        $encrypted = openssl_encrypt($input, $aes, $key, 1, self::$_vi);
        $data = base64_encode($encrypted);//对使用 MIME base64 编码的数据进行编码
        return $data;
    }

    /**
     * 解密
     * @param $sStr 加密后字符串
     * @param $sKey 公钥
     * @return string 返回值
     */
    public static function decrypt_pass($sStr, $aes, $sKey) {
        $decrypted= openssl_decrypt(base64_decode($sStr),$aes,$sKey,1,self::$_vi);
        return $decrypted;
    }
}