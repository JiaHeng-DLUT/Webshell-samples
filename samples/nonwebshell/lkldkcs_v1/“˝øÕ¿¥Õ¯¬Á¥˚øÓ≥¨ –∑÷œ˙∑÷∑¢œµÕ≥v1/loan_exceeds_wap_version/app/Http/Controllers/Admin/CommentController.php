<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\SystemMessageBack;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * 描述：后台评论管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function  index()
    {
        return view('admin.comment.index');
    }

    /**
     * 描述：后台评论管理列表数据渲染
     * @param Request $request
     * @param Comment $comment
     * @return \Illuminate\Http\JsonResponse
     * 数据接口
     */
    public function data(Request $request, Comment $comment)
    {
        if($request->get('end_time') &&  $request->get('end_time') < $request->get('start_time')){
            $data = [
                'code' => 1,
                'msg'   => '结束时间不能小于开始时间',
                'count' => '',
                'data'  => ''
            ];
            return response()->json($data);
        }
        $model = $comment->query()->with('reply');
        //开始时间
        if($request->get('start_time')){
            $model = $model->where('created_at','>',$request->get('start_time'));
        }
        //结束时间
        if($request->get('end_time')){
            $model = $model->where('created_at','<=',$request->get('end_time'));
        }
        //用户电话
        if($request->get('phone')){
            $phone = $request->get('phone');
            $model = $model->where('phone','like',"%$phone%");
        }
        //状态
        if($request->get('status')  !=  null ){
            $model = $model->where(['status'=>$request->get('status')]);
        }
        //产品类型
        if($request->get('product_type')){
            $model = $model->where(['product_type'=>$request->get('product_type')]);
        }
        //评论类型
        if($request->get('comment_type')){
            $model = $model->where(['comment_type'=>$request->get('comment_type')]);
        }
        //产品名称
        if($request->get('model_name')){
            $model_name = $request->get('model_name');
            $model = $model->where('model_name','like',"%$model_name%");
        }
        if($request->type){
            $model = $model->orderBy($request->type,$request->order);
        }
        $res = $model ->orderBy('created_at','desc')->paginate($request->get('limit',$this->pageSize))->toArray();
        foreach ($res['data'] as$key =>  $item)
        {
            if(count($item['reply']) > 0)
            {
                $res['data'][$key]['sum_reply'] = 1;
            }else{
                $res['data'][$key]['sum_reply'] = 0;
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
     * 描述：评论回复
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function  edit($id)
    {
        $info = Comment::where('id',$id)->with('reply')->first();
        return view('admin.comment.edit',compact('info'));
    }


    /**
     * 回复/编辑评论
     * @param Request $request
     */
    public  function update(Request $request)
    {

        $uid =  auth()->user()->id;
        $name = auth()->user()->name;
        $id = $request->input('id');
        $content = $request->input('content');
        $status = $request->input('status');
        $is_wonderful = $request->input('is_wonderful');
        $comm_data['status']=  $status;
        $comm_data['is_wonderful']=  $is_wonderful;
        $comm_data['updated_at']=   Carbon::now();
        $result = true;
        $comm_result = Comment::where('id',$id)->update($comm_data);
        if($content)
        {
            $commentInfo = Comment::find($id);
            $data['comment_id'] = $id;
            $data['content'] = $content;
            $data['user_id'] = $uid;
            $data['user_name'] = $name;
            $result = CommentReply::create($data);

            //系统消息推送：真实评论|审核通过
            if($request->status == 1 && $commentInfo->comment_type == 'real') {
                SystemMessageBack::create(['title' => '评论回复', 'content' => $content, 'message_type' => 'comment_reply', 'object_id' => $result->id, 'numbers' => $commentInfo->phone, 'send_type' => 1, 'send_user_type' => 3]);
            }
        }
        if($result && $comm_result)
        {
            $this->set('code', 0);
            $this->set('info', '回复成功');
        }
        else{
            $this->set('code', 1);
            $this->set('info', '回复失败');
        }
        return $this->ajaxResponse();
    }


    /**
     * 描述：单条删除评论
     * @param Request $request
     * @return array
     */
    public  function  destroy(Request $request)
    {
        $id = $request->input('id');
        $query = Comment::where('id',$id)->delete();
        if($query)
        {
            $reply = CommentReply::where('comment_id',$id)->first();
            if($reply){
                SystemMessageBack::where(['message_type'=>'comment_reply','object_id'=>$reply->id])->delete();
            }
        }else
        {
            $this->set('code', 1);
            $this->set('info', '删除失败');
        }
        return $this->ajaxResponse();
    }
    /**
     * 描述：批量通过审核
     * @param Request $request
     * @return array
     */
    function  batchAuditPass(Request $request)
    {
        $ids = $request->input('ids');
        $select = Comment::whereIn('id',$ids)->where('status',0)->get(['id'])->toArray();
        if($select)
        {
            $query = Comment::whereIn('id',array_column($select,'id'))->update(['status'=>1,'updated_at'=>Carbon::now()]);
            if($query)
            {
                $this->set('code',0);
                $this->set('info','审核成功');
            }else
             {
                 $this->set('code',1);
                 $this->set('info','审核失败');
             }
        }else
        {
            $this->set('code',1);
            $this->set('info','请选择未处理的评论');
        }
        return $this->ajaxResponse();
    }

    /**
     * 描述：批量不予展示
     * @param Request $request
     * @return array
     */
    function  batchNotAuditPass(Request $request)
    {
        $ids = $request->input('ids');
        $select = Comment::whereIn('id',$ids)->where('status','0')->get(['id'])->toArray();
        if($select)
        {
            $query = Comment::whereIn('id',array_column($select,'id'))->update(['status'=>-1,'updated_at'=>Carbon::now()]);
            if($query)
            {
                $this->set('code',0);
                $this->set('info','批量不予展示成功');
            }else
            {
                $this->set('code',1);
                $this->set('info','批量不予展示失败');
            }
        }else
        {
            $this->set('code',1);
            $this->set('info','请选择未处理的评论');
        }
        return $this->ajaxResponse();
    }

    /**
     * 描述：批量删除
     * @param Request $request
     * @return array
     */
    function  batchDestroy(Request $request)
    {
        $ids = $request->input('ids');
        $query = Comment::whereIn('id',$ids)->delete();
        if($query)
        {
//            CommentReply::whereIn('comment_id',$ids)->delete();
            foreach($ids as $item) {
                $reply = CommentReply::where('comment_id', $item)->first();
                if ($reply) {
                    SystemMessageBack::where(['message_type' => 'comment_reply', 'object_id' => $reply->id])->delete();
                }
            }
            $this->set('code',0);
            $this->set('info','批量删除成功');
        }else
         {
            $this->set('code', 1);
            $this->set('info', '批量删除失败');
        }
        return $this->ajaxResponse();
    }

    /**
     * 描述：导出EXCEL表格
     * @param Request $request
     * @param Comment $comment
     *
     */
    function  batchExport(Request $request,Comment $comment)
    {
        $ids=$request->input('ids','');
        $model = $comment->query();
        //开始时间
        if($ids){
            $ids = explode(',',$ids);
            $model=$model->whereIn('id',$ids);
        }
        if($request->get('start_time')){
            $model = $model->where('created_at','>',$request->get('start_time'));
        }
        //结束时间
        if($request->get('end_time')){
            $model = $model->where('created_at','<=',$request->get('end_time'));
        }
        //用户电话
        if($request->get('phone')){
            $phone = $request->get('phone');
            $model = $model->where('phone','like',"%$phone%");
        }
        //状态
        if($request->get('status')  !=  null ){
            $model = $model->where(['status'=>$request->get('status')]);
        }

        //产品类型
        if($request->get('product_type')){
            $model = $model->where(['product_type'=>$request->get('product_type')]);
        }
        //评论类型
        if($request->get('comment_type')){
            $model = $model->where(['comment_type'=>$request->get('comment_type')]);
        }
        //产品名称
        if($request->get('model_name')){
            $model_name = $request->get('model_name');
            $model = $model->where('model_name','like',"%$model_name%");
        }
        $data = $model->orderBy('created_at','desc')->get();
        $data=$data->map(function ($item){
            return [
                $item->comment_type ==  'real' ? '真实评论':'虚拟评论' ,
                $item->phone,
                $item->product_type ==  'product' ? '贷款':'信用卡' ,
                $item->model_name,
                $item->star,
                $item->content,
                $item->created_at,
                $item->status == '-1' ? '不予展示': ( $item->status == '0'? '未审核':'展示')
            ];
        })->toArray();
        array_unshift($data,['评论类型','用户电话','产品类型','产品名称','评分','评论内容','评论时间','状态']);
        excel_export('评论管理',$data);
    }


}
