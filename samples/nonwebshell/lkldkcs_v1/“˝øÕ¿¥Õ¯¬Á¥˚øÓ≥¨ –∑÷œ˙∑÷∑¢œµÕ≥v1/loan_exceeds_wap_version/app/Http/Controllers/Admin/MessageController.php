<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageEvent;
use App\Jobs\PushMessage;
use App\Models\Application;
use App\Models\Member;
use App\Models\Message;
use App\Models\MessageAppend;
use App\Models\MessageApplication;
use App\Models\MessageMember;
use App\Models\MessageUserModel;
use App\Models\SystemMessageBack;
use App\Models\UserModel;
use App\Models\UserModelSnapshot;
use App\Traits\CustomExcel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Facades\Excel;

class MessageController extends Controller
{
    use CustomExcel;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.message.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $models = UserModel::all(['id','name']);
        $apps = Application::whereNotIn('id',[7])->get(['id','name','display_name']);
        return view('admin.message.create',compact('models','apps'));
    }

    /**
     * excel 导入
     */
    public function importExcelData(Request $request){
        if($request->file) {
            $file = $_FILES;
            $excel_file_path = $file['file']['tmp_name'];
            $res = [];
            $mobile = '';
            Excel::load($excel_file_path, function ($reader) use (&$res) {
                $reader = $reader->getSheet(0);
                $res = $reader->toArray();
            });
            $counts = 0;
            if ($res) {
                foreach ($res as $k => $item) {
                    if($k > 0) {
                        $mobile .= ',' . $item[1];
                    }
                }
                $counts = count($res);
            }
            return response()->json(['code'=>0,'data'=>['str'=>trim($mobile,','),'counts'=>$counts],'message'=>'成功']);
        }else{
            return response()->json(['code'=>1,'message'=>'没有文件','data'=>'']);
        }
    }

    /**
     *异步查询号码数量
     */
    public function getCountsOfSelect(Request $request){
        $count = 0;
        if($request->type == 3) {
            if ($request->str) {
                $arr = explode(',', $request->str);
                $count = count($arr);
            }
            if ($request->models) {
                $numbers = $this->customNumbers($request->models);
                $count += count($numbers);
            }
        }else{
            $count = Member::count();
        }
        $this->set('data',['count'=>$count]);
        return $this->ajaxResponse();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data['title'] = $request->title;
        $data['content'] = $request->content;
        $data['send_type'] = $request->send_type;//1即时2定时
        $data['redirect_model'] = $request->redirect_model;//跳转页面
        if($request->send_type == 2){
            $data['fixed_at'] = $request->action_time;//指定时间
        }
        $data['send_object'] = $request->user_type;//1:全部用户2注册用户3指定用户
        $data['redirect_model'] = $request->redirect_model;//跳转页面
        if($request->redirect_model == 'CustomLink'){
            $data['redirect_model_detail'] = $request->redirect_model_detail ??0;//自定义跳转地址
        }
        $data['type'] = $request->type;
        $data['status'] = 0;
        DB::beginTransaction();
        try {
            $insert = Message::create($data);
            $totalNumberStr = $customNumbers = $request->customNumbers??'';//自定义号码
            if ($request->user_type == 3 ) {
                $counts = 0;
                if ($request->model) {//自定义用户模型
                    $numberStr = $this->customNumbers($request->model, 1);//用户模型查询号码
                    if($customNumbers){
                        $totalNumberStr = $customNumbers.','.$numberStr;
                    }else{
                        $totalNumberStr = $numberStr;
                    }
                    $counts += count(explode(',',$numberStr));
                    foreach (explode(',',$request->model) as $item) {//用户模型存储
                        if ($item) {
                            MessageUserModel::create(['message_id' => $insert->id, 'user_model_id' => $item]);
                        }
                    }
                }
                if ($request->customNumbers) {//自定义号码
                    MessageAppend::create(['message_id' => $insert->id, 'phone' => $customNumbers,'type'=>2]);
                    $counts += count(explode(',',$request->customNumbers));
                }
                Message::where(['id'=>$insert->id])->update(['counts'=>$counts]);//更新当前的筛选目标人数
            }else{
                $counts = Member::count();
                Message::where(['id'=>$insert->id])->update(['counts'=>$counts]);//更新当前的筛选目标人数
            }
            if($request->application){//发送应用
                foreach(explode(',',$request->application) as $item){
                    if($item) {
                        MessageApplication::create(['message_id'=>$insert->id,'application_id'=> $item]);
                    }
                }

            }
            if($totalNumberStr) {
                MessageMember::create(['message_id' => $insert->id, 'numbers' => $totalNumberStr]);//自定义号码存储
            }
            //即时推送调用
            Log::info('+++++++++');
//            $this->pushReady($insert);
            DB::commit();
            return redirect()->route('admin.push');

        } catch (\Exception $e) {
            // 数据回滚, 当try中的语句抛出异常。
            DB::rollBack();
            // 执行一些提醒操作等等...
            return redirect()->back();
        }
     /*   $this->pushReady($insert);
        return redirect()->route('admin.push');*/
    }

    /**
     * @param $models
     * @return string
     * 根据用户模型查询用户id
     */
    public function customNumbers($models,$mobile=null){
        $str = '';
       /* $modelArr = UserModelSnapshot::whereIn('user_model_id', explode(',', $models))
            ->orderBy('id','desc')
            ->get(['client_user_ids']);*/
        $modelArr = explode(',', $models);
        $strArrs = [];
        foreach($modelArr as $item){
            $res = UserModelSnapshot::where(['user_model_id'=>$item])
                ->orderBy('id','desc')
                ->first(['client_user_ids']);
            $strArrs[] = implode(',',$res->client_user_ids);
//            $str .= ','. implode(',',$res->client_user_ids);
        }
        $str = implode(',',$strArrs);
//        dd($str);
        $str = trim($str,',');
        $strArr = explode(',',$str);
        $strArr = array_unique($strArr);
        /*$key = array_search('',$strArr);
        unset($strArr[$key]);*/
        if($mobile){//返回电话字符串
            $numberObj = Member::whereIn('id',$strArr)->get(['phone'])->pluck('phone');
            $numberArr = $numberObj->toArray();
            $numberStr = implode(',',$numberArr);
            return $numberStr;
        }
       return $strArr;
    }

    /**
     * @param Request $request
     * @param Message $message
     * @return \Illuminate\Http\JsonResponse
     * 列表数据：异步
     */
    public function data(Request $request,Message $message){
        $message = $message->query();
//        DB::connection()->enableQueryLog();
        if($request->create_start){
            $message = $message->where('created_at','>=',$request->create_start);
        }
        if($request->create_end){
            $message = $message->where('created_at','<',$request->create_end);
        }
        if($request->action_start  && !$request->action_end ){
            $message = $message->where([['send_type','=',2],['send_at','>=',$request->action_start]])
                     ->orWhere([['send_type','=',1],['created_at','>=',$request->action_start]]);
        }
        if($request->action_start && $request->action_end){
            $message = $message->where([['send_type','=',2],['send_at','>=',$request->action_start],['send_at','<=',$request->action_end]])
                ->orWhere([['send_type','=',1],['created_at','>=',$request->action_start],['created_at','<=',$request->action_end]]);
        }
        if(!$request->action_start && $request->action_end){
            $message = $message->where([['send_type','=',2],['send_at','<=',$request->action_end]])
                    ->orWhere([['send_type','=',1],['created_at','<=',$request->action_end]]);
        }
        if($request->body){
            $message = $message->where('content','like',"%$request->body%");
        }
        $data = $message->with('device')
                ->select(['id','type','title','content','send_type','status','send_at','counts','created_at','type'])
                ->orderBy('id','desc')
                ->paginate($request->get('limit',$this->pageSize))
                ->toArray();
//        $log = DB::getQueryLog();
//        dd($log);
//        dd(count($data));
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $data['total'],
            'data'  => $data['data']
        ];
        return response()->json($data);

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $models = UserModel::all(['id','name']);
        $apps = Application::all(['id','name','display_name']);
        $info = Message::with(['userModel','member','application','appends'])
            ->find($id);
        if($info->userModel){
            $user = $info->userModel->pluck('user_model_id')->toArray();
            if($info->type == 'push') {
                $applications = $info->application->pluck('application_id')->toArray();
                unset($info->application);
                $info['application'] = $applications;
            }
            unset($info->userModel);
            $info['userModel'] = $user;
        }
        if($info->type == 'push') {
            return view('admin.message.create',compact('models','apps','info'));
        }else{
            return view('admin.message.system',compact('models','apps','info'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data['title'] = $request->title;
        $data['content'] = $request->content;
        $data['send_type'] = $request->send_type;//1即时2定时
        if($request->send_type == 2){
            $data['fixed_at'] = $request->action_time;//指定时间
        }
        $data['send_object'] = $request->user_type;//1:全部用户2注册用户3指定用户
        $data['redirect_model'] = $request->redirect_model;//跳转页面
        if($request->redirect_model == 'CustomLink'){
            $data['redirect_model_detail'] = $request->redirect_model_detail ??'';//自定义跳转地址
        }
        $data['type'] = $request->type;
        $data['status'] = 0;
        DB::beginTransaction();
        try {
            $update = Message::where(['id'=>$id])->update($data);
            $totalNumberStr = $customNumbers = $request->customNumbers??'';//自定义号码
            if ($request->user_type == 3 ) {
                $counts = 0;
                if ($request->model) {//自定义用户模型
                    $numberStr = $this->customNumbers($request->model, 1);//用户模型查询号码
                    $totalNumberStr = $customNumbers.','.$numberStr;
                    $counts += count(explode(',',$numberStr));
                    MessageUserModel::where(['message_id'=>$id])->delete();
                    foreach (explode(',',$request->model) as $item) {//用户模型存储
                        if ($item) {
                            MessageUserModel::create(['message_id' => $id, 'user_model_id' => $item]);
                        }
                    }
                }
                if ($request->customNumbers) {//自定义号码
                    $exist = MessageAppend::where(['message_id'=>$id])->first();
                    if($exist) {
                        MessageAppend::where(['message_id' => $id])->update(['phone' => $customNumbers, 'type' => 2]);
                    }else{
                        MessageAppend::create(['message_id' => $id,'phone' => $customNumbers, 'type' => 2]);
                    }
                    $counts += count(explode(',',$request->customNumbers));
                }
                Message::where(['id'=>$id])->update(['counts'=>$counts]);//更新当前的筛选目标人数
            }else{
                MessageUserModel::where(['message_id'=>$id])->delete();
                MessageAppend::where(['message_id'=>$id])->delete();
                MessageMember::where(['message_id'=>$id])->delete();
                $counts = Member::count();
                Message::where(['id'=>$id])->update(['counts'=>$counts]);//更新当前的筛选目标人数
            }
            if($request->application){//发送应用
                MessageApplication::where(['message_id'=>$id])->delete();
                foreach(explode(',',$request->application) as $item){
                    if($item) {
                        MessageApplication::create(['message_id'=>$id,'application_id'=> $item]);
                    }
                }
            }
            if($totalNumberStr) {
                MessageMember::where(['message_id' => $id])->update(['numbers' => $totalNumberStr]);//自定义号码存储
            }

            DB::commit();
            return redirect()->route('admin.push');
        } catch (\Exception $e) {
            // 数据回滚, 当try中的语句抛出异常。
            DB::rollBack();
            // 执行一些提醒操作等等...
            return redirect()->back();
        }
    }

    /**
     * 系统消息
     */
    public function system(){
        $models = UserModel::all(['id','name']);
        $apps = Application::all(['id','name','display_name']);
        return view('admin.message.system',compact('models','apps'));
    }

    /**
     * @param Request $request
     * 系统消息
     */
    public function systemSave(Request $request){
        $data['title'] = $request->title;
        $data['content'] = $request->content;
        $data['send_type'] = $request->send_type;//1即时2定时
        if($request->send_type == 2){
            $data['fixed_at'] = $request->action_time;//指定时间
        }
        $data['send_object'] = $request->user_type;//1:全部用户2注册用户3指定用户
        $data['redirect_model'] = '';//跳转页面类型
        $data['redirect_model_detail'] = '';//跳转页面：详情

        $data['type'] = 'system';
        if($request->send_type == 1){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        DB::beginTransaction();
        try {
            $insert = Message::create($data);
            $totalNumberStr = $customNumbers = $request->customNumbers??'';//自定义号码
            if ($request->user_type == 3 ) {
                $counts = 0;
                if ($request->model) {//自定义用户模型
                    $numberStr = $this->customNumbers($request->model, 1);//用户模型查询号码
                    $totalNumberStr = $customNumbers.','.$numberStr;
                    $counts += count(explode(',',$numberStr));
                    foreach (explode(',',$request->model) as $item) {//用户模型存储
                        if ($item) {
                            MessageUserModel::create(['message_id' => $insert->id, 'user_model_id' => $item]);
                        }
                    }
                }
                if ($request->customNumbers) {//自定义号码
                    MessageAppend::create(['message_id' => $insert->id, 'phone' => $customNumbers,'type'=>2]);
                    $counts += count(explode(',',$request->customNumbers));
                }
                Message::where(['id'=>$insert->id])->update(['counts'=>$counts]);//更新当前的筛选目标人数

            }else{
                $counts = Member::count();
                Message::where(['id'=>$insert->id])->update(['counts'=>$counts]);//更新当前的筛选目标人数
            }
            if($totalNumberStr) {
                MessageMember::create(['message_id' => $insert->id, 'numbers' => $totalNumberStr]);//自定义号码存储
            }
            //更新系统消息的备份表的数据
            SystemMessageBack::create(['title'=>$request->title,'content'=>$request->content,'message_type'=>'system','object_id'=>$insert->id,'numbers'=>$totalNumberStr,'send_type'=>$request->send_type,'send_user_type'=>$request->user_type,'send_at'=>$request->action_time]);

            DB::commit();
            return redirect()->route('admin.push');
        } catch (\Exception $e) {
            // 数据回滚, 当try中的语句抛出异常。
            DB::rollBack();
            // 执行一些提醒操作等等...
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @param $id
     * 系统消息编辑
     */
    public function systemUpdate(Request $request,$id){
        $data['title'] = $request->title;
        $data['content'] = $request->content;
        $data['send_type'] = $request->send_type;//1即时2定时
        if($request->send_type == 2){
            $data['fixed_at'] = $request->action_time;//指定时间
        }
        $data['send_object'] = $request->user_type;//1:全部用户2注册用户3指定用户
        $data['redirect_model'] = '';//跳转页面
        $data['redirect_model_detail'] = '';
        $data['type'] = 'system';
        if($request->send_type == 1){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        DB::beginTransaction();
        try {
            $update = Message::where(['id'=>$id])->update($data);
            $totalNumberStr = $customNumbers = $request->customNumbers??'';//自定义号码
            if ($request->user_type == 3 ) {
                $counts = 0;
                if ($request->model) {//自定义用户模型
                    $numberStr = $this->customNumbers($request->model, 1);//用户模型查询号码
                    $counts += count(explode(',',$numberStr));
                    $totalNumberStr = $customNumbers.','.$customNumbers;
                    MessageMember::where(['message_id' =>$id])->update(['numbers'=> $numberStr]);//自定义号码存储
                    MessageUserModel::where(['message_id'=>$id])->delete();
                    foreach (explode(',',$request->model) as $item) {//用户模型存储
                        if ($item) {
                            MessageUserModel::create(['message_id' => $id, 'user_model_id' => $item]);
                        }
                    }
                }
                if ($request->customNumbers) {//自定义号码
                    $exist = MessageAppend::where(['message_id'=>$id])->first();
                    if($exist) {
                        MessageAppend::where(['message_id' => $id])->update(['phone' => $customNumbers, 'type' => 2]);
                    }else{
                        MessageAppend::create(['message_id' => $id,'phone' => $customNumbers, 'type' => 2]);
                    }
                    $counts += count(explode(',',$request->customNumbers));
                }
                Message::where(['id'=>$id])->update(['counts'=>$counts]);//更新当前的筛选目标人数
            }else{
                MessageUserModel::where(['message_id'=>$id])->delete();
                MessageAppend::where(['message_id'=>$id])->delete();
                MessageMember::where(['message_id'=>$id])->delete();
                $counts = Member::count();
                Message::where(['id'=>$id])->update(['counts'=>$counts]);//更新当前的筛选目标人数
            }
            //更新系统消息的备份表的数据
            if($totalNumberStr) {
                MessageMember::where(['message_id' => $id])->update(['numbers' => $totalNumberStr]);//自定义号码存储
            }
            //更新系统消息的备份表的数据
            SystemMessageBack::where(['message_type'=>'system','object_id'=>$id])->update(['title'=>$request->title,'content'=>$request->content,'numbers'=>$totalNumberStr,'send_type'=>$request->send_type,'send_at'=>$request->action_time]);
            DB::commit();
            return redirect()->route('admin.push');
        } catch (\Exception $e) {
            // 数据回滚, 当try中的语句抛出异常。
            DB::rollBack();
            // 执行一些提醒操作等等...
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * 数据导出
     */
    public function exportExcelData(Request $request){
        $message = Message::select();
        if($request->create_start){
            $message = $message->where('created_at','>',$request->create_start);
        }
        if($request->create_end){
            $message = $message->where('created_at','<',$request->create_end);
        }
        if($request->action_start){
            $message = $message->where('send_at','>',$request->action_start);
        }
        if($request->action_end){
            $message = $message->where('send_at','>',$request->action_end);
        }
        if($request->body){
            $message = $message->where('content','like',"%$request->body%");
        }
        $list = $message->with('device')
            ->select(['id','type','title','content','send_type','status','send_at','counts','created_at'])
            ->orderBy('id','desc')
            ->get();
        if(count($list)){
            $result = [];
            $result[] = ['编号','类型','标题','内容','创建时间','发送状态','执行时间','发送数量','发送类型','到达数量','点击数量'];
            foreach($list as $item){
                $arr = [];
                $arr[] = $item->id;
                $arr[] = $item->type == 'push'?'推送':'系统消息';
                $arr[] = $item->title;
                $arr[] = $item->content;
                $arr[] = $item->created_at;
                $arr[] = $item->status==0?'未发送':'已发送';
                $arr[] = $item->send_at;
                $arr[] = $item->counts;
                $arr[] = $item->send_type==1 ? '即时发送':'定时发送';
                $arr[] = $item->status == 1 ? $item->counts : 0;
                $arr[] = count($item->device);
                $result[] = $arr;
            }
            $title = '消息列表'.date('YmdHis');
            $this->excelExport($title,$result);
            die();
        }
    }

    /**
     * @param Message $message
     * 极光推送：调起
     */
    public function pushReady($message){
//        Log::info($message);
        $data['title'] = $message['title'];
        $data['content'] = strip_tags($message['content']);
        $data['redirect_model'] = $message['redirect_model'];//redirect_model:AppIndex|AppProduct|AppUserCenter|CustomLink
        $data['redirect_model_detail'] = $message['redirect_model_detail'];//link
//        $platforms = 'all';//发送平台：安卓|ios
        $apps = MessageApplication::with('apps')->where(['message_id'=>$message->id])->get();
        $app = [];//发送应用
        if($apps){
            foreach($apps as $item){
                $arr = [];
                $arr['config'] = $item->apps['jpush_config'];
                $app[] = $arr;
            }
        }
        $customNumbers = '';
        if($message->send_type == 1){//即时推送
            if($message->send_object == 1)//全部用户
            {
                $user_type = 'all';
            }elseif($message->send_object == 2){//注册用户
                $user_type = 'all_region';
            }else{
                $user_type = 'custom';//指定用户
                $mobiles = MessageMember::where(['message_id'=>$message->id])->first();
                $customNumbers = $mobiles->numbers;
            }
//            $key = 'push:message:now:message_id_'.$message->id;
            Redis::set('push:message:now:message_id_'.$message->id,json_encode($data));
            //推送调起
            Log::info('--调起推送--');
            $this->setListNow($message->id,'all',$app,$user_type,$customNumbers);
        }
    }

    /**
     * @param $key mes_ig
     * @param $data ['title','content','redirect_model','redirect_model_detail']
     * @param $platforms ['all']
     * @param $apps ['ddh','hry']
     * @param $mobiles string 1,2,3,4
     * @param $user_type ['all_region','all','custom']
     */
    public function setListNow($mes_id,$platforms,$apps,$user_type,$mobiles=null){
        if($user_type == 'all'){//全部用户
            Log::info('--发送全部--');
            foreach($apps as $item){
                $job = new PushMessage($item,$mes_id,$platforms,'allUsers','');//id|all|hry|allusers|13300000000
                $this->dispatchNow($job);
            }
        }elseif($user_type == 'all_region'){//注册用户
            Log::info('--注册用户--');
            $members = Member::with(['device'=>function($query){
                $query->with('apps')->select(['app_id','identifier','push_id']);
            }])
               /* ->whereHas('device',function($query){
                    $query->where('push_id','<>','');
                })*/
               ->where('identifier_push','<>','')
                ->get();
            if(count($members)){
                foreach($members as $item){
                    $config = $item->device['apps']['jpush_config'];
                    if($config && $item->device['push_id']) {
                        $job = new PushMessage(['config' => $config], $mes_id, $platforms, 'custom_user', $item->device['push_id']);//id|all|hry|allusers|13300000000
                        $this->dispatchNow($job);
                    }
                }
            }
        }else{//指定用户
            Log::info('--指定用户--');
            if($mobiles) {
                $members = Member::with(['device' => function ($query) {
                    $query->with('apps')->select(['app_id', 'identifier', 'push_id']);
                }])
                    /* ->whereHas('device',function($query){
                         $query->where('push_id','<>','');
                     })*/
                    ->whereIn('phone', explode(',', $mobiles))
                    ->where('identifier_push','<>','')
                    ->get();
                Log::info('---member--');
                Log::info(json_encode($members));
                if (count($members)) {
                    foreach ($members as $item) {
                        Log::info('---phone---'.$item);
                        Log::info('---push_id---'.$item->device['push_id']);
                        $config = $item->device['apps']['jpush_config'];

                        if ($config && $item->device['push_id']) {
                            Log::info('---config---' . $config);
                            Log::info('---push_id---' . $item->device['push_id']);
                            $job = new PushMessage(['config' => $config], $mes_id, $platforms, 'custom_user', $item->device['push_id']);//id|all|hry|allusers|13300000000
                            $this->dispatchNow($job);
                        }
                    }
                }
            }
        }
        Log::info('更新状态');
        //TODO::已发送状态变更
        Message::where(['id'=>$mes_id])->update(['send_at'=>Carbon::now(),'status'=>1]);
    }

    /**
     * 检查定时推送
     */
    public function checkPushMessage(){
//        DB::connection()->enableQueryLog();
        $exist = Message::where([['type','=','push'],['send_type','=',2],['status','=',0],['fixed_at','<=',Carbon::now()]])
                ->orWhere([['type','=','push'],['send_type','=',1],['status','=',0]])
                ->get();
/*        $log = DB::getQueryLog();
        Log::info($log);
        Log::info(json_encode($exist));*/
        if(count($exist)){
            foreach($exist as $item){
                //查询应用
                $apps = MessageApplication::with('apps')->where(['message_id'=>$item->id])->get();
                Log::info('----item-id--'.$item->id);
                $app = [];//发送应用
                if($apps){
                    foreach($apps as $val){
                        $arr = [];
                        $arr['config'] = $val->apps['jpush_config'];
                        $app[] = $arr;
                    }
                }
                Log::info('---config--'.json_encode($app));
                ////
                $customNumbers = '';
                $data['title'] = $item['title'];
                $data['content'] = strip_tags($item['content']);
                $data['redirect_model'] = $item['redirect_model'];//redirect_model:AppIndex|AppProduct|AppUserCenter|CustomLink
                $data['redirect_model_detail'] = $item['redirect_model_detail'];//link
                Log::info('object_type:'.$item->send_object);
                if($item->send_object == 1)//全部用户
                {
                    $user_type = 'all';
                }elseif($item->send_object == 2){//注册用户
                    $user_type = 'all_region';
                }else{
                    $user_type = 'custom';//指定用户
                    $mobiles = MessageMember::where(['message_id'=>$item->id])->first();
                    if($mobiles) {
                        $customNumbers = $mobiles->numbers;
                    }
                }
                Log::info('--type--'.$user_type);
                Log::info('--numbers--'.$customNumbers);
                Redis::set('push:message:now:message_id_'.$item->id,json_encode($data));
                //推送调起
                $this->setListNow($item->id,'all',$app,$user_type,$customNumbers);
            }
        }
    }
    //检查系统消息状态
    public function checkSystemMessage(){
        $exist = Message::where([['type','=','system'],['send_type','=',2],['status','=',0],['fixed_at','<=',Carbon::now()]])
                ->get();//
        if(count($exist)){
            foreach($exist as $item)
            {
                Message::where(['id'=>$item->id])
                    ->update(['status'=>1,'send_at'=>Carbon::now()]);
            }
        }
    }

}
