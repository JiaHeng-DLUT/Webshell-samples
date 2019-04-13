<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductCategoryCreateRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.product_category.index');
    }


    public function data(Request $request){
        $pageSize=$request->input('limit',$this->pageSize);
        $field=$request->input('field','sort');
        $order=$request->input('order','desc');
        $res=ProductCategory::select();
        $res=$res->orderBy($field,$order)->paginate($pageSize)->toArray();
        if($res['data']){
            foreach ($res['data'] as $key=>$item){
                $item['icon']=env('IMG_URL').$item['icon'];
                $item['banner']=env('IMG_URL').$item['banner'];
                $res['data'][$key]=$item;
            }
        }
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
        $productCategory=new ProductCategory();
        return view('admin.product_category.create',compact('productCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryCreateRequest $request)
    {
        $data=$request->except(['_method','_token']);
        if(ProductCategory::create($data)){
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
        $productCategory=ProductCategory::findOrFail($id);
        return view('admin.product_category.edit',compact('productCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryUpdateRequest $request, $id)
    {
        $data=$request->except(['_method','_token','id','file']);
        if(!$data['redirect_type']){
            $data['redirect_slug']=null;
            $data['redirect_id']=null;
            $data['banner_redirect']=null;
        }else{
            if($data['redirect_type']=='inside'){
                $data['banner_redirect']=null;
                if(!in_array($data['redirect_slug'],['product','credit','article'])){
                    $data['redirect_id']=null;
                }
            }else{
                $data['redirect_slug']=null;
                $data['redirect_id']=null;
            }
        }

        if(ProductCategory::where(['id'=>$id])->update($data)){
            return response()->json(['code'=>0,'msg'=>'保存成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'保存失败']);
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
        DB::beginTransaction();
        try{
            $icons=ProductCategory::whereIn('id',$ids)->pluck('icon')->all();
            $banners=ProductCategory::whereIn('id',$ids)->pluck('banner')->all();
            if($icons){
                foreach ($icons as $k=>$icon){
                    $icons[$k]='public/'.$icon;
                }
                Storage::delete($icons);
            }
            if($banners){
                foreach ($banners as $k=>$banner){
                    $banners[$k]='public/'.$banner;
                }
                Storage::delete($banners);
            }
            ProductCategory::whereIn('id',$ids)->delete();
            DB::commit();
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }catch (\Exception $exception){
            return response()->json(['code'=>1,'msg'=>'删除失败'.$exception->getMessage()]);
        }

    }
}
