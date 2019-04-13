<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Models\App;
use App\Models\Apply;
use App\Models\AppMenu;
use App\Models\Device;
use App\Models\District;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductColumn;
use App\Models\ProductDistrict;
use App\Models\ProductPlatform;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Driver\Driver;

class HomeController extends BaseController
{

    /**
     * 首页列表
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'city'=>'required',
        ]);
        //极光推送定时任务的激活记录
//        $this->messageCronFirst($request->all());
        if (!$validate->fails()){
            /*Banner*/
            $banners = $this->banner();
            /*类目分类*/
            $categories = $this->category();
            /*借款数*/
            $count = $this->count();
            $all_count = $count['all'];
            $today_count = $count['today'];
            /*栏目产品*/
            $columns = $this->column($request);
            $data = [
                'banner'=>$banners,
                'category'=>$categories,
                'all'=>$all_count,
                'today'=>$today_count,
                'column'=>$columns,
            ];
            $this->set('data',$data);
        }else{
            if ($validate->errors()->has('city')){
                $this->set('type',$this->badRequest);
                $this->set('info','请传入城市信息');
            }
        }
        return $this->jsonResponse();
    }

    /**
     * 首页banner图
     * @return array
     */
    private function banner(){
        $banners = Image::where(['type'=>'banner','status'=>1])
            ->orderBy('sort','desc')->limit(5)
            ->get(['id','url','redirect_url','redirect_type']);
        if ($banners->count()){
            foreach($banners as &$banner){
                if ($banner->redirect_type == 'inside'){
                    $banner->node = json_decode($banner->redirect_url)->node;
                    $banner->node_id = json_decode($banner->redirect_url)->id;
                }else{
                    $banner->node = '';
                    $banner->node_id = '';
                }
            }
            return $banners;
        }else{
            return [];
        }
    }

    /**
     * 首页类目
     * @return array
     */
    private function category(){
        $categories = ProductCategory::orderBy('sort','desc')->limit(4)
            ->get(['id','name','icon','banner','banner_redirect','redirect_type','redirect_slug','redirect_id']);
        if ($categories->count()){
            foreach($categories as &$category){
                if ($category->redirect_type == 'inside'){
                    $category->node = $category->redirect_slug;
                    $category->node_id = $category->redirect_id;
                }else{
                    $category->node = '';
                    $category->node_id = '';
                }
                $category->type = 'product';
                unset($category->redirect_slug);
                unset($category->redirect_id);
            }
            return $categories;
        }else{
            return [];
        }
    }

    /**
     * 首页申请统计
     * @return array
     */
    private function count(){
        $website = Website::orderBy('created_at','desc')->first();
        if ($website){
            $base_loan = $website->base_loan;
            $base_today_loan = $website->base_today_loan;
        }else{
            $base_loan = 120000;
            $base_today_loan = 1000;
        }
        //累计借款
        $all_count = Apply::where('type','product')->count();
        //当天借款
        $today_count = Apply::where('type','product')
            ->whereBetween('created_at',[date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59')])
            ->count();
        return [
            'all'=>$base_loan + $all_count,
            'today'=>$base_today_loan + $today_count,
        ];
    }

    /**
     * 首页栏目产品列表
     * @param $request
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    private function column($request){
        /*城市平台*/
        $ids = $this->cityPlatform($request);
        $columns = ProductColumn::with(['columnProduct'=>function($query)use($ids){
            $query->with(['label','corner'=>function($query){
                $query->select(['id','name','url']);
                }])
                ->where('status',1)
                ->whereIn('id',$ids)
                ->orderBy('sort','desc')
                ->orderBy('id','desc')
                ->select(['id','name','logo','quota_min','quota_max','slogan','corner_id','market_element']);
            }])
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->get(['id','name','sort']);
        $new_columns = [];
        if ($columns->count()){
            foreach($columns as $k=>&$column){
                if (count($column->columnProduct)){
                   /* unset($columns[$k]);
                }else{*/
                    foreach($column->columnProduct as $key=>&$value){
                        if ($key >= 5){
                            unset($column->columnProduct[$key]);
                        }else{
                            //标签
                            $tags = [];
                            if ($value->label){
                                foreach($value->label as $item){
                                    $tags[] = $item->name;
                                }
                                $value->tags = $tags;
                            }else{
                                $value->tags = [];
                            }
                            unset($value->label);
                            unset($value->pivot);
                            //角标
                            if ($value->corner){
                                $value->mark = $value->corner;
                            }else{
                                $value->mark = null;
                            }
                            unset($value->corner);
                            unset($value->corner_id);
                        }
                    }
                $new_columns[] = $column;
                }
            }
            return $new_columns;
        }else{
            return $new_columns;
        }
    }

    /**
     * 专题产品列表
     * @param Request $request
     * @param $id
     * @return array
     */
    public function show(Request $request,$id)
    {
       /*城市平台*/
        $ids = $this->cityPlatform($request);
        $categories = ProductCategory::with(['categoryProduct'=>function($query)use($ids){
            $query->with(['label','corner'=>function($query){
                $query->select(['id','name','url']);
            }])->where('status',1)
//                ->whereIn('id',$ids)
                ->orderBy('id','desc')
                ->select(['id','name','logo','quota_min','quota_max','slogan','corner_id','market_element','redirect_url']);
            }])->where('id',$id)
            ->select(['id','name','icon','banner as banners','banner_redirect','redirect_type','redirect_slug','redirect_id'])
            ->paginate($this->page_sizes);
        if ($categories->count()){
            foreach($categories as $k=>&$category){
                $category->banner = $category->banners;
                unset($category->banners);
                if ($category->redirect_type == 'inside'){
                    $category->node = $category->redirect_slug;
                    $category->node_id = $category->redirect_id;
                }else{
                    $category->node = '';
                    $category->node_id = '';
                }
                unset($category->redirect_slug);
                unset($category->redirect_id);
                if (!$category->categoryProduct){
                    unset($categories[$k]);
                }else{
                    foreach($category->categoryProduct as $value){
                        //标签
                        $tags = [];
                        if ($value->label){
                            foreach($value->label as $item){
                                $tags[] = $item->name;
                            }
                            $value->tags = $tags;
                        }else{
                            $value->tags = [];
                        }
                        unset($value->label);
                        unset($value->pivot);
                        //角标
                        if ($value->corner){
                            $value->mark = $value->corner;
                        }else{
                            $value->mark = null;
                        }
                        unset($value->corner);
                        unset($value->corner_id);
                    }
                }
            }
        }else{
           $this->set('type',$this->noContent);
           $this->set('info','此专题暂无产品信息');
        }
        $this->set('data',$categories);
        return $this->jsonResponse();
    }

    /**
     * 启动基础数据
     * @return array
     */
    public function base()
    {
        $starts = Image::where(['type'=>'guide','status'=>1])
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->limit(3)
            ->get(['id','url','redirect_url','redirect_type']);
        if ($starts->count()){
            foreach($starts as &$start){
                if ($start->redirect_type == 'inside'){
                    $start->node = json_decode($start->redirect_url)->node;
                    $start->node_id = json_decode($start->redirect_url)->id;
                }else{
                    $start->node = '';
                    $start->node_id = '';
                }
            }
        }else{
            $starts = null;
        }
        $ads = Image::where(['type'=>'alert','status'=>1])
            ->orderBy('sort','desc')
            ->orderBy('id','desc')
            ->limit(3)
            ->get(['id','url','redirect_url','redirect_type']);
        if ($ads->count()){
            foreach($ads as &$ad){
                if ($ad->redirect_type == 'inside'){
                    $ad->node = json_decode($ad->redirect_url)->node;
                    $ad->node_id = json_decode($ad->redirect_url)->id;
                }
            }
        }else{
            $ads = null;
        }
        $menus = [
            ['name'=>'首页','slug'=>'home'],
            ['name'=>'贷款','slug'=>'mix'],
//            ['name'=>'贷款','slug'=>'loan'],
//            ['name'=>'信用卡','slug'=>'credit'],
            ['name'=>'发现','slug'=>'discover'],
            ['name'=>'我的','slug'=>'profile'],
        ];
        $data = [
            'start'=>$starts,
            'ads'=>$ads,
            'menu'=>$menus,
            'examine'=> 2,//待审核=>1 , 过审核=>2
        ];
        $this->set('data',$data);
        return $this->jsonResponse();
    }

    /**
     * 描述：生成定时push 最后操作记录
     * @param $request
     */
    public  function  messageCronFirst($request)
    {
        if($request['norm'] === 'new')
        {
            $date_time = date('Y-m-d 00:00:00',time());
            $page= MessageCrontabFirst::where('updated_at','>=',$date_time);
            $info = $page->where('identifier',$request['identifier'])->orderBy('id','desc')->first();
            //不存在的时候创建 / 已经存在更新
            $data ['identifier'] = $request['identifier'];
            $data ['platform'] = $request['platform'];
            $data ['push_id'] = $request['push'];
            $data ['system_version'] = $request['system'];
            $data ['channel_code'] = $request['channel'];
            $data ['app_id'] = Device::where('identifier', $request['identifier'])->first(['app_id'])->app_id;
            if(isset($request['uid']))
            {
                $data ['mid'] = $request['uid'];
            }
            if(!$info)
            {
                MessageCrontabFirst::create($data);
            }else{
                MessageCrontabFirst::where('identifier',$request['identifier'])->update($data);
            }
        }
    }

    public  function  cronPush(Request $request,$id)
    {
        $msg = MessageCrontabSendRecord::where(['message_id'=>$id,'identifier'=>$request->input('identifier')])->first();
        if($msg){
            $msg->is_reached = 1;
            $msg->is_clicked = 1;
            $msg->save();
            return $this->jsonResponse();
        }else{
            $this->set('info','没查到信息');
            $this->set('code','4000');
            return $this->jsonResponse();
        }


    }



}
