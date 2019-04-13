<?php

namespace App\Http\Controllers\Admin;

use App\Models\CreditOrganization;
use App\Models\Dictionary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CreditOrgController extends Controller
{
    public function index(Request $request){

        $organizations=CreditOrganization::select()->orderBy('sort','desc')->get();
        $model=Dictionary::where(['slug'=>'credit_organization'])->first();
        return view('admin.dictionary.organization',compact('organizations','model'));
    }

    public function store(Request $request){

        $news=$request->input('new');
        $old=$request->input('old');
        $arr=[];
        if($news){
            $arr_new=array_pluck($news,'name');
            $arr=array_merge($arr,$arr_new);
        }
        if($old){
            $arr_old=array_pluck($old,'name');
            $arr=array_merge($arr,$arr_old);
        }
        $arr_unique=array_unique($arr);
        if(count($arr_unique)!=count($arr)){
            return response()->json(['code'=>1,'msg'=>'存在重复的卡组织名称,请仔细检查']);
        }
        $model=Dictionary::where(['slug'=>'credit_organization'])->first();
        if(count($arr)>$model->max_num){
            return response()->json(['code'=>1,'msg'=>'最多添加'.$model->max_num.'个卡组织']);
        }
        $old_ids=$request->input('ids',[]);
        DB::beginTransaction();
        try{
            CreditOrganization::whereNotIn('id',$old_ids)->delete();
            if($old){
                foreach ($old as $item){
                    $id=$item['id'];
                    unset($item['id']);
                    CreditOrganization::where(['id'=>$id])->update($item);
                }
            }
            if($news){
                foreach ($news as $value){
                    CreditOrganization::create($value);
                }
            }
            $query=CreditOrganization::select()->orderBy('sort','desc');
            Dictionary::where(['slug'=>'credit_organization'])->update([
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
