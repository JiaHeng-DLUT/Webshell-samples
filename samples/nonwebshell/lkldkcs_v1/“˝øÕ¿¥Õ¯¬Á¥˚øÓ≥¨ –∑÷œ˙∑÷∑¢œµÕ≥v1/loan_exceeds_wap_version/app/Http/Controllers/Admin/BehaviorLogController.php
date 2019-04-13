<?php

namespace App\Http\Controllers\Admin;

use App\Models\BehaviorLog;
use App\Models\Channel;
use App\Models\Product;
use App\Models\User;
use App\Traits\CustomExcel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BehaviorLogController extends Controller
{

    use CustomExcel;

    public function index(){
        //注册渠道
        $register_channel_name = BehaviorLog::select('register_channel_name')->groupBy('register_channel_name')->get();
        //注册分发页
        $register_page_name = BehaviorLog::select('register_page_name')->groupBy('register_page_name')->get();
        //操作渠道
        $operate_channel_name = BehaviorLog::select('operate_channel_name')->groupBy('operate_channel_name')->get();
        //操作分发页
        $operate_page_name = BehaviorLog::select('operate_page_name')->groupBy('operate_page_name')->get();
//        dump($register_channel_name);
        return view('admin.behaviorlog.index',compact('register_channel_name','register_page_name','operate_channel_name','operate_page_name'));
    }

    public function data(Request $request, BehaviorLog $behaviorLog)
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

        $res = $this->_query_box($request,$behaviorLog);
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }


    public function toExcel(Request $request, BehaviorLog $behaviorLog)
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

        $res = $this->_query_box($request,$behaviorLog,'excel');

        if($res){

            $result = [];
            $result[] = ['操作时间','用户电话','产品类型','注册渠道','注册分发页','操作类型','操作渠道','操作平台','操作分发页','操作参数'];
            foreach($res as $item){
                $item['operate_params'] = collect(json_decode($item['operate_params']))->toArray();

                if($item['operate_params'] != ""){
                    if($item['operate_type'] == 6){
                        if($item['operate_params']['name'] != ""){
                            $operate_params =  '类别：'.$item['operate_params']['name'];
                        }else{
                            $operate_params = "";
                        }
                    }else if($item['operate_type'] == 5 || $item['operate_type'] == 8){
                        $operate_params =  '产品：'.$item['operate_params']['name'];
                    }else{
                        $html = '';

                        if(isset($item['operate_params']['name']) && $item['operate_params']['name'] != ""){
                            $html .=' 产品：'.$item['operate_params']['name'];

                        }
                        if(isset($item['operate_params']['from']) && $item['operate_params']['from'] != ""){
                            $html .=' 访问来源：'.$item['operate_params']['from'];
                        }
                        $operate_params = $html;
                    }

                }else{
                    $operate_params = '';
                }

                switch ($item['operate_type']){
                    case 1:
                        $item['product_type'] = '';
                        break;
                    case 2:
                        $item['product_type'] = '';
                        break;
                    case 3:
                        $item['product_type'] = '';
                        break;
                    case 4:
                        $item['product_type'] = '贷款产品';
                        break;
                    case 5:
                        $item['product_type'] = '贷款产品';
                        break;
                    case 6:
                        $item['product_type'] = '贷款产品';
                        break;
                    case 7:
                        $item['product_type'] = '信用卡';
                        break;
                    case 8:
                        $item['product_type'] = '信用卡';
                        break;
                    case 11:
                        $item['product_type'] = '';
                        break;
                    case 22:
                        $item['product_type'] = '';
                        break;
                    case 103:
                        $item['product_type'] = '';
                        break;
                    default:
                        break;
                }
//                dd($operate_params);
                switch ($item['operate_type']){
                    case 1:
                        $item['operate_type'] = '注册';
                        break;
                    case 2:
                        $item['operate_type'] = '登陆';
                        break;
                    case 3:
                        $item['operate_type'] = '启动app';
                        break;
                    case 4:
                        $item['operate_type'] = '查看贷款产品详情';
                        break;
                    case 5:
                        $item['operate_type'] = '申请贷款产品';
                        break;
                    case 6:
                        $item['operate_type'] = '查看贷款分类';
                        break;
                    case 7:
                        $item['operate_type'] = '查看信用卡产品详情';
                        break;
                    case 8:
                        $item['operate_type'] = '申请信用卡产品';
                        break;
                    case 11:
                        $item['operate_type'] = '未加密注册';
                        break;
                    case 22:
                        $item['operate_type'] = '未加密登录';
                        break;
                    case 103:
                        $item['operate_type'] = '未定义操作';
                        break;
                    default:
                        break;
                }




//                dd($item);
                $arr = [];
                $arr[] = $item['created_at'];
                $arr[] = $item['phone']??'';
                $arr[] = $item['product_type']??'';
                $arr[] = $item['register_channel_name'];
                $arr[] = $item['register_page_name']??'';
                $arr[] = $item['operate_type']??'';
                $arr[] = $item['operate_channel_name']??'';
                $arr[] = $item['operate_platform'];
                $arr[] = $item['operate_page_name'];
                $arr[] = $operate_params;
                $result[] = $arr;
            }

            $title = '用户信息'.date('YmdHis');
            $this->excelExport($title, $result );
            die();
        }
    }


    public function _query_box($request, $model, $type='index')
    {
        $user = User::find(auth()->user()->id);
        $model = $model->query();
        if($request->get('start_time')){
            $model = $model->where('created_at','>',$request->get('start_time'));
        }
        if($request->get('end_time')){
            $model = $model->where('created_at','<=',$request->get('end_time'));
        }
        if($request->get('product_type')){
            if($request->get('product_type')==1){
                if ($request->get('operate_type')){
                    $model = $model->where('operate_type',$request->get('operate_type'));
                }else{
                    $model = $model->whereIn('operate_type',['4','5','6']);
                }
            }elseif($request->get('product_type')==2){
                if ($request->get('operate_type')){
                    $model = $model->where('operate_type',$request->get('operate_type'));
                }else{
                    $model = $model->whereIn('operate_type',['7','8']);
                }

            }
        }else{
            if ($request->get('operate_type')){
                $model = $model->where('operate_type',$request->get('operate_type'));
            }
        }

        if ($request->get('register_channel_name')){
            $model = $model->where('register_channel_name',$request->get('register_channel_name'));
        }
        if ($request->get('register_page_name')){
            $model = $model->where('register_page_name',$request->get('register_page_name'));
        }
        if ($request->get('operate_platform')){
            $model = $model->where('operate_platform',$request->get('operate_platform'));
        }
        if ($request->get('operate_channel_name')){
            $model = $model->where('operate_channel_name',$request->get('operate_channel_name'));
        }

        if ($request->get('operate_page_name')){
            $model = $model->where('operate_page_name',$request->get('operate_page_name'));
        }

        if ($request->get('phone')){
            $model = $model->where('phone','like','%'.$request->get('phone').'%');
        }

        if($request->ids){
            $model = $model->whereIn('id',explode(',',$request->ids));
        }
        $res = [];
        if($type=='index'){
            $res = $model->orderBy('created_at','desc')->with(['registerChannel','registerPage','operateChannel','operatePage'])->paginate($request->get('limit',30))->toArray();

            foreach ($res['data'] as $k=>$re){

                if(!$user->isRoot()){
                    $res['data'][$k]['phone'] = substr_replace($re['phone'], '****', 3, 5);

                }

//                dd(collect(json_decode($re['operate_params']))->toArray());
                $operate_params = collect(json_decode($re['operate_params']))->toArray();
                $res['data'][$k]['operate_params'] = $operate_params;
               /* $operate_params = collect(json_decode($re['operate_params']))->toArray();

                if($re['operate_type'] == 4 || $re['operate_type'] == 5){
                    //查看贷款产品详情 || 申请贷款产品
                    $res['data'][$k]['product_name'] =  Product::select('name')->where(['id'=>$operate_params['id']])->first();

                }
                elseif ($re['operate_type'] == 6) {
                    //查看贷款分类
                    $res['data'][$k]['channel_name'] =Channel::select('channel_name')->where(['channel_code'=>$operate_params['channel']])->first();
                }
                elseif ($re['operate_type'] == 7 || $re['operate_type'] == 8) {
                    //查看信用卡产品 || 申请信用卡产品
                    $res['data'][$k]['product_name'] = Product::select('name')->where(['id'=>$operate_params['id']])->first();
                }*/
            }


        }elseif($type=='excel'){
            $res = $model->orderBy('created_at','desc')->with(['registerChannel','registerPage','operateChannel','operatePage'])->get()->toArray();
            foreach ($res as $k=>$re){

                if(!$user->isRoot()){
                    $res[$k]['phone'] = substr_replace($re['phone'], '****', 3, 5);

                }
            }
        }

//        dd($res);

        return $res;
    }
}
