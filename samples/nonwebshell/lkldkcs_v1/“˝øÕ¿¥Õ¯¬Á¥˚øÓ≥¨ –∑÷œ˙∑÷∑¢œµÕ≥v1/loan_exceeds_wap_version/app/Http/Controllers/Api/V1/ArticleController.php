<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Models\Apply;
use App\Models\Article;
use App\Models\ArticleMember;
use App\Models\ArticlePraise;
use App\Models\Member;
use App\Models\Product;
use App\Models\ArticleCollection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ArticleController extends BaseController
{

    /**
     * 资讯列表
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        $id = $request->id;
        if ($id){
            $new_article = Article::where('id','>',$id)->first();
            if ($new_article){
                $articles = Article::with(['cornerArticle'=>function($query){
                    $query->select(['id','name','url']);
                }])
                    ->where('status',1)
                    ->where('id','>',$id)
                    ->orderBy('id','desc')
                    ->select(['id','title','corner_id','cover','title','created_at','real_views','base_views','status'])
                    ->paginate($this->page_sizes);
            }else{
                $articles  = [];
            }
        }else{
            $articles = Article::with(['cornerArticle'=>function($query){
                $query->select(['id','name','url']);
            }])
                ->where('status',1)
                ->orderBy('id','desc')
                ->select(['id','title','corner_id','cover','title','created_at','real_views','base_views','status'])
                ->paginate($this->page_sizes);
        }
        if (count($articles)){
            foreach($articles as $article){
                $article->num = $article->base_views + $article->real_views;//阅读总数
                //角标
                if ($article->cornerArticle){
                    $article->mark = $article->cornerArticle;
                }else{
                    $article->mark = null;
                }
                unset($article->cornerArticle);
                unset($article->real_views);
                unset($article->base_views);
                unset($article->corner_id);
                /*判断是否已读*/
                if ($request->uid){
                    $read = ArticleMember::where(['mid'=>$request->uid,'article_id'=>$article->id])->first();
                    if ($read){
                        $article->is_read = 1;
                    }else{
                        $article->is_read = 0;
                    }
                }else{
                    $article->is_read = 0;
                }
            }
            $this->set('data',$articles);
        }else{
            $this->set('type',$this->noContent);
            $this->set('info','暂无资讯信息');
        }
        return $this->jsonResponse();
    }


    /**
     * 资讯详情
     * @param Request $request
     * @return array
     */
    public function show(Request $request,$id)
    {
        $arr = [];
        //获取资讯详情
        $article = Article::where(['id'=>$id,'status'=>1])->first();
        if($article){
            /*分享*/
            $arr['share_link'] = $this->article_share.$article->id.'?type=app&share=1&Channel='.$request->channel;
            $rand_view = mt_rand(1,9);
            $article->real_views += $rand_view;//阅读数累加一次
            $article->save();
            $article->num = $article->base_views + $article->real_views;//阅读总数
            unset($article->real_views);
            unset($article->base_views);
            unset($article->updated_at);
            $arr['article'] = $article;
            //猜你喜欢
            $ids = $this->cityPlatform($request);
            $applys = Apply::where(['mid'=>$request->uid,'type'=>'product'])->get(['product_id']);
            $all = Product::whereIn('id',$ids)->count();
            if ($applys){
                if (count($applys) < $all){//申请数小于总数时
                    $apply_ids = Apply::where(['mid'=>$request->uid,'type'=>'product'])->pluck('product_id')->all();
                }else{
                    $apply_ids = [];
                }
            }else{
                $apply_ids = [];
            }
            $likes =  Product::with(['label'=>function($query){
                $query->select(['id','name']);
            },'corner'=>function($query){
                $query->select(['id','name','url']);
            }])
                ->where(['status'=>1])
//                ->whereRaw("JSON_CONTAINS(guess_like,'[\"product\",\"article\"]')")
                ->whereRaw("JSON_CONTAINS(guess_like,'[\"article\"]')")
                ->whereIn('id',$ids)
                ->whereNotIn('id',$apply_ids)
                ->orderBy('created_at','desc')
                ->take(3)
                ->get(['id','name','market_element','corner_id','logo','slogan','status','quota_min','quota_max']);
            if ($likes->count()){
                foreach($likes as &$item){
                    $tags = [];
                    //标签
                    if ($item->label){
                        foreach($item->label as $value){
                            $tags[] = $value->name;
                        }
                        $item->tags = $tags;
                    }else{
                        $item->tags = [];
                    }
                    unset($item->label);
                    //角标
                    if ($item->corner){
                        $item->mark = $item->corner;
                    }else{
                        $item->mark = null;
                    }
                    unset($item->corner);
                    unset($item->corner_id);
                }
                $arr['likes'] = $likes;
            }else{
                $arr['likes'] = [];
            }
            //为你推荐
            $articles = Article::with(['cornerArticle'=>function($query){
                $query->select(['id','name','url']);
            }])
                ->where('id','<>',$id)
                ->where('status',1)
                ->limit(3)
                ->get(['id','title','corner_id','cover','title','created_at','real_views','base_views','status']);
            if ($articles->count()){
                foreach($articles as &$article){
                    $article->num = $article->base_views + $article->real_views;//阅读总数
                    unset($article->real_views);
                    unset($article->base_views);
                    unset($article->corner_id);
                    //角标
                    if ($article->cornerArticle){
                        $article->mark = $article->cornerArticle;
                    }else{
                        $article->mark = null;
                    }
                    unset($article->cornerArticle);
                }
                $arr['articles'] = $articles;
            }else{
                $arr['articles'] = [];
            }
            if ($request->uid){
                /*是否收藏*/
                $collectoin = ArticleCollection::where(['mid'=>$request->uid,'article_id'=>$id])->first();
                if($collectoin){
                    $arr['is_collection'] = 1;
                }else{
                    $arr['is_collection'] = 0;
                }
                /*是否点赞*/
                $praise = ArticlePraise::where(['mid'=>$request->uid,'article_id'=>$id])->first();
                if ($praise){
                    $arr['is_praise'] = 1;
                }else{
                    $arr['is_praise'] = 0;
                }
                /*记录用户已读*/
                if (!ArticleMember::where(['mid'=>$request->uid,'article_id'=>$id])->first()){
                    ArticleMember::create([
                        'mid'=>$request->uid,
                        'article_id'=>$id
                    ]);
                }
            }else{
                $arr['is_collection'] = 0;
                $arr['is_praise'] = 0;
            }
            $this->set('data',$arr);
        }else{
            $this->set('type',$this->badRequest);
            $this->set('info','该文章已下架，如有疑问请联系客服。');
        }
        return $this->jsonResponse();
    }
}
