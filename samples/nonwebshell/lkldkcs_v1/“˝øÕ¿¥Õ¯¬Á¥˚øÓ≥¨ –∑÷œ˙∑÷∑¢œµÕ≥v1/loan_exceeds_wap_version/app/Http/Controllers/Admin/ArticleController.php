<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Corner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category  = ArticleCategory::get();
        return view('admin.website.article.index',compact('category'));
    }

    public function data(Request $request, Article $article)
    {
        if($request->get('end_time')<$request->get('start_time')){
            $data = [
                'code' => 1,
                'msg'   => '结束时间不能小于开始时间',
                'count' => '',
                'data'  => ''
            ];
            return response()->json($data);
        }

        $field=$request->get('field');
        $order=$request->get('order');
        $model = $article->query();
        if($request->get('start_time')){
            $model = $model->where('created_at','>',$request->get('start_time'));
        }
        if($request->get('end_time')){
            $model = $model->where('created_at','<=',$request->get('end_time'));
        }
        if ($request->get('category_id')){
            $model = $model->where('category_id',$request->get('category_id'));
        }
        if ($request->get('title')){
            $model = $model->where('title','like','%'.$request->get('title').'%');
        }
        if($field && $order){
            if($field=='created_at'){
                $model=$model->orderBy($field,$order);
            }elseif ($field=='updated_at'){
                $model=$model->orderBy($field,$order);
            }else{
                $model=$model->orderBy($field,$order);
            }
        }
        $res = $model->orderBy('created_at','desc')->with(['corner','category'])->paginate($request->get('limit',30))->toArray();
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
        $article = new Article();
        $categories  = ArticleCategory::get();
        $corners = Corner::where(['type'=>'article'])->get();
        return view('admin.website.article.create',compact('categories','corners','article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request, Article $article)
    {
        $data = $request->all();
//        dd($data);
        $article->create($data);
        return redirect()->route('admin.website.article')->with('status', '发现管理添加成功！');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::find($id);
        $categories  = ArticleCategory::get();
        $corners = Corner::where(['type'=>'article'])->get();
        return view('admin.website.article.edit',compact('categories','corners','article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $article = Article::findOrFail($id);
        $data = $request->all();
        if ($article->update($data)){

            return redirect(route('admin.website.article'))->with(['status'=>'更新成功']);
        }
        return redirect(route('admin.website.article'))->withErrors(['status'=>'系统错误']);
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
        foreach (Article::whereIn('id',$ids)->get() as $model){
            //删除文章
            $model->delete();
        }
        return response()->json(['code'=>0,'msg'=>'删除成功']);
    }


    public function status(Request $request)
    {
//        dd($request->all());
        $status=$request->input('status');
        $id=$request->input('id');
        $article=Article::find($id);
        if(!$article){
            return response()->json(['code'=>1,'msg'=>'发现资讯不存在或已被删除']);
        }

        if($status==1){
            $article->status=0;
            $res = $this->verifyStatus('article',$id);
            if($res['code'] == 1){
                return response()->json(['code'=>1,'msg'=>$res['msg']]);
            }
        }else{
            $article->status=1;
        }
        if($article->save()){
            return response()->json(['code'=>0,'msg'=>'操作成功','status'=>$article->status]);
        }else{
            return response()->json(['code'=>1,'msg'=>'操作失败']);
        }
    }
}
