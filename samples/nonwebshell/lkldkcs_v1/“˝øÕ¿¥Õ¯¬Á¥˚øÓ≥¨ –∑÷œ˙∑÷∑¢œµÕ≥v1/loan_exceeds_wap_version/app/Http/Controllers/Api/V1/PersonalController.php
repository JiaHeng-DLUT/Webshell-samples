<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Models\App;
use App\Models\Circle;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\Help;
use App\Models\Member;
use App\Models\Page;
use App\Models\Website;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PersonalController extends BaseController
{
    /**
     * 检查版本更新
     * @param Request $request
     * @return array
     */
    public function updateVersion(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'channel'=>'required',
            'platform'=>'required',
            'version'=>'required',
        ]);
        if (!$validate->fails()){
            //根据 渠道及平台 找到当前最新安装包
            $application = App::where('channel_code',$request->channel)
                ->where('platform',$request->platform)
                ->orderBy('created_at','desc')
                ->first();
            if ($application){
                if (str_replace('.','',$application->version) > str_replace('.','',$request->version)){
                    $application->current_version = $request->version;
                    $this->set('data',$application);
                }else{
                    $this->set('type',$this->noContent);
                    $this->set('info','已经是最新版本');
                }
            }else{
                $this->set('type',$this->noContent);
//                $this->set('info','该渠道无相关App信息');
                $this->set('info','暂无最新版本信息');
            }
        }else{
            if ($validate->errors()->has('channel')){
                $this->set('type',$this->badRequest);
                $this->set('info','请填写渠道码');
            }
            elseif ($validate->errors()->has('platform')){
                $this->set('type',$this->badRequest);
                $this->set('info','请填写来源平台');
            }
            else{
                $this->set('type',$this->badRequest);
                $this->set('info','请填写App版本');
            }
        }
        return $this->jsonResponse();
    }

    /**
     * 反馈分类
     * @return array
     */
    public function feedbackCate()
    {
        $cates = FeedbackCategory::orderBy('sort','desc')->get();
        if ($cates->count()){
            $this->set('data',$cates);
        }else{
            $this->set('type',$this->noContent);
            $this->set('info','暂无反馈分类');
        }
        return $this->jsonResponse();
    }
    
    /**
     * 用户反馈
     * @param Request $request
     * @return array
     */
    public function feedback(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'feedback_category_id'=>'required',
            'content'=>'required',
            'channel'=>'required',
        ]);
        $member = Member::where('id',$request->uid)->first();
        if (!$validate->fails()){
            if ($member){
                $feedback = Feedback::create([
                    'mid'=>$request->uid,
                    'phone'=>$member->phone,
                    'channel_code'=>$request->channel,
                    'feedback_category_id'=>$request->feedback_category_id,
                    'content'=>$request->input('content'),
                ]);
                if (!$feedback){
                    $this->set('type',$this->noContent);
                    $this->set('info','提交失败');
                }else{
                    $this->set('info','反馈成功');
                }
            }else{
                $this->set('type',$this->overdueUser);
                $this->set('info','请登录');
            }
        }else{
            if ($validate->errors()->has('feedback_category_id')){
                $this->set('type',$this->badRequest);
                $this->set('info','请选择反馈类型');
            }
            elseif ($validate->errors()->has('content')){
                $this->set('type',$this->badRequest);
                $this->set('info','请填写反馈内容');
            }
            else{
                $this->set('type',$this->badRequest);
                $this->set('info','请填写渠道码');
            }
        }
        return $this->jsonResponse();
    }

    /**
     * 个人资料
     * @param Request $request
     * @return array
     */
    public function profile(Request $request)
    {
        $member = Member::where('id',$request->uid)->first();
        if ($member){
            $data = [
                'avatar'=>$member->avatar,
                'nick'=>$member->nick,
            ];
            $this->set('data',$data);
        }else{
            $this->set('type',$this->overdueUser);
            $this->set('info','请登录');
        }
        return $this->jsonResponse();
    }

    /**
     * 新手帮助
     * @return array
     */
    public function help()
    {
        $helps = Help::orderBy('sort','desc')->get(['question','answer']);
        if ($helps){
            $this->set('data',$helps);
        }else{
            $this->set('type',$this->noContent);
            $this->set('info','暂无信息');
        }
        return $this->jsonResponse();
    }

    /**
     * 关于我们
     * @return array
     */
    public function about()
    {
        $about = Page::where('slug','about')->first();
        if ($about){
            $company = Website::orderBy('created_at','desc')->first();
            if ($company){
                $company_phone = $company->phone;
            }else{
                $company_phone = '028-86783282';
            }
            $data = [
                'title'=>$about->title,
                'content'=>$about->content,
                'company_phone'=>$company_phone,
            ];
            $this->set('data',$data);
        }else{
            $this->set('type',$this->noContent);
            $this->set('info','暂无内容');
        }
        return $this->jsonResponse();
    }

    /**
     * 注册协议
     * @return array
     */
    public function agreement()
    {
        $agreement = Page::where('slug','reg')->first();
        if ($agreement){
            $data = [
                'title'=>$agreement->title,
                'content'=>$agreement->content,
            ];
            $this->set('data',$data);
        }else{
            $this->set('type',$this->noContent);
            $this->set('info','暂无内容');
        }
        return $this->jsonResponse();
    }

    /**
     * 贷贷狐圈子
     */
    public function circle()
    {
        $circles = Circle::orderBy('sort','desc')->get(['id','url','title','intro','copy_content','slug']);
        if ($circles->count()){
            $this->set('data',$circles);
        }else{
            $this->set('type',$this->noContent);
            $this->set('info','暂无圈子');
        }
        return $this->jsonResponse();
    }
}
