<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductColumnCreateRequest;
use App\Http\Requests\ProductColumnUpdateRequest;
use App\Models\ProductColumn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.product_column.index');
    }


    /**
     * 栏目数据
     * @param Request $request
     */
    public function data(Request $request){

        $pageSize=$request->input('limit',$this->pageSize);
        $name=$request->input('name','');
        $field=$request->input('field','sort');
        $order=$request->input('order','desc');
        $res=ProductColumn::select();
        if($name){
            $res->where('name','like',"%$name%");
        }
        $res=$res->orderBy($field,$order)->paginate($pageSize)->toArray();
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

        $productColumn=new ProductColumn();
        return view('admin.product_column.create',compact('productColumn'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductColumnCreateRequest $request)
    {

        $data=$request->except(['_method','_token']);
        if(ProductColumn::create($data)){
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

        $productColumn=ProductColumn::findOrFail($id);
        return view('admin.product_column.edit',compact('productColumn'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductColumnUpdateRequest $request, $id)
    {
        $productColumn=ProductColumn::findOrFail($id);
        $data=$request->except(['_method','_token','id']);
        if($productColumn->update($data)){
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
        $ids=$request->get('ids');
        if(!$ids){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        if(ProductColumn::whereIn('id',$ids)->delete()){
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'删除失败']);
        }
    }
}
