<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dictionary;
use App\Models\ProductRangePeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductRepayController extends Controller
{
    public function index(){

        $repays=ProductRangePeriod::select()->orderBy('sort','desc')->get();
        $model=Dictionary::where(['slug'=>'product_repay'])->first();
        return view('admin.dictionary.repay',compact('repays','model'));
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
        $old_ids=$request->input('ids',[]);
        DB::beginTransaction();
        try{
            ProductRangePeriod::whereNotIn('id',$old_ids)->delete();
            if($old){
                foreach ($old as $item){
                    $id=$item['id'];
                    unset($item['id']);
                    $item['per_value']=isset($item['per_value'])?$item['per_value']:0;
                    $item['min']=isset($item['min'])?$item['min']:0;
                    $item['max']=isset($item['max'])?$item['max']:0;
                    ProductRangePeriod::where(['id'=>$id])->update($item);
                }
            }
            if($news){
                foreach ($news as $value){
                    ProductRangePeriod::create($value);
                }
            }
            $names=[];
            $query=ProductRangePeriod::select()->orderBy('sort','desc');
            $repays=$query->get();
            if($repays->count()){
                foreach ($repays as $repay){
                    $range='';
                    if($repay->type==2){
                        $name=$repay->min.'~'.$repay->max;
                    }else{
                        $name=$repay->per_value;
                        if($repay->type==1){
                            $range='以内';
                        }else{
                            $range='以上';
                        }
                    }
                    if($repay->unit=='week'){
                        $name.='周'.$range;
                    }elseif($repay->unit=='month'){
                        $name.='个月'.$range;
                    }elseif ($repay->unit=='year'){
                        $name.='年'.$range;
                    }else{
                        $name.='天'.$range;
                    }
                    $names[]=$name;
                }
            }
            Dictionary::where(['slug'=>'product_repay'])->update([
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
