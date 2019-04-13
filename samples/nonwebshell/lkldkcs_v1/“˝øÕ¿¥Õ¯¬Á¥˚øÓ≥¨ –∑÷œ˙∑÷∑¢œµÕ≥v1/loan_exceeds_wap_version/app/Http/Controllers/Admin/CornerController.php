<?php

namespace App\Http\Controllers\Admin;

use App\Models\Corner;
use App\Models\Dictionary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CornerController extends Controller
{

    public function product(){

        $corners=Corner::select()->where(['type'=>'product'])->orderBy('sort','desc')->get();
        $model=Dictionary::where(['slug'=>'product_corner'])->first();
        return view('admin.dictionary.cornerProduct',compact('corners','model'));
    }

    public function storeProduct(Request $request){

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
            return response()->json(['code'=>1,'msg'=>'存在重复的贷款角标,请仔细检查']);
        }
        $model=Dictionary::where(['slug'=>'product_corner'])->first();
        if(count($arr)>$model->max_num){
            return response()->json(['code'=>1,'msg'=>'最多添加'.$model->max_num.'条贷款角标']);
        }
        $old_ids=$request->input('ids',[]);
        DB::beginTransaction();
        try{
            Corner::where(['type'=>'product'])->whereNotIn('id',$old_ids)->delete();
            if($old){
                foreach ($old as $item){
                    $id=$item['id'];
                    unset($item['id']);
                    Corner::where(['id'=>$id])->update($item);
                }
            }
            if($news){
                foreach ($news as $value){
                    Corner::create($value);
                }
            }
            $query=Corner::select()->where(['type'=>'product'])->orderBy('sort','desc');
            Dictionary::where(['slug'=>'product_corner'])->update([
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


    public function credit(){

        $corners=Corner::select()->where(['type'=>'credit'])->orderBy('sort','desc')->get();
        $model=Dictionary::where(['slug'=>'credit_corner'])->first();
        return view('admin.dictionary.cornerCredit',compact('corners','model'));
    }

    public function storeCredit(Request $request){

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
            return response()->json(['code'=>1,'msg'=>'存在重复的信用卡角标,请仔细检查']);
        }
        $model=Dictionary::where(['slug'=>'credit_corner'])->first();
        if(count($arr)>$model->max_num){
            return response()->json(['code'=>1,'msg'=>'最多添加'.$model->max_num.'条信用卡角标']);
        }
        $old_ids=$request->input('ids',[]);
        DB::beginTransaction();
        try{
            Corner::where(['type'=>'credit'])->whereNotIn('id',$old_ids)->delete();
            if($old){
                foreach ($old as $item){
                    $id=$item['id'];
                    unset($item['id']);
                    Corner::where(['id'=>$id])->update($item);
                }
            }
            if($news){
                foreach ($news as $value){
                    Corner::create($value);
                }
            }
            $query=Corner::select()->where(['type'=>'credit'])->orderBy('sort','desc');
            Dictionary::where(['slug'=>'credit_corner'])->update([
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


    public function article(){

        $corners=Corner::select()->where(['type'=>'article'])->orderBy('sort','desc')->get();
        $model=Dictionary::where(['slug'=>'article_corner'])->first();
        return view('admin.dictionary.cornerArticle',compact('corners','model'));
    }

    public function storeArticle(Request $request){

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
            return response()->json(['code'=>1,'msg'=>'存在重复的文章角标,请仔细检查']);
        }
        $model=Dictionary::where(['slug'=>'article_corner'])->first();
        if(count($arr)>$model->max_num){
            return response()->json(['code'=>1,'msg'=>'最多添加'.$model->max_num.'条文章角标']);
        }
        $old_ids=$request->input('ids',[]);
        DB::beginTransaction();
        try{
            Corner::where(['type'=>'article'])->whereNotIn('id',$old_ids)->delete();
            if($old){
                foreach ($old as $item){
                    $id=$item['id'];
                    unset($item['id']);
                    Corner::where(['id'=>$id])->update($item);
                }
            }
            if($news){
                foreach ($news as $value){
                    Corner::create($value);
                }
            }
            $query=Corner::select()->where(['type'=>'article'])->orderBy('sort','desc');
            Dictionary::where(['slug'=>'article_corner'])->update([
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
