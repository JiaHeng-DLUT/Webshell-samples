<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected  $fillable=['cover','title','corner_id','category_id','base_views','intro','content','status'];

    protected $guarded = [];

    //资讯角标
    public function cornerArticle()
    {
        return $this->belongsTo(Corner::class,'corner_id','id');
    }


    public function corner()
    {

        return $this->belongsTo(Corner::class,'corner_id','id');
    }

    public function category(){

        return $this->belongsTo(ArticleCategory::class,'category_id','id');
    }

}
