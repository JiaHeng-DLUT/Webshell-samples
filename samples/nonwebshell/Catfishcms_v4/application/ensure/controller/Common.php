<?php
/**
 * Project: Catfish.
 * Author: A.J
 * Date: 2017/9/2
 */
namespace app\ensure\controller;

use app\common\Package;
use think\Db;
use think\Cache;

class Common extends Package
{
    protected $siteType = 'open';
    protected function baseCamp($req = [])
    {
        if(!empty($req) && is_array($req))
        {
            $restr = '';
            foreach($req as $key => $val)
            {
                if($restr == '')
                {
                    $restr = $key.'='.$val;
                }
                else
                {
                    $restr .= '&'.$key.'='.$val;
                }
            }
            $url = 'http://www.catfish-cms.com/upgrade.html?'.$restr;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;http://www.baidu.com)');
            curl_setopt($ch , CURLOPT_URL , $url);
            $res = curl_exec($ch);
            curl_close($ch);
            return $res;
        }
        return false;
    }
    protected function turnon(&$summary,&$content)
    {
        $tmp = APP_PATH.'../runtime/ctmp';
        if(!is_dir($tmp))
        {
            mkdir($tmp,0777,true);
        }
        $fpath = $tmp.'/ctmp.zip';
        file_put_contents($fpath,$content);
        if(md5_file($fpath) == $summary)
        {
            Cache::clear();
            $zip = new \ZipArchive();
            if($zip->open($fpath) === true)
            {
                $zip->extractTo(APP_PATH.'../');
                $zip->close();
                @unlink($fpath);
            }
            $zfsp = APP_PATH.'install/data/data.php';
            if(is_file($zfsp))
            {
                $zfs = file_get_contents($zfsp);
                $data = ['option_name' => 'cbase', 'option_value' => $zfs, 'autoload' => 0];
                $tmpdb = Db::name('options')->where('option_name','cbase')->field('option_id')->find();
                if(empty($tmpdb))
                {
                    Db::name('options')->insert($data);
                }
                else
                {
                    Db::name('options')
                        ->where('option_id', $tmpdb['option_id'])
                        ->update($data);
                }
            }
            file_get_contents($this->host());
            return true;
        }
        else
        {
            return false;
        }
    }
    private function host()
    {
        $domain = Cache::get('domain');
        if($domain == false)
        {
            $domain = Db::name('options')->where('option_name','domain')->field('option_value')->find();
            $domain = $domain['option_value'];
            Cache::set('domain',$domain,3600);
        }
        return $domain;
    }
    protected function getmonopoly()
    {
        return APP_PATH.'../runtime/ctmp/monopoly.php';
    }
    protected function monopoly()
    {
        $monopolyp = APP_PATH.'../runtime/ctmp';
        $monopoly = $monopolyp.'/monopoly.php';
        if(!is_dir($monopolyp))
        {
            mkdir($monopolyp,0777,true);
        }
        file_put_contents($monopoly,'');
    }
    protected function unmonopoly()
    {
        $tmp = $this->getmonopoly();
        if(is_file($tmp))
        {
            @unlink($tmp);
        }
    }
}