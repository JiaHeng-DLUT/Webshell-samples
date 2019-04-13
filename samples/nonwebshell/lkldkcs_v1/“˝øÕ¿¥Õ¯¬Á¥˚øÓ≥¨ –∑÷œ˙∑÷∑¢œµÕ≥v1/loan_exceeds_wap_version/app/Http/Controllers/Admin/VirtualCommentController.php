<?php

namespace App\Http\Controllers\Admin;

use App\Models\Comment;
use App\Models\Credit;
use App\Models\Product;
use App\Models\VirtualComment;
use App\Models\VirtualPhone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class VirtualCommentController extends Controller
{
    /**
     * 虚拟评论管理首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function  index(){
        return view('admin.virtual_comment.index');
    }
    /**
     * 描述：页面拉取数据
     * @param Request $request
     * @param VirtualComment $virtualComment
     * @return \Illuminate\Http\JsonResponse
     */
    public  function  data(Request $request, VirtualComment $virtualComment)
    {
        $model = $virtualComment->query();
        //评论类型
        if($request->get('star')){
            $model = $model->where(['star'=>$request->get('star')]);
        }
        //产品名称
        if($request->get('content')){
            $content = $request->get('content');
            $model = $model->where('content','like',"%$content%");
        }
        $res = $model->orderBy('created_at','desc')->paginate($request->get('limit',$this->pageSize))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * 描述：投放虚拟评论
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public  function  create()
    {
        return view('admin.virtual_comment.create');
    }

    /**
     * 描述：获取树状产品数据
     * @return array
     */
    public  function  productData()
    {
       $product = Product::where('status',1)->get();
       $credit =  Credit::where('status',1)->get(['id','name']);
      return   ['products'=>$product,'credits'=>$credit];
    }

    /**
     * 编辑虚拟评论
     * @param Request $request
     * @return array
     */
    public  function  update(Request $request)
    {
        $data = $request->all();
       $result = VirtualComment::where('id',$data['id'])->update(['content'=>$data['edit_content'],'star'=>$data['edit_star']]);
        if($result)
        {
            $this->set('code', 0);
            $this->set('info', '编辑成功');
        }
        else{
            $this->set('code', 1);
            $this->set('info', '编辑失败');
        }
        return $this->ajaxResponse();
    }
    /**
     * 描述：单条删除
     * @param Request $request
     * @return array
     */
    public  function  destroy(Request $request)
    {
        $id = $request->input('id');
        $query = VirtualComment::where('id',$id)->delete();
        if($query)
        {
            $this->set('code',0);
            $this->set('info','删除成功');
        }else
        {
            $this->set('code', 1);
            $this->set('info', '删除失败');
        }
        return $this->ajaxResponse();
    }

    /**
     * 描述：添加虚拟评论
     * @param Request $request
     * @return array
     */
    public  function  postData(Request $request)
    {
        $data = $request->all();
        $phone_exist = VirtualPhone::count();
        if($phone_exist) {
            $date_start = strtotime($data['date_start']);
            $date_end = strtotime($data['date_end']);
            $time_start = $data['time_start'];
            $time_end = $data['time_end'];
            //起始时间
            $number = (int)$data['number'];
            $array = $data['data'];
            foreach ($array as $key => $val) {
                $array[$key] = explode(',', $val);
            }
            //计算数组个数安排轮循
            $sum = count($array);
            $x = 0;
            set_time_limit(0);
            $comments = new Comment();
            $comments->timestamps = false;
            for ($i = 0; $i < $number; $i++) {
                //获取手机号码
                $phone = VirtualPhone::orderByRaw("RAND()")->first(['phone'])->phone;
                //获取评论内容
                $comment = VirtualComment::orderByRaw("RAND()")->first(['star', 'content']);
                //拼接数据
                //获取产品的信息
                if ($array[$x][0] == 'pro') {
                    $product = Product::where('id', $array[$x][1])->first(['name', 'id']);
                    $insertDate['product_type'] = 'product';
                    $insertDate['product_id'] = $product->id;
                    $insertDate['credit_id'] = 0;
                } else {
                    $product = Credit:: where('id', $array[$x][1])->first(['name', 'id']);
                    $insertDate['product_type'] = 'credit';
                    $insertDate['credit_id'] = $product->id;
                    $insertDate['product_id'] = 0;
                }
                $comment->star = $comment->star == 0 ? 5 : $comment->star;
                $times = $this->rangDate($date_start, $date_end, $time_start, $time_end);
                $insertDate['comment_type'] = 'fake';
                $insertDate['model_name'] = $product->name;
                $insertDate['star'] = $comment->star;
                $insertDate['content'] = $comment->content;
                $insertDate['phone'] = $phone;
                $insertDate['status'] = 1;

                $insertDate['created_at'] = $times;
                $insertDate['updated_at'] = $times;
//                dd($insertDate);
                Comment::insert($insertDate);
                $x += 1;
                if ($x == $sum) {
                    $x = 0;
                }
            }
            $this->set('code', 0);
            $this->set('info', '添加成功');
        }else{
            $this->set('code', 1);
            $this->set('info', '无虚拟号码');
        }
        return $this->ajaxResponse();
    }

    /**
     * 描述：根据时间区间随机取日期
     * @param $start_time
     * @param $end_time
     * @param $time_start
     * @param $time_end
     * @return string
     */
    public  function  rangDate($start_time,$end_time,$time_start,$time_end)
    {
       $start = explode(':',$time_start);
       $end   =  explode(':',$time_end);
       $start = ($start[0] * 3600) + ($start[1] * 3600) + ($start[2]);
       $end =   ($end[0] * 3600) + ($end[1] * 3600) + ($end[2]);
       $rand = rand($start,$end);

        $hour = floor($rand/3600);
        $minute = floor(($rand-3600 * $hour)/60);
        $second = floor((($rand-3600 * $hour) - 60 * $minute) % 60);
        $result = $hour.':'.$minute.':'.$second;
        if(strtotime($result) > time())
        {
            return $this->rangDate($start_time,$end_time,$time_start,$time_end);
        }elseif(strtotime($result) == 0)
        {
            return $this->rangDate($start_time,$end_time,$time_start,$time_end);
        }else{
            return date( "Y-m-d ", mt_rand($start_time,$end_time)).$result;
        }

    }
    /**
     * 描述：下载模板
     */
    public function  downTemplate()
    {
        $data= ['5','这是内容'];
        array_unshift($data, ['评分', '评论内容']);
        Excel::create('虚拟评论模板', function ($excel) use($data){
            $excel->sheet('sheet1', function ($sheet) use($data) {
                $sheet->rows($data);
            });
        })->export('xls');
        die();
    }

    /**
     * 描述：导入EXCEL 内容
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function  importTemplate(Request $request)
    {
        if($request->file) {
            $file = $_FILES;
            $excel_file_path = $file['file']['tmp_name'];
            $res = [];
            Excel::load($excel_file_path, function ($reader) use (&$res) {
                $reader = $reader->getSheet(0);
                $res = $reader->toArray();
            });
            $success_sum = 0;
            $fail_sum = 0;
            if ($res) {
                unset($res[0]);

                foreach ($res as $k => $item) {
                    if(mb_strlen($item[1],'UTF8') <= 100 && mb_strlen($item[1],'UTF8')> 0 && strpos($item[0],".") ==false)
                    {
                        $star = (int)$item[0];

                        if($star > 0 && $star < 6){
                            $success_sum +=1;
                            VirtualComment::create(['star'=>$star,'content'=>$item[1]]);

                        }else{
                            $fail_sum +=1;
                        }
                    }else{
                        $fail_sum +=1;
                    }
                }
            }
            return response()->json(['code'=>0,'msg'=>'上传成功,成功：'.$success_sum.'条，失败：'.$fail_sum]);
        }else{
            return response()->json(['code'=>1,'msg'=>'没有文件']);
        }
    }
    /**
     * 描述：批量删除
     * @param Request $request
     * @return array
     */
    function  VirtualDestroy(Request $request)
    {
        $ids = $request->input('ids');
        $query = VirtualComment::whereIn('id',$ids)->delete();
        if($query)
        {
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
     * @param VirtualComment $virtualComment
     */
    function  export(Request $request,VirtualComment $virtualComment)
    {
        $ids=$request->input('ids','');

        $model = $virtualComment->query();

        //评分
        if($request->get('star')){
            $model = $model->where(['star'=>$request->get('star')]);
        }
        //评论内容
        if($request->get('content')){
            $content = $request->get('content');
            $model = $model->where('content','like',"%$content%");
        }
        if($ids){
            $ids = explode(',',$ids);
            $model=$model->whereIn('id',$ids);
        }
        $data = $model->orderBy('created_at','desc')->get();

        $data=$data->map(function ($item){
            return [
                $item->star ,
                $item->content,
            ];
        })->toArray();
        array_unshift($data,['评分','评论内容']);
        excel_export('评论导出'.date('His',time()),$data);
    }


}
