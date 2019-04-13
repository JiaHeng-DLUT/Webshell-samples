<?php
/**
 * Project: Catfish.
 * Author: A.J
 * Date: 2016/11/6
 */
namespace app\common;

use think\Controller;
use app\admin\controller\Tree;
use think\Db;
use think\Config;
use think\Cache;
use think\Session;
use think\Url;
use think\Validate;
use think\Request;
use think\Lang;

class Plugin extends Controller
{
    protected function get($key)
    {
        $re = Db::name('options')->where('option_name','p_'.$key)->field('option_value')->find();
        if(isset($re['option_value']))
        {
            return $re['option_value'];
        }
        else
        {
            return '';
        }
    }
    protected function set($key,$value,$protection = false)
    {
        $re = Db::name('options')->where('option_name','p_'.$key)->field('option_value')->find();
        if(empty($re))
        {
            $data = [
                'option_name' => 'p_'.$key,
                'option_value' => $value,
                'autoload' => 0
            ];
            Db::name('options')->insert($data);
        }
        else
        {
            if($protection == false)
            {
                Db::name('options')
                    ->where('option_name', 'p_'.$key)
                    ->update(['option_value' => $value]);
            }
        }
    }
    protected function delete($key)
    {
        Db::name('options')->where('option_name', 'p_'.$key)->delete();
    }
    public function run(&$params)
    {
    }
    protected function domain($check_pseudo_static = false)
    {
        $domain = Cache::get('domain');
        if($domain == false)
        {
            $domain = Db::name('options')->where('option_name','domain')->field('option_value')->find();
            $domain = $domain['option_value'];
            Cache::set('domain',$domain,3600);
        }
        if($check_pseudo_static == true)
        {
            $root = '';
            $dm = Url::build('/');
            if(strpos($dm,'/index.php') !== false)
            {
                $root = 'index.php/';
            }
            $domain = $domain . $root;
        }
        return $domain;
    }
    protected function upload($width = 0, $height = 0, $upfile = 'file')
    {
        if(Request::instance()->has($upfile,'file')){
            $file = request()->file($upfile);
            $validate = [
                'ext' => 'jpg,png,gif,jpeg'
            ];
            $isok = $file->check($validate);
            if($isok){
                $info = $file->move(ROOT_PATH . 'data' . DS . 'uploads');
                if($info){
                    if($width > 0 && $height >0)
                    {
                        $image = \think\Image::open(ROOT_PATH . 'data' . DS . 'uploads' . DS . $info->getSaveName());
                        $tuwidth = $image->width();
                        $tuheight = $image->height();
                        if($tuwidth > $width || $tuheight > $height)
                        {
                            @$image->thumb($width, $height)->save(ROOT_PATH . 'data' . DS . 'uploads' . DS . $info->getSaveName());
                        }
                    }
                    echo str_replace('\\','/',$info->getSaveName());
                    return true;
                }else{
                    echo '';
                    return false;
                }
            }
            else{
                echo '';
                return false;
            }
        }
        else{
            echo '';
            return false;
        }
    }
    protected function category()
    {
        $data = Db::name('terms')->field('id,term_name,parent_id')->select();
        if(is_array($data) && count($data) > 0)
        {
            $r = Tree::makeTreeForHtml($data);
            foreach($r as $key => $val){
                $r[$key]['level'] = str_repeat('&#12288;',$val['level']);
            }
            return $r;
        }
        else
        {
            return [];
        }
    }
    protected function subcategory($subcategoryName = '', $category = [], $self = true)
    {
        if(empty($subcategoryName))
        {
            return $category;
        }
        $delstart = true;
        $level = '';
        foreach((array)$category as $key => $val)
        {
            if($val['term_name'] != $subcategoryName && $delstart == true)
            {
                unset($category[$key]);
                continue;
            }
            if($val['term_name'] == $subcategoryName && $delstart == true)
            {
                $delstart = false;
                $level = $val['level'];
                if($self == false)
                {
                    unset($category[$key]);
                }
                continue;
            }
            if($delstart == false && strlen($val['level']) > strlen($level))
            {
                continue;
            }
            if($delstart == false && strlen($val['level']) <= strlen($level))
            {
                $delstart = true;
                $level = '';
                if($val['term_name'] != $subcategoryName)
                {
                    unset($category[$key]);
                    continue;
                }
                else
                {
                    $delstart = false;
                    $level = $val['level'];
                    if($self == false)
                    {
                        unset($category[$key]);
                    }
                    continue;
                }
            }
        }
        return $category;
    }
    protected function userID()
    {
        $session_prefix = 'catfish'.str_replace(['/','.',' ','-'],['','?','*','|'],Url::build('/'));
        return Session::get($session_prefix.'user_id');
    }
    protected function user()
    {
        $session_prefix = 'catfish'.str_replace(['/','.',' ','-'],['','?','*','|'],Url::build('/'));
        return Session::get($session_prefix.'user');
    }
    protected function prefix()
    {
        return Config::get('database.prefix');
    }
    protected function execute($statement)
    {
        if(strtolower(substr(ltrim($statement),0,6)) == 'select' || strtolower(substr(ltrim($statement),0,4)) == 'show')
        {
            try{
                return Db::query($statement);
            }catch(\Exception $e){
                return false;
            }
        }
        else
        {
            try{
                return Db::execute($statement);
            }catch(\Exception $e){
                return false;
            }
        }
    }
    protected function add(&$params,$label,$data)
    {
        if(isset($params[$label]))
        {
            $params[$label] .= $data;
        }
        else
        {
            $params[$label] = $data;
        }
    }
    protected function addTop(&$params,$label,$data)
    {
        if(isset($params[$label]))
        {
            $params[$label] = $data . $params[$label];
        }
        else
        {
            $params[$label] = $data;
        }
    }
    protected function addArray(&$params,$label,$array)
    {
        $params[$label][$array['name']] = $array;
    }
    protected function addGroup(&$params,$label,$group,$array)
    {
        $params[$label][$group][$array['name']] = $array;
    }
    protected function importFiles($files)
    {
        $re = '';
        foreach($files as $file)
        {
            $re .= $this->import($file);
        }
        return $re;
    }
    protected function import($path)
    {
        $path = str_replace('\\','/',$path);
        $path = trim($path, '/');
        $pathinfo = pathinfo($path);
        $pluginName = $this->getPlugin();
        $file = APP_PATH.'plugins/'.$pluginName.'/'.$path;
        if(is_file($file))
        {
            if($pathinfo['extension'] == 'html')
            {
                $mobile = $pathinfo['dirname'].'/mobile/'.$pathinfo['basename'];
                if(Request::instance()->isMobile() && is_file(APP_PATH.'plugins/'.$pluginName.'/'.$mobile))
                {
                    $mobile = APP_PATH.'plugins/'.$pluginName.'/'.$mobile;
                    $view = $this->fetch($mobile);
                    return $view;
                }
                else
                {
                    $view = $this->fetch($file);
                    return $view;
                }
            }
            else
            {
                $content = file_get_contents($file);
                if($pathinfo['extension'] == 'js')
                {
                    return '<script type="text/javascript"> ' . $content . ' </script>';
                }
                elseif($pathinfo['extension'] == 'css')
                {
                    return '<style type="text/css"> ' . $content . ' </style>';
                }
                elseif(in_array($pathinfo['extension'],['jpeg','jpg','png','gif']))
                {
                    $domain = $this->domain();
                    $domain = substr($domain,-1,1) == '/' ? substr($domain,0,strlen($domain)-1) : $domain;
                    return $domain . Url::build('/multimedia') . '?path='.urlencode($pluginName.'/'.$path).'&ext='.$pathinfo['extension'].'&media=image';
                }
                else
                {
                    return '';
                }
            }
        }
        else
        {
            return '';
        }
    }
    protected function siteName()
    {
        $siteName = Cache::get('plugin_siteName');
        if($siteName == false)
        {
            $siteName = Db::name('options')->where('option_name','title')->field('option_value')->find();
            $siteName = $siteName['option_value'];
            Cache::set('plugin_siteName',$siteName,3600);
        }
        return $siteName;
    }
    protected function binding($view,$name,&$params,$title = '')
    {
        if(isset($params['name']) && $params['name'] == $name)
        {
            $params['view'] = $view;
            if(!empty($title))
            {
                $params['title'] = $title;
            }
        }
    }
    protected function bindingGroup($view,$name,$group,&$params,$title = '')
    {
        if(isset($params['name']) && $params['name'] == $name && isset($params['group']) && $params['group'] == $group)
        {
            $params['view'] = $view;
            if(!empty($title))
            {
                $params['title'] = $title;
            }
        }
    }
    protected function delfile($url)
    {
        $url = str_replace('\\','/',$url);
        $weizhi = strripos($url,'data/');
        if($weizhi === false)
        {
            return false;
        }
        else
        {
            $path = substr($url,$weizhi);
            if(is_file(APP_PATH.'../'.$path))
            {
                if(@unlink(APP_PATH.'../'.$path))
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
                return true;
            }
        }
    }
    protected function verify($rule, $msg = [], $data = [])
    {
        $validate = new Validate($rule, $msg);
        if(count($data) > 0)
        {
            if(!$validate->check($data))
            {
                $this->error($validate->getError());
                return false;
            }
            else{
                return true;
            }
        }
        else
        {
            return $validate;
        }
    }
    protected function uhref($label,$isTop = false, $isGroup = false, $group = 'group')
    {
        if($isTop == true)
        {
            if($isGroup == true)
            {
                return Url::build('/user/Index/plugingt/name/'.$label.'.'.$group);
            }
            else
            {
                return Url::build('/user/Index/plugint/name/'.$label);
            }
        }
        else
        {
            if($isGroup == true)
            {
                return Url::build('/user/Index/plugingp/name/'.$label.'.'.$group);
            }
            else
            {
                return Url::build('/user/Index/plugin/name/'.$label);
            }
        }
    }
    protected function phref()
    {
        return Url::build('/admin/Index/plugins/plugin/'.$this->getPlugin());
    }
    protected function bindUser($userInfo)
    {
        $re = Db::name('users')->where('user_login',$userInfo['uname'])->field('id')->find();
        if(empty($re))
        {
            $eml = '';
            if(isset($userInfo['email']))
            {
                $eml = $userInfo['email'];
            }
            $pwd = '';
            if(isset($userInfo['password']))
            {
                $pwd = $userInfo['password'];
            }
            $data = [
                'user_login' => $userInfo['uname'],
                'user_pass' => md5($pwd),
                'user_nicename' => $userInfo['uname'],
                'user_email' => $eml,
                'last_login_ip' => get_client_ip(0,true),
                'create_time' => date("Y-m-d H:i:s"),
                'user_type' => 7
            ];
            $reid = Db::name('users')->insertGetId($data);
            return $reid;
        }
        else
        {
            return $re['id'];
        }
    }
    protected function thirdPartyLogin($userInfo)
    {
        try{
            Db::name('users')
                ->where('id', $userInfo['uid'])
                ->update([
                    'last_login_ip' => get_client_ip(0,true),
                    'last_login_time' => date("Y-m-d H:i:s")
                ]);
        }catch(\Exception $e)
        {
            return false;
        }
        $session_prefix = 'catfish'.str_replace(['/','.',' ','-'],['','?','*','|'],Url::build('/'));
        Session::set($session_prefix.'user_id',$userInfo['uid']);
        Session::set($session_prefix.'user',$userInfo['uname']);
        Session::set($session_prefix.'user_type',7);
        return true;
    }
    protected function recurseCopy($src,$dst){
        $dir=opendir($src);
        @mkdir($dst);
        while(false!==($file=readdir($dir))){
            if(($file!='.' )&&($file!='..')){
                if(is_dir($src.'/'.$file)){
                    $this->recurseCopy($src.'/'.$file,$dst.'/'.$file);
                }
                else{
                    copy($src.'/'.$file,$dst.'/'.$file);
                }
            }
        }
        closedir($dir);
    }
    protected function subdirectory()
    {
        return rtrim(Url::build('/'),'/');
    }
    protected function statement($statement)
    {
        if(!(strcasecmp(strtolower($statement),base64_decode('Y2F0ZmlzaCBjbXMgcGx1Z2lu')) == 0 ? true : false) && !(strcasecmp(strtolower($statement),base64_decode('Y2F0ZmlzaCBhbGwgcGx1Z2lu')) == 0 ? true : false))
        exit();
    }
    protected function getVersion()
    {
        $version = Config::get('version');
        return trim($version['number']);
    }
    protected function getCatfishType()
    {
        $version = Config::get('version');
        return trim($version['catfishType']);
    }
    protected function getPost($param = '')
    {
        if($param == '')
        {
            $tmp = Request::instance()->post();
            if(empty($tmp))
            {
                return false;
            }
            else
            {
                return $tmp;
            }
        }
        else
        {
            if(Request::instance()->has($param,'post'))
            {
                return urldecode(Request::instance()->post($param));
            }
            else
            {
                return false;
            }
        }
    }
    protected function getGet($param = '')
    {
        if($param == '')
        {
            $tmp = Request::instance()->get();
            if(empty($tmp))
            {
                return false;
            }
            else
            {
                return $tmp;
            }
        }
        else
        {
            if(Request::instance()->has($param,'get'))
            {
                return urldecode(Request::instance()->get($param));
            }
            else
            {
                return false;
            }
        }
    }
    protected function addMainMenu(&$params,$label,$href,$position = 'last',$target = '_self',$icon = '')
    {
        $jian = array_keys((array)$params);
        if($jian[0] != 'menu1')
        {
            return false;
        }
        $firstFloorMainMenuLen = count($params['menu1']);
        if($target == '')
        {
            $target = '_self';
        }
        $arr[] = [
            'id' => 0,
            'parent_id' => 0,
            'label' => $label,
            'target' => $target,
            'href' => Url::build('/cpage/'.$href),
            'icon' => $icon
        ];
        $isover = false;
        $layer = [];
        if($position == 'first')
        {
            $layer[] = 0;
            $isover = true;
        }
        elseif($position == 'second')
        {
            $layer[] = 1;
            $isover = true;
        }
        elseif($position == 'last' || $position == '' || !preg_match('/^\d+(,\d+)*$/', $position))
        {
            $layer[] = $firstFloorMainMenuLen;
            $isover = true;
        }
        if($isover == false)
        {
            $poarr = explode(',',$position);
            foreach($poarr as $val)
            {
                $layer[] = $val;
            }
            $isover = true;
        }
        if($layer[0] >= $firstFloorMainMenuLen)
        {
            $layer[0] = $firstFloorMainMenuLen;
        }
        $tmpmenu = $this->appendMenu($params['menu1'],$layer,$arr);
        $daohang = $tmpmenu['daohang'];
        unset($tmpmenu['daohang']);
        $params['menu1'] = $tmpmenu;
        $params['daohang'][$href] = $daohang;
        return true;
    }
    private function appendMenu($menu,$layer,$arr,$daohang = [])
    {
        if(count($layer) == 1)
        {
            $cmenu = count($menu);
            if($layer[0] >= $cmenu)
            {
                $layer[0] = $cmenu;
            }
            array_splice($menu,$layer[0],0,(array)$arr);
            $daohang[] = [
                'id' => 0,
                'label' => $arr[0]['label'],
                'icon' => $arr[0]['icon'],
                'href' => $arr[0]['href']
            ];
            $menu['daohang'] = $daohang;
            return $menu;
        }
        else
        {
            $fst = array_shift($layer);
            $cmenu = count($menu);
            if($fst >= $cmenu)
            {
                $fst = $cmenu;
            }
            if(isset($menu[$fst]['children']))
            {
                $daohang[] = [
                    'id' => $menu[$fst]['id'],
                    'label' => $menu[$fst]['label'],
                    'icon' => $menu[$fst]['icon'],
                    'href' => $menu[$fst]['href']
                ];
                $tmpmenu = $this->appendMenu($menu[$fst]['children'],$layer,$arr,$daohang);
                $tmpdaohang = $tmpmenu['daohang'];
                unset($tmpmenu['daohang']);
                $menu[$fst]['children'] = $tmpmenu;
                $menu['daohang'] = $tmpdaohang;
                return $menu;
            }
            else
            {
                array_splice($menu,$fst,0,(array)$arr);
                $daohang[] = [
                    'id' => 0,
                    'label' => $arr[0]['label'],
                    'icon' => $arr[0]['icon'],
                    'href' => $arr[0]['href']
                ];
                $menu['daohang'] = $daohang;
                return $menu;
            }
        }
    }
    protected function bindingMenu(&$params,$name)
    {
        if($params['name'] == $name)
        {
            return true;
        }
        return false;
    }
    protected function defineIncludeFile($files, $path = 'page')
    {
        $lei = $this->getPlugin();
        if($path != '')
        {
            $path = trim($path,'/');
            $path = $path.'/';
        }
        $files = explode(',',$files);
        foreach($files as $val)
        {
            if(Request::instance()->isMobile() && is_file(APP_PATH.'plugins/'.$lei.'/'.$path.'mobile/'.$val.'.html'))
            {
                $this->assign($val, 'application/plugins/'.$lei.'/'.$path.'mobile/'.$val.'.html');
            }
            else
            {
                $this->assign($val, 'application/plugins/'.$lei.'/'.$path.$val.'.html');
            }
        }
    }
    private function getPlugin()
    {
        $lei = get_called_class();
        $lei = str_replace('\\','/',$lei);
        $lei = trim($lei,'/');
        $leiArr = explode('/',$lei);
        $leiArr = array_slice($leiArr,-2,1);
        return $leiArr[0];
    }
    protected function importTheme(&$params, $path)
    {
        $lei = $this->getPlugin();
        $path = str_replace('\\','/',$path);
        $path = trim($path, '/');
        $file = pathinfo($path);
        if($file['dirname'] == '.')
        {
            $mobile = 'mobile/'.$file['basename'];
        }
        else
        {
            $mobile = $file['dirname'].'/mobile/'.$file['basename'];
        }
        if(Request::instance()->isMobile() && is_file(APP_PATH.'plugins/'.$lei.'/'.$mobile))
        {
            $params['path'] = $lei.'/'.$mobile;
        }
        else
        {
            $params['path'] = $lei.'/'.$path;
        }
    }
    protected function pluginLabel($name, $content)
    {
        $this->assign('p_'.$name, $content);
    }
    protected function templateLabel($name, $content)
    {
        $this->assign('t_'.$name, $content);
    }
    protected function theme()
    {
        $template = Cache::get('template');
        if($template == false)
        {
            $template = Db::name('options')->where('option_name','template')->field('option_value')->find();
            Cache::set('template',$template,3600);
        }
        return $template['option_value'];
    }
    protected function bindingView($view,&$params)
    {
        $params['view'] = $view;
    }
    protected function db($name)
    {
        return Db::name($name);
    }
    protected function look($variable)
    {
        header("Content-Type: text/html; charset=utf-8");
        dump($variable);
        exit();
    }
    protected function part($data)
    {
        $redata = [];
        $redata['pages'] = $data->render();
        if($redata['pages'] == null)
        {
            $redata['pages'] = '';
        }
        $pageArr = $data->toArray();
        $redata['total'] = $pageArr['total'];
        $redata['per_page'] = $pageArr['per_page'];
        $redata['current_page'] = $pageArr['current_page'];
        $redata['data'] = $pageArr['data'];
        unset($pageArr);
        return $redata;
    }
    protected function lang($str)
    {
        return Lang::get($str);
    }
    protected function getLang()
    {
        $lang = Lang::detect();
        $lang = trim(strtolower($lang));
        if($lang == 'zh' || strpos($lang,'zh-hans') !== false || strpos($lang,'zh-chs') !== false)
        {
            Lang::range('zh-cn');
            $lang = 'zh-cn';
        }
        else if($lang == 'zh-tw' || ($lang != 'zh-hk' && $lang != 'zh-mo' && (strpos($lang,'zh-hant') !== false || strpos($lang,'zh-cht') !== false)) ){
            Lang::range('zh-tw');
            $lang = 'zh-tw';
        }
        else if($lang == 'zh-hk' || ($lang != 'zh-tw' && $lang != 'zh-mo' && (strpos($lang,'zh-hant') !== false || strpos($lang,'zh-cht') !== false)) ){
            Lang::range('zh-hk');
            $lang = 'zh-hk';
        }
        else if($lang == 'zh-mo' || ($lang != 'zh-tw' && $lang != 'zh-hk' && (strpos($lang,'zh-hant') !== false || strpos($lang,'zh-cht') !== false)) ){
            Lang::range('zh-mo');
            $lang = 'zh-mo';
        }
        else if(stripos($lang,'zh') === false){
            $paramsub = substr($lang,0,2);
            switch($paramsub){
                case 'de':
                    Lang::range('de-de');
                    $lang = 'de-de';
                    break;
                case 'fr':
                    Lang::range('fr-fr');
                    $lang = 'fr-fr';
                    break;
                case 'ja':
                    Lang::range('ja-jp');
                    $lang = 'ja-jp';
                    break;
                case 'ko':
                    Lang::range('ko-kr');
                    $lang = 'ko-kr';
                    break;
                case 'ru':
                    Lang::range('ru-ru');
                    $lang = 'ru-ru';
                    break;
                case 'en':
                    if(strpos($lang,'en-us') === false){
                        Lang::range('en-gb');
                        $lang = 'en-gb';
                    }
                    else{
                        Lang::range('en-us');
                        $lang = 'en-us';
                    }
                    break;
            }
        }
        return $lang;
    }
    protected function view($name, $field = null)
    {
        return Db::view($name, $field);
    }
    protected function isMobile()
    {
        return Request::instance()->isMobile();
    }
    protected function url($url)
    {
        return Url::build($url);
    }
    protected function getCache($cache)
    {
        return Cache::get($cache);
    }
    protected function setCache($name, $value, $expire = null)
    {
        return Cache::set($name,$value,$expire);
    }
    protected function removeCache($name)
    {
        return Cache::rm($name);
    }
    protected function clearCache($tag = null)
    {
        return Cache::clear($tag);
    }
    protected function tagCache($name, $keys = null, $overlay = false)
    {
        return Cache::tag($name, $keys, $overlay);
    }
    protected function maxUploadSize()
    {
        $max = 0;
        if(ini_get('file_uploads'))
        {
            $max_size = ini_get('upload_max_filesize');
            preg_match('/(^[0-9\.]+)(\w+)/',$max_size,$info);
            $size=$info[1];
            $suffix=strtoupper($info[2]);
            $a = array_flip(array("B", "KB", "MB", "GB", "TB", "PB"));
            $b = array_flip(array("B", "K", "M", "G", "T", "P"));
            $pos = (isset($a[$suffix]) && $a[$suffix] !== 0) ? $a[$suffix] : $b[$suffix];
            $max = round($size*pow(1024,$pos));
        }
        return $max;
    }
    protected function uploadFile($type = '', $place = 'uploads', $upfile = 'file')
    {
        $fj = '';
        if(Request::instance()->has($upfile,'file')){
            $file = request()->file($upfile);
            $isok = true;
            if(!empty($type))
            {
                $validate = [
                    'ext' => $type
                ];
                $isok = $file->check($validate);
            }
            if($isok){
                $dir = ROOT_PATH . 'data' . DS . $place;
                is_dir($dir) OR mkdir($dir, 0777, true);
                $info = $file->move($dir);
                if($info){
                    $fj = trim($place,'/') . '/' . str_replace('\\','/',$info->getSaveName());
                }
            }
        }
        return $fj;
    }
    protected function uploadFiles($type = '', $place = 'uploads', $upfile = 'file')
    {
        $fj = '';
        if(Request::instance()->has($upfile,'file')){
            $dir = ROOT_PATH . 'data' . DS . $place;
            is_dir($dir) OR mkdir($dir, 0777, true);
            $files = request()->file($upfile);
            foreach($files as $file){
                $isok = true;
                if(!empty($type))
                {
                    $validate = [
                        'ext' => $type
                    ];
                    $isok = $file->check($validate);
                }
                if($isok){
                    $info = $file->move($dir);
                    if($info){
                        $fj .= trim($place,'/') . '/' . str_replace('\\','/',$info->getSaveName()) . ',';
                    }
                }
            }
            $fj = trim($fj,',');
        }
        return $fj;
    }
    protected function uploadImg($width = 0, $height = 0, $upfile = 'file')
    {
        $fj = '';
        if(Request::instance()->has($upfile,'file')){
            $file = request()->file($upfile);
            $validate = [
                'ext' => 'jpg,png,gif,jpeg'
            ];
            $isok = $file->check($validate);
            if($isok){
                $info = $file->move(ROOT_PATH . 'data' . DS . 'uploads');
                if($info){
                    if($width > 0 && $height >0)
                    {
                        $image = \think\Image::open(ROOT_PATH . 'data' . DS . 'uploads' . DS . $info->getSaveName());
                        $tuwidth = $image->width();
                        $tuheight = $image->height();
                        if($tuwidth > $width || $tuheight > $height)
                        {
                            @$image->thumb($width, $height)->save(ROOT_PATH . 'data' . DS . 'uploads' . DS . $info->getSaveName());
                        }
                    }
                    $fj = str_replace('\\','/',$info->getSaveName());
                }
            }
        }
        return $fj;
    }
    protected function uploadImgs($width = 0, $height = 0, $upfile = 'file')
    {
        $fj = '';
        if(Request::instance()->has($upfile,'file')){
            $files = request()->file($upfile);
            foreach($files as $file){
                $validate = [
                    'ext' => 'jpg,png,gif,jpeg'
                ];
                $isok = $file->check($validate);
                if($isok){
                    $info = $file->move(ROOT_PATH . 'data' . DS . 'uploads');
                    if($info){
                        if($width > 0 && $height >0)
                        {
                            $image = \think\Image::open(ROOT_PATH . 'data' . DS . 'uploads' . DS . $info->getSaveName());
                            $tuwidth = $image->width();
                            $tuheight = $image->height();
                            if($tuwidth > $width || $tuheight > $height)
                            {
                                @$image->thumb($width, $height)->save(ROOT_PATH . 'data' . DS . 'uploads' . DS . $info->getSaveName());
                            }
                        }
                        $fj .= str_replace('\\','/',$info->getSaveName()) . ',';
                    }
                }
            }
            $fj = trim($fj,',');
        }
        return $fj;
    }
    protected function hasUploadFile($upfile = 'file')
    {
        return Request::instance()->has($upfile,'file');
    }
    protected function jump($which,$id = '')
    {
        $id = trim(trim($id,'/'));
        if($id != ''){
            $id = '/'.$id;
        }
        $this->redirect(url($this->domain(true).trim(trim($which,'/')).$id));
    }
    protected function isPost()
    {
        return Request::instance()->isPost();
    }
    protected function isGet()
    {
        return Request::instance()->isGet();
    }
}