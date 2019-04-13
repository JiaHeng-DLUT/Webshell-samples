<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberLog extends Model
{
    protected $guarded = [];
    //
    public function member(){

        return $this->belongsTo(Member::class,'mid','id');
    }

    public function channel(){

        return $this->belongsTo(Channel::class,'channel_code','channel_code');
    }

    public function page(){

        return $this->belongsTo(DistributePage::class,'page_id','id');
    }
}
