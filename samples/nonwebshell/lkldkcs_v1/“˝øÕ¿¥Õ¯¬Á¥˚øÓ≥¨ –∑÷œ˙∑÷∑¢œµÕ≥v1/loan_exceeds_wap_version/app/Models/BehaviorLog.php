<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BehaviorLog extends Model
{
    protected $guarded = [];
    public function registerChannel(){

        return $this->belongsTo(Channel::class,'register_channel_id','id');
    }

    public function registerPage(){

        return $this->belongsTo(DistributePage::class,'register_page_id','id');
    }

    public function operateChannel(){

        return $this->belongsTo(Channel::class,'operate_channel_id','id');
    }

    public function operatePage(){

        return $this->belongsTo(DistributePage::class,'operate_page_id','id');
    }
}
