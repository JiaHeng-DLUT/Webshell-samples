<?php

namespace App\Http\Controllers\Admin;

use App\Models\Apply;
use App\Models\Member;
use App\Models\User;
use App\Traits\CustomExcel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApplyController extends Controller
{
    use CustomExcel;

    public function index()
    {
        return view('admin.apply.index');
    }

    public function data(Request $request,  Apply $apply)
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

        $res = $this->_query_box($request,$apply);

        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }

    public function toExcelOld(Request $request, Apply $apply)
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

        $res = $this->_query_box($request, $apply, 'excel');

        if($res){
            $result = [];
            $result[] = ['用户电话','产品类型','意向产品','申请平台','意向时间','申请来源渠道','注册来源渠道','注册来源平台','分发页','	
渠道所属部门','渠道负责人'];
            foreach($res as $item){

                if($item['type']=='product'){
                    $item['type'] = '贷款';
                    $item['product_name'] = $item['product']['name'];
                }elseif($item['type']=='credit'){
                    $item['type'] = '信用卡';
                    $item['product_name'] = $item['credit']['name'];
                }

                $arr = [];
//                $arr[] = $item['id'];
                $arr[] = $item['member']['phone']??'';
                $arr[] = $item['type'];
                $arr[] = $item['product_name'];
                $arr[] = $item['platform'];
                $arr[] = $item['created_at'];
                $arr[] = $item['channel']['channel_name']??'';
                $arr[] = $item['member']['channel']['channel_name']??'';
                $arr[] = $item['member']['platform_register']??'';
                $arr[] = $item['register_page']['name']??'';
                $arr[] = $item['channel']['department']['name']??'';
                $arr[] = $item['channel']['manager']??'';
                $result[] = $arr;
            }

            $title = '用户信息'.date('YmdHis');
            $this->excelExport($title, $result );
            die();
        }
    }

    public function toExcel(Request $request, Apply $apply)
    {
        set_time_limit(0);
        ini_set("memory_limit","1024M");
        $header = array(
            '用户电话'=>'string',
            '产品类型'=>'string',
            '意向产品'=>'string',
            '申请平台'=>'string',
            '意向时间'=>'string',
            '申请来源渠道'=>'string',
            '注册来源渠道'=>'string',
            '注册来源平台'=>'string',
            '分发页'=>'string',
            '渠道所属部门'=>'string',
            '渠道负责人'=>'string',
        );
//        echo '#'.floor((memory_get_peak_usage())/1024/1024)."MB"."\n";exit;
        $data = $this->_query_box($request,$apply,'excel');
//        echo '#'.floor((memory_get_peak_usage())/1024/1024)."MB"."\n";exit;
        $last_data = [];
        foreach ($data as $k=>$datum){
            if($datum['type']=='product'){
                $datum['type'] = '贷款';
                $datum['product_name'] = $datum['product']['name'];
            }elseif($datum['type']=='credit'){
                $datum['type'] = '信用卡';
                $datum['product_name'] = $datum['credit']['name'];
            }
            $last_data[$k]['phone'] = $datum['member']['phone']??'';
            $last_data[$k]['type'] = $datum['type']??'';
            $last_data[$k]['product_name'] = $datum['product_name'];
            $last_data[$k]['platform'] = $datum['platform']??'';
            $last_data[$k]['created_at'] = date('Y-m-d H:i:s',strtotime($datum['created_at']));
            $last_data[$k]['channel_name'] = $datum['channel']['channel_name']??'';
            $last_data[$k]['member_channel_name'] = $datum['member']['channel']['channel_name']??'';
            $last_data[$k]['platform_register'] = $datum['member']['platform_register']??'';
            $last_data[$k]['register_page_name'] = $datum['register_page']['name']??'';
            $last_data[$k]['department_name'] = $datum['channel']['department']['name']??'';
            $last_data[$k]['manager'] = $datum['channel']['manager']??'';
        }

        if(!file_exists(storage_path('app/public/excel')))
            mkdir(storage_path('app/public/excel'));

        $file_name = storage_path('app/public/excel/').'test.xlsx';
        $writer = new \XLSXWriter();
        $writer->writeSheetHeader('Sheet1', $header );
        foreach($last_data as $row){
            $writer->writeSheetRow('Sheet1', $row );
        }

        $writer->writeToFile($file_name);
        download('test.xlsx','意向管理.xlsx');
    }


    public function _query_box($request,$model,$type='index')
    {
        $user = User::find(auth()->user()->id);

        $model = $model->query();
        if($request->get('start_time')){
            $model = $model->where('created_at','>',$request->get('start_time'));
        }
        if($request->get('end_time')){
            $model = $model->where('created_at','<=',$request->get('end_time'));
        }
        if ($request->get('type')){
            $model = $model->where('type',$request->get('type'));
        }
        if ($request->get('platform')){
            $model = $model->where('platform',$request->get('platform'));
        }
        if ($request->get('channel_code')){
            $model = $model->where('channel_code',$request->get('channel_code'));
        }
        if ($request->get('department_id')){
            $model = $model->whereHas('channel',function ($q) use($request){
                $q->where('department_id','=',$request->get('department_id'));
            });
        }
        if($request->get('phone')){

            $model = $model->whereHas('member',function ($query) use($request){

                if($request->get('phone')){
                    $phone = $request->get('phone');
                    $query->where('phone','like',"%$phone%");
                }

            });
        }
        if($request->get('manager')){

            $model = $model->whereHas('channel',function ($query) use($request){

                if($request->get('manager')){
                    $manager = $request->get('manager');
                    $query->where('manager','like',"%$manager%");
                }

            });
        }
        if($request->ids){
            $model = $model->whereIn('id',explode(',',$request->ids));
        }
        $res = [];
        if($type=='index'){
            $res = $model->orderBy('created_at','desc')->with(['product','credit','channel'=>function($query){
                $query->with(['department']);
            },'registerPage','member'=>function($query){
                $query->with(['channel']);
            }])->paginate($request->get('limit',30))->toArray();
            if(!$user->isRoot()){
                foreach ($res['data'] as $k=>$re){
                    $res['data'][$k]['member']['phone'] = substr_replace($re['member']['phone'], '****', 3, 5);

                }
            }
        }elseif($type='excel'){
            $res = $model->orderBy('created_at','desc')->with(['product','credit','channel'=>function($query){
                $query->with(['department']);
            },'registerPage','member'=>function($query){
                $query->with(['channel']);
            }])->get()->toArray();

            if(!$user->isRoot()){
                foreach ($res as $k=>$re){
                    $res[$k]['member']['phone'] = substr_replace($re['member']['phone'], '****', 3, 5);
                }
            }
        }


        return $res;
    }
    
}
