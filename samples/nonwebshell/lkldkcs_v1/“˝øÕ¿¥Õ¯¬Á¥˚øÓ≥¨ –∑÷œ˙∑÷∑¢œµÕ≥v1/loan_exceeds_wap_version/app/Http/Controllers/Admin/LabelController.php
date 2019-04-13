<?php

namespace App\Http\Controllers\Admin;

use App\Models\Label;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.label.index');
    }


    public function data(Request $request){

        $pageSize=$request->input('limit',$this->pageSize);
        $res=Label::with(['channel','product'])->select()->orderBy('created_at','asc')->paginate($pageSize)->toArray();
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
        return view('admin.label.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'name'=>'required|unique:labels'
        ],[
            'name.required'=>'请填写标签名称',
            'name.unique'=>'该标签名称已存在'
        ]);
        $request->merge(['status'=>1]);
        if(Label::create($request->all())){
            return response()->json(['code'=>0,'msg'=>'保存成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'保存失败']);
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
        $label=Label::findOrFail($id);
        return view('admin.label.edit',compact('label'));
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
        $this->validate($request,[
            'name'=>'required|unique:labels,name,'.$id.',id'
        ],[
            'name.required'=>'请填写标签名称',
            'name.unique'=>'该标签名称已存在'
        ]);
        $data=$request->except(['_token','_method']);
        if(Label::where(['id'=>$id])->update($data)){
            return response()->json(['code'=>0,'msg'=>'修改成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'修改失败']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->input('id');
        if(Label::where(['id'=>$id])->delete()){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'删除失败']);
        }
    }


    /**
     * 上下架
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function status(Request $request){

        $id=$request->input('id');
        $status=$request->input('status');
        $label=Label::findOrFail($id);
        if($status=='true'){
            $label->status=1;
        }else{
            $label->status=0;
        }
        if($label->save()){
            return response()->json(['code'=>0,'msg'=>'操作成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'操作失败']);
        }
    }
}
