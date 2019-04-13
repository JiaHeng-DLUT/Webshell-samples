<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackCategory extends Model
{

    protected $fillable=['name','sort'];
    //
    public function feedback(){

        return $this->hasMany(Feedback::class,'feedback_category_id','id');
    }

    public function parent(){
        return $this->belongsTo(Feedback::class,'feedback_id','id');
    }
}
