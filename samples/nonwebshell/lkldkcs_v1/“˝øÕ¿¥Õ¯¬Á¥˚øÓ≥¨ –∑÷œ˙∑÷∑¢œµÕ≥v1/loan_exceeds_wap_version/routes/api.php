<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['prefix'=>'v1','middleware'=>['app.header','merge','member.log'],'namespace'=>'App\Http\Controllers\Api\V1'],function($api){
        $api->get('help','PersonalController@help');//新手帮助
        $api->get('about','PersonalController@about');//关于我们
        $api->get('agreement','PersonalController@agreement');//注册协议
    });

    $api->group(['middleware'=>['app.header','merge','check.token','member.log'],'namespace'=>'App\Http\Controllers'],function($api){
        $api->post('get/code','BaseController@getCode');//获取验证码
        $api->post('check/code','BaseController@checkCode');//验证验证码

        /*****************获取验证码+AES***********************/
        $api->post('get/code/aes','BaseController@getCodeAES');//获取验证码
        $api->post('check/code/aes','BaseController@checkCodeAES');//验证验证码
    });

    $api->group(['prefix'=>'v1','middleware'=>['app.header','merge'],'namespace'=>'App\Http\Controllers'], function ($api) {
        /*token**/
        $api->get('token','BaseController@generateToken');//生成token
        $api->get('detail/{id}','Api\V1\DistributeController@article');//文章详情独立接口

        $api->group(['middleware'=>['check.token','member.log'],'namespace'=>'Api\V1'],function($api){
            /*白名单**/
            $api->post('set/white','WhiteListController@setWhite');//添加 电话/渠道 白名单

            /*登录注册**/
            $api->post('register','MemberController@register');//注册
            $api->post('login','MemberController@login');//密码登录
            $api->post('verify/login','MemberController@verifyLogin');//验证码登录
            $api->post('retrieve/pwd','MemberController@retrievePwd');//找回密码

            /*************登录注册+AES*********************/
            $api->post('register/aes','MemberAESController@register');//注册
            $api->post('login/aes','MemberAESController@login');//密码登录
            $api->post('verify/login/aes','MemberAESController@verifyLogin');//验证码登录
            $api->post('retrieve/pwd/aes','MemberAESController@retrievePwd');//找回密码

            /*我的**/
            $api->get('update/version','PersonalController@updateVersion');//检查更新
            $api->get('circle','PersonalController@circle');//贷贷狐圈子

            /*资讯**/
            $api->get('article','ArticleController@index');// 资讯列表
            $api->get('article/{id}','ArticleController@show');//资讯详情

            /*贷款**/
            $api->post('loan','LoanController@index');//贷款列表
            $api->get('loan/screen','LoanController@screen');//贷款高级筛选
            $api->get('loan/{id}','LoanController@show')->middleware(['behavior.log']);//贷款详情



            /*城市数据*/
            $api->get('district','DistrictController@index');//城市数据
            $api->get('hot/city','DistrictController@hotCity');//热门城市

            /*首页*/
            $api->get('home','HomeController@index')->middleware(['behavior.log']);//首页列表

            $api->get('home/base','HomeController@base');//启动基础数据
            $api->get('home/{id}','HomeController@show')->middleware(['behavior.log']);//专题产品列表
            $api->get('count','CountController@count');//启动基础数据

            $api->get('feedback/cate','PersonalController@feedbackCate');//反馈类型



        });
        $api->group(['middleware'=>['check.token','member.log','check.login'],'namespace'=>'Api\V1'],function($api){
//            $api->group(['middleware'=>'check.login'],function($api){




            $api->get('logout','MemberController@logout');//退出登录

            $api->get('profile','PersonalController@profile');//个人资料
            $api->post('feedback','PersonalController@feedback');//用户反馈

            $api->get('product/apply','IntentionController@productApplied');//贷款申请意向

            $api->get('collection/product','IntentionController@productCollection');//贷款收藏列表

            $api->get('collection/article','IntentionController@articleCollection');//资讯收藏列表

            $api->post('apply','ActionController@apply')->middleware(['behavior.log']);//申请 产品
            $api->get('praise/{id}','ActionController@praise');//资讯点赞
            $api->get('collect','ActionController@collect');//贷款/资讯 收藏操作
            $api->post('share','ActionController@share');//贷款/资讯 分享操作
        });

    });
});
