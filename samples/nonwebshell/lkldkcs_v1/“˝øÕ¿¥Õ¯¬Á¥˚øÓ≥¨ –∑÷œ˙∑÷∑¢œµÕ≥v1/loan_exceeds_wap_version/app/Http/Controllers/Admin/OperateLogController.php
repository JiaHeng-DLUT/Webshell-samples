<?php

namespace App\Http\Controllers\Admin;

use App\Models\OperateLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OperateLogController extends Controller
{

    public function index(Request $request){

        return view('admin.operate_log.index');
    }


    public function data(Request $request){

        $limit=$request->input('limit',$this->pageSize);
        $logs=OperateLog::select()->with(['user'])->orderBy('id','desc')->paginate($limit)->toArray();
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => $logs['total'],
            'data' => $logs['data']
        ];
        return response()->json($data);
    }

    /**
     * 删除
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request){

        $ids=$request->get('ids');
        if(OperateLog::whereIn('id',$ids)->delete()){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'删除失败']);
        }
    }

    /**
     * Excel导出
     * @param Request $request
     */
    public function excel(Request $request){

        $ids=$request->input('ids','');
        if($ids){
            $ids=explode(',',$ids);
        }
        $query=OperateLog::select()->with(['user']);
        if($ids){
            $query->whereIn('id',$ids);
        }
        $logs=$query->orderBy('id','desc')->get();
        $data=$logs->map(function ($item){
            return [
                $item->id,
                $item->user?$item->user->name.'('.$item->user->username.')':'',
                $item->path,
                $item->ip,
                $item->input,
                $item->created_at
            ];
        })->toArray();
        array_unshift($data,['ID','管理员','路由地址','Ip地址','请求参数','记录时间']);
        excel_export('操作日志',$data);
    }

}
