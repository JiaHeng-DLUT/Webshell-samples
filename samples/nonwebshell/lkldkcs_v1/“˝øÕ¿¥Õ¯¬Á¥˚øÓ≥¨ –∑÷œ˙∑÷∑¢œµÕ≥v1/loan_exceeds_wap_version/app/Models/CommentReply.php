<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    protected  $table = 'comment_replies';
    protected  $guarded  =[];
    public function comment(){

        return $this->belongsTo(Comment::class,'comment_id','id');
    }

    public function user(){

        return $this->belongsTo(User::class,'user_id','id');
    }
}

