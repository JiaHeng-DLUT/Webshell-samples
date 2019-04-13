<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\HotCity;
use App\Models\Image;
use App\Models\Permission;
use App\Models\ProductCategory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $pageSize = 30;

    /**
     * @var int
     * 状态码
     */
    public $code = 0;
    /**
     * @var string
     * 返回数据
     */
    public $data = '';

    /**
     * @var string
     * 提示信息
     */
    public $info = '成功';
    /**
     * 处理权限分类
     */
    public function tree($list=[], $pk='id', $pid = 'parent_id', $child = '_child', $root = 0)
    {
        if (empty($list)){
            $list = Permission::get()->toArray();
        }
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * @param $key
     * @param $val
     * ajax 返回值变更
     */
    public function set($key,$val){
        $this->$key = $val;
    }
    /**
     * @return array
     * ajax 返回
     */
    public function ajaxResponse(){
        return ['info'=>$this->info,'data'=>$this->data,'code'=>$this->code];
    }


    public function verifyStatus($slug,$id){
        $res=['code'=>0,'msg'=>''];
        if(in_array($slug,['product','article','credit'])){
            $productCategory=ProductCategory::where(['redirect_type'=>'inside','redirect_slug'=>$slug,'redirect_id'=>$id])->first();
            $image=Image::where(['redirect_type'=>'inside'])->where('redirect_url->node',"$slug")->where('redirect_url->id',$id)->first();
            $code=0;
            $msg='';
            if($productCategory){
                $code=1;
                $msg="产品分类($productCategory->name)Banner跳转有关联该产品,请先解除关联再下架";
            }
            if($image){
                if($image->type == 'startup'){
                    $addr = '启动页里面';
                }else if($image->type == 'guide'){
                    $addr = '引导页里面';
                }else if($image->type == 'alert'){
                    $addr = '首页广告-弹窗位里面';
                }else if($image->type == 'banner'){
                    $addr = '首页banner里面';
                }else if($image->type == 'pcbanner'){
                    $addr = '首页幻灯片里面';
                }
                $code=1;
                $msg="营销位 ".$addr." 图片跳转有关联该产品,请先解除关联再下架";
            }
            $res=['code'=>$code,'msg'=>$msg];
        }
        return $res;
    }


    /**
     * 同步热门城市至redis
     */
    public function syncHotCities(){
        $hot_city_ids=HotCity::orderBy('sort','desc')->pluck('city_id')->all();
        $hot_cities=District::select('id','name','initial','pinyin')->whereIn('id',$hot_city_ids)->get();
        Redis::set('hot_cities',$hot_cities->toJson());
    }

}
