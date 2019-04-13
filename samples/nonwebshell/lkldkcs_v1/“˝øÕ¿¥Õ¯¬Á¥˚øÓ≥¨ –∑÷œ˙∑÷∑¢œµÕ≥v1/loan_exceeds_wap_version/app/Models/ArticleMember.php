<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleMember extends Model
{
    protected $guarded = [];
    public function member(){

        return $this->belongsTo(Member::class,'mid','id');
    }

    public function article(){

        return $this->belongsTo(Article::class,'article_id','id');
    }
}
