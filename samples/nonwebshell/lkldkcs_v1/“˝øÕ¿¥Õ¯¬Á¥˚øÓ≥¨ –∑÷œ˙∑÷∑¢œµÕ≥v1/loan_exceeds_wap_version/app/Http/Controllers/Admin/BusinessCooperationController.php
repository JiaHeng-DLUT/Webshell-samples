<?php

namespace App\Http\Controllers\Admin;

use App\Models\BusinessCooperation;
use App\Models\Dictionary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BusinessCooperationController extends Controller
{
    //
    public function index(Request $request){

        $categories=BusinessCooperation::select()->orderBy('id','desc')->get();
        $model=Dictionary::where(['slug'=>'business_cooperation'])->first();
        return view('admin.dictionary.businessCooperation',compact('categories','model'));
    }

    /**
     * 描述：
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){


        $news=$request->input('new');
        $old=$request->input('old');
        $arr=[];

        if($news){
            $arr_new=array_pluck($news,'phone');
            $arr=array_merge($arr,$arr_new);
        }
        if($old){
            $arr_old=array_pluck($old,'phone');
            $arr=array_merge($arr,$arr_old);
        }
        $arr_unique=array_unique($arr);
        if(count($arr_unique)!=count($arr)){
            return response()->json(['code'=>1,'msg'=>'存在重复的手机号码,请仔细检查']);
        }
        $model=Dictionary::where(['slug'=>'feedback_category'])->first();
        if(count($arr)>$model->max_num){
            return response()->json(['code'=>1,'msg'=>'最多添加'.$model->max_num.'个联系人']);
        }
        $old_ids=$request->input('ids',[]);
        DB::beginTransaction();
        try{
            BusinessCooperation::whereNotIn('id',$old_ids)->delete();
            if($old){
                foreach ($old as $item){
                    $id=$item['id'];
                    unset($item['id']);
                    BusinessCooperation::where(['id'=>$id])->update($item);
                }
            }
            if($news){
                foreach ($news as $value){
                    BusinessCooperation::create($value);
                }
            }
            $query=BusinessCooperation::select()->orderBy('id','desc');
            Dictionary::where(['slug'=>'business_cooperation'])->update([
              'content'=>implode('、',$query->pluck('name')->all()),
              'model_ids'=>$query->pluck('id')->toJson()
            ]);
            DB::commit();
            return response()->json(['code'=>0,'msg'=>'保存成功']);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json(['code'=>1,'msg'=>'保存失败'.$exception->getMessage()]);
        }
    }
}
