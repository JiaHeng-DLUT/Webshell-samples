<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dictionary;
use App\Models\FriendshipCooperation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FriendshipCooperationController extends Controller
{

    //
    public function index(Request $request)
    {
        $type = '1';
        $categories=FriendshipCooperation::where('type',$type)->select()->orderBy('id','desc')->get();
        $model=Dictionary::where(['slug'=>'cooperation'])->first();
        return view('admin.dictionary.friendship',compact('categories','model','type'));
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
            $arr_new=array_pluck($news,'name');
            $arr=array_merge($arr,$arr_new);
        }
        if($old){
            $arr_old=array_pluck($old,'name');
            $arr=array_merge($arr,$arr_old);
        }
        $arr_unique=array_unique($arr);
        if(count($arr_unique)!=count($arr)){
            return response()->json(['code'=>1,'msg'=>'存在重复的名称,请仔细检查']);
        }
        if($news[0]['type'] ==1 || $request->type == 1)
        {
            $cate = 'cooperation';
        }elseif($news[0]['type']==2  || $request->type == 2){
            $cate = 'friendship';
        }
        $model=Dictionary::where(['slug'=>$cate])->first();
        if(count($arr)>$model->max_num){
            return response()->json(['code'=>1,'msg'=>'最多添加'.$model->max_num.'个名称']);
        }
       // $old_ids=$request->input('ids',[]);
        DB::beginTransaction();
        try{
           // FriendshipCooperation::whereNotIn('id',$old_ids)->delete();
            if($old){
                foreach ($old as $item){
                    $id=$item['id'];
                    unset($item['id']);
                    FriendshipCooperation::where(['id'=>$id])->update($item);
                }
            }
            if($news){
                foreach ($news as $value){
                    FriendshipCooperation::create($value);
                }
            }
            $query=FriendshipCooperation::select()->orderBy('id','desc');
             Dictionary::where(['slug'=>$cate])->update([
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

    //
    public function friendship(Request $request){
        $type = '2';
        $categories=FriendshipCooperation::where('type',$type)->select()->orderBy('id','desc')->get();
        $model=Dictionary::where(['slug'=>'friendship'])->first();
        return view('admin.dictionary.friendship',compact('categories','model','type'));
    }

}
