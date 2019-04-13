<?php

namespace App\Http\Controllers\Admin;

use App\Models\Dictionary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DictionaryController extends Controller
{
    /**
     * 数据字典列表
     */
    public function index(){

        return view('admin.dictionary.index');
    }

    /**
     * js异步获取数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(){

        $res=Dictionary::all();
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => 1,
            'data' => $res
        ];
        return response()->json($data);
    }

    /**
     * 创建
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request){

        $dictionary=new Dictionary();
        return view('admin.dictionary.create',compact('dictionary'));
    }

    /**
     * 保存
     * @param Request $request
     */
    public function store(Request $request){

        $data=$request->only(['function_name','field_name','slug']);
        if(Dictionary::create($data)){
            return redirect()->route('admin.dictionary')->with(['status'=>'添加成功']);
        }else{
            return redirect()->back()->withErrors('添加失败');
        }
    }


}
