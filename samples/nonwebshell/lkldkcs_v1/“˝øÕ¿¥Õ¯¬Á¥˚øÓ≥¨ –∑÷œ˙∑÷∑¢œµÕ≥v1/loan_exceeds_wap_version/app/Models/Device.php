<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    //
    protected $guarded = [];
    public function channel(){

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }

    public function apps(){
        return $this->hasOne(Application::class,'id','app_id');
    }

}
