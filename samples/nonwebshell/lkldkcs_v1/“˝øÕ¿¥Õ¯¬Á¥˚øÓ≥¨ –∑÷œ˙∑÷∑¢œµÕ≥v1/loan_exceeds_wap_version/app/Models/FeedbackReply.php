<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackReply extends Model
{
    protected  $guarded = [];

    public function feedback(){

        return $this->belongsTo(Feedback::class,'feedback_id','id');
    }
}
