<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $guarded = [];
    //
    public function channel(){

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }

    public function category(){
        return $this->belongsTo(FeedbackCategory::class,'feedback_category_id','id');
    }

    public function reply(){
        return $this->hasMany(FeedbackReply::class,'feedback_id','id');
    }

/*    public function getStatusAttribute($status){
        if($status == 0){
            return $this->attributes['status'] = '未回复';
        }else{
            return $this->attributes['status'] = '已处理';
        }
    }*/



}
