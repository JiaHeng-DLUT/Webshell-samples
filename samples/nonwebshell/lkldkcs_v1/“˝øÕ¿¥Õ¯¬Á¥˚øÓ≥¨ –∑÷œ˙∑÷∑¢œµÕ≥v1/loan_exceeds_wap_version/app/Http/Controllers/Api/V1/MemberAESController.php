<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Models\App;
use App\Models\Application;
use App\Models\Device;
use App\Models\Member;
use App\Traits\BrushWarning;
use App\Traits\Deduction;
use App\Traits\Encrypt;
use App\Traits\LoginBehavior;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class MemberAESController extends BaseController
{
    use Deduction;
    use LoginBehavior;
    use Encrypt;
    use BrushWarning;

    /**
     * 用户注册
     * @param Request $request
     * @return array
     */
    public function register(Request $request)
    {
        /*解密*/
        $phone = self::decrypt_pass($request->phone,$this->_aes,$this->_key);
        $password = self::decrypt_pass($request->password,$this->_aes,$this->_key);
        $formCheck = array(
            'phone'=>$phone,
            'password'=>$password,
            'verification'=>$request->verification,
            'verify_type'=>$request->verify_type,
            'channel'=>$request->channel,
        );
        $validate = Validator::make($formCheck,[
            'phone'=>'required|min:11|max:11|regex:/^1[3456789]\d{9}$/',
            'password'=>'required|min:6|max:16|regex:/^[a-zA-Z\d]+$/',
            'verification'=>'required|min:6|max:6',
            'verify_type'=>'required',
            'channel'=>'required',
        ]);
        if (!$validate->fails()){
            $verify_type = $request->input('verify_type');
            //判断验证码是否正确
            if ($this->checkPhoneCode($phone,$verify_type)) {//有效
                if (Redis::get('VerifyCode:' . $phone.$verify_type) != $request->verification) {//错误
                    $this->set('type', $this->badRequest);
                    $this->set('info', '验证码错误');
                } else {//验证成功,删除
                    Redis::del('VerifyCode:' . $phone.$verify_type);

                    /**注册*/
                    //查询用户是否存在
                    $member = Member::where('phone',$phone)->first();
                    if($member){//用户存在
                        $this->set('type',$this->errorUser);
                        $this->set('info','该手机号已注册，使用验证码登录');
                    }else {//用户不存在
                        //注册用户
                        $nick  = preg_replace('/(\d{3})\d{4}(\d{4})/', '$1****$2',$phone);
                        $exists_token = Member::where('remember_token',$request->authentication)->get();
                        if ($exists_token->count()){
                            //登录前先清空数据库token数据
                            Member::where('remember_token',$request->authentication)->update(['remember_token'=>'']);
                        }
                        //获取App相关信息
                        $application_id = 0;
                        $app_id = 0;
                        $application = Application::where('name',$request->package)->first();
                        if ($application){
                            $application_id = $application->id;
                            $app_id = $application->id;
                            /*$app = App::where('application_id',$application_id)->first();
                            if ($app){
                                $app_id = $app->id;
                            }*/
                        }
                        $member = Member::create([
                            'phone'=>$phone,
                            'password'=>password_hash($password, PASSWORD_DEFAULT),
                            'application_id'=>$application_id,
                            'app_id'=>$app_id,
                            'channel_code'=>$request->channel,
                            'platform_register'=>$request->platform,
                            'platform_login'=>$request->platform,
                            'identifier_register'=>$request->identifier,
                            'identifier_login'=>$request->identifier,
                            'identifier_push'=>'',
                            'product_id'=>$request->input('product_id')?:0,
                            'credit_id'=>$request->input('credit_id')?:0,
                            'page_id'=>$request->input('page_id')?:0,
                            'package'=>'',//
                            'system_version'=>$request->system,
                            //TODO::用户扣量
                            'reduce_type'=>'register',
                            'reduce_rate'=>100,
                            'last_apply_at'=>null,
                            //TODO
                            'nick'=>$request->input('nick',$nick),
                            'register_ip'=>$request->ip,
                            'last_login_ip'=>$request->ip,
                            'last_login_at'=>date('Y-m-d H:i:s'),
                            'remember_token'=>$request->authentication,
                        ]);
                        //注册成功后,自动登录
                        if ($member){
                            /*修改token对应的uid*/
                            $this->uidToken($request->identifier,$request->authentication,$member->id);
                            /*修改数据库信息*/
                            $member->login_count += 1;
                            if(in_array($request->platform,['ios','android'])){
                                $member->identifier_push = $request->identifier;
                                $member->package = $request->package?:'';
                            }
                            $member->save();
                            /*扣量*/
                            $deduction = $this->deduction($request,$member);
                            if (!$deduction){//扣量错误
                                $this->set('info','成功注册');
                            }else{
                                $this->set('info','注册成功');
                            }
                            /*APP登录：修改device表信息*/
                            if(in_array($request->platform,['ios','android'])) {
                                //推送更新:推送设备id：
                                $device = Device::where('identifier', $request->identifier)->first();
                                if ($device) {
                                    Device::where('identifier', $request->identifier)->update([
                                        'app_id' => $app_id,
                                        'push_id' => $request->push,
                                    ]);
                                }
                            }
                            /*记录注册日志*/
                            $this->loginBehavior($request,$member);

                            /*刷量预警准备*/
                            $warn = $this->warn($request,$member,$this->upper_warn);
                            if ($warn == 0){
                                Log::info('+----预警数据保存失败----+');
                            }
                            $data = [
                                'avatar'=>$member->avatar,
                                'nick'=>$member->nick,
                            ];
                            $this->set('data',$data);
                        }else{
                            $this->set('type',$this->noContent);
                            $this->set('info','注册失败');
                        }
                    }
                }
            }else{
                $this->set('type',$this->noContent);
                $this->set('info','验证码无效');
            }
        }else{
            if ($validate->errors()->has('phone')){
                $this->set('type',$this->badRequest);
                $this->set('info','请输入正确的手机号');
            }
            elseif($validate->errors()->has('password')){
                $this->set('type',$this->badRequest);
                $this->set('info','6-16位字符，特殊字符除外');
            }elseif($validate->errors()->has('verification')){
                $this->set('type',$this->badRequest);
                $this->set('info','验证码错误');
            }
            elseif($validate->errors()->has('verify_type')){
                $this->set('type',$this->badRequest);
                $this->set('info','请传入验证码类型');
            }
            else{
                $this->set('type',$this->badRequest);
                $this->set('info','请传入渠道码');
            }
        }
        return $this->jsonResponse();
    }


    /**
     * 快捷登录
     * @param Request $request
     * @return array
     */
    public function verifyLogin(Request $request)
    {
        /*解密*/
        $phone = self::decrypt_pass($request->phone,$this->_aes,$this->_key);
        $formCheck = array(
            'phone'=>$phone,
            'verification'=>$request->verification,
            'verify_type'=>$request->verify_type,
            'channel'=>$request->channel,
        );
        $validate = Validator::make($formCheck,[
            'phone'=>'required|min:11|max:11|regex:/^1[3456789]\d{9}$/',
            'verification'=>'required|min:6|max:6',
            'verify_type'=>'required',
            'channel'=>'required',
        ]);
        if (!$validate->fails()){
            $identifier = $request->identifier;//用户操作设备码
            $token = $request->authentication;
            $verify_type = $request->input('verify_type');
            //判断验证码是否正确
            if ($this->checkPhoneCode($phone,$verify_type) || ($request->phone == 'J9H3e36NZ0bXJT2XcQ5YpA==' && $request->verification == '111111')){//有效,ios审核账号
                if (Redis::get('VerifyCode:'.$phone.$verify_type) != $request->verification && $request->phone != 'J9H3e36NZ0bXJT2XcQ5YpA=='){//错误,ios审核账号
                    $this->set('type',$this->badRequest);
                    $this->set('info','验证码错误');
                }else {//验证成功,删除
                    Redis::del('VerifyCode:' . $phone.$verify_type);

                    /**继续进行快捷登录流程**/
                    //判断用户是否存在
                    $user = Member::where('phone',$phone)->first();
                    $exists_token = Member::where('remember_token',$request->authentication)->get();
                    if ($exists_token->count()){
                        Member::where('remember_token',$request->authentication)->update(['remember_token'=>'']);//登录前先清空数据库token数据
                    }
                    $nick  = preg_replace('/(\d{3})\d{4}(\d{4})/', '$1****$2',$phone);
                    if (!$user){//不存在,首次快捷登录
                        //获取App相关信息
                        $application_id = 0;
                        $app_id = 0;
                        $application = Application::where('name',$request->package)->first();
                        if ($application){
                            $application_id = $application->id;
                            $app_id = $application->id;
                            /*$app = App::where('application_id',$application_id)->first();
                            if ($app){
                                $app_id = $app->id;
                            }*/
                        }
                        $member = Member::create([
                            'phone'=>$phone,
                            'password'=>'',
                            'application_id'=>$application_id,
                            'app_id'=>$app_id,
                            'channel_code'=>$request->channel,
                            'platform_register'=>$request->platform,
                            'platform_login'=>$request->platform,
                            'identifier_register'=>$request->identifier,
                            'identifier_login'=>$request->identifier,
                            'identifier_push'=>'',
                            'product_id'=>$request->input('product_id')?:0,
                            'credit_id'=>$request->input('credit_id')?:0,
                            'page_id'=>$request->input('page_id')?:0,
                            'package'=>'',
                            'system_version'=>$request->system,
                            //TODO::用户扣量
                            'reduce_type'=>'register',
                            'reduce_rate'=>100,
                            'last_apply_at'=>null,
                            //TODO
                            'nick'=>$request->input('nick',$nick),
                            'register_ip'=>$request->ip,
                            'last_login_ip'=>$request->ip,
                            'last_login_at'=>date('Y-m-d H:i:s'),
                            'remember_token'=>$request->authentication,
                        ]);
                        if ($member){
                            /*更新token*/
                            $this->uidToken($identifier,$token,$member->id);
                            /*修改数据库信息*/
                            $member->login_count += 1;
                            if(in_array($request->platform,['ios','android'])){
                                $member->identifier_push = $request->identifier;
                                $member->package = $request->package?:'';
                            }
                            $member->save();
                            /*扣量*/
                            $deduction = $this->deduction($request,$member);
                            if (!$deduction){//扣量错误
                                $this->set('info','成功登录');
                            }else{
                                $this->set('info','登录成功');
                            }
                            /*修改device表信息*/
                            if(in_array($request->platform,['ios','android'])) {
                                $device = Device::where('identifier', $request->identifier)->first();
                                if ($device) {
                                    Device::where(['id' => $device->id])
                                        ->update(['app_id' => $app_id, 'push_id' => $request->push]);
                                }
                            }

                            /*记录登录日志*/
                            $this->loginBehavior($request,$member);

                            /*刷量预警准备*/
                            $warn = $this->warn($request,$member,$this->upper_warn);
                            if ($warn == 0){
                                Log::info('+----预警数据保存失败----+');
                            }

                            $this->set('data',['avatar'=>$member->avatar,'nick'=>$nick]);
                        }else{
                            $this->set('type',$this->noContent);
                            $this->set('info','登录失败');
                        }
                    }else{//非首次快捷登录,修改登录状态
                        //更新token
                        $this->uidToken($identifier,$request->authentication,$user->id);
                        $member = Member::where('phone',$phone)->update([
                            'platform_login'=>$request->platform,
                            'identifier_login'=>$identifier,
                            'last_login_ip'=>$request->ip,
                            'last_login_at'=>date('Y-m-d H:i:s'),
                            'remember_token'=>$request->authentication,
                        ]);
                        /*APP登录：修改device表信息*/
                        if(in_array($request->platform,['ios','android'])) {
                            $application_id = 0;
                            $app_id = 0;
                            $application = Application::where('name',$request->package)->first();
                            if ($application){
                                $application_id = $application->id;
                                $app_id = $application->id;
                                /*$app = App::where('application_id',$application_id)->first();
                                if ($app){
                                    $app_id = $app->id;
                                }*/
                            }
                            $user->application_id = $application_id;
                            $user->app_id = $app_id;
                            if($request->push) {
                                $user->identifier_push = $request->identifier;
                            }
                            $user->package =  $request->package;
                            $user->save();
                            //推送更新:推送设备id：
                            $device = Device::where('identifier', $request->identifier)->first();
                            if ($device) {
                                Device::where(['identifier'=> $request->identifier])
                                    ->update([
                                    'app_id' => $app_id,
                                    'push_id' => $request->push]);
                            }
                        }
                        if ($member){
                            /*修改数据库信息*/
                            $user->login_count += 1;
                            $user->save();
                            /*记录注册日志*/
                            $this->loginBehavior($request,$user);

                            /*刷量预警准备*/
                            $warn = $this->warn($request,$user,$this->upper_warn);
                            if ($warn == 0){
                                Log::info('+----预警数据保存失败----+');
                            }

                            $this->set('info','登录成功');
                            $this->set('data',['avatar'=>$user->avatar,'nick'=>$nick]);
                        }else{
                            $this->set('type',$this->noContent);
                            $this->set('info','登录失败');
                        }
                    }
                }
            }else{//验证码无效
                $this->set('type',$this->badRequest);
                $this->set('info','验证码错误');
            }
        }else{
            if ($validate->errors()->has('phone')){
                $this->set('type',$this->badRequest);
                $this->set('info','请输入正确的手机号');
            }
            elseif ($validate->errors()->has('verification')){
                $this->set('type',$this->badRequest);
                $this->set('info','验证码错误');
            }elseif ($validate->errors()->has('verify_type')){
                $this->set('type',$this->badRequest);
                $this->set('info','请传入验证码类型');
            }
            else{
                $this->set('type',$this->badRequest);
                $this->set('info','请传入渠道码');
            }
        }
        return $this->jsonResponse();
    }


    /**
     * 密码登录
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        /*解密*/
        $phone = self::decrypt_pass($request->phone,$this->_aes,$this->_key);
        $password = self::decrypt_pass($request->password,$this->_aes,$this->_key);
        $formCheck = array(
            'phone'=>$phone,
            'password'=>$password,
        );
        $validate = Validator::make($formCheck,[
            'phone'=>'required|min:11|max:11|regex:/^1[3456789]\d{9}$/',
            'password'=>'required|min:6|max:16|regex:/^[a-zA-Z\d]+$/',
        ]);
        if (!$validate->fails()){
            $identifier = $request->identifier;//用户操作设备码
            //判断用户是否存在
            $user = Member::where('phone',$phone)->first();
            if(!$user){
                $this->set('type',$this->errorUser);
                $this->set('info','该手机号未注册，请先注册');
            }
            elseif (empty($user->password)){
                $this->set('type',$this->errorUser);
                $this->set('info','您尚未设置密码,请找回密码');
            }
            else {//正常情况
                //验证密码
                if (!(Auth::attempt(['phone'=>$phone,'password'=>$password]))) {
                    $this->set('type', $this->errorUser);
                    $this->set('info', '密码错误');
                } else {
                    $exists_token = Member::where('remember_token', $request->authentication)->get();
                    if ($exists_token->count()) {
                        Member::where('remember_token', $request->authentication)->update(['remember_token' => '']);//登录前先清空数据库token数据
                    }
                    /*更新token*/
                    $this->uidToken($request->identifier, $request->authentication, $user->id);
                    //登录成功,修改用户token及相关参数
                    $member = Member::where('phone', $phone)
                        ->update([
                            /*'application_id'=>$application_id,
                            'app_id'=>$app_id,*/
                            'platform_login' => $request->platform,
                            'identifier_login' => $identifier,
                            'last_login_ip' => $request->ip,
                            'last_login_at' => date('Y-m-d H:i:s'),
                            'remember_token' => $request->authentication
                        ]);
                    /*修改device表信息*/
                    /*APP登录：修改device表信息*/
                    if (in_array($request->platform, ['ios', 'android'])) {
                        $application_id = 0;
                        $app_id = 0;
                        $application = Application::where('name', $request->package)->first();
                        if ($application) {
                            $application_id = $application->id;
                            $app_id = $application->id;
                            /*$app = App::where('application_id',$application_id)->first();
                            if ($app){
                                $app_id = $app->id;
                            }*/
                        }
                        $user->application_id = $application_id;
                        $user->app_id = $app_id;
                        $user->package = $request->package;
                        if ($request->push) {
                            $user->identifier_push = $request->identifier;
                        }
                        $user->save();
                        //推送更新:推送设备id：
                        $device = Device::where('identifier', $request->identifier)->first();
                        if ($device) {
                            Device::where('identifier', $request->identifier)->update([
                                'app_id' => $app_id,
                                'push_id' => $request->push,
                            ]);
                        }
                    }

                    if ($member) {
                        /*修改数据库信息*/
                        $user->login_count += 1;
                        $user->save();
                        /*记录注册日志*/
                        $this->loginBehavior($request, $user);

                        /*刷量预警准备*/
                        $warn = $this->warn($request,$user,$this->upper_warn);
                        if ($warn == 0){
                            Log::info('+----预警数据保存失败----+');
                        }

                        $data = [
                            'avatar' => $user->avatar,
                            'nick' => $user->nick,
                        ];
                        $this->set('info', '登录成功');
                        $this->set('data', $data);
                    } else {
                        $this->set('type', $this->noContent);
                        $this->set('info', '登录失败');
                    }
                }
            }
            return $this->jsonResponse();
        }else{
            if ($validate->errors()->has('phone')){
                $this->set('type',$this->badRequest);
                $this->set('info','请输入正确的手机号');
            }
            else{
                $this->set('type',$this->badRequest);
                $this->set('info','6-16位字符，特殊字符除外');
            }
            return $this->jsonResponse();
        }
    }

    /**
     * 修改密码
     * @param Request $request
     * @return array
     */
    public function retrievePwd(Request $request)
    {
        /*解密*/
        $phone = self::decrypt_pass($request->phone,$this->_aes,$this->_key);
        $password = self::decrypt_pass($request->password,$this->_aes,$this->_key);
        $formCheck = array(
            'phone'=>$phone,
            'password'=>$password,
            'verification'=>$request->verification,
            'verify_type'=>$request->verify_type,
            'channel'=>$request->channel,
        );
        $validate = Validator::make($formCheck,[
            'phone'=>'required|min:11|max:11|regex:/^1[3456789]\d{9}$/',
            'password'=>'required|min:6|max:16|regex:/^[a-zA-Z\d]+$/',
            'verification'=>'required|min:6|max:6',
            'verify_type'=>'required',
            'channel'=>'required',
        ]);

        if (!$validate->fails()){
            $verify_type = $request->input('verify_type');
            //判断验证码是否正确
            if ($this->checkPhoneCode($phone,$verify_type)) {//有效
                if (Redis::get('VerifyCode:' . $phone.$verify_type) != $request->verification) {//错误
                    $this->set('type', $this->badRequest);
                    $this->set('info', '验证码错误');
                } else {//验证成功,删除
                    Redis::del('VerifyCode:' . $phone.$verify_type);

                    /**找回密码*/
                    //判断用户是否存在
                    $user = Member::where('phone',$phone)->first();
                    if ($user){
                        //修改用户密码
                        $hashPwd = password_hash($password,PASSWORD_DEFAULT);
                        $member = Member::where('phone',$phone)->update(['password'=>$hashPwd]);
                        if ($member){
                            $this->set('info','找回密码成功,请登录');
                        }else{
                            $this->set('type',$this->noContent);
                            $this->set('info','找回密码失败');
                        }
                    }else{
                        $this->set('type',$this->errorUser);
                        $this->set('info','用户不存在,请先注册');
                    }
                }
            }else{
                $this->set('type',$this->noContent);
                $this->set('info','验证码无效');
            }
        }else{
            if ($validate->errors()->has('phone')){
                $this->set('type',$this->badRequest);
                $this->set('info','请输入正确的手机号');
            }
            elseif ($validate->errors()->has('password')){
                $this->set('type',$this->badRequest);
                $this->set('info','密码不能含特殊字符');
            }
            elseif($validate->errors()->has('verification')){
                $this->set('type',$this->badRequest);
                $this->set('info','验证码错误');
            }
            elseif($validate->errors()->has('verify_type')){
                $this->set('type',$this->badRequest);
                $this->set('info','请传入验证码类型');
            }
            else{
                $this->set('type',$this->badRequest);
                $this->set('info','请传入渠道码');
            }
        }
        return $this->jsonResponse();
    }

    /**
     * 退出登录
     * @param Request $request
     * @return array
     */
    public function logout(Request $request)
    {
        $member = Member::where('id',$request->uid)->update(['remember_token'=>'']);
        if ($member){
            $this->uidToken($request->identifier,$request->authentication,0);
            $this->set('info','您已安全退出');
        }else{
            $this->set('type',$this->noContent);
            $this->set('info','无法退出');
        }
            return $this->jsonResponse();
    }


}
