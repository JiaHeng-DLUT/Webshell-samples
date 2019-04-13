<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ImageRequest;
use App\Models\Article;
use App\Models\Credit;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.website.image.index');
    }

    public function data(Request $request, Image $image)
    {
        /*$data = [
            'code' => 1,
            'msg'   => '暂无数据',
            'count' => '',
            'data'  => ''
        ];
        $count = $image->count();*/
        $startup = $image->where(['type'=>'startup'])->first();
        $guide = $image->where(['type'=>'guide'])->first();
        $alert = $image->where(['type'=>'alert'])->first();
        $banner = $image->where(['type'=>'banner'])->first();
        $pcbanner = $image->where(['type'=>'pcbanner'])->first();
        if($startup){
            $startup_at= strtotime($startup->updated_at);
        }
        if($guide){
            $guide_at= strtotime($guide->updated_at);
        }
        if($alert){
            $alert_at= strtotime($alert->updated_at);
        }
        if($banner){
            $banner_at= strtotime($banner->updated_at);
        }

        if($pcbanner){
            $pcbanner_at= strtotime($pcbanner->updated_at);
        }

//        dd($alert_at);


            $res = [

                'data'=>[
                    /*[
                        'id'=>1,
                        'name'=>'启动页',
                        'now_number'=>$image->where(['type'=>'startup'])->count(),
                        'number'=>1,
                        'platform'=>'APP',
                        'time' => $startup_at['formatted']??'2018-11-11 12:00:00'
                    ],
                    [
                        'id'=>2,
                        'name'=>'引导页',
                        'now_number'=>$image->where(['type'=>'guide'])->count(),
                        'number'=>3,
                        'platform'=>'APP',
                        'time' => $guide_at['formatted']??'2018-11-11 12:00:00'
                    ],*/
                    [
                        'id'=>3,
                        'name'=>'首页广告-弹窗位',
                        'now_number'=>$image->where(['type'=>'alert'])->count(),
                        'number'=>1,
                        'platform'=>'APP',
                        'time' => date('Y-m-d H:i:s',$alert_at??'1541920702')
                    ],
                    [
                        'id'=>4,
                        'name'=>'首页Banner',
                        'now_number'=>$image->where(['type'=>'banner'])->count(),
                        'number'=>5,
                        'platform'=>'APP&WAP',
                        'time' => date('Y-m-d H:i:s',$banner_at??'1541920702')
                    ],
                    [
                        'id'=>5,
                        'name'=>'首页幻灯片',
                        'now_number'=>$image->where(['type'=>'pcbanner'])->count(),
                        'number'=>5,
                        'platform'=>'PC',
                        'time' => date('Y-m-d H:i:s',$pcbanner_at??'1541920702')
                    ],
                    [
                        'id'=>6,
                          'name'=>'极速贷款',
                          'now_number'=>$image->where(['type'=>'pcbanner'])->count(),
                          'number'=>5,
                          'platform'=>'PC',
                          'time' => date('Y-m-d H:i:s',$pcbanner_at??'1541920702')
                    ],
                    [
                        'id'=>7,
                        'name'=>'信用卡广告位管理',
                        'now_number'=>$image->where(['type'=>'pcbanner'])->count(),
                        'number'=>5,
                        'platform'=>'PC',
                        'time' => date('Y-m-d H:i:s',$pcbanner_at??'1541920702')
                   ],
                   [
                        'id'=>8,
                        'name'=>'发现',
                        'now_number'=>$image->where(['type'=>'pcbanner'])->count(),
                        'number'=>5,
                        'platform'=>'PC',
                        'time' => date('Y-m-d H:i:s',$pcbanner_at??'1541920702')
                   ],
                   [
                        'id'=>9,
                        'name'=>'发现',
                        'now_number'=>$image->where(['type'=>'pcbanner'])->count(),
                        'number'=>5,
                        'platform'=>'PC（旁边小广告位）',
                        'time' => date('Y-m-d H:i:s',$pcbanner_at??'1541920702')
                   ],
                   [
                        'id'=>10,
                        'name'=>'发现',
                        'now_number'=>$image->where(['type'=>'pcbanner'])->count(),
                        'number'=>5,
                        'platform'=>'PC（底部广告位）',
                        'time' => date('Y-m-d H:i:s',$pcbanner_at??'1541920702')
                   ],
                ],
                'total'=>3
            ];
//        dd($res);
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
        return view('admin.website.image.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Image $image)
    {

        $data = [
            'code' => 0,
            'msg'   => '添加成功',
            'count' => '',
            'data'  => ''
        ];
        switch ($request->id) {
            case  1:
                return $this->_store_func($image,'startup',1,$data,'启动页只能添加1个图片');
                break;
            case  2:
                return $this->_store_func($image,'guide',3,$data,'引导页最多添加3个图片');
                break;
            case  3:
                return $this->_store_func($image,'alert',1,$data,'首页广告弹窗位只能添加1个图片');
                break;
            case  4:
                return $this->_store_func($image,'banner',5,$data,'首页Banner最多添加5个图片');
                break;
            case  5:
                return $this->_store_func($image,'pcbanner',5,$data,'首页幻灯片最多添加5个图片');
                break;
            default :
                break;
        }
    }

    //提的公共方法
    public function _store_func($image, $type, $count_number, $data, $msg){
        $count = $image->where(['type'=>$type])->count();
        if($count < $count_number){
            $image->type = $type;
            $image->save();
            return response()->json($data);
        }else{

            $data = [
                'code' => 1,
                'msg'   => $msg,
                'count' => '',
                'data'  => ''
            ];
            return response()->json($data);
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
    public function edit(Image $image,$id)
    {
        $data = [];
        switch ($id) {
            case  1:
                $data = $image->where(['type'=>'startup'])->get()->toArray();
                $max_number = 1;
                $type = 'startup';
                break;
            case  2:
                $data = $image->where(['type'=>'guide'])->get()->toArray();
                $max_number = 3;
                $type = 'guide';
                break;
            case  3:
                $data = $image->where(['type'=>'alert'])->get()->toArray();
                $max_number = 1;
                $type = 'alert';
                break;
            case  4:
                $data = $image->where(['type'=>'banner'])->get()->toArray();
                $max_number = 5;
                $type = 'banner';
                break;
            case  5:
                $data = $image->where(['type'=>'pcbanner'])->get()->toArray();
                $max_number = 5;
                $type = 'pcbanner';
                break;
            case  6:
                $data = $image->where(['type'=>'pcbanner'])->get()->toArray();
                $max_number = 5;
                $type = 'pcloan';
                break;
            case  7:
                $data = $image->where(['type'=>'pcbanner'])->get()->toArray();
                $max_number = 5;
                $type = 'pccredit';
                break;
            case  8:
                $data = $image->where(['type'=>'pcbanner'])->get()->toArray();
                $max_number = 5;
                $type = 'pcfound';
                break;
            case  9:
                $data = $image->where(['type'=>'pcbanner'])->get()->toArray();
                $max_number = 5;
                $type = 'pcfoundbeside';
                break;
            case  10:
                $data = $image->where(['type'=>'pcbanner'])->get()->toArray();
                $max_number = 5;
                $type = 'pcfoundbottom';
                break;
            default :
                break;
        }
        foreach ($data as $k=>$datum){
            if($datum['redirect_type'] == 'inside'){
                $data[$k]['redirect_url'] = collect(json_decode($datum['redirect_url']))->toArray();
            }
        }
//        dump($data);
        $products = Product::where(['status'=>1])->get()->toArray();
        $credits = Credit::where(['status'=>1])->get()->toArray();
        $articles = Article::where(['status'=>1])->get()->toArray();
        return view('admin.website.image.edit',compact('id','data','max_number','type','products','credits','articles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id,Image $image)
    {
//        dd($request->all());
        $data = $request->all();

        if(isset($data['ids'])){
            $image->where(['type'=>$data['type']])->whereNotIn('id',$data['ids'])->delete();
        }else{
            $image->where(['type'=>$data['type']])->delete();
        }


        if(isset($data['new_data']) && $data['new_data']){
            foreach ( $data['new_data'] as $datum){

                if($datum['redirect_type'] == 'outside'){
                    $image->create(['type'=>$datum['type'],'url'=>$datum['url'],'redirect_type'=>$datum['redirect_type'],'redirect_url'=>$datum['redirect_url'],'sort'=>$datum['sort'],'status'=>1]);
                }elseif($datum['redirect_type'] == 'inside'){
                    $arr = [];
                    $arr['node'] = $datum['node'];
                    if($datum['node'] == 'product'){
                        $arr['id'] = $datum['product_id'];
                    }elseif($datum['node'] == 'credit'){
                        $arr['id'] = $datum['credit_id'];
                    }elseif($datum['node'] == 'article'){
                        $arr['id'] = $datum['article_id'];
                    }elseif($datum['node'] == 'help'){
                        $arr['id'] = '0';
                    }elseif($datum['node'] == 'about'){
                        $arr['id'] = '0';
                    }
//                    $arr['product_id'] = $datum['product_id'];
//                    $arr['credit_id'] = $datum['credit_id'];
//                    $arr['article_id'] = $datum['article_id'];
                    $arr = json_encode($arr);
                    $image->create(['type'=>$datum['type'],'url'=>$datum['url'],'redirect_type'=>$datum['redirect_type'],'redirect_url'=>$arr,'sort'=>$datum['sort'],'status'=>1]);
                }
            }
        }
        if(isset($data['data']) && $data['data']){
            foreach ($data['data'] as $item){
                if($item['redirect_type'] == 'outside'){
                    $image->where(['id'=>$item['id']])->update(['url'=>$item['url'],'redirect_type'=>$item['redirect_type'],'redirect_url'=>$item['redirect_url'],'sort'=>$item['sort'],'status'=>1]);
                }elseif($item['redirect_type'] == 'inside'){
                    $arr = [];
                    $arr['node'] = $item['node'];
                    if($item['node'] == 'product'){
                        $arr['id'] = $item['product_id'];
                    }elseif($item['node'] == 'credit'){
                        $arr['id'] = $item['credit_id'];
                    }elseif($item['node'] == 'article'){
                        $arr['id'] = $item['article_id'];
                    }elseif($item['node'] == 'help'){
                        $arr['id'] = '0';
                    }elseif($item['node'] == 'about'){
                        $arr['id'] = '0';
                    }
                    $arr = json_encode($arr);
                    $image->where(['id'=>$item['id']])->update(['url'=>$item['url'],'redirect_type'=>$item['redirect_type'],'redirect_url'=>$arr,'sort'=>$item['sort'],'status'=>1]);
                }

            }
        }



        return redirect()->route('admin.website.image',[$id])->with('status', '营销位更新成功！');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id, Image $image)
    {
        $data = [
            'code' => 0,
            'msg'   => '移除成功',
            'count' => '',
            'data'  => ''
        ];

        if($id){
            $res = $image->destroy($id);
            if($res){
                return response()->json($data);
            }else{
                $data = [
                    'code' => 1,
                    'msg'   => '移除失败',
                    'count' => '',
                    'data'  => ''
                ];
                return response()->json($data);
            }
        }

    }
}
