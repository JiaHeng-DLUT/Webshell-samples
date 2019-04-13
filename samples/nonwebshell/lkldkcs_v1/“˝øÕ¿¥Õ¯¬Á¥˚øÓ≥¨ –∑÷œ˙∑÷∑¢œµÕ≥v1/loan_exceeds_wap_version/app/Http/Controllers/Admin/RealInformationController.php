<?php

namespace App\Http\Controllers\Admin;

use App\Models\RealInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RealInformationController extends Controller
{
    public function index()
    {
        return view('admin.real_information.index');
    }

    public function  data(Request $request,RealInformation $realInformation)
    {
        $model = $realInformation->query();
        $res = $model->with('member') ->orderBy('created_at','desc')
                                ->paginate($request->get('limit',$this->pageSize))->toArray();
        $data = [
          'code' => 0,
          'msg'   => '正在请求中...',
          'count' => $res['total'],
          'data'  => $res['data']
        ];
        return response()->json($data);
    }

    public function  show($id)
    {
        $info = RealInformation::where('id',$id)->with('member')->with('provinceName')
          ->with('cityName')->with('districtName')->first();
        return view('admin.real_information.show',compact('info'));
    }
}
