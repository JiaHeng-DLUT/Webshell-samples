<?php
/**
 * Project: Catfish CMS.
 * Author: A.J <804644245@qq.com>
 * Copyright: http://www.catfish-cms.com All rights reserved.
 * Date: 2016/9/29
 */
namespace app\install\controller;

use think\Controller;
use think\Validate;
use think\Request;
use think\Config;
use think\Db;
use think\Url;
use think\Lang;

class Index extends Controller
{
    private $lang;
    public function _initialize()
    {
        $this->lang = Lang::detect();
        $this->lang = $this->filterLanguages($this->lang);
        Lang::load(APP_PATH . 'install/lang/'.$this->lang.'.php');
    }
    public function index()
    {
        $this->check();
        $this->assign('version',Config::get('version'));
        $this->domain();
        $view = $this->fetch();
        return $view;
    }
    public function step1()
    {
        $this->check();
        $right = '<span class="glyphicon glyphicon-ok text-success"></span> ';
        $wrong = '<span class="glyphicon glyphicon-remove text-danger"></span> ';
        $data=array();
        $data['phpversion'] = @ phpversion();
        $data['os']=PHP_OS;
        $err = 0;
        if (version_compare($data['phpversion'], '5.4.0', '>=')) {
            $data['phpversion'] = $right . $data['phpversion'];
        }
        else {
            $data['phpversion'] = $wrong . $data['phpversion'];
            $err++;
        }
        if (class_exists('pdo')) {
            $data['pdo'] = $right . Lang::get('Turned on');
        } else {
            $data['pdo'] = $wrong . Lang::get('Unopened');
            $err++;
        }
        if (extension_loaded('pdo_mysql')) {
            $data['pdo_mysql'] = $right . Lang::get('Turned on');
        } else {
            $data['pdo_mysql'] = $wrong . Lang::get('Unopened');
            $err++;
        }
        if (ini_get('file_uploads')) {
            $data['upload_size'] = $right . ini_get('upload_max_filesize');
        } else {
            $data['upload_size'] = $wrong . Lang::get('Upload is prohibited');
        }
        if (function_exists('curl_init')) {
            $data['curl'] = $right . Lang::get('Turned on');
        } else {
            $data['curl'] = $wrong . Lang::get('Unopened');
            $err++;
        }
        if (function_exists('gd_info')) {
            $data['gd'] = $right . Lang::get('Turned on');
        } else {
            $data['gd'] = $wrong . Lang::get('Unopened');
            $err++;
        }
        if (class_exists('ZipArchive')) {
            $data['ZipArchive'] = $right . Lang::get('Turned on');
        } else {
            $data['ZipArchive'] = $wrong . Lang::get('Unopened');
            $err++;
        }
        if (function_exists('session_start')) {
            $data['session'] = $right . Lang::get('Turned on');
        } else {
            $data['session'] = $wrong . Lang::get('Unopened');
            $err++;
        }
        $lujing = ltrim(str_replace('/index.php','',Url::build('/')),'/');
        $folders = array(
            '',
            'data',
            'data/uploads',
            'application',
            'public/common/extended',
            'runtime',
            'runtime/cache',
            'runtime/log',
            'runtime/temp'
        );
        $new_folders=array();
        foreach($folders as $dir){
            $Testdir = "./".$dir;
            $this->createDir($Testdir);
            if($this->testWrite($Testdir)){
                $new_folders[$lujing.$dir]['w']=true;
            }else{
                $new_folders[$lujing.$dir]['w']=false;
                $err++;
            }
            if(is_readable($Testdir)){
                $new_folders[$lujing.$dir]['r']=true;
            }else{
                $new_folders[$lujing.$dir]['r']=false;
                $err++;
            }
        }
        $data['folders']=$new_folders;
        $this->assign('version',Config::get('version'));
        $this->assign('data',$data);
        $this->assign('error',$err);
        $this->domain();
        $view = $this->fetch();
        return $view;
    }
    private function createDir($path, $mode = 0777)
    {
        if(is_dir($path))
            return true;
        $path = str_replace('\\', '/', $path);
        if(substr($path, -1) != '/')
            $path = $path . '/';
        $temp = explode('/', $path);
        $cur_dir = '';
        $max = count($temp) - 1;
        for($i = 0; $i < $max; $i++)
        {
            $cur_dir .= $temp[$i] . '/';
            if (@is_dir($cur_dir))
                continue;
            @mkdir($cur_dir, 0777, true);
            @chmod($cur_dir, 0777);
        }
        return is_dir($path);
    }
    private function testWrite($d)
    {
        $tfile = "_test.txt";
        $fp = @fopen($d . "/" . $tfile, "w");
        if (!$fp) {
            return false;
        }
        fclose($fp);
        $rs = @unlink($d . "/" . $tfile);
        if ($rs) {
            return true;
        }
        return false;
    }
    public function step2()
    {
        $this->check();
        $this->assign('version',Config::get('version'));
        $this->domain();
        $view = $this->fetch();
        return $view;
    }
    public function step3()
    {
        $this->check();
        $rule = [
            'host' => 'require',
            'port' => 'require|number',
            'user' => 'require',
            'name' => 'require',
            'admin' => 'require',
            'pwd' => 'require|min:8',
            'repwd' => 'require',
            'email' => 'require|email'
        ];
        $msg = [
            'host.require' => Lang::get('The database server must be filled out'),
            'port.require' => Lang::get('The database port must be filled in'),
            'port.number' => Lang::get('The database port must be a number'),
            'user.require' => Lang::get('The database user name must be filled in'),
            'name.require' => Lang::get('The database name must be filled in'),
            'admin.require' => Lang::get('The administrator account must be filled in'),
            'pwd.require' => Lang::get('The administrator password is required'),
            'pwd.min' => Lang::get('The administrator password can not be less than 8 characters'),
            'repwd.require' => Lang::get('Confirm password is required'),
            'email.require' => Lang::get('Email is required'),
            'email.email' => Lang::get('Email format is incorrect')
        ];
        $data = [
            'host' => Request::instance()->post('host'),
            'port' => Request::instance()->post('port'),
            'user' => Request::instance()->post('user'),
            'name' => Request::instance()->post('name'),
            'admin' => Request::instance()->post('admin'),
            'pwd' => Request::instance()->post('pwd'),
            'repwd' => Request::instance()->post('repwd'),
            'email' => Request::instance()->post('email')
        ];
        $validate = new Validate($rule, $msg);
        if(!$validate->check($data))
        {
            $this->error($validate->getError());
        }
        elseif($data['pwd'] !== $data['repwd'])
        {
            $this->error(Lang::get('The "Administrator Password" and "Confirm Password" must be the same'));
        }
        else
        {
            try{
                $dbh=new \PDO('mysql:host='.$data['host'].';port='.$data['port'],$data['user'],Request::instance()->post('password'));
                $dbh->exec('CREATE DATABASE IF NOT EXISTS `' . $data['name'] . '` DEFAULT CHARACTER SET utf8');
            }catch(\Exception $e){
                $this->error(Lang::get('Database information error'));
                return false;
            }
            $this->assign('version',Config::get('version'));
            $domain = $this->domain();
            $sql = file_get_contents(APP_PATH . 'install/data/catfish.sql');
            $sql = str_replace("\r", "\n", $sql);
            $sql = explode(";\n", $sql);
            $default_tablepre = "catfish_";
            $sql = str_replace(" `{$default_tablepre}", " `" . Request::instance()->post('prefix'), $sql);
            $sql = str_replace("http://localhost/", $domain, $sql);
            foreach ($sql as $item) {
                $item = trim($item);
                if(empty($item)) continue;
                preg_match('/CREATE TABLE `([^ ]*)`/', $item, $matches);
                $this->dbExec($item);
            }
            $qu = $this->dbExec('select * from '.Request::instance()->post('prefix').'posts where id=1',true);
            if(empty($qu))
            {
                $this->error(Lang::get('Bad database name'));
            }
            $view = $this->fetch();
            echo $view;
            $create_date=date("Y-m-d H:i:s");
            $ip=get_client_ip(0,true);
            $biaoti = Request::instance()->post('biaoti');
            $biaoti = str_replace('\'','\\\'',$biaoti);
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "users`
    (id,user_login,user_pass,user_nicename,user_email,user_url,create_time,user_activation_key,user_status,last_login_ip,last_login_time,user_type) VALUES
    (1, '" . Request::instance()->post('admin') . "', '" . md5(Request::instance()->post('pwd')) . "', '" . Request::instance()->post('admin') . "', '" . Request::instance()->post('email') . "', '', '{$create_date}', '', '1', '{$ip}','{$create_date}', 1)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value) VALUES (1, 'title', '" . $biaoti . "')");
            $subtitle = Lang::get('Another Catfish CMS site');
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value) VALUES (2, 'subtitle', '" . $subtitle . "')");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value) VALUES (3, 'keyword', '')");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value) VALUES (4, 'description', '')");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value) VALUES (5, 'template', 'default')");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value) VALUES (6, 'record', '')");
            $copyright = Lang::get('Catfish CMS');
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value) VALUES (7, 'copyright', '".serialize($copyright)."')");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value) VALUES (8, 'statistics', '".serialize('')."')");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (9, 'email', '" . Request::instance()->post('email') . "', 0)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (10, 'filter', '', 0)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (11, 'comment', 0, 0)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (12, 'slideshowWidth', 750, 0)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (13, 'slideshowHeight', 390, 0)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (14, 'domain', '".$domain."', 1)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (15, 'logo', '', 1)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (16, 'captcha', '1', 0)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (17, 'bulletin', '', 0)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (18, 'spare', '', 0)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (19, 'write', '0', 0)");
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (20, 'checkwrite', '0', 0)");
            $pageSettings = 'a:2:{s:5:"hunhe";a:6:{i:1;a:4:{s:6:"biaoti";s:0:"";s:8:"shuliang";s:2:"10";s:7:"fangshi";s:9:"post_date";s:6:"fenlei";s:1:"0";}i:2;a:4:{s:6:"biaoti";s:0:"";s:8:"shuliang";s:2:"10";s:7:"fangshi";s:9:"post_date";s:6:"fenlei";s:1:"0";}i:3;a:4:{s:6:"biaoti";s:0:"";s:8:"shuliang";s:2:"10";s:7:"fangshi";s:9:"post_date";s:6:"fenlei";s:1:"0";}i:4;a:4:{s:6:"biaoti";s:0:"";s:8:"shuliang";s:2:"10";s:7:"fangshi";s:9:"post_date";s:6:"fenlei";s:1:"0";}i:5;a:4:{s:6:"biaoti";s:0:"";s:8:"shuliang";s:2:"10";s:7:"fangshi";s:9:"post_date";s:6:"fenlei";s:1:"0";}i:6;a:4:{s:6:"biaoti";s:0:"";s:8:"shuliang";s:2:"10";s:7:"fangshi";s:9:"post_date";s:6:"fenlei";s:1:"0";}}s:5:"tuwen";a:3:{i:1;a:4:{s:6:"biaoti";s:0:"";s:8:"shuliang";s:2:"10";s:7:"fangshi";s:9:"post_date";s:6:"fenlei";s:1:"0";}i:2;a:4:{s:6:"biaoti";s:0:"";s:8:"shuliang";s:2:"10";s:7:"fangshi";s:9:"post_date";s:6:"fenlei";s:1:"0";}i:3;a:4:{s:6:"biaoti";s:0:"";s:8:"shuliang";s:2:"10";s:7:"fangshi";s:9:"post_date";s:6:"fenlei";s:1:"0";}}}';
            $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (21, 'pageSettings', '" . $pageSettings . "', 1)");
            if(is_file(APP_PATH . 'install/data/data.php')) {
                $this->dbExec("INSERT INTO `" . Request::instance()->post('prefix') . "options` (option_id,option_name,option_value,autoload) VALUES (22, 'cbase', '" . file_get_contents(APP_PATH . 'install/data/data.php') . "', 0)");
            }
            $conf = file_get_contents(APP_PATH . 'install/data/database.php');
            $data['password'] = Request::instance()->post('password');
            $data['prefix'] = Request::instance()->post('prefix');
            foreach ($data as $key => $value) {
                $conf = str_replace("#{$key}#", $value, $conf);
            }
            file_put_contents(APP_PATH . 'database.php', $conf);
            touch(APP_PATH . 'install.lock');
            echo '<div class="hidden">';
            $this->success(Lang::get('Installation completed'), 'step4');
            echo '</div>';
        }
    }
    public function step4()
    {
        $this->assign('version',Config::get('version'));
        $this->domain();
        $view = $this->fetch();
        return $view;
    }
    private function domain()
    {
        $http = Request::instance()->isSsl() ? 'https://' : 'http://';
        $domain = $http . str_replace("\\",'/',$_SERVER['HTTP_HOST'].str_replace('/index.php','',Url::build('/')));
        $domain = substr($domain, -1, 1) == '/' ? $domain : $domain . '/';
        $this->assign('domain',$domain);
        return $domain;
    }
    private function check()
    {
        if(is_file(APP_PATH . 'install.lock')){
            $this->redirect(Url::build('/index'));
            exit;
        }
    }
    private function dbExec($exStr,$query = false)
    {
        try{
            $cnn = Db::connect([
                // 数据库类型
                'type' => 'mysql',
                // 数据库连接DSN配置
                'dsn' => '',
                // 服务器地址
                'hostname' => Request::instance()->post('host'),
                // 数据库名
                'database' => Request::instance()->post('name'),
                // 数据库用户名
                'username' => Request::instance()->post('user'),
                // 数据库密码
                'password' => Request::instance()->post('password'),
                // 数据库连接端口
                'hostport' => Request::instance()->post('port'),
                // 数据库连接参数
                'params' => [],
                // 数据库编码默认采用utf8
                'charset' => 'utf8',
                // 数据库表前缀
                'prefix' => Request::instance()->post('prefix')
            ]);
            if($query == false)
            {
                $cnn->execute($exStr);
            }
            else
            {
                return $cnn->query($exStr);
            }
        }catch(\Exception $e){
            return false;
        }
        return true;
    }
    private function filterLanguages($parameter)
    {
        $param = strtolower($parameter);
        if($param == 'zh' || strpos($param,'zh-hans') !== false || strpos($param,'zh-chs') !== false)
        {
            Lang::range('zh-cn');
            return 'zh-cn';
        }
        else if($param == 'zh-tw' || strpos($param,'zh-hant') !== false || strpos($param,'zh-cht') !== false){
            Lang::range('zh-tw');
            return 'zh-tw';
        }
        else if(stripos($param,'zh') === false)
        {
            $paramsub = substr($param,0,2);
            switch($paramsub)
            {
                case 'de':
                    Lang::range('de-de');
                    return 'de-de';
                    break;
                case 'fr':
                    Lang::range('fr-fr');
                    return 'fr-fr';
                    break;
                case 'ja':
                    Lang::range('ja-jp');
                    return 'ja-jp';
                    break;
                case 'ko':
                    Lang::range('ko-kr');
                    return 'ko-kr';
                    break;
                case 'ru':
                    Lang::range('ru-ru');
                    return 'ru-ru';
                    break;
                default:
                    return $param;
            }
        }
        else
        {
            return $param;
        }
    }
}