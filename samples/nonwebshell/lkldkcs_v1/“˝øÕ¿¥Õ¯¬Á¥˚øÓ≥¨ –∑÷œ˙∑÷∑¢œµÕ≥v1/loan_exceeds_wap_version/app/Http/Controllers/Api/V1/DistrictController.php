<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Models\City;
use App\Models\District;
use App\Models\HotCity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class DistrictController extends BaseController
{
    /**
     * 城市数据
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        if ($request->type == 'sort'){//排序
            if (!Redis::exists('city_sort')){//redis不存在,重新生成
                $cities = District::where(['level'=>'city'])->orderBy('initial','asc')->get(['id','adcode','name','initial']);
                if ($cities->count()==0){
                    $this->set('type',$this->noContent);
                    $this->set('info','暂无城市数据');
                }else{
                    $city_sort = [];
                    foreach($cities as $city){
                        $city->citys = District::where(['level'=>'city','initial'=>$city->initial])
                            ->get(['id','adcode','name','initial']);
                        $city_sort[$city->initial] = [
                            'initial'=>$city->initial,
                            'cities'=>$city->citys,
                        ];
                    }
                    Redis::set('city_sort',json_encode($city_sort,JSON_UNESCAPED_UNICODE));//JSON_UNESCAPED_UNICODE不转码
                }
                $data = Redis::get('city_sort');
            }else{//存在
                $data = Redis::get('city_sort');
            }
        }else{//联动
            if (!Redis::exists('linkage')){
                $provinces=District::select('id','adcode','name','level')->where('level','province')->get();
                if ($provinces->count()==0){
                    $this->set('type',$this->noContent);
                    $this->set('info','暂无城市数据');
                }else{
                    foreach ($provinces as $province){
                        $province->cities=District::select('id','adcode','name','level')->where('level','city')
                            ->where('adcode', 'like', mb_substr($province->adcode, 0, 2) . '%00')->get();
                        foreach($province->cities as $city){
                            $city->areas=District::select('id','adcode','name','level')->where('level','district')
                                ->where('adcode', 'like', mb_substr($city->adcode, 0, 4) . '%')->get();
                            foreach($city->areas as $street){
                                $street->street=District::select('id','adcode','name','level')->where('level','street')
                                    ->where('adcode', 'like', $street->adcode)->get();
                            }
                        }
                    }
                    Redis::set('linkage',json_encode($provinces,JSON_UNESCAPED_UNICODE));//JSON_UNESCAPED_UNICODE不转码
                }
                $data = Redis::get('linkage');
            }else{
                $data = Redis::get('linkage');
            }
        }
        $this->set('data',json_decode($data));
        return $this->jsonResponse();
    }


    /**
     * 添加热门城市
     * @return array
     */
    public function hotCity()
    {
        $hot_ids = HotCity::orderBy('sort','desc')->pluck('city_id')->all();
        $hot_cities = District::whereIn('id',$hot_ids)->pluck('name')->all();
        if (count($hot_cities)){
            foreach($hot_cities as &$hot_city){
                $hot_city = str_replace('城区','市',$hot_city);
            }
        }else{
            $this->set('data',null);
        }

        $this->set('data',$hot_cities);
        return $this->jsonResponse();
    }
}
