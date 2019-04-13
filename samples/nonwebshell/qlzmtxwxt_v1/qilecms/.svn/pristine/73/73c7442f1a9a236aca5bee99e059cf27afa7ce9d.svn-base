<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------

namespace thinksdk;

abstract class ThinkOauth
{
    /**
     * 第三方配置属性
     * @var type String
     */
    protected $config = '';
    /**
     * 获取到的第三方Access Token
     * @var type Array
     */
    protected $accessToken = null;
    /**
     * 请求授权页面展现形式
     * @var type String
     */
    protected $display = 'default';
    /**
     * 授权后获取到的TOKEN信息
     * @var array
     */
    protected $token = null;
    /**
     * oauth版本
     * @var string
     */
    protected $Version = '2.0';

    /**
     * 申请应用时分配的app_key
     * @var string
     */
    protected $AppKey = '';

    /**
     * 申请应用时分配的 app_secret
     * @var string
     */
    protected $AppSecret = '';
    protected $Display = '';

    /**
     * 授权类型 response_type 目前只能为code
     * @var string
     */
    protected $ResponseType = 'code';

    /**
     * grant_type 目前只能为 authorization_code
     * @var string
     */
    protected $GrantType = 'authorization_code';

    /**
     * 回调页面URL  可以通过配置文件配置
     * @var string
     */
    protected $Callback = '';

    /**
     * 获取request_code的额外参数 URL查询字符串格式
     * @var string
     */
    protected $Authorize = '';
    private $Type = '';
    protected $timestamp = '';

    private function __construct($token = null)
    {
         //设置SDK类型
        $class = get_class($this);
        $this->Type = strtoupper(substr($class, 0, strlen($class) - 3));
        //获取应用配置
        $config = config("think_sdk_{$this->Type}");
        if (empty($config['app_key']) || empty($config['app_secret']) || empty($config['display'])) {
            exception('你尚未配置应用或未开启');
        } else {
            $_config         = array('response_type' =>$this->ResponseType,'grant_type'=>$this->GrantType);
            $this->config    = array_merge($config, $_config);
            $this->timestamp = time();
           // $this->Token = $token; 
        }
    }

    /**
     * 设置授权页面样式，PC或者Mobile
     * @param type $display
     */
    public function setDisplay($display)
    {
        if (in_array($display, array('default', 'mobile'))) {
            $this->display = $display;
        }
    }


    /**
     * 取得Oauth实例
     * @static
     * @return mixed 返回Oauth
     */
    public static function getInstance($type, $token = null)
    {
        $name = ucfirst(strtolower($type)) . 'SDK';
        require_once "sdk/{$name}.php";
        if (class_exists($name)) {
            return new $name($token);
        } else {
            exception(lang('_CLASS_NOT_EXIST_') . ':' . $name);
        }
    }

     /**
     * 合并默认参数和额外参数
     * @param array $params  默认参数
     * @param array/string $param 额外参数
     * @return array:
     */
    protected function param($params, $param)
    {
        if (is_string($param)) {
            parse_str($param, $param);
        }
        return array_merge($params, $param);
    }
    /**
     * 默认的AccessToken请求参数
     * @return type
     */
    protected function _params()
    {
        $params = array(
            'client_id'     => $this->config['app_key'],
            'client_secret' => $this->config['app_secret'],
            'grant_type'    => $this->GrantType,
            'code'          => $_GET['code'],
            'redirect_uri'  => $this->config['callback'],
        );
        return $params;
    }
      /**
     * 获取指定API请求的URL
     * @param  string $api API名称
     * @param  string $fix api后缀
     * @return string      请求的完整URL
     */
    protected function url($api, $fix = '')
    {
        return $this->ApiBase . $api . $fix;
    }
    /**
     * 获取access_token
     */
    public function getAccessToken($ignore_stat = false)
    {
        if ($ignore_stat === false && isset($_COOKIE['A_S']) && $_GET['state'] != $_COOKIE['A_S']) {
            throw new Exception('传递的STATE参数不匹配！');
        } else {
            $this->initConfig();
            $params      = $this->_params();
            $data = $this->http($this->GetAccessTokenURL, $params, 'POST');
            $this->token = $this->parseToken($data);
            setcookie('A_S', $this->timestamp, $this->timestamp - 600, '/');
            return $this->token;
        }
    }

    /**
     * 初始化一些特殊配置
     */
    protected function initConfig()
    {
        /*用与后续扩展*/
        $callback = array(
             'default' => $this->config['callback'],
             'mobile'  => $this->config['callback'],
            );
        $this->config['callback'] = $callback[$this->display];
    }

    /**
     * 发送HTTP请求方法，目前只支持CURL发送请求
     * @param  string $url 请求URL
     * @param  array $params 请求参数
     * @param  string $method 请求方法GET/POST
     * @return array  $data   响应数据
     */
    protected function http($url, $params, $method = 'GET', $header = array(), $multi = false)
    {
        $opts = array(
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => $header
        );

        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET':
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':
                //判断是否传输文件
                $params = $multi ? $params : http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                exception('不支持的请求方式！');
        }

        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error)
            exception('请求发生错误：' . $error);
        return $data;
    }



     /**
     * 抽象方法
     * 得到请求code的地址
     */
    abstract public function getRequestCodeURL();
    /**
     * 抽象方法
     * 组装接口调用参数 并调用接口
     */
    abstract protected function call($api, $param = '', $method = 'GET');
    /**
     * 抽象方法
     * 解析access_token方法请求后的返回值
     */
    abstract protected function parseToken($result);
    /**
     * 抽象方法
     * 获取当前授权用户的SNS标识
     */
    abstract public function openid();
    abstract public function userinfo();

    

}