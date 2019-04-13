<?php

namespace App\Http\Controllers\Admin;

use App\Models\Channel;
use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\FeedbackReply;
use App\Models\SystemMessageBack;
use App\Models\User;
use App\Traits\CustomExcel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FeedBackController extends Controller
{
    use CustomExcel;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $channels = FeedbackCategory::get(['id','name']);
        return view('admin.feedback.index',compact('channels'));
    }

    /**
     * @param Request $request
     * @param Feedback $feedback
     * @return \Illuminate\Http\JsonResponse
     *
     * 数据接口
     */
    public function data(Request $request, Feedback $feedback)
    {
        if($request->get('end_time')<$request->get('start_time')){
            $data = [
                'code' => 1,
                'msg'   => '结束时间不能小于开始时间',
                'count' => '',
                'data'  => ''
            ];
            return response()->json($data);
        }
        DB::connection()->enableQueryLog();
        $model = $feedback->query();

        if($request->get('start_time')){
            $model = $model->where('created_at','>',$request->get('start_time'));
        }

        if($request->get('end_time')){
            $model = $model->where('created_at','<=',$request->get('end_time'));
        }

        if($request->get('phone')){
            $phone = $request->get('phone');
            $model = $model->where('phone','like',"%$phone%");
        }

        if($request->get('channel_id')){
            $model = $model->where(['feedback_category_id'=>$request->get('channel_id')]);
        }

        if(isset($request->reply_status)){
            $model = $model->where(['status'=>$request->get('reply_status')]);
        }

        $res = $model->with('category')->orderBy('created_at','desc')->paginate($request->get('limit',$this->pageSize))->toArray();

        if($res['data']){
            foreach($res['data'] as &$item){
                $category = $item['category']['name'];
                unset($item['category']);
                $item['category'] = $category;
            }
        }
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request,Feedback $feedback)
    {
        if($request->get('end_time')<$request->get('start_time')){
            $data = [
                'code' => 1,
                'msg'   => '结束时间不能小于开始时间',
                'count' => '',
                'data'  => ''
            ];
            return response()->json($data);
        }

        $model = $feedback->query();

        if($request->get('start_time')){
            $model = $model->where('created_at','>',$request->get('start_time'));
        }

        if($request->get('end_time')){
            $model = $model->where('created_at','<=',$request->get('end_time'));
        }

        if($request->get('phone')){
            $phone = $request->get('phone');
            $model = $model->where('phone','like',"%$phone%");
        }

        if($request->get('channel_id')){
            $model = $model->where(['feedback_category_id'=>$request->get('channel_id')]);
        }

        if(isset($request->getreply_status)){
            $model = $model->where(['status'=>$request->get('reply_status')]);
        }

        if($request->ids){
            $model = $model->whereIn('id',explode(',',$request->ids));
        }
        $res = $model->with('category')->orderBy('created_at','desc')->get();
        if($res){
            $result = [];
            $result[] = ['编号','反馈人','反馈时间','反馈分类','反馈内容','回复状态'];
            foreach($res as $item){
                $arr = [];
                $arr[] = $item->id;
                $arr[] = $item->phone;
                $arr[] = $item->created_at;
                $arr[] = $item->category['name'];
                $arr[] = $item->content;
                $arr[] = $item->status;
                $result[] = $arr;
            }
            $title = '反馈列表'.date('YmdHis');
            $this->excelExport($title, $result );
            die();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $uid = auth()->user()->id;
        if($request->id && $request->Content){
            DB::beginTransaction();
            try {
                $info = User::find($uid,['name']);
                $insert = FeedbackReply::create(['feedback_id'=>$request->id,'content'=>$request->Content,'user_id'=>$uid,'user_name'=>$info->name]);
                Feedback::where(['id'=>$request->id])->update(['status'=>1]);
                $feedInfo = Feedback::find($request->id);
                //系统消息推送：
                SystemMessageBack::create(['message_type'=>'feedback_reply','object_id'=>$insert->id,'title'=>'反馈回复','content'=>$request->Content,'numbers'=>$feedInfo->phone,'send_type'=>1,'send_user_type'=>3]);
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                $this->set('code',1);
                $this->set('info','操作失败');
            }
        }else{
            $this->set('code',1);
            $this->set('info','参数不正确');
        }
        return $this->ajaxResponse();
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
        $info = Feedback::with('reply')->find($id);
        return view('admin.feedback.edit',compact('info'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
