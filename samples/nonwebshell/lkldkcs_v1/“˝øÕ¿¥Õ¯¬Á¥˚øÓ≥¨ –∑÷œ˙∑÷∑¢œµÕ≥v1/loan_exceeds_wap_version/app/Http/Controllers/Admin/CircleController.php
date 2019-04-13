<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CircleRequest;
use App\Models\Circle;
use App\Models\Help;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CircleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('admin.website.circle.index');
    }

    public function data(Request $request)
    {
        $model = Circle::query();

        $res = $model->orderBy('created_at','desc')->paginate($request->get('limit',30))->toArray();
        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
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
        $slug =Circle::pluck('slug')->toArray();
        return view('admin.website.circle.create',compact('slug'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CircleRequest $request)
    {
        $data = $request->all();
        Circle::create($data);
        return redirect()->route('admin.website.circle')->with('status', '圈子添加成功！');
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
        $circle = Circle::find($id);
        $slug =Circle::pluck('slug')->toArray();
        return view('admin.website.circle.edit',compact('circle','slug'));

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
        $circle = Circle::findOrFail($id);
        $data = $request->all();
        if ($circle->update($data)){

            return redirect(route('admin.website.circle'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.website.circle'))->withErrors(['status'=>'系统错误']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->get('ids');
        if (empty($ids)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        foreach (Circle::whereIn('id',$ids)->get() as $model){
            //删除文章
            $model->delete();
        }
        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }
}
