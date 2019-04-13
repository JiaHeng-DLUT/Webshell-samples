<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\VirtualPhoneCreateRequest;
use App\Models\VirtualPhone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class VirtualPhoneController extends Controller
{
    protected $phones=[];

    protected $error=0;

    protected $msg='';

    protected $exist_phones=[];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.virtual_phone.index');
    }

    /**
     * 虚拟号码数据
     * @param Request $request
     */
    public function data(Request $request){

        $pageSize=$request->input('limit',$this->pageSize);
        $res=VirtualPhone::orderBy('created_at','desc')->paginate($pageSize)->toArray();
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.virtual_phone.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VirtualPhoneCreateRequest $request)
    {
        $filename=storage_path('app').'/'.$request->input('path');
        Excel::load($filename, function($reader) {

            $reader->each(function ($sheet){

                if($sheet->count()){
                    $heading=$sheet->getHeading();
                    if($heading && $heading[0]=='phone'){
                        $sheet->each(function ($row){
                            $phone="".$row->phone;
                            if(preg_match("/^1[3456789]\d{9}$/", $phone)){
                                $this->phones[]=$phone;
                            }else{
                                $this->error++;
                                $this->msg='手机号'.$phone.'格式不正确';
                            }

                        });
                    }else{
                        $this->error++;
                        $this->msg='Excel格式有误';
                    }
                }
            });
        });
        if(!$this->error){
            $db_phones=VirtualPhone::pluck('phone')->all();
            $this->exist_phones=array_intersect($this->phones,$db_phones);
            if($import_type=$request->import_type=='append'){
                $dif_phones=array_diff($this->phones,$db_phones);
            }else{
                $dif_phones=$this->phones;
            }
            $phones=[];
            if($dif_phones){
                foreach ($dif_phones as $dif_phone){
                    if(!in_array($dif_phone,array_pluck($phones,'phone'))){
                        $phones[]=['phone'=>$dif_phone,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')];
                    }else{
                        $this->exist_phones[]=$dif_phone;
                    }
                }
            }
            if($phones){
                if($import_type=='append'){ //追加
                    if(DB::table('virtual_phones')->insert($phones)){
                        return response()->json(['code'=>0,'msg'=>"保存成功,成功导入".count($phones)."条,重复".count($this->exist_phones)."条未导入"]);
                    }else{
                        return response()->json(['code'=>1,'msg'=>'保存失败']);
                    }
                }else{ //覆盖

                    DB::beginTransaction();
                    try{
                        DB::table('virtual_phones')->truncate() ;
                        DB::table('virtual_phones')->insert($phones);
                        Storage::delete($request->input('path'));
                        DB::commit();
                        return response()->json(['code'=>0,'msg'=>"保存成功,成功导入".count($phones)."条"]);
                    }catch (\Exception $exception){
                        DB::rollBack();
                        return response()->json(['code'=>1,'msg'=>'保存失败'.$exception->getMessage()]);
                    }
                }
            }else{
                return response()->json(['code'=>1,'msg'=>'导入号码为空或全部已存在于号码池']);
            }
        }else{
            return response()->json(['code'=>1,'msg'=>$this->msg]);
        }
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
        //
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
    public function destroy(Request $request)
    {

        $ids=$request->get('ids');
        if(VirtualPhone::whereIn('id',$ids)->delete()){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'删除失败']);
        }
    }

    /**
     * 一键清空
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyAll(Request $request)
    {
        if(VirtualPhone::truncate()){
            return response()->json(['code'=>0,'msg'=>'清空成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'清空失败']);
        }
    }
}
