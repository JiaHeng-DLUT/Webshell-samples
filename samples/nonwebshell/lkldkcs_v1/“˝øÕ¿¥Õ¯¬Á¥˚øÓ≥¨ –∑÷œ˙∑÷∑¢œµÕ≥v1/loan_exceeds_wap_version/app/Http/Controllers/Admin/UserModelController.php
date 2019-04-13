<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserModelRequest;
use App\Models\Channel;
use App\Models\Product;
use App\Models\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserModelController extends Controller
{
    public function index()
    {
        return view('admin.userModel.index');
    }

    public function data(Request $request, UserModel $userModel)
    {

        $model = $userModel->query();

        $res = $model->orderBy('id','desc')->with(['snapshot'=>function($query){
           $query->orderBy('id','desc')->get();
        }])->paginate($request->get('limit',1))->toArray();
//        dd($res);
        foreach ($res['data'] as $k=>$re){
            //处理注册渠道
            if($re['register_channels']){
                $channel = Channel::select('channel_name')->whereIn('channel_code',$re['register_channels'])->get();
                $arr = [];
                foreach ( $channel as $item){
                    $arr[] = $item['channel_name'];
                }
//                dd($arr);
                $str = implode(',',$arr);
                $res['data'][$k]['register_channels'] = $str;
            }
            //处理注册平台
            if($re['register_platforms']){

                $res['data'][$k]['register_platforms'] = implode(',',$re['register_platforms']);
            }

            //处理申请过的产品
            if($re['apply_loans']){
                $channel = Product::select('name')->whereIn('id',$re['apply_loans'])->get();
                $arr = [];
                foreach ( $channel as $item){
                    $arr[] = $item['name'];
                }
//                dd($arr);
                $str = implode(',',$arr);
                $res['data'][$k]['apply_loans'] = $str;
            }

            //处理未申请过的产品
            if($re['not_apply_loans']){
                $channel = Product::select('name')->whereIn('id',$re['not_apply_loans'])->get();
                $arr = [];
                foreach ( $channel as $item){
                    $arr[] = $item['name'];
                }
//                dd($arr);
                $str = implode(',',$arr);
                $res['data'][$k]['not_apply_loans'] = $str;
            }

            //处理最后的登录平台
            if($re['last_login_platforms']){

                $res['data'][$k]['last_login_platforms'] = implode(',',$re['last_login_platforms']);
            }

            //处理最后申请过的产品
            if($re['last_apply_loans']){
                $channel = Product::select('name')->whereIn('id',$re['last_apply_loans'])->get();
                $arr = [];
                foreach ( $channel as $item){
                    $arr[] = $item['name'];
                }
//                dd($arr);
                $str = implode(',',$arr);
                $res['data'][$k]['last_apply_loans'] = $str;
            }


        }
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
     * 添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $channels = Channel::select('id','channel_name','channel_code')->get();
        $products  = Product::select('id','name')->get();

        return view('admin.userModel.create',compact('channels','products'));
    }


    /**
     * 添加保存
     * @param UserModelRequest $request
     * @param UserModel $userModel
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserModelRequest $request){

        $data=$this->filterRequest($request);

        if($data['register_channels']){
            $data['register_channels'] = explode(',',$data['register_channels'][0]);
        }
        if($data['register_platforms']){
            $data['register_platforms'] = explode(',',$data['register_platforms'][0]);
        }
        if($data['apply_loans']){
            $data['apply_loans'] = explode(',',$data['apply_loans'][0]);
        }
        if($data['not_apply_loans']){
            $data['not_apply_loans'] = explode(',',$data['not_apply_loans'][0]);
        }
        if($data['last_login_platforms']){
            $data['last_login_platforms'] = explode(',',$data['last_login_platforms'][0]);
        }
        if($data['last_apply_loans']){
            $data['last_apply_loans'] = explode(',',$data['last_apply_loans'][0]);
        }
        DB::beginTransaction();

        try{
            $userModel = UserModel::create($data);

            $userModel->createSnapshot(1);
            DB::commit();
            return redirect(route('admin.userModel'))->with(['status'=>'保存成功']);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->withErrors(['errors'=>$exception->getMessage()])->withInput($request->all());
        }

    }


    public function edit($id,UserModel $userModel)
    {

        $user_model = $userModel->find($id);

        $channels = Channel::select('id','channel_name','channel_code')->get();
        $products  = Product::select('id','name')->get();
        return view('admin.userModel.edit',compact('channels','products','user_model'));
    }


    public function update($id,UserModelRequest $request, UserModel $userModel )
    {
        $data=$this->filterRequest($request);

        if($data['register_channels']){
            $data['register_channels'] = explode(',',$data['register_channels'][0]);
        }
        if($data['register_platforms']){
            $data['register_platforms'] = explode(',',$data['register_platforms'][0]);
        }
        if($data['apply_loans']){
            $data['apply_loans'] = explode(',',$data['apply_loans'][0]);
        }
        if($data['not_apply_loans']){
            $data['not_apply_loans'] = explode(',',$data['not_apply_loans'][0]);
        }
        if($data['last_login_platforms']){
            $data['last_login_platforms'] = explode(',',$data['last_login_platforms'][0]);
        }
        if($data['last_apply_loans']){
            $data['last_apply_loans'] = explode(',',$data['last_apply_loans'][0]);
        }

        DB::beginTransaction();
        $model = $userModel->find($id);
        try{
            $model->update($data);
            $model->createSnapshot(2);
            DB::commit();
            return redirect(route('admin.userModel'))->with(['status'=>'修改成功']);
        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->back()->withErrors(['errors'=>$exception->getMessage()])->withInput($request->all());
        }
    }

    /**
     * 保存前不需要的全部 不给值
     * @param $request
     * @return mixed
     */
    public function filterRequest($request){

        $data=$request->all();
        if($request->register_at_type==0){

            $data['register_at_abstract_start']=null;
            $data['register_at_abstract_end']=null;
            $data['register_at_relative_num']=null;
            $data['register_at_relative_unit']=null;
            $data['register_at_relative_type']=null;
        }
        if($request->register_at_type==1){
            $data['register_at_relative_num']=null;
            $data['register_at_relative_unit']=null;
            $data['register_at_relative_type']=null;
        }
        if($request->register_at_type==2){
            $data['register_at_abstract_start']=null;
            $data['register_at_abstract_end']=null;
        }

        if($request->last_active_at_type==0){
            $data['last_active_at_abstract_start']=null;
            $data['last_active_at_abstract_end']=null;
            $data['last_active_at_relative_num']=null;
            $data['last_active_at_relative_unit']=null;
            $data['last_active_at_relative_type']=null;
        }
        if($request->last_active_at_type==1){
            $data['last_active_at_relative_num']=null;
            $data['last_active_at_relative_unit']=null;
            $data['last_active_at_relative_type']=null;
        }
        if($request->last_active_at_type==2){
            $data['last_active_at_abstract_start']=null;
            $data['last_active_at_abstract_end']=null;
        }

        if($request->last_apply_loan_at_type==0){
            $data['last_apply_loan_at_abstract_start']=null;
            $data['last_apply_loan_at_abstract_end']=null;
            $data['last_apply_loan_at_relative_num']=null;
            $data['last_apply_loan_at_relative_unit']=null;
            $data['last_apply_loan_at_relative_type']=null;
        }
        if($request->last_apply_loan_at_type==1){
            $data['last_apply_loan_at_relative_num']=null;
            $data['last_apply_loan_at_relative_unit']=null;
            $data['last_apply_loan_at_relative_type']=null;
        }
        if($request->last_apply_loan_at_type==2){
            $data['last_apply_loan_at_abstract_start']=null;
            $data['last_apply_loan_at_abstract_end']=null;
        }
        if(empty($request->all_login_day_start)){
            $data['all_login_day_start']=null;
        }
        if(empty($request->all_login_day_end)){
            $data['all_login_day_end']=null;
        }
        if(empty($request->all_apply_num_start)){
            $data['all_apply_num_start']=null;
        }
        if(empty($request->all_apply_num_end)){
            $data['all_apply_num_end']=null;
        }
        if(!isset($data['register_channels'])){
            $data['register_channels']=null;
        }
        if(!isset($data['register_platforms'])){
            $data['register_platforms']=null;
        }
        if(!isset($data['apply_loans'])){
            $data['apply_loans']=null;
        }
        if(!isset($data['not_apply_loans'])){
            $data['not_apply_loans']=null;
        }
        if(!isset($data['last_login_platforms'])){
            $data['last_login_platforms']=null;
        }
        if(!isset($data['last_apply_loans'])){
            $data['last_apply_loans']=null;
        }

        return $data;
    }

    //刷新模型
    public function refreshSnapshot(){

        return $this->updateSnapshot(3);

    }

    //定时任务
    public function cronRefreshSnapshot(){

        return $this->updateSnapshot(4);

    }

    public function updateSnapshot($type){
        $userModels=UserModel::all();
        if($userModels->count()){
            DB::beginTransaction();
            try{
                foreach ($userModels as $userModel){
                    $userModel->createSnapshot($type);
                }
                DB::commit();
                if($type!=4){
                    return redirect(route('admin.userModel'))->with(['status'=>'刷新成功']);
                }
            }catch (\Exception $exception){
                DB::rollBack();
                if($type!=4){
                    return redirect()->back()->with(['refresh_error'=>$exception->getMessage()]);
                }
            }
        }
    }



}
