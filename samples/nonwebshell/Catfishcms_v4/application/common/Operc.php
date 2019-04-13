<?php
/**
 * Project: Catfish.
 * Author: A.J
 * Date: 2017/9/15
 */
namespace app\common;

use think\Db;
use think\Cache;

class Operc
{
    public static function getc($key)
    {
        $re = Db::name('options')->where('option_name','c_'.$key)->field('option_value')->find();
        if(isset($re['option_value']))
        {
            return $re['option_value'];
        }
        else
        {
            return '';
        }
    }
    public static function setc($key,$value)
    {
        $re = Db::name('options')->where('option_name','c_'.$key)->field('option_value')->find();
        if(empty($re))
        {
            $data = [
                'option_name' => 'c_'.$key,
                'option_value' => $value,
                'autoload' => 0
            ];
            Db::name('options')->insert($data);
        }
        else
        {
            Db::name('options')
                ->where('option_name', 'c_'.$key)
                ->update(['option_value' => $value]);
        }
    }
    public static function getTitle()
    {
        $wtitle = Cache::get('webTitle');
        if($wtitle == false)
        {
            $wtitle = Db::name('options')->where('option_name','title')->field('option_value')->find();
            $wtitle = $wtitle['option_value'];
            Cache::set('webTitle',$wtitle,86400);
        }
        return $wtitle;
    }
    public static function isCorP($cp)
    {
        if(stripos($cp,'/category/') !== false || stripos($cp,'/page/') !== false)
        {
            return true;
        }
        return false;
    }
    public static function cm($n,$o,$m)
    {
        if(md5($o.$n) != $m.'a22bf6704bf4755e')
        {
            return false;
        }
        return true;
    }
    public static function aut()
    {
        $operc_aut = Cache::get('operc_aut');
        if($operc_aut == false)
        {
            $author = self::getc('author');
            if(!empty($author))
            {
                $operc_aut = unserialize($author);
            }
            else
            {
                $operc_aut = '';
            }
            Cache::set('operc_aut',$operc_aut,3600);
        }
        if(empty($operc_aut))
        {
            return false;
        }
        else
        {
            if(isset($operc_aut['open']) && isset($operc_aut['veri']) && isset($operc_aut['rm']) && isset($operc_aut['sq']) && isset($operc_aut['ck']))
            {
                if($operc_aut['ck'] == md5($operc_aut['rm'].$operc_aut['sq']))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
    }
    public static function bdc($str)
    {
        return base64_decode($str);
    }
}