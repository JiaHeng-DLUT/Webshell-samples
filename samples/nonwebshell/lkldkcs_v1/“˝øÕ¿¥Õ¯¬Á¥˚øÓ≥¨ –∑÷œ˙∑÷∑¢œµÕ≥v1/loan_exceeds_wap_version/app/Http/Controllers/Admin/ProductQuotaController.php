<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dictionary;
use App\Models\ProductRangeMoney;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductQuotaController extends Controller
{
    public function index(){

        $quotas=ProductRangeMoney::select()->orderBy('sort','desc')->get();
        $model=Dictionary::where(['slug'=>'product_quota'])->first();
        return view('admin.dictionary.quota',compact('quotas','model'));
    }

    public function store(Request $request){

        $news=$request->input('new');
        $old=$request->input('old');
        $arr=[];
        if($news){
            $arr_new=array_pluck($news,'type');
            $arr=array_merge($arr,$arr_new);
        }
        if($old){
            $arr_old=array_pluck($old,'type');
            $arr=array_merge($arr,$arr_old);
        }
//        $arr_unique=array_unique($arr);
//        if(count($arr_unique)!=count($arr)){
//            return response()->json(['code'=>1,'msg'=>'存在重复的贷款金额条件名称,请仔细检查']);
//        }
//        $model=Dictionary::where(['slug'=>'product_quota'])->first();
//        if(count($arr)>$model->max_num){
//            return response()->json(['code'=>1,'msg'=>"最多添加".$model->max_num."个贷款金额条件"]);
//        }
        $old_ids=$request->input('ids',[]);
        DB::beginTransaction();
        try{
            ProductRangeMoney::whereNotIn('id',$old_ids)->delete();
            if($old){
                foreach ($old as $item){
                    $id=$item['id'];
                    unset($item['id']);
                    $item['per_value']=isset($item['per_value'])?$item['per_value']:0;
                    $item['min']=isset($item['min'])?$item['min']:0;
                    $item['max']=isset($item['max'])?$item['max']:0;
                    ProductRangeMoney::where(['id'=>$id])->update($item);
                }
            }
            if($news){
                foreach ($news as $value){
                    ProductRangeMoney::create($value);
                }
            }
            $names=[];
            $query=ProductRangeMoney::select()->orderBy('sort','desc');
            $quotas=$query->get();
            if($quotas->count()){
                foreach ($quotas as $quota){
                    $range='';
                    if($quota->type==2){
                        $name=$quota->min.'~'.$quota->max;
                    }else{
                        $name=$quota->per_value;
                        if($quota->type==1){
                            $range='以下';
                        }else{
                            $range='以上';
                        }
                    }
                    if($quota->unit=='yuan'){
                        $name.='元'.$range;
                    }else{
                        $name.='万'.$range;
                    }
                    $names[]=$name;
                }
            }
            Dictionary::where(['slug'=>'product_quota'])->update([
                'content'=>implode('、',$names),
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
