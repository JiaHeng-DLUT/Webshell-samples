<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
use thinksdk\ThinkOauth;

class WechatSDK extends ThinkOauth
{
	/**
	 * 获取requestCode的api接口
	 * @var string
	 */
	protected $GetRequestCodeURL = 'https://open.weixin.qq.com/connect/oauth2/authorize';
	
	/**
	 * 获取access_token的api接口
	 * @var string
	 */
	protected $GetAccessTokenURL = 'https://api.weixin.qq.com/sns/oauth2/access_token';
	

	/**
	 * API根路径
	 * @var string
	 */
	protected $ApiBase  = 'https://api.weixin.qq.com/sns/';
	/**
	 * 获取scope的额外参数,可在配置中修改 URL查询字符串格式
	 * @var string
	 */
	protected $scope    = 'snsapi_login';

	/**
     * 请求Authorize访问地址
     */
    public function getRequestCodeURL()
    {
        setcookie('A_S', $this->timestamp, $this->timestamp + 600, '/');
        $this->initConfig();
        //Oauth 标准参数
        $params = array(
            'appid'         => $this->config['app_key'],
            'redirect_uri'  => $this->config['callback'],
            'response_type' => $this->config['response_type'],
            'scope'         => $this->scope,
            'state'         => $this->timestamp,
        );

        return $this->GetRequestCodeURL . '?' . http_build_query($params);
    }

	/**
	 * 组装接口调用参数 并调用接口
	 * @param  string $api    微博API
	 * @param  string $param  调用API的额外参数
	 * @param  string $method HTTP请求方法 默认为GET
	 * @return json
	 */
	public function call($api, $param = '', $method = 'GET', $multi = false)
    {
		/* 腾讯QQ调用公共参数 */
		$params = array(
            'access_token' => $this->token['access_token'],
            'openid'       => $this->openid(),
            'lang'         => 'zh_CN'
        );
		$data = $this->http($this->url($api), $this->param($params, $param), $method);
		return json_decode($data, true);
	}

	
	 /**
     * 解析access_token方法请求后的返回值
     * @param string $result 获取access_token的方法的返回值
     */
    protected function parseToken($result)
    {
        parse_str($result, $data);
        if ($data['access_token'] && $data['expires_in'] && $data['openid']) {
            $this->token    = $data;
            $data['openid'] = $this->openid();
            return $data;
        } else {
            throw new Exception("获取微信 ACCESS_TOKEN 出错：{$result}");
        }
    }
    /**
     * 获取当前授权应用的openid
     * @return string
     */
    public function openid()
    {
         $data = $this->token;
        if (isset($data['openid']))
            return $data['openid'];
        else
            throw new Exception('没有获取到微信用户ID！');
    }
    /**
     * 获取授权用户的用户信息
     */
    public function userinfo()
    {
        $rsp = $this->call('userinfo');
        if (!$rsp || (isset($rsp['errcode']) && $rsp['errcode'] != 0)) {
            throw new Exception('接口访问失败！' . $rsp['msg']);
        } else {
            $userinfo = array(
                'openid'  => $this->openid(),
                'name' => $rsp['nickname'],
                'unionid' => isset($this->token['unionid']) ? $this->token['unionid'] : '',
                'head'    => $rsp['figureurl']
            );
            return $userinfo;
        }
    }


}