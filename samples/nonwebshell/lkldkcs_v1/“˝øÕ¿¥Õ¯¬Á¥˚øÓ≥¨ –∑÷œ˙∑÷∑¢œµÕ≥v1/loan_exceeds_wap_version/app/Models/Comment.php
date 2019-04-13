<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    //
    use SoftDeletes;

    protected $dates=['deleted_at'];

    protected  $guarded = [];
//    public $timestamps = false;
    public function product(){

        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function credit(){

        return $this->belongsTo(Credit::class,'credit_id','id');
    }

    public function apply(){

        return $this->belongsTo(Apply::class,'apply_id','id');
    }

    public function member(){

        return $this->belongsTo(Member::class,'mid','id');
    }

    public function reply(){

        return $this->hasMany(CommentReply::class,'comment_id','id');
    }
}
