<?php
/**
 * Project: Catfish CMS.
 * Author: A.J <804644245@qq.com>
 * Copyright: http://www.catfish-cms.com All rights reserved.
 * Date: 2016/10/1
 */
namespace app\login\controller;

use app\model\Users;
use app\model\Options;
use app\common\Operc;
use think\Controller;
use think\Request;
use think\Validate;
use think\Session;
use think\Cookie;
use think\Cache;
use think\Db;
use think\Url;
use think\Lang;
use think\Config;
use think\Hook;

class Index extends Controller
{
    protected $session_prefix;
    private $lang;
    private $ccc;
    protected $params = [];
    protected $plugins = [];
    public function _initialize()
    {
        $this->session_prefix = 'catfish'.str_replace(['/','.',' ','-'],['','?','*','|'],Url::build('/'));
        $this->lang = Lang::detect();
        $this->lang = $this->filterLanguages($this->lang);
        Lang::load(APP_PATH . 'login/lang/'.$this->lang.'.php');
        $this->ccc = 'Catfish CMS Copyright';
    }
    public function index()
    {
        $captcha = Db::name('options')->where('option_name','captcha')->field('option_value')->find();
        if(Request::instance()->has('user','post'))
        {
            if(Request::instance()->has('captcha','post'))
            {
                $rule = [
                    'user' => 'require',
                    'pwd' => 'require',
                    'captcha|'.Lang::get('Captcha')=>'require|captcha'
                ];
            }
            else
            {
                $rule = [
                    'user' => 'require',
                    'pwd' => 'require'
                ];
            }
            $msg = [
                'user.require' => Lang::get('The user name must be filled in'),
                'pwd.require' => Lang::get('Password must be filled in')
            ];
            if($captcha['option_value'] == 1)
            {
                $data = [
                    'user' => Request::instance()->post('user'),
                    'pwd' => Request::instance()->post('pwd'),
                    'captcha' => Request::instance()->post('captcha')
                ];
            }
            else
            {
                $data = [
                    'user' => Request::instance()->post('user'),
                    'pwd' => Request::instance()->post('pwd')
                ];
            }
            $validate = new Validate($rule, $msg);
            if(!$validate->check($data))
            {
                $this->error($validate->getError());
                return false;
            }
            $loginError = Cache::get('loginError_'.$data['user']);
            if($loginError)
            {
                Cache::set('loginError_'.$data['user'],'loginError',5);
                $this->error(Lang::get('Password error'));
                return false;
            }
            $users = new Users();
            $user = $users->where('user_login', htmlspecialchars(Request::instance()->post('user')))
                ->find();
            if(empty($user))
            {
                $this->error(Lang::get('Username error'));
                return false;
            }
            if($user['user_pass'] != md5(Request::instance()->post('pwd')))
            {
                Cache::set('loginError_'.$data['user'],'loginError',5);
                $this->error(Lang::get('Password error'));
                return false;
            }
            if($user['user_status'] == 0)
            {
                $this->error(Lang::get('Account has been disabled, please contact the administrator'));
                return false;
            }
            $user->save([
                'last_login_ip' => get_client_ip(0,true),
                'last_login_time' => date("Y-m-d H:i:s")
            ],['id' => $user['id']]);
            Session::set($this->session_prefix.'user_id',$user['id']);
            Session::set($this->session_prefix.'user',$user['user_login']);
            Session::set($this->session_prefix.'user_type',$user['user_type']);
            if(Request::instance()->post('remember'))
            {
                Cookie::set($this->session_prefix.'user_id',$user['id'],604800);
                Cookie::set($this->session_prefix.'user',$user['user_login'],604800);
                $cookie_user_p = Cache::get('cookie_user_p');
                if($cookie_user_p == false)
                {
                    $cookie_user_p = md5(time());
                    Cache::set('cookie_user_p',$cookie_user_p,604800);
                }
                Cookie::set($this->session_prefix.'user_p',md5($cookie_user_p.$user['user_pass']),604800);
            }
        }
        if(!Session::has($this->session_prefix.'user_id'))
        {
            $this->assign('yanzheng', $captcha['option_value']);
            $this->getPlugins();
            Hook::add('login_background',$this->plugins);
            Hook::listen('login_background',$this->params);
            if(isset($this->params['login_background']))
            {
                $this->assign('login_background', $this->params['login_background']);
            }
            Hook::add('login_annex',$this->plugins);
            Hook::listen('login_annex',$this->params);
            if(isset($this->params['login_annex']))
            {
                $this->assign('login_annex', $this->params['login_annex']);
            }
            $param = '';
            Hook::add('login_annex_post',$this->plugins);
            Hook::listen('login_annex_post',$param);
            $this->options();
            $this->domain();
            $view = $this->fetch();
            return $view;
        }
        elseif(Session::get($this->session_prefix.'user_type') < 7)
        {
            $this->redirect(Url::build('/admin'));
        }
        else
        {
            $this->redirect(Url::build('/user'));
        }
    }
    public function denglu()
    {
        if(Request::instance()->post('user') == '')
        {
            return Lang::get('The user name must be filled in');
        }
        if(Request::instance()->post('pwd') == '')
        {
            return Lang::get('Password must be filled in');
        }
        $userName = Request::instance()->post('user');
        $loginError = Cache::get('loginError_'.$userName);
        if($loginError)
        {
            Cache::set('loginError_'.$userName,'loginError',3);
            return Lang::get('Password error');
        }
        $users = new Users();
        $user = $users->where('user_login', htmlspecialchars($userName))
            ->find();
        if(empty($user))
        {
            return Lang::get('Username error');
        }
        if($user['user_pass'] != md5(Request::instance()->post('pwd')))
        {
            Cache::set('loginError_'.$userName,'loginError',3);
            return Lang::get('Password error');
        }
        if($user['user_status'] == 0)
        {
            return Lang::get('Account has been disabled, please contact the administrator');
        }
        $user->save([
            'last_login_ip' => get_client_ip(0,true),
            'last_login_time' => date("Y-m-d H:i:s")
        ],['id' => $user['id']]);
        Session::set($this->session_prefix.'user_id',$user['id']);
        Session::set($this->session_prefix.'user',$user['user_login']);
        Session::set($this->session_prefix.'user_type',$user['user_type']);
        return 'ok';
    }
    public function register()
    {
        $options_spare = $this->optionsSpare();
        if(isset($options_spare['notAllowLogin']) && $options_spare['notAllowLogin'] == 1)
        {
            $this->redirect(Url::build('/index'));
            exit();
        }
        if(Request::instance()->has('user','post'))
        {
            $rule = [
                'user' => 'require',
                'pwd' => 'require',
                'repeat' => 'require',
                'email' => 'require|email'
            ];
            $msg = [
                'user.require' => Lang::get('The user name must be filled in'),
                'pwd.require' => Lang::get('Password must be filled in'),
                'repeat.require' => Lang::get('Confirm password is required'),
                'email.require' => Lang::get('E-mail address is required'),
                'email.email' => Lang::get('The e-mail format is incorrect')
            ];
            $data = [
                'user' => Request::instance()->post('user'),
                'pwd' => Request::instance()->post('pwd'),
                'repeat' => Request::instance()->post('repeat'),
                'email' => Request::instance()->post('email')
            ];
            $validate = new Validate($rule, $msg);
            if(!$validate->check($data))
            {
                $this->error($validate->getError());
                return false;
            }
            if(Request::instance()->post('pwd') != Request::instance()->post('repeat'))
            {
                $this->error(Lang::get('Confirm the password must be the same as the password'));
                return false;
            }
            $guolv = Options::get(['option_name' => 'filter']);
            $jinyg = $guolv->option_value;
            if(!empty($jinyg))
            {
                $jinyg = str_replace('，',',',$jinyg);
                $jinygArr = explode(',', $jinyg);
                foreach($jinygArr as $key => $val)
                {
                    if(strpos(Request::instance()->post('user'),$val) !== false)
                    {
                        $this->error(Lang::get('Please use a different username'));
                        return false;
                    }
                }
            }
            $users = new Users;
            $user = $users->where('user_login', Request::instance()->post('user'))
                ->find();
            if(!empty($user))
            {
                $this->error(Lang::get('User name has been registered'));
                return false;
            }
            $users->data([
                'user_login' => htmlspecialchars(Request::instance()->post('user')),
                'user_pass' => md5(Request::instance()->post('pwd')),
                'user_nicename' => htmlspecialchars(Request::instance()->post('user')),
                'user_email' => Request::instance()->post('email'),
                'last_login_ip' => get_client_ip(0,true),
                'create_time' => date("Y-m-d H:i:s"),
                'user_type' => 7
            ]);
            $users->save();
            $this->success(Lang::get('User registration is successful'), Url::build('/login'));
        }
        $this->options();
        $this->getPlugins();
        Hook::add('registration_background',$this->plugins);
        Hook::listen('registration_background',$this->params);
        if(isset($this->params['registration_background']))
        {
            $this->assign('registration_background', $this->params['registration_background']);
        }
        $this->domain();
        $view = $this->fetch();
        return $view;
    }
    public function zhuce()
    {
        $options_spare = $this->optionsSpare();
        if(isset($options_spare['notAllowLogin']) && $options_spare['notAllowLogin'] == 1)
        {
            return Lang::get('Registration is not allowed');
        }
        $user = trim(Request::instance()->post('user'));
        $pwd = Request::instance()->post('pwd');
        $repeat = Request::instance()->post('repeat');
        $email = trim(Request::instance()->post('email'));
        if($user == '')
        {
            return Lang::get('The user name must be filled in');
        }
        if($pwd == '')
        {
            return Lang::get('Password must be filled in');
        }
        if($repeat == '')
        {
            return Lang::get('Confirm password is required');
        }
        if($email == '')
        {
            return Lang::get('Password must be filled in');
        }
        $rule = [
            'email' => 'email'
        ];
        $msg = [
            'email.email' => Lang::get('The e-mail format is incorrect')
        ];
        $data = [
            'email' => $email
        ];
        $validate = new Validate($rule, $msg);
        if(!$validate->check($data))
        {
            return $validate->getError();
        }
        if($pwd != $repeat)
        {
            return Lang::get('Confirm the password must be the same as the password');
        }
        $guolv = Options::get(['option_name' => 'filter']);
        $jinyg = $guolv->option_value;
        if(!empty($jinyg))
        {
            $jinyg = str_replace('，',',',$jinyg);
            $jinygArr = explode(',', $jinyg);
            foreach($jinygArr as $key => $val)
            {
                if(strpos($user,$val) !== false)
                {
                    return Lang::get('Please use a different username');
                }
            }
        }
        $users = new Users;
        $hasuser = $users->where('user_login', $user)
            ->find();
        if(!empty($hasuser))
        {
            return Lang::get('User name has been registered');
        }
        $users->data([
            'user_login' => htmlspecialchars($user),
            'user_pass' => md5($pwd),
            'user_nicename' => htmlspecialchars($user),
            'user_email' => $email,
            'last_login_ip' => get_client_ip(0,true),
            'create_time' => date("Y-m-d H:i:s"),
            'user_type' => 7
        ]);
        $users->save();
        echo 'ok';
        exit();
    }
    private function domain()
    {
        $domain = Cache::get('domain');
        if($domain == false)
        {
            $domain = Options::get(['option_name' => 'domain'])->option_value;
            Cache::set('domain',$domain,3600);
        }
        $this->assign('domain', $domain);
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
    protected function optionsSpare()
    {
        $options_spare = Cache::get('options_spare');
        if($options_spare == false)
        {
            $options_spare = Db::name('options')->where('option_name','spare')->field('option_value')->find();
            $options_spare = $options_spare['option_value'];
            if(!empty($options_spare))
            {
                $options_spare = unserialize($options_spare);
            }
            Cache::set('options_spare',$options_spare,3600);
        }
        return $options_spare;
    }
    private function options()
    {
        $data_options = Cache::get('options');
        if($data_options == false)
        {
            $data_options = Db::name('options')->where('autoload',1)->field('option_name,option_value')->select();
            Cache::set('options',$data_options,3600);
        }
        $ns = '';
        if(Operc::aut())
        {
            $ns = Operc::bdc('IHN0eWxlPSJkaXNwbGF5OiBub25lOyI=');
        }
        $version = Config::get('version');
        $this->assign('catfish', '<a href="http://www.'.$version['official'].'/" target="_blank" id="catfish"'.$ns.'>'.$version['name'].'&nbsp;'.$version['number'].'</a>&nbsp;&nbsp;');
        foreach($data_options as $key => $val)
        {
            if($val['option_name'] == 'copyright' || $val['option_name'] == 'statistics')
            {
                $this->assign($val['option_name'], unserialize($val['option_value']));
            }
            else if($val['option_name'] == 'pageSettings')
            {
                ;
            }
            else
            {
                $this->assign($val['option_name'], $val['option_value']);
            }
        }
    }
    private function getPlugins()
    {
        $plugins = Cache::get('plugins');
        if($plugins == false)
        {
            $plugins = Db::name('options')->where('option_name','plugins')->field('option_value')->find();
            if(!empty($plugins))
            {
                $plugins = unserialize($plugins['option_value']);
            }
            else
            {
                $plugins = [];
            }
            Cache::set('plugins',$plugins,3600);
        }
        if(!empty($plugins))
        {
            foreach($plugins as $key => $val)
            {
                $pluginFile = APP_PATH.'plugins/'.$val.'/'.ucfirst($val).'.php';
                if(is_file($pluginFile))
                {
                    $plugins[$key] = 'app\\plugins\\'.$val.'\\'.ucfirst($val);
                    Lang::load(APP_PATH . 'plugins/'.$val.'/lang/'.$this->lang.'.php');
                }
                else
                {
                    unset($plugins[$key]);
                }
            }
            $this->plugins = $plugins;
        }
    }
}