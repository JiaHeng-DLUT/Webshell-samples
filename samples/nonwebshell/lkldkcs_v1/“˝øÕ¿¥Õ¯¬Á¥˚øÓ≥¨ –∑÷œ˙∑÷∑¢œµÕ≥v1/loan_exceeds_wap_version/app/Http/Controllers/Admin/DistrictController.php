<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\HotCityCreateRequest;
use App\Http\Requests\HotCityUpdateRequest;
use App\Models\District;
use App\Models\HotCity;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class DistrictController extends Controller
{

    /**
     * 省市区列表
     */
    public function index(){

        return view('admin.district.index');
    }

    /**
     * 省市区数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function data(Request $request){

        $parent_id=$request->input('parent_id',0);
        $pageSize=$request->input('limit',$this->pageSize);
        $res=District::where(['parent_id'=>$parent_id])->paginate($pageSize)->toArray();
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * 热门城市列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hotCity(){

        return view('admin.district.hot_city');
    }

    /**
     * 热门城市数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function hotCityData(Request $request){

        $pageSize=$request->input('limit',$this->pageSize);
        $res=HotCity::with(['city'])->orderBy('sort','desc')->paginate($pageSize)->toArray();
        $data = [
            'code' => 0,
            'msg' => '正在请求中...',
            'count' => $res['total'],
            'data' => $res['data']
        ];
        return response()->json($data);
    }

    /**
     * 热门城市添加
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hotCityCreate(){
        $provinces=District::where(['parent_id'=>0])->get();
        $city=new HotCity();
        $cities=new Collection([]);
        return view('admin.district.hot_city_create',compact('provinces','city','cities'));
    }

    /**
     * 热门城市保存
     * @param Request $request
     */
    public function hotCityStore(HotCityCreateRequest $request){

        $count=HotCity::count();
        if($count>=50){
            return response()->json(['code'=>1,'msg'=>'最多50个热门城市，请先取消一些城市的热门标记']);
        }
        $data=$request->except(['_method','_token','province_id']);
        if(HotCity::create($data)){
            $this->syncHotCities();
            return response()->json(['code'=>0,'msg'=>'添加成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'添加失败']);
        }
    }

    /**
     * 热门城市编辑
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function hotCityEdit($id){

        $provinces=District::where(['parent_id'=>0])->get();
        $city=HotCity::findOrFail($id);
        $cities=District::where(['parent_id'=>$city->city->parent_id])->get();
        return view('admin.district.hot_city_edit',compact('provinces','city','cities'));
    }

    public function hotCityUpdate(HotCityUpdateRequest $request,$id){

        $data=$request->except(['_method','_token','province_id']);
        if(HotCity::where(['id'=>$id])->update($data)){
            $this->syncHotCities();
            return response()->json(['code'=>0,'msg'=>'修改成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'修改失败']);
        }
    }



    /**
     * 热门城市移除
     * @param Request $request
     */
    public function hotCityDestroy(Request $request){

        $id=$request->input('id','');
        if(!$id){
            return response()->json(['code'=>1,'msg'=>'热门城市id不能为空']);
        }
        if(HotCity::where(['id'=>$id])->delete()){
            $this->syncHotCities();
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }else{
            return response()->json(['code'=>1,'msg'=>'删除失败']);
        }
    }

    public function getCityByProvince(Request $request){

        $id=$request->input('id',0);
        if(!$id){
            return response()->json(['code'=>1,'msg'=>'省份id不能为空']);
        }
        $cities=District::where(['parent_id'=>$id])->get();
        return response()->json(['code'=>0,'msg'=>'ok','data'=>$cities]);
    }



}
