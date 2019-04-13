<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-3-4
 * Time: 14:35
 */

namespace App\Traits;


use App\Models\Channel;
use App\Models\Department;
use App\Models\Member;
use App\Models\RemindPhone;
use App\Models\SmsRecord;
use App\Models\Warn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

trait BrushWarning
{
    use SendMsg;

    /**
     * 预警用户数据-流水
     * @param $request
     * @param $member
     * @param $upper_warn
     * @return int
     */
    public function warn($request,$member,$upper_warn)
    {
        $phone = $member->phone;
        $identifier_login = $request->identifier;
        $start = date('Y-m-d 00:00:00');
        $end = date('Y-m-d 23:59:59');
        //判断当天的某个用户是否存在
        $exist = Warn::where('phone',$phone)->whereBetween('created_at',[$start,$end])->first();
        if (!$exist){//不存在,用户记录流水信息
            Log::info('---+记录不存在');
            $channel = Channel::where('channel_code',$member->channel_code)->first();
            if (!$channel){
                return 0;
            }else{
                $manager = $channel->manager;
                $department_id = $channel->department_id;
                $department = Department::where('id',$department_id)->first();
                if (!$department){
                    return 0;
                }else{
                    $department_name = $department->name;
                }
            }
            $res = Warn::create([
                'uid'=>$member->id,
                'phone'=>$phone,
                'deviceid_register'=>$member->identifier_register,
                'deviceid_login'=>$identifier_login,//最后登录设备
                'ip'=>$member->register_ip,
                'channel_code'=>$member->channel_code,
                'platform'=>$request->platform,//最后登录平台
                'status'=>0,
                'department_name'=>$department_name,
                'manager'=>$manager,
            ]);
            if (!$res){
                return 0;
            }
        }else{//存在,修改登录设备/登录时间/状态
            Log::info('---+记录存在');
            $exist->deviceid_login = $identifier_login;//最后登录设备
            $exist->platform = $request->platform;//最后登录平台
            $exist->updated_at = time();
            $res = $exist->save();
            if (!$res){
                return 0;
            }
        }
        //判断当天同一设备是否登录三个用户
        $same_num = Warn::where('deviceid_login',$identifier_login)->whereBetween('created_at',[$start,$end])->count();
        Log::info('$same_num = '.$same_num);
        if ($same_num == $upper_warn){//同台设备登录用户达到上限
            //修改之前存在的记录状态值
            $warns = Warn::where('deviceid_login',$identifier_login)
                ->whereBetween('created_at',[$start,$end])
                ->update(['status'=>1]);
            Log::info('达到3时修改 = '.$warns);
            /**发送预警短信**/
            $res = $this->warnSms($identifier_login);
            if (!$res){//失败
                Log::info('warn--发送失败--');
            }
        }
        return 1;
    }

    /**
     * 循环发送短信
     * @param $identifier_login
     * @return int
     */
    public function warnSms($identifier_login)
    {
        $phones = RemindPhone::first();
        if ($phones){
            $phone = explode(';',$phones->phones);
            Log::info('warn--号码-'.json_encode($phone));
            foreach($phone as $item){
                $this->sendWarnMsg($item,$identifier_login);
            }
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 发送预警短信
     * @param $phone
     * @param $identifier_login
     * @return int
     */
    public function sendWarnMsg($phone,$identifier_login)
    {
        /**存该电话相关预警提示**/
        $code = '';
        $verifyType = 'warn';
        /*预警提示存表*/
        $content = '刷量预警';
        //获取渠道及平台
        $user = Member::where('phone',$phone)->first();
        if ($user){
            $channel_code = $user->channel_code;
            $platform = $user->platform_register;
        }else{
            $channel_code = 100001;
            $platform = 'android';
        }
        $sms_record = SmsRecord::create([
            'phone'=>$phone,
            'captcha'=>$identifier_login,
            'content'=>$content,
            'channel_code'=>$channel_code,
            'platform'=>$platform,
        ]);
        if (!$sms_record){
            Log::info('warn----短信记录保存失败');
        }
        //短信上限检查
        $res = $this->checkCodeHistory($phone);
        if (!$res){
            Log::info('warn--接收上限--');
            return 2;
        }else{
            /**发送短信**/
            $res = $this->sendMsg(7,$verifyType,$phone,$code);
            if ($res->code == '0'){
                Log::info('warn--成功--'.$res->msg);
                return 1;
            }else{
                Log::info('warn--失败--'.json_encode($res));
                return 0;
            }
        }
    }
}