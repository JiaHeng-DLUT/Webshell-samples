<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Models\Apply;
use App\Models\Article;
use App\Models\ArticleCollection;
use App\Models\Comment;
use App\Models\Credit;
use App\Models\CreditCollection;
use App\Models\Member;
use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IntentionController extends BaseController
{
    
    /**
     * 申请产品意向
     * @param Request $request
     * @return array
     */
    public function productApplied(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'uid'=>'required',
        ]);
        if (!$validate->fails()){
            $member = Member::where('id',$request->uid)->first();
            if ($member){
                $product_applies = Apply::with(['productIntention'=>function($query){
                    $query->with(['label','corner'=>function($query){
                        $query->select(['id','name','url']);
                    }]);
                }])
                    ->whereHas('productIntention',function($query){
                        $query->where('deleted_at', null);
                    })
                    ->where(['mid'=>$request->uid,'type'=>'product'])
                    ->orderBy('id','desc')
                    ->select(['id','product_id','created_at'])
                    ->paginate($this->page_sizes);
//            return $product_applies;
                if ($product_applies->count()){
                    foreach($product_applies as &$item){
                        $item->name = $item->productIntention['name'];
                        $item->logo = $item->productIntention['logo'];
                        $item->min_money = $item->productIntention['quota_min'];
                        $item->max_money = $item->productIntention['quota_max'];
                        $item->introduce = $item->productIntention['slogan'];
                        $item->status = $item->productIntention['status'];
                        $item->market_element = $item->productIntention['market_element'];
                        $item->type = 'product';
                        $exists = Comment::where([
                            'mid'=>$request->uid,
                            'product_type'=>'product',
                            'product_id'=>$item->product_id,
                            'apply_id'=>$item->id,
                        ])->first();
                        if ($exists){//判断产品是否评价
                            $item->is_comment = 1;
                        }else{
                            $item->is_comment = 0;
                        }
                        $tags = [];
                        if($item->productIntention['label']){
                            foreach ($item->productIntention['label'] as $info){
                                $tags[] = $info['name'];
                            }
                            $item->tags = $tags;
                            unset( $item->productIntention['label']);
                        }else{
                            $item->tags = [];
                        }
                        //角标
                        if ($item->productIntention['corner']){
                            $item->mark = $item->productIntention['corner'];
                        }else{
                            $item->mark = null;
                        }
                        unset($item->productIntention['corner']);
                        unset($item->productIntention);
                    }
                    $this->set('data',$product_applies);
                }else{
                    $this->set('type',$this->noContent);
                    $this->set('info','您还没有申请过产品哦~');
                }
            }else{
                $this->set('type',$this->overdueUser);
                $this->set('info','请登录');
            }
        }else{
            if ($validate->errors()->has('uid')){
                $this->set('type',$this->noContent);
                $this->set('info','请传入uid');
            }
        }
        return $this->jsonResponse();
    }

    /**
     * 申请信用卡意向
     * @param Request $request
     * @return array
     */
    public function creditApplied(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'uid'=>'required',
        ]);
        if (!$validate->fails()){
            $member = Member::where('id',$request->uid)->first();
            if ($member){
                $credit_applies = Apply::with(['creditIntention'=>function($query){
                        $query->with(['corner'=>function($query){//=>function($query){$query->where('status',1)->get();}
                            $query->select(['id','name','url'])->orderBy('id','desc');
                        }]);
                    }])
                    ->where(['mid'=>$request->uid,'type'=>'credit'])
                    ->orderBy('id','desc')
                    ->select(['id','credit_id','created_at'])
                    ->paginate($this->page_sizes);
                if ($credit_applies->count()){
                    foreach ($credit_applies as &$credit_apply){
                        $credit_apply->name = $credit_apply->creditIntention['name'];
                        $credit_apply->logo = $credit_apply->creditIntention['logo'];
                        $credit_apply->introduce = $credit_apply->creditIntention['introduce'];
                        $credit_apply->status = $credit_apply->creditIntention['status'];
                        $credit_apply->num = $credit_apply->creditIntention['base_apply_num']+$credit_apply->creditIntention['apply_numbers'];
                        $credit_apply->type = 'credit';
                        //角标
                        if ($credit_apply->creditIntention['corner']){
                            $credit_apply->corner = $credit_apply->creditIntention['corner'];
                        }else{
                            $credit_apply->corner = null;
                        }
                        unset($credit_apply->creditIntention['corner']);
                        //判断信用卡是否评价
                        $is_comment = Comment::where(['product_type'=>'credit','mid'=>$request->uid,'apply_id'=>$credit_apply->id])->first();
                        if(count($is_comment)){
                            $credit_apply->is_comment = 1;
                        }else{
                            $credit_apply->is_comment = 0;
                        }
                        unset( $credit_apply->creditIntention);
                    }
                    $this->set('data',$credit_applies);
                }else{
                    $this->set('type',$this->noContent);
                    $this->set('info','您还没有申请过信用卡哦~');
                }
            }else{
                $this->set('type',$this->overdueUser);
                $this->set('info','请登录');
            }
        }else{
            if ($validate->errors()->has('uid')){
                $this->set('type',$this->noContent);
                $this->set('info','请传入uid');
            }
        }
        return $this->jsonResponse();
    }


    /**
     * 贷款 / 信用卡评论
     * @param Request $request
     * @return array
     */
    public function comment(Request $request)
    {
        $type = $request->type;
        if ($type){
            $validate = Validator::make($request->all(),[
                'id'=>'required',
                'apply_id'=>'required',
                'star'=>'required',
                'content'=>'required',
                'uid'=>'required',
            ]);
            if (!$validate->fails()){
                $member = Member::where('id',$request->uid)->first();
                if ($member){
                    if ($type == 'product'){
                        $product_id = $request->id;
                        $credit_id = 0;
                        $model = Product::where('id',$product_id)->first();
                        if ($model){
                            $model_name = $model->name;
                        }else{
                            $model_name = '';
                        }
                    }else{
                        $product_id = 0;
                        $credit_id = $request->id;
                        $model = Credit::where('id',$credit_id)->first();
                        if ($model){
                            $model_name = $model->name;
                        }else{
                            $model_name = '';
                        }
                    }
                  //判断用户是否已评价
                  $exists_comment = Comment::where(['mid'=>$request->uid,'product_id'=>$product_id,'credit_id'=>$credit_id,'apply_id'=>$request->apply_id])->first();
                    if (!$exists_comment){
                        $comment = Comment::create([
                            'product_type'=>$type,
                            'comment_type'=>'real',
                            'mid'=>$request->uid,
                            'phone'=>$member->phone,
                            'product_id'=>$product_id,
                            'credit_id'=>$credit_id,
                            'model_name'=>$model_name,
                            'apply_id'=>$request->apply_id,
                            'content'=>$request->input('content'),
                            'star'=>$request->star,
                            'status'=>0,
                            'is_wonderful'=>0,
                        ]);
                        if ($comment){
                            $this->set('info','评论成功');
                        }else{
                            $this->set('type',$this->noContent);
                            $this->set('info','评论失败');
                        }
                    }else{
                        $this->set('info','评论成功');
                    }
                }else{
                    $this->set('type',$this->overdueUser);
                    $this->set('info','请登录');
                }
            }else{
                if ($validate->errors()->has('id')){
                    $this->set('type',$this->badRequest);
                    $this->set('info','请传入产品id');
                }elseif ($validate->errors()->has('apply_id')){
                    $this->set('type',$this->badRequest);
                    $this->set('info','请传入申请id');
                }
                elseif ($validate->errors()->has('star')){
                    $this->set('type',$this->badRequest);
                    $this->set('info','请传入星级');
                }
                elseif ($validate->errors()->has('content')){
                    $this->set('type',$this->badRequest);
                    $this->set('info','请传入评价内容');
                }
                else{
                    $this->set('type',$this->badRequest);
                    $this->set('info','请传入uid');
                }
            }
        }else{
            $this->set('type',$this->badRequest);
            $this->set('info','请传入评论类型');
        }
        return $this->jsonResponse();
    }

    /**
     * 产品收藏
     * @param Request $request
     * @return array
     */
    public function productCollection(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'uid'=>'required',
        ]);
        if (!$validate->fails()){
            $member = Member::where('id',$request->uid)->first();
            if ($member){
                $product = ProductCollection::where('mid',$request->uid)->get();
                if(count($product)) {
                    $product_ids = [];
                    foreach ($product as $value) {
                        $product_ids[] = $value->product_id;
                    }
                    $all_product = Product::with(['label' => function ($query) {
                        $query->select(['id', 'name']);
                    }, 'corner' => function ($query) {
                        $query->select(['id', 'name', 'url']);
                    }])
                        ->whereIn('id', $product_ids)
                        ->orderBy('status','desc')
                        ->select(['id', 'name', 'logo', 'slogan', 'market_element','corner_id', 'status', 'quota_min', 'quota_max'])
                        ->paginate($this->page_sizes);
                    foreach ($all_product as &$item) {
                        $tags = [];
                        if ($item->label) {
                            foreach ($item->label as $value) {
                                $tags[] = $value->name;
                            }
                            $item->tags = $tags;
                            unset($item->label);
                        } else {
                            $item->tags = [];
                        }
                        //角标
                        if ($item->corner) {
                            $item->mark = $item->corner;
                        } else {
                            $item->mark = null;
                        }
                        unset($item->corner);
                    }
                    $this->set('data', $all_product);
                }else{
                    $this->set('type',$this->noContent);
                    $this->set('info','您还没有收藏的贷款产品哦~');
                }
            }else{
                $this->set('type',$this->overdueUser);
                $this->set('info','请登录');
            }
        }else{
            if ($validate->errors()->has('uid')){
                $this->set('type',$this->overdueUser);
                $this->set('info','请登录');
            }
        }
        return $this->jsonResponse();
    }

    /**
     * 信用卡收藏
     * @param Request $request
     * @return array
     */
    public function creditCollection(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'uid'=>'required',
        ]);
        if (!$validate->fails()){
            $member = Member::where('id',$request->uid)->first();
            if ($member){
                $credit = CreditCollection::where('mid',$request->uid)->get();
                if(count($credit)){
                    $credit_ids = [];
                    foreach ($credit as $value){
                        $credit_ids[] = $value->credit_id;
                    }
                    $all_credit = Credit::with(['corner'=>function($query){
                        $query->select(['id','name','url']);
                    }])
                        ->whereIn('id',$credit_ids)
                        ->orderBy('status','desc')
                        ->select(['id','name','logo','introduce','base_apply_num','apply_numbers','status','corner_id'])
                        ->paginate($this->page_sizes);
                    foreach($all_credit as &$value){
                        $value->num = $value->base_apply_num + $value->apply_numbers;
                        unset($value->base_apply_num);
                        unset($value->apply_numbers);
                        //角标
                        if ($value->corner){
                            $value->mark = $value->corner;
                        }else{
                            $value->mark = null;
                        }
                        unset($value->corner);
                    }
                    $this->set('data',$all_credit);
                }else{
                    $this->set('type',$this->noContent);
                    $this->set('info','您还没有收藏的信用卡哦~');
                }
            }else{
                $this->set('type',$this->overdueUser);
                $this->set('info','请登录');
            }
        }else{
            if ($validate->errors()->has('uid')){
                $this->set('type',$this->overdueUser);
                $this->set('info','请登录');
            }
        }
        return $this->jsonResponse();
    }

    /**
     * 资讯收藏
     * @param Request $request
     * @return array
     */
    public function articleCollection(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'uid'=>'required',
        ]);
        if (!$validate->fails()){
            $member = Member::where('id',$request->uid)->first();
            if ($member){
                $article = ArticleCollection::where('mid',$request->uid)->get();
                if(count($article)){
                    $article_ids = [];
                    foreach($article as $value){
                        $article_ids[] = $value->article_id;
                    }
                    $all_article = Article::with(['cornerArticle'=>function($query){
                        $query->select(['id','name','url']);
                    }])
                        ->whereIn('id',$article_ids)
                        ->orderBy('status','desc')
                        ->select(['id','cover','title','base_views','real_views','created_at','status','corner_id'])
                        ->paginate($this->page_sizes);
                    foreach($all_article as &$value){
                        $value->num = $value->base_views + $value->real_views;//阅读总数
                        unset($value->base_views);
                        unset($value->real_views);
                        //角标
                        if ($value->cornerArticle){
                            $value->mark = $value->cornerArticle;
                        }else{
                            $value->mark = null;
                        }
                        unset($value->cornerArticle);
                    }
                    $this->set('data',$all_article);
                }else{
                    $this->set('type',$this->noContent);
                    $this->set('info','您还没有收藏的文章哦~');
                }
            }else{
                $this->set('type',$this->overdueUser);
                $this->set('info','请登录');
            }
        }else{
            if ($validate->errors()->has('uid')){
                $this->set('type',$this->overdueUser);
                $this->set('info','请登录');
            }
        }
        return $this->jsonResponse();
    }

}
